<!-- Css Files -->
<?php
$css->set("css/animate.min.css");
$css->set("bootstrap/bootstrap.css");
$css->set("fontawesome640/all.css");
$css->set("menu-mobile/menu-mobile.css");
$css->set("slick/slick-theme.css");
$css->set("slick/slick-style.css");
$css->set("fancybox5/fancybox.css");
$css->set("css/account.css");
$css->set("css/fonts.css");
$css->set("simplenotify/simple-notify.css");
$css->set("css/style.css");
$css->set("css/style-media.css");
$css->set("slick/slick.css");
echo $css->get();
?>

<!-- Js Google Analytic -->
<?php if (!$func->isGoogleSpeed()){ ?>
	<?= $func->decodeHtmlChars($setting['analytics']) ?>
<?php } ?>
<!-- Js Head -->
<?php if (!$func->isGoogleSpeed()){ ?>
	<?=$func->decodeHtmlChars($setting['headjs']) ?>
<?php } ?>