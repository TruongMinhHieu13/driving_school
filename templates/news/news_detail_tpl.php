    <h2 class="title-main"><?= $rowDetail['name' . $lang] ?></h2>
    <p class="slogan"><?=$optsetting['slogan']?></p>
    <div class="time-main"><i class="fa-solid fa-calendar-days"></i><span class="me-2"><?= date("d/m/Y h:i A", $rowDetail['date_created']) ?></span> <i class="fa-solid fa-eye"></i> <?= $rowDetail['view'] ?> <?= luotxem ?></div>
    <?php if (!empty($rowDetail['content' . $lang])) { ?>
        <div class="meta-toc">
            <a class="mucluc-dropdown-list_button"></a>
            <div class="box-readmore">
                <ul class="toc-list" data-toc="article" data-toc-headings="h1, h2, h3"></ul>
            </div>
        </div>
        <div class="content-main content-ck" id="toc-content"><?= htmlspecialchars_decode($rowDetail['content' . $lang]) ?></div>
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
            <strong><?= noidungdangcapnhat ?></strong>
        </div>
    <?php } ?>
    <?php if (!empty($news)) { ?>
        <div class="share othernews mb-3">
            <b><?= baivietkhac ?>:</b>
            <ul class="list-news-other">
                <?php foreach ($news as $k => $v) { ?>
                    <li><a class="text-decoration-none" href="<?= $v[$sluglang] ?>" title="<?= $v['name' . $lang] ?>"><?= $v['name' . $lang] ?> - <?= date("d/m/Y", $v['date_created']) ?></a></li>
                <?php } ?>
            </ul>
            <div class="pagination-home w-100"><?= (!empty($paging)) ? $paging : '' ?></div>
        </div>
    <?php } ?>
    
