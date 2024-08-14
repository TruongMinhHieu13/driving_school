<?php
if(!defined('SOURCES')) die("Error");

$action = htmlspecialchars($match['params']['action']);

switch($action)
{
    /* Thông tin tài khoản */
    case 'dang-nhap':
    $titleMain = dangnhap;
    $template = "account/info/login";
    if(!empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại",$configBase, false);
    if(!empty($_POST['login-user'])) loginMember();
    break;

    case 'dang-ky':
    $titleMain = dangky;
    $template = "account/info/registration";
    if(!empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại",$configBase, false);
    if(!empty($_POST['registration-user'])) signupMember();
    break;

    case 'quen-mat-khau':
    $titleMain = quenmatkhau;
    $template = "account/info/forgot_password";
    if(!empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại",$configBase, false);
    if(!empty($_POST['forgot-password-user'])) forgotPasswordMember();
    break;

    case 'doi-mat-khau':
    $titleMain = capnhatthongtin;
    $template = "account/info/change_password";
    if(empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại",$configBase, false);
    infoMember();
    if(!empty($_POST['change-password-user'])) changePasswordMember();
    break;

    case 'kich-hoat':
    $titleMain = kichhoat;
    $template = "account/info/activation";
    if(!empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại",$configBase, false);
    checkActivationMember();
    break;

    case 'thong-tin':
    $titleMain = capnhatthongtin;
    $template = "account/info/info";
    if(empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại",$configBase, false);
    infoMember();
    break;

    case 'duyet-ly-thuyet':
    $titleMain = "Duyệt lý thuyết";
    $template = "account/teacher/man";
    if(empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại",$configBase, false);
    getStudent();
    break;

    case 'duyet-cabin':
    $titleMain = "Duyệt cabin";
    $template = "account/teacher/man";
    if(empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại",$configBase, false);
    getStudent();
    break;

    case 'duyet-hinh':
    $titleMain = "Duyệt Hình";
    $template = "account/teacher/man";
    if(empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại",$configBase, false);
    getStudent();
    break;

    case 'duyet-dat':
    $titleMain = "Duyệt DAT";
    $template = "account/teacher/man";
    if(empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại",$configBase, false);
    getStudent();
    break;

    case 'dang-xuat':
    if(empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại",$configBase, false);
    logoutMember();

    default:
    header('HTTP/1.0 404 Not Found', true, 404);
    include("404.php");
    exit();
}

/* SEO */
$seo->set('title',$titleMain);

/* breadCrumbs */
if(!empty($titleMain)) $breadcr->set('',$titleMain);
$breadcrumbs = $breadcr->get();


/* Lấy thông tin cá nhân */
function infoMember()
{
    global $d, $func, $flash, $rowDetail, $configBase, $loginMember, $functionTeacher;

    $iduser = $_SESSION[$loginMember]['id'];


    if($iduser)
    {
        $rowDetail = $d->rawQueryOne("select id, fullname, username, gender, birthday, email, phone, address, chucnang from #_member where id = ? limit 0,1",array($iduser));
        $functionTeacher = array();
        $functionTeacher = explode(',', $rowDetail['chucnang']);

        if(!empty($_POST['info-user']))
        {
            $message = '';
            $response = array();
            $old_password = (!empty($_POST['old-password'])) ? $_POST['old-password'] : '';
            $old_passwordMD5 = md5($old_password);
            $new_password = (!empty($_POST['new-password'])) ? $_POST['new-password'] : '';
            $new_passwordMD5 = md5($new_password);
            $new_password_confirm = (!empty($_POST['new-password-confirm'])) ? $_POST['new-password-confirm'] : '';
            $fullname = (!empty($_POST['fullname'])) ? htmlspecialchars($_POST['fullname']) : '';
            $email = (!empty($_POST['email'])) ? htmlspecialchars($_POST['email']) : '';
            $phone = (!empty($_POST['phone'])) ? htmlspecialchars($_POST['phone']) : 0;
            $address = (!empty($_POST['address'])) ? htmlspecialchars($_POST['address']) : '';
            $gender = (!empty($_POST['gender'])) ? htmlspecialchars($_POST['gender']) : 0;
            $birthday = (!empty($_POST['birthday'])) ? htmlspecialchars($_POST['birthday']) : '';

            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);

                if ($photo = $func->uploadImage("file", '.jpg|.gif|.png|.jpeg|.gif', UPLOAD_USER_L, $file_name)) {
                    $row = $d->rawQueryOne("select id, avatar from #_member where id = ? limit 0,1", array($iduser));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_USER_L . $row['avatar']);
                    }

                    $photoUpdate['avatar'] = $photo;
                    $d->where('id', $iduser);
                    $d->update('member', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* Valid data */
            if(empty($fullname))
            {
                $response['messages'][] = 'Họ tên không được trống';
            }

            if(!empty($old_password))
            {
                $isWrongPass = false;
                $row = $d->rawQueryOne("select id from #_member where id = ? and password = ? limit 0,1",array($iduser,$old_passwordMD5));

                if(empty($row['id']))
                {
                    $isWrongPass = true;
                    $response['messages'][] = 'Mật khẩu cũ không chính xác';
                }
                else if(empty($new_password))
                {
                    $isWrongPass = true;
                    $response['messages'][] = 'Mật khẩu mới không được trống';
                }
                else if(!empty($new_password) && empty($new_password_confirm))
                {
                    $isWrongPass = true;
                    $response['messages'][] = 'Xác nhận mật khẩu mới không được trống';
                }
                else if($new_password != $new_password_confirm)
                {
                    $isWrongPass = true;
                    $response['messages'][] = 'Mật khẩu mới và xác nhận mật khẩu mới không chính xác';
                }
            }


            if(empty($birthday))
            {
                $response['messages'][] = 'Ngày sinh không được trống';
            }

            if(!empty($birthday) && !$func->isDate($birthday))
            {
                $response['messages'][] = 'Ngày sinh không hợp lệ';
            }

            if(empty($email))
            {
                $response['messages'][] = 'Email không được trống';
            }

            if(!empty($email))
            {
                if(!$func->isEmail($email))
                {
                    $response['messages'][] = 'Email không hợp lệ';
                }

                if($func->checkAccount($email, 'email', 'member', $iduser))
                {
                    $response['messages'][] = 'Email đã tồn tại';
                }
            }

            if(!empty($phone) && !$func->isPhone($phone))
            {
                $response['messages'][] = 'Số điện thoại không hợp lệ';
            }

            if(empty($address))
            {
                $response['messages'][] = 'Địa chỉ không được trống';
            }

            if(!empty($response))
            {
                /* Flash data */
                $flash->set('fullname', $fullname);
                $flash->set('gender', $gender);
                $flash->set('birthday', $birthday);
                $flash->set('email', $email);
                $flash->set('phone', $phone);
                $flash->set('address', $address);

                /* Errors */
                $response['status'] = 'danger';
                $message = base64_encode(json_encode($response));
                $flash->set('message', $message);
                $func->redirect($configBase."account/thong-tin");
            }

            if(!empty($old_password) && empty($isWrongPass))
            {
                $data['password'] = $new_passwordMD5;
            }

            $data['fullname'] = $fullname;
            $data['email'] = $email;
            $data['phone'] = $phone;
            $data['address'] = $address;
            $data['gender'] = $gender;
            $data['birthday'] = strtotime(str_replace("/","-",$birthday));

            $d->where('id', $iduser);
            if($d->update('member',$data))
            {
                if(!empty($dataPhoto))
                {
                    $myFile = $_FILES['review-file-photo'];
                    $fileCount = count($myFile["name"]) - 1;
                    for($i=0;$i<$fileCount;$i++)
                    {
                        if(in_array($myFile["name"][$i], $dataPhoto))
                        {               

                            $_FILES['file-uploader-temp'] = array(
                                'name' => $myFile['name'][$i],
                                'type' => $myFile['type'][$i],
                                'tmp_name' => $myFile['tmp_name'][$i],
                                'error' => $myFile['error'][$i],
                                'size' => $myFile['size'][$i]
                            );
                            $file_name = $func->uploadName($myFile["name"][$i]);

                            if($photo = $func->uploadImage("file-uploader-temp", '.jpg|.png|.jpeg', ROOT.UPLOAD_ACCOUNT_L, $file_name))
                            {
                                $dataTemp = array();
                                $dataTemp['id_parent'] = $iduser;
                                $dataTemp['photo'] = $photo;
                                $d->insert('gallery', $dataTemp);
                            }
                        }
                    }
                }

                if($old_password)
                {
                    unset($_SESSION[$loginMember]);
                    setcookie('login_member_id',"",-1,'/');
                    setcookie('login_member_session',"",-1,'/');
                    $func->transfer("Cập nhật thông tin thành công",$configBase."account/dang-nhap");
                }
                else
                {
                    $func->transfer("Cập nhật thông tin thành công",$configBase."account/thong-tin");
                }
            }
            else
            {
                $func->transfer("Cập nhật thông tin thất bại",$configBase."account/thong-tin", false);
            }
        }
    }
    else
    {
        $func->transfer("Trang không tồn tại",$configBase, false);
    }
}

/* Đổi mật khẩu */
function changePasswordMember()
{
    global $d, $func, $flash, $rowDetail, $configBase, $loginMember;

    $iduser = $_SESSION[$loginMember]['id'];

    if($iduser)
    {
        $rowDetail = $d->rawQueryOne("select fullname, username, gender, birthday, email, phone, address from #_member where id = ? limit 0,1",array($iduser));


        if(!empty($_POST['change-password-user']))
        {
            $message = '';
            $response = array();
            $old_password = (!empty($_POST['old-password'])) ? $_POST['old-password'] : '';
            $old_passwordMD5 = md5($old_password);
            $new_password = (!empty($_POST['new-password'])) ? $_POST['new-password'] : '';
            $new_passwordMD5 = md5($new_password);
            $new_password_confirm = (!empty($_POST['new-password-confirm'])) ? $_POST['new-password-confirm'] : '';

            /* Valid data */
            if(!empty($old_password))
            {
                $isWrongPass = false;
                $row = $d->rawQueryOne("select id from #_member where id = ? and password = ? limit 0,1",array($iduser,$old_passwordMD5));

                if(empty($row['id']))
                {
                    $isWrongPass = true;
                    $response['messages'][] = 'Mật khẩu cũ không chính xác';
                }
                else if(empty($new_password))
                {
                    $isWrongPass = true;
                    $response['messages'][] = 'Mật khẩu mới không được trống';
                }
                else if(!empty($new_password) && empty($new_password_confirm))
                {
                    $isWrongPass = true;
                    $response['messages'][] = 'Xác nhận mật khẩu mới không được trống';
                }
                else if($new_password != $new_password_confirm)
                {
                    $isWrongPass = true;
                    $response['messages'][] = 'Mật khẩu mới và xác nhận mật khẩu mới không chính xác';
                }
            }
            if(!empty($response))
            {
                /* Errors */
                $response['status'] = 'danger';
                $message = base64_encode(json_encode($response));
                $flash->set('message', $message);
                $func->redirect($configBase."account/doi-mat-khau");
            }

            if(!empty($old_password) && empty($isWrongPass))
            {
                $data['password'] = $new_passwordMD5;
            }
            $d->where('id', $iduser);
            if($d->update('member',$data))
            {
                if($old_password)
                {
                    unset($_SESSION[$loginMember]);
                    setcookie('login_member_id',"",-1,'/');
                    setcookie('login_member_session',"",-1,'/');
                    $func->transfer("Cập nhật thông tin thành công",$configBase."account/dang-nhap");
                }
                else
                {
                    $func->transfer("Cập nhật thông tin thành công",$configBase."account/thong-tin");
                }
            }
            else
            {
                $func->transfer("Cập nhật thông tin thất bại",$configBase."account/thong-tin", false);
            }
        }
    }
    else
    {
        $func->transfer("Trang không tồn tại",$configBase, false);
    }   
}

/* Check Active */
function checkActivationMember()
{
    global $d, $func, $flash, $rowDetail, $configBase;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if(!empty($_POST['activation-user']))
    {
        /* Data */
        $message = '';
        $response = array();
        $confirm_code = (!empty($_POST['confirm_code'])) ? htmlspecialchars($_POST['confirm_code']) : '';

        /* Valid data */
        if(empty($id))
        {
            $response['messages'][] = 'Người dùng không tồn tại';
        }
        else
        {
            $rowDetail = $d->rawQueryOne("select status, confirm_code, id from #_member where id = ? limit 0,1",array($id));

            if(empty($rowDetail))
            {
                $response['messages'][] = 'Tài khoản của bạn không tồn tại';
            }
            else if(!empty($rowDetail['status']) && strstr($rowDetail['status'], 'hienthi'))
            {
                $func->transfer("Trang không tồn tại",$configBase, false);
            }
            else
            {
                if(empty($confirm_code))
                {
                    $response['messages'][] = 'Mã xác nhận không được trống';
                }

                if(!empty($confirm_code) && ($rowDetail['confirm_code'] != $confirm_code))
                {
                    $response['messages'][] = 'Mã xác nhận không đúng. Vui lòng nhập lại mã xác nhận.';
                }
            }
        }

        if(!empty($response))
        {
            $response['status'] = 'danger';
            $message = base64_encode(json_encode($response));
            $flash->set("message", $message);
            $func->redirect($configBase."account/kich-hoat?id=".$id);
        }

        /* Save data */
        $data['status'] = 'hienthi';
        $data['confirm_code'] = '';
        $d->where('id', $id);
        if($d->update('member',$data))
        {
            $func->transfer("Kích hoạt tài khoản thành công.",$configBase."account/dang-nhap");
        }
    }
    else
    {
        /* Valid data */
        if(empty($id))
        {
            $func->transfer("Trang không tồn tại",$configBase, false);
        }
        else
        {
            $rowDetail = $d->rawQueryOne("select status, confirm_code, id from #_member where id = ? limit 0,1",array($id));

            if(empty($rowDetail) || (!empty($rowDetail['status']) && strstr($rowDetail['status'], 'hienthi')))
            {
                $func->transfer("Trang không tồn tại",$configBase, false);
            }
        }
    }
}

/* Đăng nhập */
function loginMember()
{
    global $d, $func, $flash, $loginMember, $configBase;

    /* Data */
    $username = (!empty($_POST['username'])) ? htmlspecialchars($_POST['username']) : '';
    $password = (!empty($_POST['password'])) ? $_POST['password'] : '';
    $passwordMD5 = md5($password);
    $remember = (!empty($_POST['remember-user'])) ? htmlspecialchars($_POST['remember-user']) : false;

    /* Valid data */
    if(empty($username))
    {
        $response['messages'][] = 'Tên đăng nhập không được trống';
    }

    if(empty($password))
    {
        $response['messages'][] = 'Mật khẩu không được trống';
    }

    if(!empty($response))
    {
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set("message", $message);
        $func->redirect($configBase."account/dang-nhap");
    }

    $row = $d->rawQueryOne("select id, password, username, phone, address, email, fullname, avatar from #_member where username = ? and find_in_set('hienthi',status) limit 0,1",array($username));

    if(!empty($row))
    {
        if($row['password'] == $passwordMD5)
        {
            /* Tạo login session */
            $id_user = $row['id'];
            $lastlogin = time();
            $login_session = md5($row['password'].$lastlogin);
            $d->rawQuery("update #_member set login_session = ?, lastlogin = ? where id = ?",array($login_session,$lastlogin,$id_user));

            /* Lưu session login */
            $_SESSION[$loginMember]['active'] = true;
            $_SESSION[$loginMember]['id'] = $row['id'];
            $_SESSION[$loginMember]['username'] = $row['username'];
            $_SESSION[$loginMember]['avatar'] = $row['avatar'];
            $_SESSION[$loginMember]['phone'] = $row['phone'];
            $_SESSION[$loginMember]['address'] = $row['address'];
            $_SESSION[$loginMember]['email'] = $row['email'];
            $_SESSION[$loginMember]['fullname'] = $row['fullname'];
            $_SESSION[$loginMember]['login_session'] = $login_session;

            /* Nhớ mật khẩu */
            setcookie('login_member_id',"",-1,'/');
            setcookie('login_member_session',"",-1,'/');
            if($remember)
            {
                $time_expiry = time()+3600*24;
                setcookie('login_member_id',$row['id'],$time_expiry,'/');
                setcookie('login_member_session',$login_session,$time_expiry,'/');
            }

            $func->transfer("Đăng nhập thành công", $configBase);
        }
        else
        {
            $response['messages'][] = 'Tên đăng nhập hoặc mật khẩu không chính xác. Hoặc tài khoản của bạn chưa được xác nhận từ Quản trị website';
        }
    }
    else
    {
        $response['messages'][] = 'Tên đăng nhập hoặc mật khẩu không chính xác. Hoặc tài khoản của bạn chưa được xác nhận từ Quản trị website';
    }

    /* Response error */
    if(!empty($response))
    {
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set("message", $message);
        $func->redirect($configBase."account/dang-nhap");
    }
}

/* Đăng ký */
function signupMember()
{
    global $d, $func, $flash, $configBase;

    /* Data */
    $message = '';
    $response = array();
    $username = (!empty($_POST['username'])) ? htmlspecialchars($_POST['username']) : '';
    $password = (!empty($_POST['password'])) ? $_POST['password'] : '';
    $passwordMD5 = md5($password);
    $repassword = (!empty($_POST['repassword'])) ? $_POST['repassword'] : '';
    $fullname = (!empty($_POST['fullname'])) ? htmlspecialchars($_POST['fullname']) : '';
    $email = (!empty($_POST['email'])) ? htmlspecialchars($_POST['email']) : '';
    $confirm_code = $func->digitalRandom(0,3,6);
    $phone = (!empty($_POST['phone'])) ? htmlspecialchars($_POST['phone']) : 0;
    $address = (!empty($_POST['address'])) ? htmlspecialchars($_POST['address']) : '';
    $gender = (!empty($_POST['gender'])) ? htmlspecialchars($_POST['gender']) : 0;
    $birthday = (!empty($_POST['birthday'])) ? htmlspecialchars($_POST['birthday']) : '';
    $type_account = (!empty($_POST['type_account'])) ? htmlspecialchars($_POST['type_account']) : '';
    $address_store = (!empty($_POST['address_store'])) ? htmlspecialchars($_POST['address_store']) : '';
    $payments = (!empty($_POST['payments'])) ? htmlspecialchars($_POST['payments']) : 0;
    $payments = (!empty($_POST['money'])) ? htmlspecialchars($_POST['money']) : 0;
    $payments = (!empty($_POST['money'])) ? htmlspecialchars($_POST['money']) : 0;
    $dataPhoto = $func->listsGallery('review-file-photo');
    $hashImage = (!empty($_POST['hash'])) ? $_POST['hash'] : '';

    /* Valid data */
    if(empty($fullname))
    {
        $response['messages'][] = 'Họ tên không được trống';
    }

    if(empty($username))
    {
        $response['messages'][] = 'Tài khoản không được trống';
    }

    if(!empty($username))
    {
        if(!$func->isAlphaNum($username))
        {
            $response['messages'][] = 'Tài khoản chỉ được nhập chữ thường và số (chữ thường không dấu, ghi liền nhau, không khoảng trắng)';
        }

        if($func->checkAccount($username, 'username', 'member'))
        {
            $response['messages'][] = 'Tài khoản đã tồn tại';
        }
    }

    if(empty($password))
    {
        $response['messages'][] = 'Mật khẩu không được trống';
    }

    if(!empty($password) && empty($repassword))
    {
        $response['messages'][] = 'Xác nhận mật khẩu không được trống';
    }

    if(!empty($password) && !empty($repassword) && !$func->isMatch($password, $repassword))
    {
        $response['messages'][] = 'Mật khẩu không trùng khớp';
    }

    if(empty($birthday))
    {
        $response['messages'][] = 'Ngày sinh không được trống';
    }

    if(empty($email))
    {
        $response['messages'][] = 'Email không được trống';
    }

    if(!empty($email))
    {
        if(!$func->isEmail($email))
        {
            $response['messages'][] = 'Email không hợp lệ';
        }

        if($func->checkAccount($email, 'email', 'member'))
        {
            $response['messages'][] = 'Email đã tồn tại';
        }
    }

    if(!empty($phone) && !$func->isPhone($phone))
    {
        $response['messages'][] = 'Số điện thoại không hợp lệ';
    }

    if(empty($address))
    {
        $response['messages'][] = 'Địa chỉ không được trống';
    }
    if(!empty($response))
    {
        /* Flash data */
        $flash->set('fullname', $fullname);
        $flash->set('username', $username);
        $flash->set('gender', $gender);
        $flash->set('birthday', $birthday);
        $flash->set('email', $email);
        $flash->set('phone', $phone);
        $flash->set('address', $address);

        /* Errors */
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set('message', $message);
        $func->redirect($configBase."account/dang-ky");
    }

    /* Save data */
    $data['fullname'] = $fullname;
    $data['username'] = $username;
    $data['password'] = md5($password);
    $data['email'] = $email;
    $data['phone'] = $phone;
    $data['address'] = $address;
    $data['gender'] = $gender;
    $data['birthday'] = strtotime(str_replace("/","-",$birthday));
    $data['confirm_code'] = $confirm_code;
    $data['status'] = '';

    if($d->insert('member',$data))
    {
        $func->transfer("Đăng ký thành viên thành công. Vui lòng kiểm tra email: ".$data['email']." để kích hoạt tài khoản", $configBase."account/dang-nhap");
    }
    else
    {
        $func->transfer("Đăng ký thành viên thất bại. Vui lòng thử lại sau.", $configBase, false);
    }
}

/* Gửi active */
function sendActivation($username)
{
    global $d, $setting, $emailer, $func, $configBase, $lang;

    /* Lấy thông tin người dùng */
    $row = $d->rawQueryOne("select id, confirm_code, username, password, fullname, email, phone, address from #_member where username = ? limit 0,1",array($username));

    /* Gán giá trị gửi email */
    $iduser = $row['id'];
    $confirm_code = $row['confirm_code'];
    $tendangnhap = $row['username'];
    $matkhau = $row['password'];
    $tennguoidung = $row['fullname'];
    $emailnguoidung = $row['email'];
    $dienthoainguoidung = $row['phone'];
    $diachinguoidung = $row['address'];
    $linkkichhoat = $configBase."account/kich-hoat?id=".$iduser;

    /* Thông tin đăng ký */
    $thongtindangky='<td style="padding:3px 9px 9px 0px;border-top:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal" valign="top"><span style="text-transform:normal">Username: '.$tendangnhap.'</span><br>Mã kích hoạt: '.$confirm_code.'</td><td style="padding:3px 0px 9px 9px;border-top:0;border-left:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal" valign="top">';
    if($tennguoidung)
    {
        $thongtindangky.='<span style="text-transform:capitalize">'.$tennguoidung.'</span><br>';
    }
    if($emailnguoidung)
    {
        $thongtindangky.='<a href="mailto:'.$emailnguoidung.'" target="_blank">'.$emailnguoidung.'</a><br>';
    }
    if($diachinguoidung)
    {
        $thongtindangky.=$diachinguoidung.'<br>';
    }
    if($dienthoainguoidung)
    {
        $thongtindangky.='Tel: '.$dienthoainguoidung.'</td>';
    }

    /* Defaults attributes email */
    $emailDefaultAttrs = $emailer->defaultAttrs();

    /* Variables email */
    $emailVars = array(
        '{emailInfoSignupMember}',
        '{emailLinkActiveMember}'
    );
    $emailVars = $emailer->addAttrs($emailVars, $emailDefaultAttrs['vars']);

    /* Values email */
    $emailVals = array(
        $thongtindangky,
        $linkkichhoat
    );
    $emailVals = $emailer->addAttrs($emailVals, $emailDefaultAttrs['vals']);

    /* Send email admin */
    $arrayEmail = array(
        "dataEmail" => array(
            "name" => $row['username'],
            "email" => $row['email']
        )
    );
    $subject = "Thư kích hoạt tài khoản thành viên từ ".$setting['name'.$lang];
    $message = str_replace($emailVars, $emailVals, $emailer->markdown('member/active'));
    $file = '';

    if(!$emailer->send("customer", $arrayEmail, $subject, $message, $file))
    {
        $func->transfer("Có lỗi xảy ra trong quá trình kích hoạt tài khoản. Vui lòng liên hệ với chúng tôi.",$configBase."lien-he", false);
    }
}

/* Quên mật khẩu */
function forgotPasswordMember()
{
    global $d, $setting, $emailer, $func, $flash, $loginMember, $configBase, $lang;

    /* Data */
    $message = '';
    $response = array();
    $username = (!empty($_POST['username'])) ? htmlspecialchars($_POST['username']) : '';
    $email = (!empty($_POST['email'])) ? htmlspecialchars($_POST['email']) : '';
    $newpass = substr(md5(rand(0,999)*time()), 15, 6);
    $newpassMD5 = md5($newpass);

    /* Valid data */
    if(empty($username))
    {
        $response['messages'][] = 'Tài khoản không được trống';
    }

    if(!empty($username) && !$func->isAlphaNum($username))
    {
        $response['messages'][] = 'Tài khoản chỉ được nhập chữ thường và số (chữ thường không dấu, ghi liền nhau, không khoảng trắng)';
    }

    if(empty($email))
    {
        $response['messages'][] = 'Email không được trống';
    }

    if(!empty($email) && !$func->isEmail($email))
    {
        $response['messages'][] = 'Email không hợp lệ';
    }

    if(!empty($username) && !empty($email))
    {
        $row = $d->rawQueryOne("select id from #_member where username = ? and email = ? limit 0,1",array($username,$email));

        if(empty($row))
        {
            $response['messages'][] = 'Tên đăng nhập hoặc/và email không tồn tại';
        }
    }

    if(!empty($response))
    {
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set('message', $message);
        $func->redirect($configBase."account/quen-mat-khau");
    }

    /* Cập nhật mật khẩu mới */
    $data['password'] = $newpassMD5;
    $d->where('username', $username);
    $d->where('email', $email);
    $d->update('member',$data);

    /* Lấy thông tin người dùng */
    $row = $d->rawQueryOne("select id, username, password, fullname, email, phone, address from #_member where username = ? limit 0,1",array($username));

    /* Gán giá trị gửi email */
    $iduser = $row['id'];
    $tendangnhap = $row['username'];
    $matkhau = $row['password'];
    $tennguoidung = $row['fullname'];
    $emailnguoidung = $row['email'];
    $dienthoainguoidung = $row['phone'];
    $diachinguoidung = $row['address'];

    /* Thông tin đăng ký */
    $thongtindangky='<td style="padding:3px 9px 9px 0px;border-top:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal" valign="top"><span style="text-transform:normal">Username: '.$tendangnhap.'</span><br>Mật khẩu: *******'.substr($matkhau,-3).'</td><td style="padding:3px 0px 9px 9px;border-top:0;border-left:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal" valign="top">';
    if($tennguoidung)
    {
        $thongtindangky.='<span style="text-transform:capitalize">'.$tennguoidung.'</span><br>';
    }

    if($emailnguoidung)
    {
        $thongtindangky.='<a href="mailto:'.$emailnguoidung.'" target="_blank">'.$emailnguoidung.'</a><br>';
    }

    if($diachinguoidung)
    {
        $thongtindangky.=$diachinguoidung.'<br>';
    }

    if($dienthoainguoidung)
    {
        $thongtindangky.='Tel: '.$dienthoainguoidung.'</td>';
    }

    /* Defaults attributes email */
    $emailDefaultAttrs = $emailer->defaultAttrs();

    /* Variables email */
    $emailVars = array(
        '{emailInfoSignupMember}',
        '{emailNewPasswordMember}'
    );
    $emailVars = $emailer->addAttrs($emailVars, $emailDefaultAttrs['vars']);

    /* Values email */
    $emailVals = array(
        $thongtindangky,
        $newpass
    );
    $emailVals = $emailer->addAttrs($emailVals, $emailDefaultAttrs['vals']);

    /* Send email admin */
    $arrayEmail = array(
        "dataEmail" => array(
            "name" => $tennguoidung,
            "email" => $email
        )
    );
    $subject = "Thư cấp lại mật khẩu từ ".$setting['name'.$lang];
    $message = str_replace($emailVars, $emailVals, $emailer->markdown('member/forgot-password'));
    $file = '';

    if($emailer->send("customer", $arrayEmail, $subject, $message, $file))
    {
        unset($_SESSION[$loginMember]);
        setcookie('login_member_id',"",-1,'/');
        setcookie('login_member_session',"",-1,'/');
        $func->transfer("Cấp lại mật khẩu thành công. Vui lòng kiểm tra email: ".$email, $configBase);
    }
    else
    {
        $func->transfer("Có lỗi xảy ra trong quá trình cấp lại mật khẩu. Vui lòng liện hệ với chúng tôi.", $configBase."account/quen-mat-khau", false);
    }
}
function logoutMember()
{
    global $d, $func, $loginMember, $configBase;

    unset($_SESSION[$loginMember]);
    setcookie('login_member_id',"",-1,'/');
    setcookie('login_member_session',"",-1,'/');

    $func->redirect($configBase);
}

function getStudent()
    {
        global $d, $func, $row_detail, $config_base, $loginMember, $items,$paging, $functionTeacher, $typeData, $type;
        $iduser = $_SESSION[$loginMember]['id'];
        $type = $_REQUEST['type'];
        if ($type == 'lythuyet') $typeData = 'theory'; elseif($type == 'hinh') $typeData = 'geometry'; else $typeData = $type;
        $rowTeacher = $d->rawQueryOne("select * from #_member where id = ?  order by numb,id desc limit 1",array($iduser));

        $functionTeacher = array();
        $functionTeacher = explode(',', $rowTeacher['chucnang']);



        if($iduser)
        {
            /* Kiểm tra chức năng giáo viên */
            if (!in_array($type,$functionTeacher)) {
                $func->transfer("Bạn không được cấp quyền vào đây !",$configBase."account/thong-tin", false);
            }

            $get_page = isset($_GET['p']) ? htmlspecialchars($_GET['p']) : 1;
            /* Lấy sản phẩm */
            $where = "";

            if (!empty($_REQUEST['courses-id'])) {
                // Show data search
                $dataResult['courses_id'] = explode(",", $_REQUEST['courses-id']);

                foreach($dataResult['courses_id'] as $s => $vc){
                    $where .= ($s == 0 ? ' and (' : ' or') ." MA_KHOA_HOC = '".$vc."'";
                }
                $where = $where.")";
            }

            if (!empty($_REQUEST['status-pass']) && $_REQUEST['status-pass'] == 1) {
                $where .= " and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.".$typeData.".point')) > 0";
            }
            if (!empty($_REQUEST['status-pass']) && $_REQUEST['status-pass'] == 2) {
                $where .= " and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.".$typeData.".point')) = 0";
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

            if (!empty($_REQUEST['gplx']) && $_REQUEST['gplx'] > 0) {
                $where .= " and HANG_GPLX = '".$_REQUEST['gplx']."'";
            }

            /* Lấy mã khoá học giáo viên đang dạy */
            $listCourses = $d->rawQuery("select MA_KHOA_HOC from #_courses where JSON_CONTAINS(data_teacher, JSON_ARRAY('".$iduser."'))");
            if (!empty($listCourses)) {
                foreach ($listCourses as $key => $v) {
                    $where .= ($key == 0 ? ' and (' : ' or') ." MA_KHOA_HOC = '".$v['MA_KHOA_HOC']."'";
                }
                $where = $where.")";
                $params = array();
                $curPage = $get_page;
                $per_page = 15;
                $startpoint = ($curPage * $per_page) - $per_page;
                $limit = " limit ".$startpoint.",".$per_page;
                $sql = "select * from #_student where id <> 0 $where order by numb,id desc $limit";
                $items = $d->rawQuery($sql);
                $sqlNum = "select count(*) as 'num' from #_student where id <> 0 $where order by numb,id desc";
                $count = $d->rawQueryOne($sqlNum,$params);
                $total = $count['num'];
                $url = $func->getCurrentPageURL();
                $paging = $func->pagination($total,$per_page,$curPage,$url);
            }
        }
    }

?>