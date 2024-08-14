<?php
if (!defined('SOURCES')) die("Error");

/* Cấu hình đường dẫn trả về */
$strUrl = "";
$arrUrl = array('courses-name', 'fill', 'courses-id', 'gplx', 'date_open','student-name','student-id','student-cmt','date_close','type','status','graduate-status','test-status');
foreach ($arrUrl as $k => $v) {
    if (isset($_REQUEST[$arrUrl[$k]])) $strUrl .= "&" . $arrUrl[$k] . "=" . htmlspecialchars($_REQUEST[$arrUrl[$k]]);
}
switch ($act) {
        /* Man */
    case "man":
        viewMans();
        $template = "student/man/mans";
        break;

    case "getBC1":
        viewMans();
        $template = "student/man/mans";
        break;

    case "add":
        $template = "student/man/man_add";
        break;
    case "edit":
        editMan();
        $template = "student/man/man_add";
        break;
    case "save":
        saveMan();
        break;
    case "delete":
        deleteMan();
        break;

    // GPLX
    case "gplx":
        viewGPLX();
        $template = "student/gplx/mans";
        break;

    case "add-gplx":
        $template = "student/gplx/mans_add";
        break;

    case "edit-gplx":
        editGPLX();
        $template = "student/gplx/mans_add";
        break;

    case "save-gplx":
        saveGPLX();
        break;
    
    case "delete-gplx":
        deleteGPLX();
        break;

    // Duyệt TN
    case "manGraduate":
        viewMans();
        $template = "student/graduate/graduate";
        break;

    // Update Graduate
    case "updateGraduate":
        updateGraduate();
        break;

    // Collect graduation fees
    case "collect-graduation":
        viewMans();
        $template = "student/graduate/collect";
        break;

    default:
        $template = "404";
}

