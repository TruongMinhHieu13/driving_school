<?php
if (!defined('SOURCES')) die("Error");
/* Cấu hình đường dẫn trả về */
$strUrl = "";
$arrUrl = array('courses-name', 'fill', 'courses-id', 'gplx', 'date_open','student-name','student-id','student-cmt','date_close','test-status','date_sh','date_close');
foreach ($arrUrl as $k => $v) {
    if (isset($_REQUEST[$arrUrl[$k]])) $strUrl .= "&" . $arrUrl[$k] . "=" . htmlspecialchars($_REQUEST[$arrUrl[$k]]);
}

switch ($act) {
        /* Man */
    case "man":
        viewMans();
        $template = "graduate/man/mans";
        break;

    case "manImport":
        viewMans();
        $template = "graduate/man/mans";
        break;
        
    default:
        $template = "404";
}

/* View man */
function viewMans()
{
    global $d, $func,$strUrl, $curPage, $items, $paging, $dataResult, $arrayGPLX, $fee, $act, $statusGraduate, $statusTest, $result_bc2;

    $where = "";
    $whereCourses = "";
    $date_open = (isset($_REQUEST['date_open'])) ? htmlspecialchars($_REQUEST['date_open']) : 0;
    $date_close = (isset($_REQUEST['date_close'])) ? htmlspecialchars($_REQUEST['date_close']) : 0;
    $date_sh = (isset($_REQUEST['date_sh'])) ? htmlspecialchars($_REQUEST['date_sh']) : 0;
    $result_bc2 = (!empty($_REQUEST['result-bc2']) ? $_REQUEST['result-bc2'] : 0);
    $statusTest = (!empty($_REQUEST['test-status']) ? $_REQUEST['test-status'] : 0);

    if (!empty($_REQUEST['courses-id'])) {
        // Show data search
        $dataResult['courses_id'] = explode(",", $_REQUEST['courses-id']);

        foreach($dataResult['courses_id'] as $s => $vc){
            $where .= ($s == 0 ? ' and (' : ' or') ." MA_KHOA_HOC = '".$vc."'";
        }
        $where = $where.")";
    }

    // echo $where;

    if (!empty($_REQUEST['gplx'])) {
        // Show data search
        $arrayGPLX = explode(",", $_REQUEST['gplx']);

        foreach($arrayGPLX as $s => $v){
            $where .= ($s == 0 ? ' and (' : ' or') ." HANG_GPLX = '".$v."'";
        }
        $where = $where.")";
    }

    if (!empty($_REQUEST['student-name'])) {
        // Show data search
        $dataResult['student-name'] = explode(",", $_REQUEST['student-name']);

        foreach($dataResult['student-name'] as $s => $vc){
            $where .= ($s == 0 ? ' and (' : ' or') ." HO_VA_TEN LIKE '%".$vc."%'";
        }
        $where = $where.")";
    }
    
    if (!empty($_REQUEST['student-id'])) {
        // Show data search
        $dataResult['student-id'] = explode(",", $_REQUEST['student-id']);

        foreach($dataResult['student-id'] as $s => $vc){
            $where .= ($s == 0 ? ' and (' : ' or') ." MA_DK = '".$vc."'";
        }
        $where = $where.")";
    }
    
    if (!empty($_REQUEST['student-cmt'])) {
        // Show data search
        $dataResult['student-cmt'] = explode(",", $_REQUEST['student-cmt']);

        foreach($dataResult['student-cmt'] as $s => $vc){
            $where .= ($s == 0 ? ' and (' : ' or') ." SO_CMT = '".$vc."'";
        }
        $where = $where.")";
    }

    if (!empty($statusTest)) {
        if($statusTest == 1) $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) = 'DA'";
        elseif($statusTest == 3) $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) = 'KDDK'";
        elseif($statusTest == 2) $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) != 'KDDK' and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) != 'DA'";
    }

    // Lấy thông tin khoá học. Truy vấn học viên của khoá đó

    if (!empty($_REQUEST['courses-name'])) {
        // Show data search
        $dataResult['courses-name'] = explode(",", $_REQUEST['courses-name']);

        $condition = '';
        foreach($dataResult['courses-name'] as $s => $vc){
            $condition .= ($s == 0 ? ' (' : ' or') ." TEN_KHOA_HOC = '".$vc."'";
        }
        $condition = $condition.")";

        // Lấy id khoá học
        $id_courses = $d->rawQuery("select MA_KHOA_HOC from #_courses where ".$condition);

        if(!empty($id_courses)){
            foreach ($id_courses as $s => $course) {
                $where .= ($s == 0 ? ' and (' : ' or') ." MA_KHOA_HOC = '".$course['MA_KHOA_HOC']."'";
            }
            $where = $where.")";
        }else {
            $where = ' and  numb < 0';
        }
    }

    if (!empty($date_open)) {
        $date_open = explode("-", $date_open);
        $date_from = trim($date_open[0] . ' 12:00:00 AM');
        $date_to = trim($date_open[1] . ' 11:59:59 PM');
        $date_from = strtotime(str_replace("/", "-", $date_from));
        $date_to = strtotime(str_replace("/", "-", $date_to));
        $whereCourses .= " and NGAY_KHAI_GIANG<=$date_to and NGAY_KHAI_GIANG>=$date_from";
    }

    if (!empty($date_close)) {
        $date_close = explode("-", $date_close);
        $date_from = trim($date_close[0] . ' 12:00:00 AM');
        $date_to = trim($date_close[1] . ' 11:59:59 PM');
        $date_from = strtotime(str_replace("/", "-", $date_from));
        $date_to = strtotime(str_replace("/", "-", $date_to));
        $whereCourses .= " and NGAY_BE_GIANG<=$date_to and NGAY_BE_GIANG>=$date_from";
    }

    if (!empty($date_sh)) {
        $date_sh = explode("-", $date_sh);
        $date_from = trim($date_sh[0] . ' 12:00:00 AM');
        $date_to = trim($date_sh[1] . ' 11:59:59 PM');
        $date_from = strtotime(str_replace("/", "-", $date_from));
        $date_to = strtotime(str_replace("/", "-", $date_to));
        $whereCourses .= " and NGAY_SAT_HACH<=$date_to and NGAY_SAT_HACH>=$date_from";
    } 

    if (!empty($whereCourses) && $whereCourses != '') {
        // Lấy id khoá học
        $idCourses = $d->rawQuery("select MA_KHOA_HOC from #_courses where id <> 0 ".$whereCourses);

        if(!empty($idCourses)){
            foreach ($idCourses as $s => $course) {
                $where .= ($s == 0 ? ' and (' : ' or') ." MA_KHOA_HOC = '".$course['MA_KHOA_HOC']."'";
            }
            $where = $where.")";
        }else {
            $where = ' and  numb < 0';
        }
    }

    if (!empty($result_bc2) && $result_bc2 == 1) {
        $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KQ_BC2')) = 1";
    }
    if (!empty($result_bc2) && $result_bc2 == 2) {
        $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KQ_BC2')) = 0";
    }

    if (!empty($statusTest)) {
        if($statusTest == 1) $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) = 'DA'";
        elseif($statusTest == 3) $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) = 'KDDK'";
        elseif($statusTest == 2) $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) != 'KDDK' and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) != 'DA'";
    }

    $where .= " and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.theory.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.geometry.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.cabin.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.dat.point')) > 0";

    if ($act == 'manImport') {
        $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KQ_BC2')) > 0";
    } 
    if ($act == 'man') {
        $where .= " and (NOT JSON_CONTAINS_PATH(data_student, 'one', '$.KET_QUA_SH') OR JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) IS NULL OR JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) = '' OR JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) != 'DA') ";
    }

 
    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_student where id <> 0 $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from #_student where id <> 0 $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum);
    $sqlTT = "SELECT SUM(JSON_EXTRACT(infor_student, '$.tuition_fee')) AS total_tuition_fee FROM table_student  WHERE id <> 0 ".$where;
    $totalPrice = $d->rawQueryOne($sqlTT);
    $fee = $totalPrice['total_tuition_fee'];

    $total = (!empty($count)) ? $count['num'] : 0;
    if ($act == 'manImport') $url = "index.php?com=graduate&act=manImport" . $strUrl;
    else $url = "index.php?com=graduate&act=man" . $strUrl;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}
