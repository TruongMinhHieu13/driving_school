<?php
if (!defined('SOURCES')) die("Error");

$slider = $d->rawQuery("select name$lang, desc$lang, photo, link from #_photo where type = ? and find_in_set('hienthi',status) order by numb,id desc", array('slide'));

$newsHome = $d->rawQuery("select name$lang, desc$lang, slugvi, slugen, photo, date_created from #_news where type = ? and find_in_set('hienthi',status) and find_in_set('noibat',status) order by numb,id desc", array('tin-tuc'));

$internalInformation = $d->rawQuery("select name$lang, desc$lang, slugvi, slugen, photo from #_news where type = ? and find_in_set('hienthi',status) order by numb,id desc", array('thong-tin'));

$albumHome = $d->rawQuery("select name$lang, slugvi, slugen, photo from #_news where type = ? and find_in_set('hienthi',status) order by numb,id desc limit 7", array('hinh-anh'));

$introHome = $d->rawQueryOne("select name$lang, desc$lang, desc2$lang, photo, photo1, photo2 from #_static where type = ? and find_in_set('hienthi',status) limit 1", array('gioi-thieu'));

$videoHome = $d->rawQuery("select id,name$lang, link_video, photo from #_photo where type = ? and find_in_set('hienthi',status)", array('video'));

$criteriaHome = $d->rawQuery("select name$lang, desc$lang, photo from #_photo where type = ? and find_in_set('hienthi',status)", array('criteria'));

$whyHome = $d->rawQuery("select name$lang, slugvi, slugen from #_news where type = ? and find_in_set('hienthi',status)", array('tieu-chi'));

$coursesHome = $d->rawQuery("select name$lang, desc$lang, slugvi, slugen, photo from #_news where type = ? and find_in_set('hienthi',status)", array('khoa-hoc'));

$scheduleHome = $d->rawQuery("select name$lang, morningvi, noonvi, afternoonvi from #_news where type = ? and find_in_set('hienthi',status)", array('lich-hoc'));

$statisticalHome = $d->rawQuery("select name$lang, quanlity, unit, photo, find_in_set('countup',status) as countup from #_news where type = ? and find_in_set('hienthi',status)", array('thong-ke'));



/* SEO */
$seopage = $d->rawQueryOne("select * from #_seopage where type = ? limit 0,1", array('trang-chu'));

$seo->set('h1', $seopage['title' . $seolang]);
if (!empty($seopage['title' . $seolang])) $seo->set('title', $seopage['title' . $seolang]);
else $seo->set('title', $titleMain);
if (!empty($seopage['keywords' . $seolang])) $seo->set('keywords', $seopage['keywords' . $seolang]);
if (!empty($seopage['description' . $seolang])) $seo->set('description', $seopage['description' . $seolang]);
$seo->set('url', $func->getPageURL());
$imgJson = (!empty($seopage['options'])) ? json_decode($seopage['options'], true) : null;
if (!empty($seopage['photo'])) {
    if (empty($imgJson) || ($imgJson['p'] != $seopage['photo'])) {
        $imgJson = $func->getImgSize($seopage['photo'], UPLOAD_SEOPAGE_L . $seopage['photo']);
        $seo->updateSeoDB(json_encode($imgJson), 'seopage', $seopage['id']);
    }
    if (!empty($imgJson)) {
        $seo->set('photo', $configBase . THUMBS . '/' . $imgJson['w'] . 'x' . $imgJson['h'] . 'x2/' . UPLOAD_SEOPAGE_L . $seopage['photo']);
        $seo->set('photo:width', $imgJson['w']);
        $seo->set('photo:height', $imgJson['h']);
        $seo->set('photo:type', $imgJson['m']);
    }
}
