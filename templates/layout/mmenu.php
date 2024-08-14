<div class="menu-moblie">
    <div class="head-bottom">
        <div class="wrap-content flex">
            <div class="company-logo">
                <a class="logo-mobile" href="">
                    <img onerror="this.src='<?= THUMBS ?>/134x134x2/assets/images/noimage.png';" src="<?= UPLOAD_PHOTO_L . $logo['photo'] ?>" alt="logo" title="logo" />
                </a>
                <div class="banner-header">
                    <a class="banner-head" href="">
                        <img onerror="this.src='<?= THUMBS ?>/149x67x2/assets/images/noimage.png';" src="<?= THUMBS ?>/149x67x2/<?= UPLOAD_PHOTO_L . $banner['photo'] ?>" alt="banner" title="banner" />
                    </a>
                </div>
            </div>
            <div class="right-head align-items-center">
                <a id="hamburger" href="#menu" title="Menu"><span></span></a>
            </div>
        </div>
    </div>
</div>
<nav id="menu">
    <ul class="menu-main">
        <li><a class="<?php if ($com == '' || $com == 'index') echo 'active'; ?> transition" href="" title="<?= trangchu ?>"><?= trangchu ?></a></li>
        <li><a class="<?php if ($com == 'gioi-thieu') echo 'active'; ?> transition" href="gioi-thieu" title="<?= gioithieu ?>"><?= gioithieu ?></a></li>
        <li><a class="<?php if ($com == 'mo-phong') echo 'active'; ?> transition" href="mo-phong" title="Mô phỏng">Mô phỏng</a></li>
        <li><a class="<?php if ($com == 'thi-thu') echo 'active'; ?> transition" href="thi-thu" title="Thi thử lý thuyết">Thi thử lý thuyết</a></li>
        <li><a class="<?php if ($com == 'tai-lieu') echo 'active'; ?> transition" href="tai-lieu" title="Tài liệu">Tài liệu</a></li>
        <li><a class="<?php if ($com == 'thong-bao') echo 'active'; ?> transition" href="thong-bao" title="Thông báo">Thông báo</a></li>
        <li><a class="<?php if ($com == 'khoa-hoc') echo 'active'; ?> transition" href="khoa-hoc" title="Khoá học">Khoá học</a></li>
        <li><a class="<?php if ($com == 'dang-ky') echo 'active'; ?> transition" href="dang-ky" title="Đăng ký học">Đăng ký học</a></li>
    </ul>
</nav>
</div>