/* View man */
function viewMans()
{
    global $d, $func,$strUrl, $curPage, $items, $paging, $dataResult, $arrayGPLX, $fee, $act, $type, $statusGraduate, $statusTest, $subjectStatus, $count;

    $where = " ";
    $whereCourses = "";
    $date_open = (isset($_REQUEST['date_open'])) ? htmlspecialchars($_REQUEST['date_open']) : 0;
    $date_close = (isset($_REQUEST['date_close'])) ? htmlspecialchars($_REQUEST['date_close']) : 0;
    $date_sh = (isset($_REQUEST['date_sh'])) ? htmlspecialchars($_REQUEST['date_sh']) : 0;
    $fill = (isset($_REQUEST['fill'])) ? htmlspecialchars($_REQUEST['fill']) : '';
    $statusGraduate = (!empty($_REQUEST['graduate-status']) ? $_REQUEST['graduate-status'] : 0);
    $statusTest = (!empty($_REQUEST['test-status']) ? $_REQUEST['test-status'] : 0);
    $subjectStatus = (!empty($_REQUEST['subject-status']) ? $_REQUEST['subject-status'] : 0);

    if (!empty($fill) && $fill != "man") {
        (!empty($where) && $where == " " ? $where .= 'id <> 0' : $where);
        if($fill == 'graduate') $where .= " and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.theory.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.geometry.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.cabin.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.dat.point')) > 0";  
        elseif($fill == 'KDDK') $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) = 'KDDK'";   
        elseif($fill == 'failed-examination') $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) != 'DA'";  
        elseif($fill == 'pass-examination')  $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) = 'DA'"; 
        else $where .= " and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.".$fill.".point')) > 0";
    }

    if (!empty($act == "manGraduate") && $act == "manGraduate") {
        (!empty($where) && $where == " " ? $where .= 'id <> 0' : $where);
        $status = (isset($_REQUEST['status'])) ? htmlspecialchars($_REQUEST['status']) : '';
        if ($status == "pass") {
            $where .= "  and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.'".$type."'.point')) > 0";
        }
    }

    if (!empty($_REQUEST['student-name'])) {
        $dataResult['student-name'] = explode(",", $_REQUEST['student-name']);
        $where = $func->getCondition($dataResult['student-name'],'HO_VA_TEN',$where);
    }

    if (!empty($_REQUEST['gplx'])) {
        $arrayGPLX = explode(",", $_REQUEST['gplx']);
        $where = $func->getCondition($arrayGPLX,'HANG_GPLX',$where);
    }

    if (!empty($_REQUEST['courses-id'])) {
        $dataResult['courses-id'] = explode(",", $_REQUEST['courses-id']);
        $where = $func->getCondition($dataResult['courses-id'],'MA_KHOA_HOC',$where);
    }
    
    if (!empty($_REQUEST['student-id'])) {
        $dataResult['student-id'] = explode(",", $_REQUEST['student-id']);
        $where = $func->getCondition( $dataResult['student-id'],'MA_DK',$where);
    }
    
    if (!empty($_REQUEST['student-cmt'])) {
        $dataResult['student-cmt'] = explode(",", $_REQUEST['student-cmt']);
        $where = $func->getCondition($dataResult['student-cmt'],'SO_CMT',$where);
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
            $where = $func->getCondition($id_courses,'MA_KHOA_HOC',$where, false);
        }else {
            (!empty($where) && $where == " " ? $where .= 'id <> 0' : $where);
            $where .= ' and  numb < 0';
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
            $where = $func->getCondition($id_courses,'MA_KHOA_HOC',$where);
        }else {
            (!empty($where) && $where == " " ? $where .= 'id <> 0' : $where);
            $where .= ' and  numb < 0';
        }
    }

    if (!empty($statusGraduate) && $statusGraduate == 1) {
        (!empty($where) && $where == " " ? $where .= 'id <> 0' : $where);
        $where .= " and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.theory.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.geometry.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.cabin.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.dat.point')) > 0";
    }
    if (!empty($statusGraduate) && $statusGraduate == 2) {
        (!empty($where) && $where == " " ? $where .= 'id <> 0' : $where);
        $where .= " and (JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.theory.point')) = 0 or JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.geometry.point')) = 0 or JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.cabin.point')) = 0 or JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.dat.point')) = 0)";
    }

    if (!empty($statusTest)) {
        (!empty($where) && $where == " " ? $where .= 'id <> 0' : $where);
        if($statusTest == 1) $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) = 'DA'";
        elseif($statusTest == 3) $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) = 'KDDK'";
        elseif($statusTest == 2) $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) != 'KDDK' and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) != 'DA'";
    }

    if (!empty($_REQUEST['subject-status']) && $_REQUEST['subject-status'] == 1) {
        (!empty($where) && $where == " " ? $where .= 'id <> 0' : $where);
        $where .= " and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.".$type.".point')) > 0";
    }
    if (!empty($_REQUEST['subject-status']) && $_REQUEST['subject-status'] == 2) {
        (!empty($where) && $where == " " ? $where .= 'id <> 0' : $where);
        $where .= " and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.".$type.".point')) = 0";
    }

    if ($act == 'getBC1') { 
        (!empty($where) && $where == " " ? $where .= 'id <> 0' : $where);
        $where .= " and `MA_DK` = '' ";  
    }
    
    if ($act == 'collect-graduation') {
        (!empty($where) && $where == " " ? $where .= 'id <> 0' : $where);
        $where .= " and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.theory.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.geometry.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.cabin.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.dat.point')) > 0";  
    }
<<<<<<< HEAD

    echo $where;

=======
    
>>>>>>> 9b29925d519b88e424a6ac27d59f4ea93f3cff3f
    $perPage = 50;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_student where ".(!empty($where) && $where == ' ' ? 'id <> 0' : $where)." order by numb,id desc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from #_student where ".(!empty($where) && $where == ' ' ? 'id <> 0' : $where)." order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum);

    // $sqlTT = "SELECT SUM(JSON_EXTRACT(infor_student, '$.tuition_fee')) AS total_tuition_fee FROM table_student  WHERE id <> 0 ".$where;
    // $totalPrice = $d->rawQueryOne($sqlTT);
    // $fee = $totalPrice['total_tuition_fee'];

    $total = (!empty($count)) ? $count['num'] : 0;
    
    if ($act == 'collect-graduation') $url = "index.php?com=student&act=collect-graduation" . $strUrl;
    elseif ($act == 'getBC1') $url = "index.php?com=student&act=getBC1" . $strUrl;
    elseif ($act == 'manGraduate') $url = "index.php?com=student&act=manGraduate" . $strUrl;
    else $url = "index.php?com=student&act=man" . $strUrl;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Edit man */
