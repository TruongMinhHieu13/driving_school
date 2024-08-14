<?php
/* Check HTTP */
$func->checkHTTP($http, $config['arrayDomainSSL'], $configBase, $configUrl);

/* Validate URL */
$func->checkUrl($config['website']['index']);

/* Check login */
$func->checkLoginMember();

if (!empty($config['website']['linkredirect'])) {
    $func->checkRedirect();
}

/* Mobile detect */
$deviceType = ($detect->isMobile() || $detect->isTablet()) ? 'mobile' : 'computer';
define('TEMPLATE', ($deviceType == 'computer') ? './templates/' : './templates/');

/* Router */
$router->setBasePath($config['database']['url']);
$router->map('GET', ADMIN . '/', function () {
    global $func, $config;
    $func->redirect($config['database']['url'] . ADMIN . "/index.php");
    exit;
});
$router->map('GET', ADMIN, function () {
    global $func, $config;
    $func->redirect($config['database']['url'] . ADMIN . "/index.php");
    exit;
});
$router->map('GET|POST', '', 'index', 'home');
$router->map('GET|POST', 'index.php', 'index', 'index');
$router->map('GET|POST', 'sitemap.xml', 'sitemap', 'sitemap');
$router->map('GET|POST', '[a:com]', 'allpage', 'show');
$router->map('GET|POST', '[a:com]/[a:lang]/', 'allpagelang', 'lang');
$router->map('GET|POST', '[a:com]/[a:action]', 'account', 'account');
$router->map('GET', THUMBS . '/[i:w]x[i:h]x[i:z]/[**:src]', function ($w, $h, $z, $src) {
    global $func;
    $infoWebp = $func->webpinfo($src);
    if (isset($infoWebp['Animation']) && $infoWebp['Animation'] === true) {
        $contentWebp = file_get_contents($src);
        header('Content-Type: image/webp');
        echo $contentWebp;
    } else {
        $func->createThumb($w, $h, $z, $src, null, THUMBS);
    }
}, 'thumb');
$router->map('GET', WATERMARK . '/product/[i:w]x[i:h]x[i:z]/[**:src]', function ($w, $h, $z, $src) {
    global $func, $d;
    $wtm = $d->rawQueryOne("select status, photo, options from #_photo where type = ? and act = ? limit 0,1", array('watermark', 'photo_static'));
    $func->createThumb($w, $h, $z, $src, $wtm, "product");
}, 'watermark');

$router->map('GET', WATERMARK . '/news/[i:w]x[i:h]x[i:z]/[**:src]', function ($w, $h, $z, $src) {
    global $func, $d;
    $wtm = $d->rawQueryOne("select status, photo, options from #_photo where type = ? and act = ? limit 0,1", array('watermark-news', 'photo_static'));
    $func->createThumb($w, $h, $z, $src, $wtm, "news");
}, 'watermarkNews');


/* Router match */
$match = $router->match();

/* Router check */
if (is_array($match)) {
    if (is_callable($match['target'])) {
        call_user_func_array($match['target'], $match['params']);
    } else {
        $com = (!empty($match['params']['com'])) ? htmlspecialchars($match['params']['com']) : htmlspecialchars($match['target']);
        $getPage = !empty($_GET['p']) ? htmlspecialchars($_GET['p']) : 1;
    }
} else {
    header('HTTP/1.0 404 Not Found', true, 404);
    include("404.php");
    exit;
}

/* Setting */
$sqlCache = "select * from #_setting";
$setting = $cache->get($sqlCache, null, 'fetch', 7200);
$optsetting = (!empty($setting['options'])) ? json_decode($setting['options'], true) : null;

/* Lang */
if (!empty($match['params']['lang'])) $_SESSION['lang'] = $match['params']['lang'];
else if (empty($_SESSION['lang']) && empty($match['params']['lang'])) $_SESSION['lang'] = $optsetting['lang_default'] ? $optsetting['lang_default'] : 'vi';
$lang = $_SESSION['lang'];

/* Check lang */
$weblang = (!empty($config['website']['lang'])) ? array_keys($config['website']['lang']) : array();

if (!in_array($lang, $weblang)) {
    $_SESSION['lang'] = 'vi';
    $lang = $_SESSION['lang'];
}

/* Slug lang */
$sluglang = 'slugvi';

/* SEO Lang */
$seolang = "vi";

/* Require datas lang */
require_once LIBRARIES . "lang/web/$lang.php";

/* Tối ưu link */
$requick = array(

    /* Bài viết */
    array("tbl" => "news", "field" => "id", "source" => "news", "com" => "dao-tao", "type" => "dao-tao", "menu" => true),
    array("tbl" => "news", "field" => "id", "source" => "news", "com" => "mo-phong", "type" => "mo-phong", "menu" => true),
    array("tbl" => "news", "field" => "id", "source" => "news", "com" => "thi-thu", "type" => "thi-thu", "menu" => true),
    array("tbl" => "news", "field" => "id", "source" => "news", "com" => "tai-lieu", "type" => "tai-lieu", "menu" => true),
    array("tbl" => "news", "field" => "id", "source" => "news", "com" => "khoa-hoc", "type" => "khoa-hoc", "menu" => true),
    array("tbl" => "news", "field" => "id", "source" => "news", "com" => "thong-bao", "type" => "thong-bao", "menu" => true),

    array("tbl" => "news", "field" => "id", "source" => "news", "com" => "tin-tuc", "type" => "tin-tuc", "menu" => false),
    array("tbl" => "news", "field" => "id", "source" => "news", "com" => "tieu-chi", "type" => "tieu-chi", "menu" => false),
    array("tbl" => "news", "field" => "id", "source" => "news", "com" => "thong-tin", "type" => "thong-tin", "menu" => false),
    array("tbl" => "news", "field" => "id", "source" => "news", "com" => "hinh-anh", "type" => "hinh-anh", "menu" => false),

    /* Trang tĩnh */
    array("tbl" => "static", "field" => "id", "source" => "static", "com" => "gioi-thieu", "type" => "gioi-thieu", "menu" => true),
);

