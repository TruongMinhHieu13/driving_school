<?php
if (!defined('LIBRARIES')) die("Error");

/* Timezone */
date_default_timezone_set('Asia/Ho_Chi_Minh');

/* Cấu hình coder */
define('NN_CONTRACT', '0900824');
define('NN_AUTHOR', 'minhhieu2505.nina@gmail.com');

/* Cấu hình chung */
/* PHP Ver: 8.2.4 | Update: 04-11-2023 */
$config = array(
    'author' => array(
        'name' => 'Minh Hiếu',
        'email' => 'minhhieu2505.nina@gmail.com',
        'timefinish' => '8/2024'
    ),
    'arrayDomainSSL' => array(),
    'database' => array(
        'server-name' => $_SERVER["SERVER_NAME"],
        'url' => '/2024/T8/tiendat_0900824w/',
        'type' => 'mysql',
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'dbname' => '24_7_tiendat',
        'port' => 3306,
        'prefix' => 'table_',
        'charset' => 'utf8mb4'
    ),
    'website' => array(
        'error-reporting' => false, // Bắt buộc để false cho các chức năng hoạt động ổn định
        'secret' => '$nina@',
        'salt' => '@hf#@%21%',
        'debug-developer' => false,
        'debug-css' => true,
        'debug-js' => true,
        'index' => false,
        'linkredirect' => false,
        'image' => array(),
        'noseo' => array('user', 'order', 'search'), 
        'video' => array(
            'extension' => array('mp4', 'mkv'),
            'poster' => array(
                'width' => 700,
                'height' => 610,
                'extension' => '.jpg|.png|.jpeg'
            ),
            'allow-size' => '100Mb',
            'max-size' => 100 * 1024 * 1024
        ),
        'upload' => array(
            'max-width' => 1920,
            'max-height' => 1600
        ),
        'adminlang' => array(
            'active' => false,
            'key' => array('vi'),
            'lang' => array(
                'vi' => 'Tiếng Việt'
            )
        ),
        'lang' => array(
            'vi' => 'Tiếng Việt',
        ),
        'lang-doc' => 'vi',
        'slug' => array(
            'vi' => 'Tiếng Việt'
        ),
        'seo' => array(
            'vi' => 'Tiếng Việt'
        ),
        'ckfinderkey' => array(
            'demo69.ninavietnam.org' => 'B989WHAF6HJBQ7JFLVS1X5R4VYLBT',
            'localhost' => 'FMHM1RKGEP4NTF1D3D1Y47ESV8JJH'
        ),
        'comlang' => array(
        )
    ),
    'order' => array(
        'ship' => false
    ),
    'login' => array(
        'admin' => 'LoginAdmin' . NN_CONTRACT,
        'member' => 'LoginMember' . NN_CONTRACT,
        'attempt' => 5,
        'delay' => 15
    ),
    'googleAPI' => array(
        'recaptcha' => array(
            'active' => true,
            'urlapi' => 'https://www.google.com/recaptcha/api/siteverify',
            'sitekey' => '6LfY6nIfAAAAAHrAIU7iQXCtS02pi1lYxRslwMgL',
            'secretkey' => '6LfY6nIfAAAAAMvNKaK3wICNpDKpMnc5qBKo3bkU'
        )
    ),
    'oneSignal' => array(
        'active' => false,
        'id' => 'af12ae0e-cfb7-41d0-91d8-8997fca889f8',
        'restId' => 'MWFmZGVhMzYtY2U0Zi00MjA0LTg0ODEtZWFkZTZlNmM1MDg4'
    )
);

/* Error reporting */
error_reporting(($config['website']['error-reporting']) ? E_ALL : 0);
/* Cấu hình http */
if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
    $http = 'https://';
} else {
    $http = 'http://';
}

/* Redirect http/https */
if (!count($config['arrayDomainSSL']) && $http == 'https://') {
    $host = $_SERVER['HTTP_HOST'];
    $request_uri = $_SERVER['REQUEST_URI'];
    $good_url = "http://" . $host . $request_uri;
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: $good_url");
    exit;
}

/* CheckSSL */
if (count($config['arrayDomainSSL'])) {
    include LIBRARIES . "checkSSL.php";
}

/* Cấu hình base */
$configUrl = $config['database']['server-name'] . $config['database']['url'];
$configBase = $http . $configUrl;

/* Token */
define('TOKEN', md5(NN_CONTRACT . $config['database']['url']));

/* Path */
define('ROOT', str_replace(basename(__DIR__), '', __DIR__));
define('ASSET', $http . $configUrl);
define('ADMIN', 'admin');

/* Cấu hình login */
$loginAdmin = $config['login']['admin'];
$loginMember = $config['login']['member'];

/* Cấu hình upload */
require_once LIBRARIES . "constant.php";