function editMan()
{
    global $d, $strUrl, $func, $item, $curPage, $dataStudent, $infoStudent;

    if (!empty($_GET['id'])) $id = htmlspecialchars($_GET['id']);
    else if (!empty($_GET['id_copy'])) $id = htmlspecialchars($_GET['id_copy']);
    else $id = 0;

    if (empty($id)) {
        $func->transfer(khongnhanduocdulieu, "index.php?com=student&act=man&p=" . $curPage . $strUrl, false);
    } else {
        $item = $d->rawQueryOne("select * from #_student where id = ? limit 0,1", array($id));
        $dataStudent = json_decode($item['data_student'], true);
        $infoStudent = json_decode($item['infor_student'], true);

        if (empty($item)) {
            $func->transfer(dulieukhongcothuc, "index.php?com=student&act=man&p=" . $curPage . $strUrl, false);
        }
    }
}

/* Save man */
function saveMan()
{
    global $d, $strUrl, $func, $flash, $curPage, $act, $loginAdmin;

    /* Check post */
    if (empty($_POST)) {
        $func->transfer(khongnhanduocdulieu, "index.php?com=student&act=man&p=" . $curPage . $strUrl, false);
    }

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $savehere = (isset($_POST['save-here'])) ? true : false;
    $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $data = !empty($_POST['data']) ? $_POST['data'] : null;
    $dataInternal = !empty($_POST['dataInternal']) ? $_POST['dataInternal'] : null;
    $dataStudent = !empty($_POST['dataStudent']) ? $_POST['dataStudent'] : null;
    if ($data) {
        foreach ($data as $column => $value) {
            $data[$column] = htmlspecialchars($func->sanitize($value));
        }
    }


    /* Valid data */
    if (empty($dataStudent['HO_TEN_DEM'])) {
        $response['messages'][] = "Bạn chưa nhập họ tên đệm";
    }
    
    if (empty($dataStudent['TEN'])) {
        $response['messages'][] = "Bạn chưa nhập tên";
    }
    
    if (empty($data['HO_VA_TEN'])) {
        $response['messages'][] = "Bạn chưa nhập họ và tên";
    }
    
    if (empty($dataStudent['NGAY_SINH'])) {
        $response['messages'][] = "Bạn chưa chọn ngày sinh";
    }

    if (empty($data['SO_CMT'])) {
        $response['messages'][] = "Bạn chưa nhập số CMND/CCCD/Hộ Chiếu";
    }

    if (empty($dataStudent['HO_VA_TEN_IN'])) {
        $response['messages'][] = "Bạn chưa nhập họ và tên in hoa";
    }
    
    if($act == 'add')
    {
        if(!empty($data['SO_CMT'])){
            $row = $d->rawQueryOne("select id from #_student where SO_CMT = ? and HANG_GPLX = ? limit 0,1", array($data['SO_CMT'],$data['HANG_GPLX']));
            if (!empty($row)) {
                $response['messages'][] = "Số CMND/CCCD/Hộ Chiếu đã tồn tại ở hạng gplx này !";
            }
        }
    }
    
    if(!empty($dataInternal['driving_seniority'])){
        if (empty($dataStudent['NGAY_CAP_GPLX_DACO'])) {
            $response['messages'][] = "Bạn phải nhập ngày cấp GPLX đã có !";
        } else {
            // Ngày đầu tiên
            $date1 = new DateTime($dataInternal['driving_seniority']);
            // Ngày thứ hai
            $date2 = new DateTime($dataStudent['NGAY_CAP_GPLX_DACO']);

            // Tính khoảng cách năm
            $interval = $date1->diff($date2);

            // Lấy khoảng cách năm
            $yearsDifference = $interval->y;

            // Hiển thị kết quả
            if($yearsDifference < 3){
                $response['messages'][] = "Người lái xe phải có thâm niên từ 3 năm trở lên mới có thể đăng ký gplx NH C";
            }
        }
    }


    if (!empty($response)) {
        /* Flash data */
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                if (!empty($v)) {
                    $flash->set($k, $v);
                }
            }
        }
        if (!empty($dataStudent)) {
            foreach ($dataStudent as $k => $v) {
                if (!empty($v)) {
                    $flash->set($k, $v);
                }
            }
        }
        if (!empty($dataInternal)) {
            foreach ($dataInternal as $k => $v) {
                if (!empty($v)) {
                    $flash->set($k, $v);
                }
            }
        }

        /* Errors */
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set('message', $message);

        if ($id) {
            $func->redirect("index.php?com=student&act=edit&p=" . $curPage . $strUrl . "&id=" . $id);
        } else {
            $func->redirect("index.php?com=student&act=add&p=" . $curPage . $strUrl);
        }
    }

    // Convert Date 'Ymd'

    if(!empty($dataStudent['NGAY_CAP_GPLX_DACO'])){
        $dataStudent['NGAY_CAP_GPLX_DACO'] = strtotime(str_replace("/", "-", $dataStudent['NGAY_CAP_GPLX_DACO']));
    }
    
    if(!empty($dataStudent['NGAY_SINH'])){
        $dataStudent['NGAY_SINH'] = strtotime(str_replace("/", "-", $dataStudent['NGAY_SINH']));
    }
    
    if(!empty($dataStudent['NGAY_CAP_CMT'])){
        $dataStudent['NGAY_CAP_CMT'] = strtotime(str_replace("/", "-", $dataStudent['NGAY_CAP_CMT']));
    }

    if(!empty($dataStudent['NGAY_HH_GPLX_DACO'])){
        $dataStudent['NGAY_HH_GPLX_DACO'] = strtotime(str_replace("/", "-", $dataStudent['NGAY_HH_GPLX_DACO']));
    }
    
    if(!empty($dataStudent['NGAY_TT_GPLX_DACO'])){
        $dataStudent['NGAY_TT_GPLX_DACO'] = strtotime(str_replace("/", "-", $dataStudent['NGAY_TT_GPLX_DACO']));
    }

    if (!empty($dataInternal['health_certificate'])) {
        $dataInternal['health_certificate'] = strtotime(str_replace("/", "-", $dataInternal['health_certificate']));
    }

    if (!empty($dataInternal['date_receipt'])) {
        $dataInternal['date_receipt'] = strtotime(str_replace("/", "-", $dataInternal['date_receipt']));
    }

    if (!empty($dataInternal['driving_seniority'])) {
        $dataInternal['driving_seniority'] = strtotime(str_replace("/", "-", $dataInternal['driving_seniority']));
    }

    if(!empty($dataInternal['tuition_fee'])){
        $dataInternal['tuition_fee'] = (isset($dataInternal['tuition_fee']) && $dataInternal['tuition_fee'] != '') ? str_replace(",", "", $dataInternal['tuition_fee']) : 0;
    }

    $data['infor_student'] = json_encode($dataInternal);
    $data['data_student'] = json_encode($dataStudent);

    /* Đổi học phí */
    if (!empty($dataInternal['tuition_fee'])) {
        $row = $d->rawQueryOne("select id, photo, JSON_UNQUOTE(JSON_EXTRACT(infor_student, '$.tuition_fee')) as fee from #_student where id = ? and JSON_UNQUOTE(JSON_EXTRACT(infor_student, '$.tuition_fee')) > 0 limit 0,1", array($id));
        if (!empty($row)) {
            if ($row['fee'] != $dataInternal['tuition_fee']) {
                /* Lưu lại lịch sử nếu có nhập học phí */
                $dataHistory['namevi'] = '';
                $dataHistory['descvi'] = 'Cập nhật học phí - '.$data['HO_VA_TEN'].' - '.$data['SO_CMT'].' - '.$func->formatMOney($dataInternal['tuition_fee']);
                $dataHistory['file'] = '';
                $dataHistory['type'] = 'tuition_fee';
                $dataHistory['quantity'] = 0;
                $dataHistory['date_created'] = time();
                $dataHistory['id_downloader'] = $_SESSION[$loginAdmin]['id'];
                $dataHistory['downloads'] = 0;
                $d->insert('user_operation', $dataHistory);
            }
        } else {
            /* Lưu lại lịch sử nếu có nhập học phí */
            $dataHistory['namevi'] = '';
            $dataHistory['descvi'] = 'Thu học phí - '.$data['HO_VA_TEN'].' - '.$data['SO_CMT'].' - '.$func->formatMOney($dataInternal['tuition_fee']);
            $dataHistory['file'] = '';
            $dataHistory['type'] = 'tuition_fee';
            $dataHistory['quantity'] = 0;
            $dataHistory['date_created'] = time();
            $dataHistory['id_downloader'] = $_SESSION[$loginAdmin]['id'];
            $dataHistory['downloads'] = 0;
            $d->insert('user_operation', $dataHistory);
        }
    }

    /* Save data */
    if ($id && $act != 'save_copy') {
        $data['date_updated'] = time();

        $d->where('id', $id);
        if ($d->update('student', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);

                if ($photo = $func->uploadImage("file", ".jpg|.gif|.png|.jpeg|.gif|.webp|.WEBP", UPLOAD_STUDENT, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from #_student where id = ? limit 0,1", array($id));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_STUDENT . $row['photo']);
                    }
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    unset($photoUpdate);
                }
            }

            if ($savehere) {
                $func->transfer(capnhatdulieuthanhcong, "index.php?com=student&act=edit&p=" . $curPage . $strUrl . "&id=" . $id);
            } else {
                $func->transfer(capnhatdulieuthanhcong, "index.php?com=student&act=man&p=" . $curPage . $strUrl);
            }
        } else {
            if ($savehere) {
                $func->transfer(capnhatdulieubiloi, "index.php?com=student&act=edit&p=" . $curPage . $strUrl . "&id=" . $id, false);
            } else {
                $func->transfer(capnhatdulieubiloi, "index.php?com=student&act=man&p=" . $curPage . $strUrl, false);
            }
        }
    } else {
        $data['date_created'] = time();
        // Tạo giá trị mặc định cho trường graduate
        $data_result_test['theory']['note'] = '';
        $data_result_test['theory']['point'] = 1;
        $data_result_test['geometry']['note'] = '';
        $data_result_test['geometry']['point'] = 1;
        $data_result_test['cabin']['note'] = '';
        $data_result_test['cabin']['point'] = 0;
        $data_result_test['dat']['note'] = '';
        $data_result_test['dat']['point'] = 0;
        $data_result_test['fee-graduation'] = 0;
        $data['graduate'] = json_encode($data_result_test);

        if ($d->insert('student', $data)) {
            $id_insert = $d->getLastInsertId();
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);

                if ($photo = $func->uploadImage("file", ".jpg|.gif|.png|.jpeg|.gif|.webp|.WEBP", UPLOAD_STUDENT, $file_name)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('student', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            if (!empty($dataInternal['tuition_fee']) && $dataInternal['tuition_fee'] > 0) {
                /* Lưu lại lịch sử nếu có nhập học phí */
                $dataHistory['namevi'] = '';
                $dataHistory['descvi'] = 'Thu học phí - '.$data['HO_VA_TEN'].' - '.$data['SO_CMT'].' - '.$func->formatMOney($dataInternal['tuition_fee']);
                $dataHistory['file'] = '';
                $dataHistory['type'] = 'tuition_fee';
                $dataHistory['quantity'] = 0;
                $dataHistory['date_created'] = time();
                $dataHistory['id_downloader'] = $_SESSION[$loginAdmin]['id'];
                $dataHistory['downloads'] = 0;
                $d->insert('user_operation', $dataHistory);
            }

            if($savehere) {
                $func->transfer(luudulieuthanhcong, "index.php?com=student&act=edit&p=" . $curPage . $strUrl . "&id=" . $id_insert);
            } else {
                $func->transfer(luudulieuthanhcong, "index.php?com=student&act=man&p=" . $curPage . $strUrl);
            }
        } else {
            $func->transfer(luudulieubiloi, "index.php?com=student&act=man&p=" . $curPage . $strUrl . "&id=" . $id, false);
        }
    }
}

