<?php
if (!defined('SOURCES')) die("Error");

/* Cấu hình đường dẫn trả về */
$strUrl = "";
$arrUrl = array('courses-name','courses-id', 'gplx', 'teacher-code','teacher-cmt','function-teacher','teacher-name');
foreach ($arrUrl as $k => $v) {
    if (isset($_REQUEST[$arrUrl[$k]])) $strUrl .= "&" . $arrUrl[$k] . "=" . htmlspecialchars($_REQUEST[$arrUrl[$k]]);
}

switch ($act) {
        /* Man */
    case "man":
        viewMans();
        $template = "teacher/man/mans";
        break;
    case "add":
        $template = "teacher/man/man_add";
        break;
    case "edit":
        editMan();
        $template = "teacher/man/man_add";
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
    global $d, $langadmin, $func, $curPage, $items, $paging, $config, $dataResult, $arrayGPLX,$strUrl;

    $where = "";

    if (!empty($_REQUEST['hangxe'])) {
        // Show data search
        $arrayGPLX = explode(",", $_REQUEST['hangxe']);

        foreach($arrayGPLX as $s => $v){
            $where .= ($s == 0 ? ' and (' : ' or') ." hangxe = '".$v."'";
        }
        $where = $where.")";
    }

    if (!empty($_REQUEST['courses-id'])) {
        // Show data search
        $dataResult['courses_id'] = explode(",", $_REQUEST['courses-id']);
        $arrId = '';

        foreach($dataResult['courses_id'] as $key => $id_courses){
            $rowCourses = $d->rawQueryOne("select data_teacher from #_courses where MA_KHOA_HOC = ? limit 1",array($id_courses));
            if(!empty($rowCourses['data_teacher'])) $arrId .= ($arrId != '' ? ',' : '') . implode(",", json_decode($rowCourses['data_teacher'],true));
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
            $rowCourses = $d->rawQueryOne("select data_teacher from #_courses where TEN_KHOA_HOC = ? limit 1",array($name_courses));

            if(!empty($rowCourses['data_teacher'])) $arrId .= ($arrId != '' ? ',' : '') . implode(",", json_decode($rowCourses['data_teacher'],true));
        }

        if($arrId != '') {
            $arrayTeacher = array_unique(explode(',',$arrId));
            $arrayTeacher = array_values($arrayTeacher);
            $where .= " and id IN (".implode(',',$arrayTeacher).")";
        }
    }



    if (!empty($_REQUEST['teacher-code'])) {
        // Show data search
        $dataResult['teacher-code'] = explode(",", $_REQUEST['teacher-code']);

        foreach($dataResult['teacher-code'] as $s => $vc){
            $where .= ($s == 0 ? ' and (' : ' or') ." id_code = '".$vc."'";
        }
        $where = $where.")";
    }

    if (!empty($_REQUEST['teacher-name'])) {
        // Show data search
        $dataResult['teacher-name'] = explode(",", $_REQUEST['teacher-name']);

        foreach($dataResult['teacher-name'] as $s => $vc){
            $where .= ($s == 0 ? ' and (' : ' or') ." fullname LIKE '%".$vc."%'";
        }
        $where = $where.")";
    }

    if (!empty($_REQUEST['teacher-cmt'])) {
        // Show data search
        $dataResult['teacher-cmt'] = explode(",", $_REQUEST['teacher-cmt']);

        foreach($dataResult['teacher-cmt'] as $s => $vc){
            $where .= ($s == 0 ? ' and (' : ' or') ." cccd = '".$vc."'";
        }
        $where = $where.")";
    }

    if (!empty($_REQUEST['function-teacher'])) {
        // Show data search
        $dataResult['function-teacher'] = explode(",", $_REQUEST['function-teacher']);

        $where .= ' and find_in_set("'.$_REQUEST['function-teacher'].'",chucnang)';
    }

    $perPage = 50;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_member where chucnang != '' $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from #_member where chucnang != '' $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=teacher&act=man" . $strUrl;
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
        $func->transfer(khongnhanduocdulieu, "index.php?com=teacher&act=man&p=" . $curPage . $strUrl, false);
    } else {
        $item = $d->rawQueryOne("select * from #_member where id = ? limit 0,1", array($id));

        if (empty($item)) {
            $func->transfer(dulieukhongcothuc, "index.php?com=teacher&act=man&p=" . $curPage . $strUrl, false);
        }
    }
}

