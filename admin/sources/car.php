<?php
if (!defined('SOURCES')) die("Error");

/* Cấu hình đường dẫn trả về */
$strUrl = "";
$arrUrl = array('courses-name','courses-id', 'car-id', 'car-loai');
foreach ($arrUrl as $k => $v) {
    if (isset($_REQUEST[$arrUrl[$k]])) $strUrl .= "&" . $arrUrl[$k] . "=" . htmlspecialchars($_REQUEST[$arrUrl[$k]]);
}

switch ($act) {
        /* Man */
    case "man":
        viewMans();
        $template = "car/man/mans";
        break;
    case "add":
        $template = "car/man/man_add";
        break;
    case "edit":
        editMan();
        $template = "car/man/man_add";
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

   if (!empty($_REQUEST['car-id'])) {
        // Show data search
        $dataResult['car_id'] = explode(",", $_REQUEST['car-id']);

        foreach($dataResult['car_id'] as $s => $vc){
            $where .= ($s == 0 ? ' and (' : ' or') ." id_xe = '".$vc."'";
        }
        $where = $where.")";
    }

    if (!empty($_REQUEST['car-loai'])) {
        // Show data search
        $dataResult['car_loai'] = explode(",", $_REQUEST['car-loai']);

        foreach($dataResult['car_loai'] as $s => $vc){
            $where .= ($s == 0 ? ' and (' : ' or') ." loaixe = '".$vc."'";
        }
        $where = $where.")";
    }

    if (!empty($_REQUEST['courses-id'])) {
        // Show data search
        $dataResult['courses_id'] = explode(",", $_REQUEST['courses-id']);
        $arrId = '';

        foreach($dataResult['courses_id'] as $key => $id_courses){
            $rowCourses = $d->rawQueryOne("select data_car from #_courses where MA_KHOA_HOC = ? limit 1",array($id_courses));
            if(!empty($rowCourses['data_car'])) $arrId .= ($arrId != '' ? ',' : '') . implode(",", json_decode($rowCourses['data_car'],true));
        }

        if($arrId != '') {
            $arrayTeacher = array_unique(explode(',',$arrId));
            $arrayTeacher = array_values($arrayTeacher);
            $where .= " and id IN (".implode(',',$arrayTeacher).")";
        }
    }

    if (!empty($_REQUEST['courses-name'])) {
        // Show data search
        $dataResult['courses-name'] = explode(",", $_REQUEST['courses-name']);

        foreach($dataResult['courses-name'] as $key => $name_courses){
            $rowCourses = $d->rawQueryOne("select data_car from #_courses where TEN_KHOA_HOC = ? limit 1",array($name_courses));

            if(!empty($rowCourses['data_car'])) $arrId .= ($arrId != '' ? ',' : '') . implode(",", json_decode($rowCourses['data_car'],true));
        }

        if($arrId != '') {
            $arrayTeacher = array_unique(explode(',',$arrId));
            $arrayTeacher = array_values($arrayTeacher);
            $where .= " and id IN (".implode(',',$arrayTeacher).")";
        }
    } 


    $perPage = 50;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_car where id <> 0 $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from #_car where id <> 0 $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=car&act=man" . $strUrl;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Edit man */
function editMan()
{
    global $d, $langadmin, $strUrl, $func, $item, $type, $com, $curPage;

    if (!empty($_GET['id'])) $id = htmlspecialchars($_GET['id']);
    else if (!empty($_GET['id_copy'])) $id = htmlspecialchars($_GET['id_copy']);
    else $id = 0;

    if (empty($id)) {
        $func->transfer(khongnhanduocdulieu, "index.php?com=car&act=man&p=" . $curPage . $strUrl, false);
    } else {
        $item = $d->rawQueryOne("select * from #_car where id = ? limit 0,1", array($id));

        if (empty($item)) {
            $func->transfer(dulieukhongcothuc, "index.php?com=car&act=man&p=" . $curPage . $strUrl, false);
        }
    }
}

/* Save man */
function saveMan()
{
    global $d, $strUrl, $func, $flash, $curPage, $act;

    /* Check post */
    if (empty($_POST)) {
        $func->transfer(khongnhanduocdulieu, "index.php?com=car&act=man&p=" . $curPage . $strUrl, false);
    }

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $savehere = (isset($_POST['save-here'])) ? true : false;
    $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $data = !empty($_POST['data']) ? $_POST['data'] : null;
    $datacar = !empty($_POST['datacar']) ? $_POST['datacar'] : null;
    
    if ($data) {
        foreach ($data as $column => $value) {
            $data[$column] = htmlspecialchars($func->sanitize($value));
        }
    }
    
    /* Valid data */
    if (empty($data['biensoxe'])) {
        $response['messages'][] = "Bạn chưa nhập biển số xe";
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
            $func->redirect("index.php?com=car&act=edit&p=" . $curPage . $strUrl . "&id=" . $id);
        } else {
            $func->redirect("index.php?com=car&act=add&p=" . $curPage . $strUrl);
        }
    }

    // Convert Date 'Ymd'

    if(!empty($data['ngaycapgplx'])){
        $data['ngaycapgplx'] = strtotime(str_replace("/", "-", $data['ngaycapgplx']));
    }

    if(!empty($data['hethan'])){
        $data['hethan'] = strtotime(str_replace("/", "-", $data['hethan']));
    }

    $data['id_xe'] = $data['biensoxe'];

    /* Save data */
    if ($id && $act != 'save_copy') {
        $data['date_updated'] = time();

        $d->where('id', $id);
        if ($d->update('car', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);

                if ($photo = $func->uploadImage("file", ".jpg|.gif|.png|.jpeg|.gif|.webp|.WEBP", UPLOAD_STUDENT, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from #_car where id = ? limit 0,1", array($id));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_STUDENT . $row['photo']);
                    }
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    unset($photoUpdate);
                }
            }
            if ($savehere) {
                $func->transfer(capnhatdulieuthanhcong, "index.php?com=car&act=edit&p=" . $curPage . $strUrl . "&id=" . $id);
            } else {
                $func->transfer(capnhatdulieuthanhcong, "index.php?com=car&act=man&p=" . $curPage . $strUrl);
            }
        } else {
            if ($savehere) {
                $func->transfer(capnhatdulieubiloi, "index.php?com=car&act=edit&p=" . $curPage . $strUrl . "&id=" . $id, false);
            } else {
                $func->transfer(capnhatdulieubiloi, "index.php?com=car&act=man&p=" . $curPage . $strUrl, false);
            }
        }
    } else {
        $data['date_created'] = time();
        if ($d->insert('car', $data)) {
            $id_insert = $d->getLastInsertId();
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);

                if ($photo = $func->uploadImage("file", ".jpg|.gif|.png|.jpeg|.gif|.webp|.WEBP", UPLOAD_STUDENT, $file_name)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('car', $photoUpdate);
                    unset($photoUpdate);
                }
            }
            if ($savehere) {
                $func->transfer(luudulieuthanhcong, "index.php?com=car&act=edit&p=" . $curPage . $strUrl . "&id=" . $id_insert);
            } else {
                $func->transfer(luudulieuthanhcong, "index.php?com=car&act=man&p=" . $curPage . $strUrl);
            }
        } else {
            $func->transfer(luudulieubiloi, "index.php?com=car&act=man&p=" . $curPage . $strUrl . "&id=" . $id, false);
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
        $row = $d->rawQueryOne("select id, photo from #_car where id = ? limit 0,1", array($id));

        if (!empty($row)) {
            $func->deleteFile(UPLOAD_STUDENT . $row['photo']);
            $d->rawQuery("delete from #_car where id = ?", array($id));
            $func->transfer(xoadulieuthanhcong, "index.php?com=car&act=man&p=" . $curPage . $strUrl);
        } else {
            $func->transfer(xoadulieubiloi, "index.php?com=car&act=man&p=" . $curPage . $strUrl, false);
        }
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);

            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id, photo from #_car where id = ? limit 0,1", array($id));

            if (!empty($row)) {
                $func->deleteFile(UPLOAD_STUDENT . $row['photo']);
                $d->rawQuery("delete from #_car where id = ?", array($id));
            }
        }

        $func->transfer(xoadulieuthanhcong, "index.php?com=car&act=man&p=" . $curPage . $strUrl);
    } else {
        $func->transfer(khongnhanduocdulieu, "index.php?com=car&act=man&p=" . $curPage . $strUrl, false);
    }
}
