<div class="footer">
    <div class="footer-article">
        <div class="wrap-content flex">  
            <div class="footer-news">
                <a class="logo-head" href="">
                    <img onerror="this.src='<?= THUMBS ?>/134x134x2/assets/images/noimage.png';" src="<?= UPLOAD_PHOTO_L . $logo['photo'] ?>" alt="logo" title="logo" />
                </a>
                <div class="footer-desc content-ck"><?= $func->decodeHtmlChars($footer['desc' . $lang]) ?></div>
                <ul class="social social-footer list-unstyled d-flex align-items-center justify-content-center">
                    <?php foreach ($social as $k => $v) { ?>
                        <li class="d-inline-block align-top">
                            <a href="<?= $v['link'] ?>" target="_blank" class="me-2">
                                <img class="lazy" data-src="<?= THUMBS ?>/42x42x2/<?= UPLOAD_PHOTO_L . $v['photo'] ?>" alt="<?= $v['name' . $lang] ?>" title="<?= $v['name' . $lang] ?>">
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="footer-news">
                <div class="footer-title">Liên hệ</div>
                <div class="footer-info content-ck"><?= $func->decodeHtmlChars($footer['content' . $lang]) ?></div>
            </div>
            <div class="footer-news">
                <div class="footer-title">Đào tạo</div>
                <ul class="footer-ul d-flex flex-wrap">
                    <?php foreach ($policy as $v) { ?>
                        <li class="w-100"><a class=" text-decoration-none " href="<?= $v[$sluglang] ?>" title="<?= $v['name' . $lang] ?>"><?= $v['name' . $lang] ?></a></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="footer-news">
                <?= $addons->set('footer-map', 'footer-map', 1); ?>
            </div>
        </div>
    </div>
    <div class="footer-powered">
        <div class="wrap-content">
            <div class="row">
                <div class="footer-copyright col-md-12">Copyright © 2024 <b><?= $copyright['name' . $lang] ?></b>. Designed by <a href="https://nina.vn" class=" text-decoration-none" title="Nina.vn">Nina.vn</a></div>
            </div>
        </div>
    </div>
</div>
<div class="check-toolbar">
    <input class="yep" id="check-toolbar" type="checkbox" checked>
    <label for="check-toolbar"></label>
</div>
<?= $addons->set('messages-facebook', 'messages-facebook', 1); ?>
<a class="btn-zalo btn-frame text-decoration-none" target="_blank" href="https://zalo.me/<?= preg_replace('/[^0-9]/', '', $optsetting['zalo']); ?>" target="_blank">
    <div class="animated infinite zoomIn kenit-alo-circle"></div>
    <div class="animated infinite pulse kenit-alo-circle-fill"></div>
    <i><?= $func->getImage(['size-error' => '35x35x2', 'upload' => 'assets/images/', 'image' => 'zl.png', 'alt' => 'Zalo']) ?></i>
</a>
<a class="btn-phone btn-frame text-decoration-none" href="tel:<?= preg_replace('/[^0-9]/', '', $optsetting['hotline']); ?>" target="_blank">
    <div class="animated infinite zoomIn kenit-alo-circle"></div>
    <div class="animated infinite pulse kenit-alo-circle-fill"></div>
    <i><?= $func->getImage(['size-error' => '35x35x2', 'upload' => 'assets/images/', 'image' => 'hl.png', 'alt' => 'Hotline']) ?></i>
</a>
<a class="btn-map btn-frame text-decoration-none" href="<?= $optsetting['link_googlemaps']?>" target="_blank">
    <div class="animated infinite zoomIn kenit-alo-circle"></div>
    <div class="animated infinite pulse kenit-alo-circle-fill"></div>
    <i class="fa-sharp fa-solid fa-location-dot"></i>
</a>