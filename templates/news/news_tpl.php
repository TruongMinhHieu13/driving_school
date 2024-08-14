<div class="page-news">
    <h2 class="title-main"><?= (!empty($titleCate)) ? $titleCate : @$titleMain ?></h2>
    <p class="slogan"><?=$optsetting['slogan']?></p>
    <?php if (isset($news) && count($news) > 0) { ?>
        <div class="row">
            <?php $func->getNews($news,'col-lg-4 col-md-4 col-sm-6 col-6 mb-3');?>
        </div>
    <?php } else { ?>
        <div class="alert alert-warning w-100" role="alert">
            <strong><?= khongtimthayketqua ?></strong>
        </div>
    <?php } ?>
    <div class="pagination-home w-100"><?= (!empty($paging)) ? $paging : '' ?></div>
</div>