/* Delete man */
function deleteMan()
{
    global $d, $langadmin, $strUrl, $func, $curPage, $com, $type;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id, photo from #_student where id = ? limit 0,1", array($id));

        if (!empty($row)) {
            /* Xóa chính */
            $func->deleteFile(UPLOAD_STUDENT . $row['photo']);
            $d->rawQuery("delete from #_student where id = ?", array($id));
            $func->transfer(xoadulieuthanhcong, "index.php?com=student&act=man&p=" . $curPage . $strUrl);
        } else {
            $func->transfer(xoadulieubiloi, "index.php?com=student&act=man&p=" . $curPage . $strUrl, false);
        }
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);

            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id, photo from #_student where id = ? limit 0,1", array($id));

            if (!empty($row)) {
                /* Xóa chính */
                $func->deleteFile(UPLOAD_STUDENT . $row['photo']);
                $d->rawQuery("delete from #_student where id = ?", array($id));
            }
        }

        $func->transfer(xoadulieuthanhcong, "index.php?com=student&act=man&p=" . $curPage . $strUrl);
    } else {
        $func->transfer(khongnhanduocdulieu, "index.php?com=student&act=man&p=" . $curPage . $strUrl, false);
    }
}

/* View man */
function viewGPLX()
{
    global $d, $langadmin, $func, $strUrl, $curPage, $items, $paging;
    $where = "";
    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (namevi LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_gplx where id <> 0 $where order by id asc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from #_gplx where id <> 0 $where order by id asc";
    $count = $d->rawQueryOne($sqlNum);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=student&act=gplx" . $strUrl;
    $paging = $func->pagination($total, $perPage, $curPage, $url);

}

/* Edit man */
function editGPLX()
{
    global $d, $strUrl, $func, $item, $curPage;

    if (!empty($_GET['id'])) $id = htmlspecialchars($_GET['id']);
    else $id = 0;

    if (empty($id)) {
        $func->transfer(khongnhanduocdulieu, "index.php?com=student&act=gplx&p=" . $curPage . $strUrl, false);
    } else {
        $item = $d->rawQueryOne("select * from #_gplx where id = ? limit 0,1", array($id));

        if (empty($item)) {
            $func->transfer(dulieukhongcothuc, "index.php?com=student&act=gplx&p=" . $curPage . $strUrl, false);
        }
    }
}

/* Save man */
function saveGPLX()
{
    global $d, $strUrl, $func, $flash, $curPage;

    /* Check post */
    if (empty($_POST)) {
        $func->transfer(khongnhanduocdulieu, "index.php?com=student&act=gplx&p=" . $curPage . $strUrl, false);
    }

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $savehere = (isset($_POST['save-here'])) ? true : false;
    $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $data = !empty($_POST['data']) ? $_POST['data'] : null;

    if ($data) {
        foreach ($data as $column => $value) {
            $data[$column] = htmlspecialchars($func->sanitize($value));
        }

        if (isset($_POST['status'])) {
            $status = '';
            foreach ($_POST['status'] as $attr_column => $attr_value) if ($attr_value != "") $status .= $attr_value . ',';
            $data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
        } else {
            $data['status'] = "";
        }
    }


    /* Valid data */
    $checkTitle = $func->checkTitle($data);

    if (!empty($checkTitle)) {
        foreach ($checkTitle as $k => $v) {
            $response['messages'][] = $v;
        }
    }

    if (!empty($response)) {
        /* Flash data */
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                if (!empty($v)) {
                    $flash->set($k, $v);
                }
            }
        }
        /* Errors */
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set('message', $message);

        if ($id) {
            $func->redirect("index.php?com=student&act=edit-gplx&p=" . $curPage . $strUrl . "&id=" . $id);
        } else {
            $func->redirect("index.php?com=student&act=add-gplx&p=" . $curPage . $strUrl);
        }
    }
    
    /* Save data */
    if ($id) {
        $data['date_updated'] = time();
        $d->where('id', $id);
        if ($d->update('gplx', $data)) {
            if ($savehere) {
                $func->transfer(capnhatdulieuthanhcong, "index.php?com=student&act=edit-gplx&p=" . $curPage . $strUrl . "&id=" . $id);
            } else {
                $func->transfer(capnhatdulieuthanhcong, "index.php?com=student&act=gplx&p=" . $curPage . $strUrl);
            }
        } else {
            if ($savehere) {
                $func->transfer(capnhatdulieubiloi, "index.php?com=student&act=edit-gplx&p=" . $curPage . $strUrl . "&id=" . $id, false);
            } else {
                $func->transfer(capnhatdulieubiloi, "index.php?com=student&act=man-gplx&p=" . $curPage . $strUrl, false);
            }
        }
    } else {
        $data['date_created'] = time();
        if ($d->insert('gplx',$data)) {
            $id_insert = $d->getLastInsertId();
            if ($savehere) {
                $func->transfer(luudulieuthanhcong, "index.php?com=student&act=edit-gplx&p=" . $curPage . $strUrl . "&id=" . $id_insert);
            } else {
                $func->transfer(luudulieuthanhcong, "index.php?com=student&act=gplx&p=" . $curPage . $strUrl);
            }
        } else {
            $func->transfer(luudulieubiloi, "index.php?com=student&act=gplx&p=" . $curPage . $strUrl . "&id=" . $id, false);
        }
    }
}


