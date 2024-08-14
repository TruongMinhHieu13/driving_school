<div class="page-news">
    <h2 class="title-main"><?= (!empty($titleCate)) ? $titleCate : @$titleMain ?></h2>
    <p class="slogan"><?=$optsetting['slogan']?></p>
    <?php if (isset($news) && count($news) > 0) { ?>
        <div class="row">
            <?php foreach ($news as $v){ ?>
                <div class="col-lg-4 col-md-4 col-sm-6 col-6 mb-3">
                <div class="items-courses">
                    <div class="icon-courses">
                        <a href="<?=$v[$sluglang]?>" title="<?=$v['name'.$lang]?>">
                            <img onerror="this.src='<?= THUMBS ?>/60x60x1/assets/images/noimage.png';" src="<?= UPLOAD_NEWS_L . $v['photo'] ?>" alt="<?= $v['name' . $lang] ?>" title="<?= $v['name' . $lang] ?>" />
                        </a>
                    </div>
                    <h3 class="name-courses">
                        <a href="<?=$v[$sluglang]?>" title="<?=$v['name'.$lang]?>"><?=$v['name'.$lang]?></a>
                    </h3>
                    <p class="desc-courses text-split"><?=$v['desc'.$lang]?></p>
                    <a href="<?=$v[$sluglang]?>" title="<?=$v['name'.$lang]?>" class="see-detail">Xem chi tiết <i class="fa-regular fa-angle-right ms-2"></i></a>
                </div>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <div class="alert alert-warning w-100" role="alert">
            <strong><?= khongtimthayketqua ?></strong>
        </div>
    <?php } ?>
    <div class="pagination-home w-100"><?= (!empty($paging)) ? $paging : '' ?></div>
</div>