<?php
if (!defined('SOURCES')) die("Error");

/* Cấu hình đường dẫn trả về */
$strUrl = "";
$arrUrl = array('id_list', 'id_cat', 'id_item', 'id_sub', 'id_brand');
if (isset($_POST['data'])) {
    $dataUrl = isset($_POST['data']) ? $_POST['data'] : null;
    if ($dataUrl) {
        foreach ($arrUrl as $k => $v) {
            if (isset($dataUrl[$arrUrl[$k]])) $strUrl .= "&" . $arrUrl[$k] . "=" . htmlspecialchars($dataUrl[$arrUrl[$k]]);
        }
    }
} else {
    foreach ($arrUrl as $k => $v) {
        if (isset($_REQUEST[$arrUrl[$k]])) $strUrl .= "&" . $arrUrl[$k] . "=" . htmlspecialchars($_REQUEST[$arrUrl[$k]]);
    }
    if (isset($_REQUEST['keyword'])) $strUrl .= "&keyword=" . htmlspecialchars($_REQUEST['keyword']);
    if (isset($_REQUEST['fill'])) $strUrl .= "&fill=" . htmlspecialchars($_REQUEST['fill']);
    
}
switch ($act) {
        /* Man */
    case "man":
        viewMans();
        $template = "history/man/mans";
        break;
    case "fee":
        viewFee();
        $template = "history/man/fee";
        break;
    case "getFile":
        getFile();
        break;
    default:
        $template = "404";
}

/* View man */
function viewMans()
{
    global $d, $func,$strUrl, $curPage, $items, $paging, $config, $fill;

    $where = "";

    
    /* Xoá file quá hạn 90 ngày */
    $relativeDirectory = $config['database']['url'].'upload/file/operation/';
    $directory = $_SERVER['DOCUMENT_ROOT'] . $relativeDirectory;

    if (!is_dir($directory)) {
        $func->transfer("Thư mục không tồn tại: $directory\n","index.php?com=history&act=man",false);
    }
    $files = scandir($directory);

    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            $filePath = $directory . $file;
            if (is_file($filePath)) {
                $fileModifiedTime = filemtime($filePath);
                $currentTime = time();
                $daysOld = ($currentTime - $fileModifiedTime) / (60 * 60 * 24);
                if ($daysOld > 90) {
                    unlink($filePath);
                }
            }
        }
    }

    $fill = (!empty($_GET['fill']) ? $_GET['fill'] : '');

    /* Xoá data quá hạn 90 ngày */
    $now = new DateTime();
    $now->modify('-90 days');
    $timestamp = $now->getTimestamp();
    $delete = $d->rawQuery("delete from #_user_operation where date_created < ?",array($timestamp));

   if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (descvi LIKE '%$keyword%')";
    }

    if ($fill == 'import') {
        $where .= " and (descvi LIKE '%import%')";
    }
    
    if ($fill == 'export') {
        $where .= " and (descvi LIKE '%export%')";
    }


    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_user_operation where type != 'fee' and type !='fee-retest' and type !='tuition_fee' $where order by date_created desc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from #_user_operation where type != 'fee' and type !='fee-retest' and type !='tuition_fee' $where order by date_created desc";
    $count = $d->rawQueryOne($sqlNum);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=history&act=man" . $strUrl;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}


/* View man */
function viewFee()
{
    global $d, $func,$strUrl, $curPage, $items, $paging, $config;
    $where = "";

    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (descvi LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_user_operation where (type = ? or type = ? or type = ?) $where order by date_created desc $limit";
    $items = $d->rawQuery($sql,array('fee-retest','fee','tuition_fee'));
    $sqlNum = "select count(*) as 'num' from #_user_operation where (type = ? or type = ?) $where order by date_created desc";
    $count = $d->rawQueryOne($sqlNum,array('fee-retest','fee','tuition_fee'));
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=history&act=fee" . $strUrl;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Get File */
function getFile()
{
    global $d, $func,$strUrl, $curPage, $items, $id, $config;
    
    $id = (!empty($_REQUEST['id']) ? $_REQUEST['id'] : 0);

    // Đường dẫn tương đối từ thư mục gốc của máy chủ web
    $relativeDirectory = $config['database']['url'].'upload/file/operation/';

    // Tạo đường dẫn tuyệt đối bằng cách kết hợp DOCUMENT_ROOT và đường dẫn tương đối
    $directory = $_SERVER['DOCUMENT_ROOT'] . $relativeDirectory;

    if ($id > 0) {
        $filename = $func->getInfoDetail('file','user_operation',$id)['file'];
        $luottai = $func->getInfoDetail('downloads','user_operation',$id)['downloads'];
        $type = $func->getInfoDetail('type','user_operation',$id)['type'];

        // Cập nhật lượt tải về
        $data['downloads'] = ($luottai + 1);
        $d->where('id', $id);
        $d->update('user_operation', $data);
        $directory = $directory.$filename;
        if($type == 'import-excel-bc2' || $type == 'import-excel-bc1' || $type == 'import-excel-sh') $filename= $filename.'.xlsx';

        if (file_exists($directory)) {
            // Gửi file xuống trình duyệt
            header('Content-Type: application/zip');
            header('Content-disposition: attachment; filename='.$filename);
            header('Content-Length: ' . filesize($directory));
            readfile($directory);
            exit;
        } else {
            $func->transfer("File không tồn tại","index.php?com=history&act=man",false);
        }
    } else {
        $func->transfer("Không nhận được dữ liệu","?com=history&act=man",false);
    }
}

