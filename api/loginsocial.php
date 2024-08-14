<?php
include "config.php";

$cmt = $_POST['cmt'] != '' ? $_POST['cmt'] : 'zalo';
$id = $_POST['id'];
$name = $_POST['name'];
$img = $_POST['img'];
$mail = $_POST['mail'];
$return['status'] = 0;



if (isset($cmt) && $cmt == 'google') {
    $sql = "select * from #_member where id_google='" . $mail . "'  limit 0,1";
    $counts = $d->rawQuery($sql);

    if (count($counts) > 0) {
        global $d, $func, $restApi, $flash, $loginMember, $configBase, $apiRoutes,$config_database;
        unset($_SESSION[$loginMember]);
        $rs_login = $d->rawQueryOne($sql);
        $id_user = $rs_login['id'];
        $rowCheck = $d->rawQueryOne('select id,status from #_member where id=? and find_in_set("hienthi",status)',array($id_user));

        if(!empty($rowCheck['id'])){
            if (empty($rs_login['id_google'])) {
                $d->rawQuery("update #_member set id_google = ? where id = ?", array($user['id_google'], $id_user));
            }
            if (empty($_SESSION[$loginMember])) {
                $lastlogin = time();
                $login_session = md5($rs_login['id_google'] . $lastlogin);
                $userId = $rs_login['id'];
                $_SESSION[$loginMember]['active'] = true;
                $_SESSION[$loginMember]['id'] = $userId;
                $_SESSION[$loginMember]['username'] = $rs_login['username'];
                $_SESSION[$loginMember]['email'] = $rs_login['email'];
                $_SESSION[$loginMember]['fullname'] = $rs_login['fullname'];
                $_SESSION[$loginMember]['last_name'] = $rs_login['last_name'];
                $_SESSION[$loginMember]['callback'] = $rs_login['fullname'];
                $_SESSION[$loginMember]['login_session'] = $login_session;
                /* Update login session in database */
                $d->rawQuery("update #_member set login_session = ?, lastlogin = ? where id = ?", array($login_session, $lastlogin, $userId));
                foreach ($config_database as $k => $v) {
                    $d->rawQuery("update ".$v."table_member set login_session = ?, lastlogin = ? where id = ?", array($login_session, $lastlogin, $userId));
                }
            }
        }else{
            $return['hienthi'] = 0;
        }
    } else {
        global $d, $func, $restApi, $flash, $loginMember, $configBase, $apiRoutes,$config_database;

        unset($_SESSION[$loginMember]);

        $data_insert = array();
        $cut_name = explode(' ', $name);
        $data_insert['id_google'] = $mail;
        $data_insert['fullname'] = $name;
        $data_insert['last_name'] = $cut_name[count($cut_name) - 1];

        unset($cut_name[count($cut_name) - 1]);

        $data_insert['first_name'] = implode(' ', $cut_name);
        $data_insert['username'] = 'gg.' . current(explode('@', $mail));
        $data_insert['status'] = 'hienthi';
        $data_insert['date_created']        = time();

        $d->insert('member', $data_insert);
        $id_insert = $d->getLastInsertId();
        $sql = "select * from #_member where id = ? limit 0,1";
        $row_detail = $d->rawQueryOne($sql, array($id_insert));

        if (!empty($row_detail['id'])) {
            $rs_login = $d->rawQueryOne($sql, array($row_detail['id']));
            $lastlogin = time();
            $login_session = md5($row_detail['id_google'] . $lastlogin);
            $userId = $rs_login['id'];

            $_SESSION[$loginMember]['active'] = true;
            $_SESSION[$loginMember]['id'] = $userId;
            $_SESSION[$loginMember]['username'] = $rs_login['username'];
            $_SESSION[$loginMember]['fullname'] = $rs_login['fullname'];
            $_SESSION[$loginMember]['login_session'] = $login_session;

            /* Update login session in database */
            $d->rawQuery("update #_member set login_session = ?, lastlogin = ? where id = ?", array($login_session, $lastlogin, $userId));
            $data = $d->rawQueryOne("select * from #_member where id = ? limit 0,1", array($userId));
            $unset_array = array('password', 'password_virtual');
            $data['login_session'] = $login_session;
            $data['lastlogin'] = $lastlogin;
            
            foreach ($config_database as $k => $v) {
                if(!$d->insert($v.'table_member', $data)){
                    $func->dump($d->getLastError());
                }
            }
            //$func->WriteUserAll($data);
        }
    }
}

