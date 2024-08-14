<?php

/* Config type - News */
require_once LIBRARIES . 'type/config-type-news.php';

/* Config type - Newsletter */
require_once LIBRARIES . 'type/config-type-newsletter.php';

/* Config type - Static */
require_once LIBRARIES . 'type/config-type-static.php';

/* Config type - Photo */
require_once LIBRARIES . 'type/config-type-photo.php';

/* Seo page */
$config['seopage']['page'] = array(
    "trang-chu" => trangchu,
    "mo-phong" => "Mô phỏng",
    "thi-thu" => "Thi thử lý thuyết",
    "tai-lieu" => "Tài liệu",
    "thong-bao" => "Thông báo",
    "cac-khoa-hoc" => "Đăng ký học"
);
$config['seopage']['width'] = 300;
$config['seopage']['height'] = 200;
$config['seopage']['thumb'] = '300x200x1';
$config['seopage']['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.webp|.WEBP';

/* Setting */
$config['setting']['address'] = true;
$config['setting']['hotline'] = true;
$config['setting']['hotlineP'] = false;
$config['setting']['phone'] = false;
$config['setting']['zalo'] = true;
$config['setting']['email'] = true;
$config['setting']['website'] = true;
$config['setting']['fanpage'] = true;
$config['setting']['coords'] = false;
$config['setting']['coords_iframe'] = true;
$config['setting']['link_googlemaps'] = true;
$config['setting']['link_tiktok'] = true;
$config['setting']['worktime'] = true;
$config['setting']['slogan'] = true;


/* Quản lý tài khoản */
$config['user']['active'] = true;
$config['user']['admin'] = true;
$config['user']['check_admin'] = array("hienthi" => kichhoat);
$config['user']['member'] = true;
$config['user']['check_member'] = array("hienthi" => kichhoat);

/* Quản lý phân quyền */
$config['permission']['active'] = true;
$config['permission']['check'] = array("hienthi" => kichhoat);

/* Quản lý liên lệ */
$config['contact']['check'] = array("hienthi" => xacnhan);
$config['contact']['active'] = false;


?>