/* Delete man */
function deleteGPLX()
{
    global $d, $strUrl, $func, $curPage, $com;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        if($id != 4){
            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id from #_gplx where id = ? limit 0,1", array($id));

            if (!empty($row)) {
                /* Xóa chính */
                $d->rawQuery("delete from #_gplx where id = ?", array($id));

                $func->transfer(xoadulieuthanhcong, "index.php?com=student&act=gplx&p=" . $curPage . $strUrl);
            } else {
                $func->transfer(xoadulieubiloi, "index.php?com=student&act=man&p=" . $curPage . $strUrl, false);
            }
        } else {
            $func->transfer("Bạn không được phép xoá hạng lái xe này.", "index.php?com=student&act=gplx&p=" . $curPage . $strUrl, false);
        }
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);

            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id from #_gplx where id = ? limit 0,1", array($id));

            if (!empty($row)) {
                /* Xóa chính */
                $d->rawQuery("delete from #_gplx where id = ?", array($id));
            }
        }

        $func->transfer(xoadulieuthanhcong, "index.php?com=student&act=gplx&p=" . $curPage . $strUrl);
    } else {
        $func->transfer(khongnhanduocdulieu, "index.php?com=student&act=gplx&p=" . $curPage . $strUrl, false);
    }
}


/* update Graduate */
function updateGraduate()
{
    global $d, $strUrl, $func, $curPage, $com;
    
    $dataGraduate = [];
    if(!empty($_POST['submit-graduate'])){

        $idStudent = (!empty($_POST['id-student']) ? $_POST['id-student'] : 0);
        $typeGraduate = (!empty($_POST['type-graduate']) ? $_POST['type-graduate'] : '');
        $data=[];

        $row = $d->rawQueryOne("select graduate,id from #_student where id = ?",array($idStudent));
        $dataGraduate = json_decode($row['graduate'],true);
        $dataGraduate[$typeGraduate]['note'] = (!empty($_POST['note-graduate']) ? $_POST['note-graduate'] : '');
        $dataGraduate[$typeGraduate]['point'] = (!empty($_POST['point-graduate']) ? $_POST['point-graduate'] : 0);
        $data['graduate'] = json_encode($dataGraduate);
        $d->where('id', $idStudent);
        if($d->update('student', $data)){
            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=student&act=manGraduate&type=".$typeGraduate."&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Cập nhật dữ liệu thất bại", "index.php?com=student&act=manGraduate&type=".$typeGraduate."&p=" . $curPage . $strUrl, false);
        }
        
    }
}
