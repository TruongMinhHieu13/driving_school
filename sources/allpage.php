<?php
if (!defined('SOURCES')) die("Error");

/* static */
$copyright = $d->rawQueryOne("select name$lang from #_static where type = ? limit 0,1", array('copyright'));

$favicon = $d->rawQueryOne("select photo from #_photo where type = ? and act = ? and find_in_set('hienthi',status) limit 0,1", array('favicon', 'photo_static'));

$logo = $d->rawQueryOne("select id, photo, options from #_photo where type = ? and act = ? and find_in_set('hienthi',status) limit 0,1", array('logo', 'photo_static'));

$banner = $d->rawQueryOne("select id, photo, options from #_photo where type = ? and act = ? and find_in_set('hienthi',status) limit 0,1", array('banner', 'photo_static'));

$social = $d->rawQuery("select photo, name$lang, link from #_photo where type = ? and find_in_set('hienthi',status) order by numb, id desc", array('social'));

$footer = $d->rawQueryOne("select content$lang, desc$lang from #_static where type = ? and find_in_set('hienthi',status) limit 1", array('footer'));

$policy = $d->rawQuery("select name$lang, slugvi, slugen, id, photo from #_news where type = ? and find_in_set('hienthi',status) order by numb,id desc", array('dao-tao'));



/* Get statistic */
$counter = $statistic->getCounter();
$online = $statistic->getOnline();


/* Newsletter */
if (!empty($_POST['newsletter']) && $_POST['newsletter']=='submit') {
    $responseCaptcha = $_POST['recaptcha_response_newsletter'];
    $resultCaptcha = $func->checkRecaptcha($responseCaptcha);
    $scoreCaptcha = (!empty($resultCaptcha['score'])) ? $resultCaptcha['score'] : 0;
    $actionCaptcha = (!empty($resultCaptcha['action'])) ? $resultCaptcha['action'] : '';
    $testCaptcha = (!empty($resultCaptcha['test'])) ? $resultCaptcha['test'] : false;
    $dataNewsletter = (!empty($_POST['dataNewsletter'])) ? $_POST['dataNewsletter'] : null;

    $error = $flash->get('error');

    if (!empty($error)) {
        $func->transfer($error, $configBase, false);
    }

    /* Save data */
    if (($scoreCaptcha >= 0.5 && $actionCaptcha == 'Newsletter') || $testCaptcha == true) {
        foreach ($dataNewsletter as $column => $value) {
            $dataNewsletter[$column] = htmlspecialchars($value);
        }
        if($duplicate_email){
            $func->transfer("Email này đã đăng ký.",$configBase, false);
        }else{
            if ($d->insert('newsletter', $dataNewsletter)) {
                $func->transfer("Đăng ký thành công. Chúng tôi sẽ liên hệ với bạn sớm.", $configBase);
            } else {
                $func->transfer("Đăng ký thất bại. Vui lòng thử lại sau.", $configBase, false);
            }
        }
    } else {
        $func->transfer("Đăng ký thất bại. Vui lòng thử lại sau.", $configBase, false);
    }
}

/* Newsletter */
if (!empty($_POST['newsletter']) && $_POST['newsletter']=='submit') {
    $responseCaptcha = $_POST['recaptcha_response_newsletter'];
    $resultCaptcha = $func->checkRecaptcha($responseCaptcha);
    $scoreCaptcha = (!empty($resultCaptcha['score'])) ? $resultCaptcha['score'] : 0;
    $actionCaptcha = (!empty($resultCaptcha['action'])) ? $resultCaptcha['action'] : '';
    $testCaptcha = (!empty($resultCaptcha['test'])) ? $resultCaptcha['test'] : false;
    $dataNewsletter = (!empty($_POST['dataNewsletter'])) ? $_POST['dataNewsletter'] : null;

    $error = $flash->get('error');

    if (!empty($error)) {
        $func->transfer($error, $configBase, false);
    }

    /* Save data */
    if (($scoreCaptcha >= 0.5 && $actionCaptcha == 'Newsletter') || $testCaptcha == true) {
        foreach ($dataNewsletter as $column => $value) {
            $dataNewsletter[$column] = htmlspecialchars($value);
        }
        if($duplicate_email){
            $func->transfer("Email này đã đăng ký.",$configBase, false);
        }else{
            if ($d->insert('newsletter', $dataNewsletter)) {
                $func->transfer("Đăng ký thành công. Chúng tôi sẽ liên hệ với bạn sớm.", $configBase);
            } else {
                $func->transfer("Đăng ký thất bại. Vui lòng thử lại sau.", $configBase, false);
            }
        }
    } else {
        $func->transfer("Đăng ký thất bại. Vui lòng thử lại sau.", $configBase, false);
    }
}
/* Newsletter */
if (!empty($_POST['newsletterIndex']) && $_POST['newsletterIndex']=='submit') {
    $responseCaptcha = $_POST['recaptcha_response_newsletter_index'];
    $resultCaptcha = $func->checkRecaptcha($responseCaptcha);
    $scoreCaptcha = (!empty($resultCaptcha['score'])) ? $resultCaptcha['score'] : 0;
    $actionCaptcha = (!empty($resultCaptcha['action'])) ? $resultCaptcha['action'] : '';
    $testCaptcha = (!empty($resultCaptcha['test'])) ? $resultCaptcha['test'] : false;
    $dataNewsletter = (!empty($_POST['dataNewsletter'])) ? $_POST['dataNewsletter'] : null;

    $error = $flash->get('error');

    if (!empty($error)) {
        $func->transfer($error, $configBase, false);
    }

    /* Save data */
    if (($scoreCaptcha >= 0.5 && $actionCaptcha == 'Newsletter') || $testCaptcha == true) {
        foreach ($dataNewsletter as $column => $value) {
            $dataNewsletter[$column] = htmlspecialchars($value);
        }
        if($duplicate_email){
            $func->transfer("Email này đã đăng ký.",$configBase, false);
        }else{
            if ($d->insert('newsletter', $dataNewsletter)) {
                $func->transfer("Đăng ký thành công. Chúng tôi sẽ liên hệ với bạn sớm.", $configBase);
            } else {
                $func->transfer("Đăng ký thất bại. Vui lòng thử lại sau.", $configBase, false);
            }
        }
    } else {
        $func->transfer("Đăng ký thất bại. Vui lòng thử lại sau.", $configBase, false);
    }
}