/* Save man */
function saveMan()
{
    global $d, $strUrl, $func, $flash, $curPage, $act;

    global $d, $langadmin, $func, $flash, $curPage;

    /* Check post */
    if (empty($_POST)) {
        $func->transfer(khongnhanduocdulieu, "index.php?com=teacher&act=man&p=" . $curPage, false);
    }

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $data = (!empty($_POST['data'])) ? $_POST['data'] : null;
    $dataAcademic = (!empty($_POST['dataAcademic'])) ? $_POST['dataAcademic'] : null;
    if ($data) {
        foreach ($data as $column => $value) {
            $data[$column] = ($column == 'password') ? $value : htmlspecialchars($func->sanitize($value));
        }

        if (isset($_POST['status'])) {
            $status = '';
            foreach ($_POST['status'] as $attr_column => $attr_value) if ($attr_value != "") $status .= $attr_value . ',';
            $data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
        } else {
            $data['status'] = "";
        }

        $birthday = $data['birthday'];
        $data['birthday'] = strtotime(str_replace("/", "-", $data['birthday']));

        $data['date-cccd'] = strtotime(str_replace("/", "-", $data['date-cccd']));
        $data['ngaygplx'] = strtotime(str_replace("/", "-", $data['ngaygplx']));
    }

    /* Valid data */
    if (empty($data['username'])) {
        $response['messages'][] = taikhoankhongduoctrong;
    }
    
    if (implode(',',$_POST['data']['chucnang']) == '') {
        $response['messages'][] = "Bạn phải chọn chức nằng cho giáo viên";
    }

    if (isset($data['chucnang'])) {
        $response['messages'][] = "Vui lòng chọn chức năng";
    }

    if (!empty($data['username']) && !$func->isAlphaNum($data['username'])) {
        $response['messages'][] = taikhoanchiduocnhapchuthuongvaso;
    }

    if (!empty($data['username'])) {
        if ($func->checkAccount($data['username'], 'username', 'member', $id)) {
            $response['messages'][] = taikhoandatontai;
        }
    }

    if (empty($id) || !empty($data['password'])) {
        if (empty($data['password'])) {
            $response['messages'][] = matkhaukhongduoctrong;
        }

        // if (!empty($data['password']) && empty($_POST['confirm_password'])) {
        //     $response['messages'][] = xacnhanmatkhaukhongduoctrong;
        // }

        // if (!empty($data['password']) && !empty($_POST['confirm_password']) && !$func->isMatch($data['password'], $_POST['confirm_password'])) {
        //     $response['messages'][] = matkhaukhongtrungkhop;
        // }
    }
    if (empty($data['fullname'])) {
        $response['messages'][] = hotenkhongthetrong;
    }


    if (!empty($data['email']) && !$func->isEmail($data['email'])) {
        $response['messages'][] = emailkhonghople;
    }

    if (!empty($data['email'])) {
        if ($func->checkAccount($data['email'], 'email', 'member', $id)) {
            $response['messages'][] = emaildatontai;
        }
    }

    if (!empty($data['phone']) && !$func->isPhone($data['phone'])) {
        $response['messages'][] = sodienthoaikhonghople;
    }

    if (empty($data['gender'])) {
        $response['messages'][] = chuachongioitinh;
    }

    if (empty($birthday)) {
        $response['messages'][] = ngaysinhkhongduoctrong;
    }

    // if (!empty($birthday) && !$func->isDate($birthday)) {
    //     $response['messages'][] = ngaysinhkhonghople;
    // }

    if (!empty($response)) {
        /* Flash data */
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                if (!empty($v)) {
                    $flash->set($k, $v);
                }
            }
        }

        /* Flash data */
        if (!empty($dataAcademic)) {
            foreach ($dataAcademic as $k => $v) {
                if (!empty($v)) {
                    $flash->set($k, $v);
                }
            }
        }

        /* Errors */
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set('message', $message);

        if (empty($id)) {
            $func->redirect("index.php?com=teacher&act=add");
        } else {
            $func->redirect("index.php?com=teacher&act=edit&id=" . $id);
        }
    }

    $data['academic'] = json_encode($dataAcademic);
    $data['chucnang'] = implode(',',$_POST['data']['chucnang']);
    $data['status'] = 'hienthi';

    /* Save data */
    if ($id) {
        if ($func->checkRole()) {
            $row = $d->rawQueryOne("select id from #_member where id = ? limit 0,1", array($id));

            if (!empty($row)) {
                $func->transfer(bankhongcoquyentrentaikhoannaymoithacmacxinlienhequantriwebsite, "index.php?com=teacher&act=man&p=" . $curPage, false);
            }
        }

        if (!empty($data['password'])) {
            $password = $data['password'];
            $confirm_password = !empty($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
            $data['password'] = md5($password);
        } else {
            unset($data['password']);
        }

        $d->where('id', $id);
        if ($d->update('member', $data)) {

            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);

                if ($photo = $func->uploadImage("file", '.jpg|.gif|.png|.jpeg|.gif|.webp|.WEBP', UPLOAD_USER , $file_name)) {
                    $row = $d->rawQueryOne("select avatar from #_member where id = ? limit 0,1", array($id));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_USER . $row['avatar']);
                    }

                    $photoUpdate['avatar'] = $photo;
                    $d->where('id', $id);
                    $d->update('member', $photoUpdate);
                    unset($photoUpdate);
                }
            }
            $func->transfer(capnhatdulieuthanhcong, "index.php?com=teacher&act=man&p=" . $curPage);
        } else {
            $func->transfer(capnhatdulieubiloi, "index.php?com=teacher&act=man&p=" . $curPage, false);
        }
    } else {
        if (!empty($data['password'])) {
            $data['password'] = md5($data['password']);
        }

        /* Photo */
        if ($func->hasFile("file")) {
            $photoUpdate = array();
            $file_name = $func->uploadName($_FILES['file']["name"]);

            if ($photo = $func->uploadImage("file", '.jpg|.gif|.png|.jpeg|.gif|.webp|.WEBP', UPLOAD_USER, $file_name)) {
                $photoUpdate['avatar'] = $photo;
                $d->where('id', $id_insert);
                $d->update('member', $photoUpdate);
                unset($photoUpdate);
            }
        }

        if ($d->insert('member', $data)) {
            $func->transfer(luudulieuthanhcong, "index.php?com=teacher&act=man&p=" . $curPage);
        } else {
            $func->transfer(luudulieubiloi, "index.php?com=teacher&act=man&p=" . $curPage, false);
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
        $row = $d->rawQueryOne("select id, avatar from #_member where id = ? limit 0,1", array($id));

        if (!empty($row)) {
            $d->rawQuery("delete from #_member where id = ?", array($id));
            $func->transfer(xoadulieuthanhcong, "index.php?com=teacher&act=man&p=" . $curPage . $strUrl);
        } else {
            $func->transfer(xoadulieubiloi, "index.php?com=teacher&act=man&p=" . $curPage . $strUrl, false);
        }
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);

            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id, avatar from #_member where id = ? limit 0,1", array($id));

            if (!empty($row)) {
                $d->rawQuery("delete from #_member where id = ?", array($id));
            }
        }

        $func->transfer(xoadulieuthanhcong, "index.php?com=teacher&act=man&p=" . $curPage . $strUrl);
    } else {
        $func->transfer(khongnhanduocdulieu, "index.php?com=teacher&act=man&p=" . $curPage . $strUrl, false);
    }
}
