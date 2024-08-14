<?php
/* Tại Sao */
$nametype = "tieu-chi";
$config['news'][$nametype]['title_main'] = "Tại Sao Chọn Chúng Tôi";
$config['news'][$nametype]['view'] = true;
$config['news'][$nametype]['hidden-category'] = true;
$config['news'][$nametype]['slug'] = true;
$config['news'][$nametype]['check'] = array("hienthi" => hienthi);
$config['news'][$nametype]['images'] = false;
$config['news'][$nametype]['desc'] = false;
$config['news'][$nametype]['show_images'] = false;
$config['news'][$nametype]['content'] = true;
$config['news'][$nametype]['content_cke'] = true;
$config['news'][$nametype]['seo'] = true;
$config['news'][$nametype]['schema'] = true;
$config['news'][$nametype]['width'] = 385;
$config['news'][$nametype]['height'] = 260;
$config['news'][$nametype]['thumb'] = '100x100x2';
$config['news'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.webp|.WEBP';

/* Các khóa học & thủ tục */
$nametype = "khoa-hoc";
$config['news'][$nametype]['title_main'] = "Các khóa học & thủ tục";
$config['news'][$nametype]['view'] = true;
$config['news'][$nametype]['slug'] = true;
$config['news'][$nametype]['check'] = array("noibat" => noibat,"hienthi" => hienthi);
$config['news'][$nametype]['images'] = true;
$config['news'][$nametype]['desc'] = true;
$config['news'][$nametype]['show_images'] = true;
$config['news'][$nametype]['content'] = true;
$config['news'][$nametype]['content_cke'] = true;
$config['news'][$nametype]['seo'] = true;
$config['news'][$nametype]['schema'] = true;
$config['news'][$nametype]['width'] = 110;
$config['news'][$nametype]['height'] = 110;
$config['news'][$nametype]['thumb'] = '100x100x2';
$config['news'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.webp|.WEBP';

/* Lịch học */
$nametype = "lich-hoc";
$config['news'][$nametype]['title_main'] = "Lịch học";
$config['news'][$nametype]['hidden-category'] = true;
$config['news'][$nametype]['dropdown'] = true;
$config['news'][$nametype]['copy'] = false;
$config['news'][$nametype]['copy_image'] = false; 
$config['news'][$nametype]['slug'] = false;
$config['news'][$nametype]['check'] = array("hienthi" => hienthi);
$config['news'][$nametype]['images'] = false;
$config['news'][$nametype]['show_images'] = false;
$config['news'][$nametype]['width'] = 385;
$config['news'][$nametype]['height'] = 330;
$config['news'][$nametype]['thumb'] = '100x100x2';
$config['news'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.webp|.WEBP';

/* Tin tức */
$nametype = "tin-tuc";
$config['news'][$nametype]['title_main'] = "Tin tức";
$config['news'][$nametype]['view'] = true; 
$config['news'][$nametype]['hidden-category'] = true;
$config['news'][$nametype]['slug'] = true;
$config['news'][$nametype]['check'] = array("noibat" => noibat,"hienthi" => hienthi);
$config['news'][$nametype]['images'] = true;
$config['news'][$nametype]['desc'] = true;
$config['news'][$nametype]['show_images'] = true;
$config['news'][$nametype]['content'] = true;
$config['news'][$nametype]['content_cke'] = true;
$config['news'][$nametype]['seo'] = true;
$config['news'][$nametype]['schema'] = true;
$config['news'][$nametype]['width'] = 380;
$config['news'][$nametype]['height'] = 280;
$config['news'][$nametype]['thumb'] = '100x100x2';
$config['news'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.webp|.WEBP';

/* Thông tin */
$nametype = "thong-tin";
$config['news'][$nametype]['title_main'] = "Thông tin";
$config['news'][$nametype]['view'] = true;
$config['news'][$nametype]['hidden-category'] = true; 
$config['news'][$nametype]['slug'] = true;
$config['news'][$nametype]['check'] = array("hienthi" => hienthi);
$config['news'][$nametype]['images'] = true;
$config['news'][$nametype]['desc'] = true;
$config['news'][$nametype]['show_images'] = true;
$config['news'][$nametype]['content'] = true;
$config['news'][$nametype]['content_cke'] = true;
$config['news'][$nametype]['seo'] = true;
$config['news'][$nametype]['schema'] = true;
$config['news'][$nametype]['width'] = 380;
$config['news'][$nametype]['height'] = 280;
$config['news'][$nametype]['thumb'] = '100x100x2';
$config['news'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.webp|.WEBP';


/* Thống kê */
$nametype = "thong-ke";
$config['news'][$nametype]['title_main'] = "Thống kê";
$config['news'][$nametype]['dropdown'] = true;
$config['news'][$nametype]['hidden-category'] = true;
$config['news'][$nametype]['view'] = true;
$config['news'][$nametype]['check'] = array("hienthi" => hienthi);
$config['news'][$nametype]['images'] = true;
$config['news'][$nametype]['show_images'] = true;
$config['news'][$nametype]['width'] = 60;
$config['news'][$nametype]['height'] = 60;
$config['news'][$nametype]['thumb'] = '60x60x2';
$config['news'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.webp|.WEBP';


/* Hình ảnh hoạt động */
$nametype = "hinh-anh";
$config['news'][$nametype]['title_main'] = "Hình ảnh hoạt động";
$config['news'][$nametype]['dropdown'] = true;
$config['news'][$nametype]['hidden-category'] = true;
$config['news'][$nametype]['view'] = true;
$config['news'][$nametype]['copy'] = true;
$config['news'][$nametype]['copy_image'] = true; 
$config['news'][$nametype]['slug'] = true;
$config['news'][$nametype]['check'] = array("hienthi" => hienthi);
$config['news'][$nametype]['images'] = true;
$config['news'][$nametype]['show_images'] = true;
$config['news'][$nametype]['gallery'] = array(
    $nametype => array(
        "title_main_photo" => "Hình ảnh hoạt động",
        "title_sub_photo" => hinhanh,
        "check_photo" => array("hienthi" => hienthi),
        "number_photo" => 3,
        "images_photo" => true,
        "cart_photo" => true,
        "avatar_photo" => true,
        "name_photo" => true,
        "width_photo" => 540,
        "height_photo" => 540,
        "thumb_photo" => '100x100x1',
        "img_type_photo" => '.jpg|.gif|.png|.jpeg|.gif|.webp|.WEBP'
    )
);
$config['news'][$nametype]['seo'] = true;
$config['news'][$nametype]['schema'] = true;
$config['news'][$nametype]['width'] = 395;
$config['news'][$nametype]['height'] = 435;
$config['news'][$nametype]['thumb'] = '100x100x2';
$config['news'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.webp|.WEBP';

/* Đào tạo */
$nametype = "dao-tao";
$config['news'][$nametype]['title_main'] = "Đào tạo";
$config['news'][$nametype]['view'] = true;
$config['news'][$nametype]['hidden-category'] = true;
$config['news'][$nametype]['copy'] = true;
$config['news'][$nametype]['copy_image'] = true; 
$config['news'][$nametype]['slug'] = true;
$config['news'][$nametype]['check'] = array("hienthi" => hienthi);
$config['news'][$nametype]['images'] = false;
$config['news'][$nametype]['desc'] = false;
$config['news'][$nametype]['content'] = true;
$config['news'][$nametype]['content_cke'] = true;
$config['news'][$nametype]['seo'] = true;
$config['news'][$nametype]['schema'] = true;
$config['news'][$nametype]['width'] = 400;
$config['news'][$nametype]['height'] = 300;
$config['news'][$nametype]['thumb'] = '100x100x2';
$config['news'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.webp|.WEBP';

/* Mô phỏng */
$nametype = "mo-phong";
$config['news'][$nametype]['title_main'] = "Mô phỏng";
$config['news'][$nametype]['view'] = true; 
$config['news'][$nametype]['hidden-category'] = true;
$config['news'][$nametype]['slug'] = true;
$config['news'][$nametype]['check'] = array("hienthi" => hienthi);
$config['news'][$nametype]['images'] = true;
$config['news'][$nametype]['desc'] = true;
$config['news'][$nametype]['show_images'] = true;
$config['news'][$nametype]['content'] = true;
$config['news'][$nametype]['content_cke'] = true;
$config['news'][$nametype]['seo'] = true;
$config['news'][$nametype]['schema'] = true;
$config['news'][$nametype]['width'] = 380;
$config['news'][$nametype]['height'] = 280;
$config['news'][$nametype]['thumb'] = '100x100x2';
$config['news'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.webp|.WEBP';

/* Thi thử lý thuyết */
$nametype = "thi-thu";
$config['news'][$nametype]['title_main'] = "Thi thử lý thuyết";
$config['news'][$nametype]['view'] = true; 
$config['news'][$nametype]['hidden-category'] = true;
$config['news'][$nametype]['slug'] = true;
$config['news'][$nametype]['check'] = array("hienthi" => hienthi);
$config['news'][$nametype]['images'] = true;
$config['news'][$nametype]['desc'] = true;
$config['news'][$nametype]['show_images'] = true;
$config['news'][$nametype]['content'] = true;
$config['news'][$nametype]['content_cke'] = true;
$config['news'][$nametype]['seo'] = true;
$config['news'][$nametype]['schema'] = true;
$config['news'][$nametype]['width'] = 380;
$config['news'][$nametype]['height'] = 280;
$config['news'][$nametype]['thumb'] = '100x100x2';
$config['news'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.webp|.WEBP';

/* Tài liệu */
$nametype = "tai-lieu";
$config['news'][$nametype]['title_main'] = "Tài liệu";
$config['news'][$nametype]['view'] = true; 
$config['news'][$nametype]['hidden-category'] = true;
$config['news'][$nametype]['slug'] = true;
$config['news'][$nametype]['check'] = array("hienthi" => hienthi);
$config['news'][$nametype]['images'] = true;
$config['news'][$nametype]['desc'] = true;
$config['news'][$nametype]['show_images'] = true;
$config['news'][$nametype]['content'] = true;
$config['news'][$nametype]['content_cke'] = true;
$config['news'][$nametype]['seo'] = true;
$config['news'][$nametype]['schema'] = true;
$config['news'][$nametype]['width'] = 380;
$config['news'][$nametype]['height'] = 280;
$config['news'][$nametype]['thumb'] = '100x100x2';
$config['news'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.webp|.WEBP';

/* Thông báo */
$nametype = "thong-bao";
$config['news'][$nametype]['title_main'] = "Thông báo";
$config['news'][$nametype]['view'] = true; 
$config['news'][$nametype]['hidden-category'] = true;
$config['news'][$nametype]['slug'] = true;
$config['news'][$nametype]['check'] = array("hienthi" => hienthi);
$config['news'][$nametype]['images'] = true;
$config['news'][$nametype]['desc'] = true;
$config['news'][$nametype]['show_images'] = true;
$config['news'][$nametype]['content'] = true;
$config['news'][$nametype]['content_cke'] = true;
$config['news'][$nametype]['seo'] = true;
$config['news'][$nametype]['schema'] = true;
$config['news'][$nametype]['width'] = 380;
$config['news'][$nametype]['height'] = 280;
$config['news'][$nametype]['thumb'] = '100x100x2';
$config['news'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.webp|.WEBP';

/* Đăng ký học */
$nametype = "dang-ky";
$config['news'][$nametype]['title_main'] = "Đăng ký học";
$config['news'][$nametype]['view'] = true; 
$config['news'][$nametype]['hidden-category'] = true;
$config['news'][$nametype]['slug'] = true;
$config['news'][$nametype]['check'] = array("hienthi" => hienthi);
$config['news'][$nametype]['images'] = true;
$config['news'][$nametype]['desc'] = true;
$config['news'][$nametype]['show_images'] = true;
$config['news'][$nametype]['content'] = true;
$config['news'][$nametype]['content_cke'] = true;
$config['news'][$nametype]['seo'] = true;
$config['news'][$nametype]['schema'] = true;
$config['news'][$nametype]['width'] = 380;
$config['news'][$nametype]['height'] = 280;
$config['news'][$nametype]['thumb'] = '100x100x2';
$config['news'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.webp|.WEBP';


/* Quản lý mục (Không cấp) */
if (isset($config['news'])) {
    foreach ($config['news'] as $key => $value) {
        if (!isset($value['dropdown']) || (isset($value['dropdown']) && $value['dropdown'] == false)) {
            $config['shownews'] = 1;
            break;
        }
    }
}
