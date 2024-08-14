<?php if (!empty($slider)) { ?>
    <div class="slideshow">
        <div class="slide-text none">
            <?php foreach ($slider as $v) { ?>
                <div>
                    <a class="slideshow-image" href="<?= $v['link'] ?>" target="_blank" title="<?= $v['name' . $lang] ?>">
                        <picture>
                            <source media="(max-width: 1366px)" srcset="<?= THUMBS ?>/1366x580x1/<?= UPLOAD_PHOTO_L . $v['photo'] ?>">
                            <source media="(max-width: 500px)" srcset="<?= THUMBS ?>/500x212x1/<?= UPLOAD_PHOTO_L . $v['photo'] ?>">
                            <img class="w-100" onerror="this.src='<?= THUMBS ?>/1920x815x1/assets/images/noimage.png';" src="<?= THUMBS ?>/1920x815x1/<?= UPLOAD_PHOTO_L . $v['photo'] ?>" alt="<?= $v['name' . $lang] ?>" title="<?= $v['name' . $lang] ?>" />
                        </picture>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>