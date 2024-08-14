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

    if (!empty($_REQUEST['comment_status'])) $strUrl .= "&comment_status=" . htmlspecialchars($_REQUEST['comment_status']);
    if (isset($_REQUEST['keyword'])) $strUrl .= "&keyword=" . htmlspecialchars($_REQUEST['keyword']);
}

switch ($act) {
        /* Man */
    case "man":
        viewMans();
        $template = "courses/man/mans";
        break;
    case "add":
        addMan();
        $template = "courses/man/man_add";
        break;
    case "edit":
        editMan();
        $template = "courses/man/man_add";
        break;
    case "save":
        saveMan();
        break;
    case "delete":
        deleteMan();
        break;
    default:
        $template = "404";
}

/* View man */
function viewMans()
{
    global $d, $func,$strUrl, $curPage, $items, $paging, $arrayGPLX, $dataResult;

    $where = "";
    $date_open = (isset($_REQUEST['date_open'])) ? htmlspecialchars($_REQUEST['date_open']) : 0;
    $date_close = (isset($_REQUEST['date_close'])) ? htmlspecialchars($_REQUEST['date_close']) : 0;
    $date_sh = (isset($_REQUEST['date_sh'])) ? htmlspecialchars($_REQUEST['date_sh']) : 0;

   if (!empty($_REQUEST['courses-id'])) {
        // Show data search
        $dataResult['courses_id'] = explode(",", $_REQUEST['courses-id']);

        foreach($dataResult['courses_id'] as $s => $vc){
            $where .= ($s == 0 ? ' and (' : ' or') ." MA_KHOA_HOC = '".$vc."'";
        }
        $where = $where.")";
    }

    if (!empty($_REQUEST['gplx'])) {
        // Show data search
        $arrayGPLX = explode(",", $_REQUEST['gplx']);

        foreach($arrayGPLX as $s => $v){
            $where .= ($s == 0 ? ' and (' : ' or') ." HANG_GPLX = '".$v."'";
        }
        $where = $where.")";
    }

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

    if (!empty($_REQUEST['code-open'])) {
        // Show data search
        $dataResult['code-open'] = explode(",", $_REQUEST['code-open']);

        foreach($dataResult['code-open'] as $s => $vc){
            $where .= ($s == 0 ? ' and (' : ' or') ." SO_QD_KG = '".$vc."'";
        }
        $where = $where.")";
    }

    if (!empty($date_open)) {
        $date_open = explode("-", $date_open);
        $date_from = trim($date_open[0] . ' 12:00:00 AM');
        $date_to = trim($date_open[1] . ' 11:59:59 PM');
        $date_from = strtotime(str_replace("/", "-", $date_from));
        $date_to = strtotime(str_replace("/", "-", $date_to));
        $where .= " and NGAY_KHAI_GIANG<=$date_to and NGAY_KHAI_GIANG>=$date_from";
    }

    if (!empty($date_close)) {
        $date_close = explode("-", $date_close);
        $date_from = trim($date_close[0] . ' 12:00:00 AM');
        $date_to = trim($date_close[1] . ' 11:59:59 PM');
        $date_from = strtotime(str_replace("/", "-", $date_from));
        $date_to = strtotime(str_replace("/", "-", $date_to));
        $where .= " and NGAY_BE_GIANG<=$date_to and NGAY_BE_GIANG>=$date_from";
    }

    if (!empty($date_sh)) {
        $date_sh = explode("-", $date_sh);
        $date_from = trim($date_sh[0] . ' 12:00:00 AM');
        $date_to = trim($date_sh[1] . ' 11:59:59 PM');
        $date_from = strtotime(str_replace("/", "-", $date_from));
        $date_to = strtotime(str_replace("/", "-", $date_to));
        $where .= " and NGAY_SAT_HACH<=$date_to and NGAY_SAT_HACH>=$date_from";
    }


    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_courses where id <> 0 $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from #_courses where id <> 0 $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=courses&act=man" . $strUrl;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Add man */
function addMan()
{
    global $d, $func, $listTeacher, $listCar, $gplx, $listStudent;

    $gplx = $d->rawQuery("select id, namevi, age from #_gplx where id <> 0 and find_in_set('hienthi',status) order by id asc");


    // Lấy học viên của hạng gplx đầu tiên
    $listStudent = $d->rawQuery("select id, HO_VA_TEN, SO_CMT, HANG_GPLX, data_student, MA_KHOA_HOC from #_student where id <> 0 and MA_KHOA_HOC = '' and HANG_GPLX = ? order by MA_KHOA_HOC asc", array($gplx[0]['id']));

    $listTeacher = $d->rawQuery("select fullname, id_code, id from #_member where chucnang IS NOT NULL order by numb,id desc");

    $listCar = $d->rawQuery("select biensoxe, socho, id, hang from #_car order by numb,id desc");
}

/* Edit man */
function editMan()
{
    global $d, $strUrl, $func, $item, $curPage, $studentOfCourses, $gplx, $listStudent, $listTeacher, $listCar, $dataCourses, $teacherOfCourses, $dataTeacher, $carOfCourses, $dataCar;

    if (!empty($_GET['id'])) $id = htmlspecialchars($_GET['id']);
    else if (!empty($_GET['id_copy'])) $id = htmlspecialchars($_GET['id_copy']);
    else $id = 0;

    if (empty($id)) {
        $func->transfer(khongnhanduocdulieu, "index.php?com=courses&act=man&p=" . $curPage . $strUrl, false);
    } else {
        $item = $d->rawQueryOne("select * from #_courses where id = ? limit 0,1", array($id));
        
        $studentOfCourses = $d->rawQuery("select id, HO_VA_TEN, SO_CMT, HANG_GPLX, data_student from #_student where id <> 0 and MA_KHOA_HOC = ?  order by numb,id desc", array($item['MA_KHOA_HOC']));

        $gplx = $d->rawQuery("select id, namevi, age from #_gplx where id <> 0 and find_in_set('hienthi',status) order by id asc");

        $listStudent = $d->rawQuery("select id, HO_VA_TEN, SO_CMT, HANG_GPLX, data_student, MA_KHOA_HOC from #_student where id <> 0 and (MA_KHOA_HOC = ? or MA_KHOA_HOC = '') and HANG_GPLX = ? order by MA_KHOA_HOC asc", array($item['MA_KHOA_HOC'], $item['HANG_GPLX']));

        $listTeacher = $d->rawQuery("select fullname, id_code, id from #_member where chucnang IS NOT NULL order by numb,id desc");

        $listCar = $d->rawQuery("select biensoxe, socho, id, hang from #_car order by numb,id desc");

        if(!empty($item['data_courses'])) $dataCourses = json_decode($item['data_courses'],true);
        if(!empty($item['data_teacher'])) {
            $dataTeacher = json_decode($item['data_teacher'],true);
            if(!empty($dataTeacher)) $teacherOfCourses = $d->rawQuery("select fullname, cccd, id, birthday from #_member where id in (".implode(',',$dataTeacher).")");
        }
        if(!empty($item['data_car'])) {
            $dataCar = json_decode($item['data_car'],true);
            if(!empty($dataCar)) $carOfCourses = $d->rawQuery("select biensoxe, socho, id, hang from #_car where id in (".implode(',',$dataCar).")");
        }

        if (empty($item)) {
            $func->transfer(dulieukhongcothuc, "index.php?com=courses&act=man&p=" . $curPage . $strUrl, false);
        }
    }
}

/* Save man */
function saveMan()
{
    global $d, $strUrl, $func, $flash, $curPage, $act;

    /* Check post */
    if (empty($_POST)) {
        $func->transfer(khongnhanduocdulieu, "index.php?com=courses&act=man&p=" . $curPage . $strUrl, false);
    }

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $savehere = (isset($_POST['save-here'])) ? true : false;
    $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $data = !empty($_POST['data']) ? $_POST['data'] : null;
    $dataCourses = !empty($_POST['dataCourses']) ? $_POST['dataCourses'] : null;
    $listStudent = !empty($_POST['list-student']) ? $_POST['list-student'] : null;
    
    if ($data) {
        foreach ($data as $column => $value) {
            $data[$column] = htmlspecialchars($func->sanitize($value));
        }
    }
    
    /* Valid data */
    if (empty($data['TEN_KHOA_HOC'])) {
        $response['messages'][] = "Bạn chưa tên khoá học";
    }
    
    if (empty($data['MA_KHOA_HOC'])) {
        $response['messages'][] = "Bạn chưa nhập mã khoá học";
    }
    
    if (empty($data['MA_HANG_DAO_TAO'])) {
        $response['messages'][] = "Bạn chưa nhập mã hạng đào tạo";
    }
    
    if (empty($data['NGAY_KHAI_GIANG'])) {
        $response['messages'][] = "Bạn chưa chọn ngày khai giảng";
    }
    
    if (empty($data['NGAY_BE_GIANG'])) {
        $response['messages'][] = "Bạn chưa chọn ngày bế giảng";
    }
    
    if($id == 0){
        if (!empty($data['MA_KHOA_HOC'])) {
            $checkAssets = $d->rawQueryOne("select id from #_courses where MA_KHOA_HOC = '".$data['MA_KHOA_HOC']."' limit 0,1");
            if(!empty($checkAssets)){
                $response['messages'][] = "Mã khoá học đã tồn tại";
            }
        }
    }

    if($data['NGAY_KHAI_GIANG'] >= $data['NGAY_BE_GIANG']){
        $response['messages'][] = "Ngày khai giảng phải trước ngày bế giảng";
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

        if (!empty($dataCourses)) {
            foreach ($dataCourses as $k => $v) {
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
            $func->redirect("index.php?com=courses&act=edit&p=" . $curPage . $strUrl . "&id=" . $id);
        } else {
            $func->redirect("index.php?com=courses&act=add&p=" . $curPage . $strUrl);
        }
    }

     // Convert Date 'Ymd'

    if(!empty($data['NGAY_KHAI_GIANG'])){
        $data['NGAY_KHAI_GIANG'] = strtotime(str_replace("/", "-", $data['NGAY_KHAI_GIANG']));
    }
    
    if(!empty($data['NGAY_BE_GIANG'])){
        $data['NGAY_BE_GIANG'] = strtotime(str_replace("/", "-", $data['NGAY_BE_GIANG']));
    }
    
    if(!empty($dataCourses['NGAY_BCI'])){
        $dataCourses['NGAY_BCI'] = strtotime(str_replace("/", "-", $dataCourses['NGAY_BCI']));
    }

    if(!empty($dataCourses['NGAY_QD_KG'])){
        $dataCourses['NGAY_QD_KG'] = strtotime(str_replace("/", "-", $dataCourses['NGAY_QD_KG']));
    }

    if(!empty($data['NGAY_SAT_HACH'])){
        $data['NGAY_SAT_HACH'] = strtotime(str_replace("/", "-", $data['NGAY_SAT_HACH']));
    }

    if(!empty($dataCourses))$data['data_courses'] = json_encode($dataCourses);
    if(!empty($_POST['list-teacher'])) $data['data_teacher'] = json_encode($_POST['list-teacher']);
    if(!empty($_POST['list-car'])) $data['data_car'] = json_encode($_POST['list-car']);
    
    $idStudent = implode(',', $listStudent);



    /* Save data */
    if ($id && $act != 'save_copy') {
        $data['date_updated'] = time();

        $d->where('id', $id);
        if ($d->update('courses', $data)) {
            /* Photo */
            
            // Cập nhật lại khóa học cho học viên
               // -- Xóa tất cả học viên của khóa đó rồi update
            if (!empty($listStudent)) {
                $d->rawQuery("UPDATE `table_student` SET `MA_KHOA_HOC` = '' WHERE MA_KHOA_HOC = '".$data['MA_KHOA_HOC']."' ");
                $d->rawQuery("UPDATE `table_student` SET `MA_KHOA_HOC` = '".$data['MA_KHOA_HOC']."' WHERE find_in_set(id, '".$idStudent."')");
            }

            if ($savehere) {
                $func->transfer(capnhatdulieuthanhcong, "index.php?com=courses&act=edit&p=" . $curPage . $strUrl . "&id=" . $id);
            } else {
                $func->transfer(capnhatdulieuthanhcong, "index.php?com=courses&act=man&p=" . $curPage . $strUrl);
            }
        } else {
            if ($savehere) {
                $func->transfer(capnhatdulieubiloi, "index.php?com=courses&act=edit&p=" . $curPage . $strUrl . "&id=" . $id, false);
            } else {
                $func->transfer(capnhatdulieubiloi, "index.php?com=courses&act=man&p=" . $curPage . $strUrl, false);
            }
        }
    } else {
        $data['date_created'] = time();

        if ($d->insert('courses', $data)) {
            $id_insert = $d->getLastInsertId();
            $code = $func->getColDetail('MA_KHOA_HOC','courses', $id_insert);
            if (!empty($listStudent)) {
                $d->rawQuery("update #_student set `MA_KHOA_HOC` = '".$code."' where find_in_set(id, '".$idStudent."')");
            }
            if ($savehere) {
                $func->transfer(luudulieuthanhcong, "index.php?com=courses&act=edit&p=" . $curPage . $strUrl . "&id=" . $id_insert);
            } else {
                $func->transfer(luudulieuthanhcong, "index.php?com=courses&act=man&p=" . $curPage . $strUrl);
            }
        } else {
            $func->transfer(luudulieubiloi, "index.php?com=courses&act=man&p=" . $curPage . $strUrl . "&id=" . $id, false);
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
        $row = $d->rawQueryOne("select id, MA_KHOA_HOC from #_courses where id = ? limit 0,1", array($id));

        if (!empty($row)) {
            $d->rawQuery("UPDATE `table_student` SET `MA_KHOA_HOC` = '' WHERE MA_KHOA_HOC = '".$row['MA_KHOA_HOC']."' ");
            $d->rawQuery("delete from #_courses where id = ?", array($id));
            $func->transfer(xoadulieuthanhcong, "index.php?com=courses&act=man&p=" . $curPage . $strUrl);
        } else {
            $func->transfer(xoadulieubiloi, "index.php?com=courses&act=man&p=" . $curPage . $strUrl, false);
        }
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);

            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id from #_courses where id = ? limit 0,1", array($id));

            if (!empty($row)) {
                $d->rawQuery("UPDATE `table_student` SET `MA_KHOA_HOC` = '' WHERE MA_KHOA_HOC = '".$row['MA_KHOA_HOC']."' ");
                $d->rawQuery("delete from #_courses where id = ?", array($id));
            }
        }

        $func->transfer(xoadulieuthanhcong, "index.php?com=courses&act=man&p=" . $curPage . $strUrl);
    } else {
        $func->transfer(khongnhanduocdulieu, "index.php?com=courses&act=man&p=" . $curPage . $strUrl, false);
    }
}
