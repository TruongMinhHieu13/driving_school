<div class="header">
    <div class="header-top">
        <div class="wrap-content">
            <div class="flex-header">
                <div class="hotline-header">
                    <img src="./assets/images/icon-phone.png" alt="">
                    Hotline: <?=$func->formatPhone(preg_replace('/[^0-9]/', '', $optsetting['hotline']));?>
                </div>
                <div class="address-header">
                    <img src="./assets/images/icon-map.png" alt="">
                    Địa chỉ: <?=$setting['address'.$lang]?>
                </div>
                <div class="email-header">
                    <img src="./assets/images/icon-email.png" alt="">
                    Email: <?=$optsetting['email']?>
                </div>
                <?php if (array_key_exists($loginMember, $_SESSION) && $_SESSION[$loginMember]['active'] == true) { ?>
                    <div class="user-head">
                        <a href="account/thong-tin">
                            <span>Hi, <?= $_SESSION[$loginMember]['fullname'] ?></span>
                        </a>
                        <a href="account/dang-xuat">
                            <i class="fas fa-sign-out-alt"></i>
                            <span><?= dangxuat ?></span>
                        </a>
                    </div>
                <?php } else { ?>
                    <div class="user-head">
                        <a href="account/dang-nhap">
                            <i class="fas fa-sign-in-alt"></i>
                            <span><?= dangnhap ?></span>
                        </a>
                        <a href="account/dang-ky">
                            <i class="fas fa-user-plus"></i>
                            <span><?= dangky ?></span>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="header-bottom">
        <div class="wrap-content">
            <div class="logo-header">
                <a class="logo-head" href="">
                    <img onerror="this.src='<?= THUMBS ?>/134x134x2/assets/images/noimage.png';" src="<?= UPLOAD_PHOTO_L . $logo['photo'] ?>" alt="logo" title="logo" />
                </a>
            </div>
            <div class="banner-header">
                <a class="banner-head" href="">
                    <img onerror="this.src='<?= THUMBS ?>/149x67x2/assets/images/noimage.png';" src="<?= THUMBS ?>/149x67x2/<?= UPLOAD_PHOTO_L . $banner['photo'] ?>" alt="banner" title="banner" />
                </a>
            </div>
            <div class="menu-header">
                <?php include TEMPLATE . LAYOUT . "menu.php"; ?>
            </div>
        </div>
    </div>
</div>