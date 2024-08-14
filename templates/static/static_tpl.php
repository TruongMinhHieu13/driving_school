<?php if (!empty($static)) { ?>
    <h2 class="title-main"><?= $static['name' . $lang] ?></h2>
    <p class="slogan"><?=$optsetting['slogan']?></p>
    <div class="content-main content-ck"><?= $func->decodeHtmlChars($static['content' . $lang]) ?></div>
    <div class="share">
        <b><?= chiase ?>:</b>
        <div class="social-plugin w-clear">
            <?php
            $params = array();
            $params['oaid'] = $optsetting['oaidzalo'];
            echo $func->markdown('social/share', $params);
            ?>
        </div>
    </div>
<?php } else { ?>
    <div class="alert alert-warning w-100" role="alert">
        <strong><?= dangcapnhatdulieu ?></strong>
    </div>
    <?php } ?>