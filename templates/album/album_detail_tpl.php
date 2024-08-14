<div class="title-main"><span><?= $rowDetail['name' . $lang] ?></span></div>
<div class="content-main">
    <?php if (isset($rowDetailPhoto) && count($rowDetailPhoto) > 0) { ?>
        <div class="row-album row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
            <?php foreach ($rowDetailPhoto as $k => $v) { ?>
                <div class="col col-album">
                    <div class="box-product">
                        <a class="album-image scale-img mb-0" data-fancybox="gallery" data-src="<?= ASSET . UPLOAD_NEWS_L . $v['photo'] ?>" data-caption="" title="<?= $rowDetail['name' . $lang] ?>">
                            <img class="lazy w-100" onerror="this.src='<?= THUMBS ?>/540x540x1/assets/images/noimage.png';" data-src="<?= THUMBS ?>/540x540x1/<?= UPLOAD_NEWS_L . $v['photo'] ?>" alt="<?= $rowDetail['name' . $lang] ?>" title="<?= $rowDetail['name' . $lang] ?>" />
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <div class="alert alert-warning w-100" role="alert">
            <strong><?= noidungdangcapnhat ?></strong>
        </div>
    <?php }  ?>
</div>