if (isset($cmt) && $cmt == 'facebook') {
    $sql = "select * from #_member where id_facebook='" . $id . "'  limit 0,1";
    $counts = $d->rawQuery($sql);

    if (count($counts) > 0) {
        global $d, $func, $restApi, $flash, $loginMember, $configBase, $apiRoutes,$config_database;
        unset($_SESSION[$loginMember]);
        $rs_login = $d->rawQueryOne($sql);
        $id_user = $rs_login['id'];
        $rowCheck = $d->rawQueryOne('select id,status from #_member where id=? and find_in_set("hienthi",status)',array($id_user));
        if(!empty($rowCheck['id'])){
            if (empty($rs_login['id_facebook'])) {
                $d->rawQuery("update #_member set id_facebook = ? where id = ?", array($user['id_facebook'], $id_user));
            }

            if (empty($_SESSION[$loginMember])) {
                $lastlogin = time();
                $login_session = md5($rs_login['id_facebook'] . $lastlogin);
                $userId  =  $rs_login['id'];

                $_SESSION[$loginMember]['active'] = true;
                $_SESSION[$loginMember]['id'] = $userId;
                $_SESSION[$loginMember]['username'] = $rs_login['username'];
                $_SESSION[$loginMember]['email'] = $rs_login['email'];
                $_SESSION[$loginMember]['fullname'] = $rs_login['fullname'];
                $_SESSION[$loginMember]['login_session'] = $login_session;

                /* Update login session in database */
                $d->rawQuery("update #_member set login_session = ?, lastlogin = ? where id = ?", array($login_session, $lastlogin, $userId));
                foreach ($config_database as $k => $v) {
                    $d->rawQuery("update ".$v."table_member set login_session = ?, lastlogin = ? where id = ?", array($login_session, $lastlogin, $userId));
                }
            }
        }else{
            $return['hienthi'] = 0;
        }
    } else {
        global $d, $func, $restApi, $flash, $loginMember, $configBase, $apiRoutes,$config_database;

        $data_insert = array();
        $cut_name = explode(' ', $name);
        $data_insert['id_facebook'] = $id;
        $data_insert['fullname'] = $name;
        $data_insert['last_name'] = $cut_name[count($cut_name) - 1];

        unset($cut_name[count($cut_name) - 1]);

        $data_insert['first_name'] = implode(' ', $cut_name);
        $data_insert['username'] = 'fb.' . str_replace('-', '', $func->changeTitle($name));
        $data_insert['status'] = 'hienthi';
        $data_insert['date_created'] = time();

        $d->insert('member', $data_insert);
        $id_insert = $d->getLastInsertId();

        if ($id_insert) {
            $row_detail = $d->rawQueryOne("select * from #_member where id = ? limit 0,1", array($id_insert));

            if (!empty($row_detail['id'])) {
                $rs_login = $d->rawQueryOne($sql, array($row_detail['id']));
                $lastlogin = time();
                $login_session = md5($row_detail['id_facebook'] . $lastlogin);
                $userId = $rs_login['id'];

                $_SESSION[$loginMember]['active'] = true;
                $_SESSION[$loginMember]['id'] = $userId;
                $_SESSION[$loginMember]['username'] = $rs_login['username'];
                $_SESSION[$loginMember]['fullname'] = $rs_login['fullname'];
                $_SESSION[$loginMember]['login_session'] = $login_session;

                /* Update login session in database */
                $d->rawQuery("update #_member set login_session = ?, lastlogin = ? where id = ?", array($login_session, $lastlogin, $userId));

                $unset_array = array('password', 'password_virtual');
                $data['login_session'] = $login_session;
                foreach ($row_detail as $column => $value) {
                    if (in_array($column, $unset_array)) continue;
                    $data[$column] = htmlspecialchars($func->sanitize($value));
                }

                foreach ($config_database as $k => $v) {
                    if(!$d->insert($v.'table_member', $data)){
                        $func->dump($d->getLastError());
                    }
                }
            }
        }
    }
}


$return['status'] = 1;
$return['back'] = $_SESSION['back'];
unset($_SESSION['back']);
echo json_encode($return);