/* Find data */
if (!empty($com) && !in_array($com, ['tim-kiem', 'account', 'sitemap', 'khuyen-mai'])) {
    foreach ($requick as $k => $v) {
        $urlTbl = (!empty($v['tbl'])) ? $v['tbl'] : '';
        $urlTblTag = (!empty($v['tbltag'])) ? $v['tbltag'] : '';
        $urlType = (!empty($v['type'])) ? $v['type'] : '';
        $urlField = (!empty($v['field'])) ? $v['field'] : '';
        $urlCom = (!empty($v['com'])) ? $v['com'] : '';

        if (!empty($urlTbl) && !in_array($urlTbl, ['static', 'photo'])) {
            $row = $d->rawQueryOne("select id from #_$urlTbl where $sluglang = ? and type = ? and find_in_set('hienthi',status) limit 0,1", array($com, $urlType));

            if (!empty($row['id'])) {
                $_GET[$urlField] = $row['id'];
                $com = $urlCom;
                break;
            }
        }
    }
}

/* Switch coms */
switch ($com) {
    case 'gioi-thieu':
        $source = "static";
        $template = "static/static";
        $type = $com;
        $seo->set('type', 'article');
        $titleMain = gioithieu;
        break;

    case 'mo-phong':
        $source = "news";
        $template = isset($_GET['id']) ? "news/news_detail" : "news/news";
        $seo->set('type', isset($_GET['id']) ? "article" : "object");
        $type = $com;
        $titleMain = "Mô phỏng";
        break;

    case 'thi-thu':
        $source = "news";
        $template = isset($_GET['id']) ? "news/news_detail" : "news/news";
        $seo->set('type', isset($_GET['id']) ? "article" : "object");
        $type = $com;
        $titleMain = "Thi Thử Lý Thuyết";
        break;

    case 'tai-lieu':
        $source = "news";
        $template = isset($_GET['id']) ? "news/news_detail" : "news/news";
        $seo->set('type', isset($_GET['id']) ? "article" : "object");
        $type = $com;
        $titleMain = "Tài liệu";
        break;

    case 'thong-bao':
        $source = "news";
        $template = isset($_GET['id']) ? "news/news_detail" : "news/news";
        $seo->set('type', isset($_GET['id']) ? "article" : "object");
        $type = $com;
        $titleMain = "Thông báo";
        break;

    case 'khoa-hoc':
        $source = "news";
        $template = isset($_GET['id']) ? "news/news_detail" : "news/courses";
        $seo->set('type', isset($_GET['id']) ? "article" : "object");
        $type = $com;
        $titleMain = "Khoá học";
        break;

    case 'dang-ky':
        $source = "news";
        $template = isset($_GET['id']) ? "news/news_detail" : "news/news";
        $seo->set('type', isset($_GET['id']) ? "article" : "object");
        $type = $com;
        $titleMain = "Đăng ký học";
        break;

    case 'dao-tao':
        $source = "news";
        $template = isset($_GET['id']) ? "news/news_detail" : "";
        $seo->set('type', isset($_GET['id']) ? "article" : "object");
        $type = $com;
        $titleMain = "";
        break;

    case 'tieu-chi':
        $source = "news";
        $template = isset($_GET['id']) ? "news/news_detail" : "";
        $seo->set('type', isset($_GET['id']) ? "article" : "object");
        $type = $com;
        $titleMain = "";
        break;

    case 'tin-tuc':
        $source = "news";
        $template = isset($_GET['id']) ? "news/news_detail" : "";
        $seo->set('type', isset($_GET['id']) ? "article" : "object");
        $type = $com;
        $titleMain = "";
        break;

    case 'thong-tin':
        $source = "news";
        $template = isset($_GET['id']) ? "news/news_detail" : "";
        $seo->set('type', isset($_GET['id']) ? "article" : "object");
        $type = $com;
        $titleMain = "";
        break;

    case 'hinh-anh':
        $source = "news";
        $template = isset($_GET['id']) ? "album/album_detail" : "";
        $seo->set('type', isset($_GET['id']) ? "article" : "object");
        $type = $com;
        $titleMain = "";
        break;

    case 'account':
        $source = "user";
        break;
        
    case 'ngon-ngu':
        if (isset($lang)) {
            switch ($lang) {
                case 'vi':
                    $_SESSION['lang'] = 'vi';
                    break;
                case 'en':
                    $_SESSION['lang'] = 'en';
                    break;
                default:
                    $_SESSION['lang'] = 'vi';
                    break;
            }
        }
        $func->redirect($_SERVER['HTTP_REFERER']);
        break;

    case 'sitemap':
        include_once LIBRARIES . "sitemap.php";
        exit();

    case '':
    case 'index':
        $titleMain = "";
        $source = "index";
        $template = "index/index";
        $seo->set('type', 'website');
        break;

    default:
        header('HTTP/1.0 404 Not Found', true, 404);
        include("404.php");
        exit();
}

/* Require datas for all page */
require_once SOURCES . "allpage.php";

/* Include sources */
if (!empty($source)) {
    include SOURCES . $source . ".php";
}

/* Include sources */
if (empty($template)) {
    header('HTTP/1.0 404 Not Found', true, 404);
    include("404.php");
    exit();
}