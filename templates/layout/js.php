<!-- Js Config -->
<script type="text/javascript">
    var NN_FRAMEWORK = NN_FRAMEWORK || {};
    var CONFIG_BASE = '<?= $configBase ?>';
    var SOURCE = '<?= $source ?>';
    var ASSET = '<?= ASSET ?>';
    var WEBSITE_NAME = '<?= (!empty($setting['name' . $lang])) ? addslashes($setting['name' . $lang]) : '' ?>';
    var TIMENOW = '<?= date("d/m/Y", time()) ?>';
    var RECAPTCHA_ACTIVE = <?= (!empty($config['googleAPI']['recaptcha']['active'])) ? 'true' : 'false' ?>;
    var RECAPTCHA_SITEKEY = '<?= $config['googleAPI']['recaptcha']['sitekey'] ?>';
    var GOTOP = ASSET + 'assets/images/top.png';
    var LANG = {
        'back_to_home': '<?= vetrangchu ?>',
        'thongbao': '<?= thongbao ?>',
        'dongy': '<?= dongy ?>',
        'dungluonghinhanhlon': '<?= dungluonghinhanhlon ?>',
        'dulieukhonghople': '<?= dulieukhonghople ?>',
        'dangcapnhatdulieu': '<?= dangcapnhatdulieu ?>',
    };
    var logo_img='<?=$configBase?><?= UPLOAD_PHOTO_L . $logo['photo'] ?>';
</script>
<!-- Js Files -->

<?php
$js->set("js/jquery.min.js");
$js->set("js/lazyload.min.js");
$js->set("bootstrap/bootstrap.js");
if ($source != 'index') {
    $js->set("toc/toc.js");
}
$js->set("fancybox5/fancybox.umd.js");
$js->set("slick/slick.js");
$js->set("js/functions.js");
$js->set("simplenotify/simple-notify.js");
$js->set("menu-mobile/menu-mobile.js");
$js->set("countup/countUp.js");
$js->set("countup/noframework.waypoints.min.js");
$js->set("js/apps.js");
echo $js->get();
?>
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>
<script src="https://accounts.google.com/gsi/client" async defer></script>

<?php if ($com == 'index' || $com == 'lien-he' ) { if (!$func->isRecaptchaSkip()) {
    if (!empty($config['googleAPI']['recaptcha']['active'])) { ?>
        <!-- Js Google Recaptcha V3 -->
        <script src="https://www.google.com/recaptcha/api.js?render=<?= $config['googleAPI']['recaptcha']['sitekey'] ?>">
        </script>
    <?php } }
} ?>
<!-- Js Addons && Js Structdata -->
<?php if (!$func->isGoogleSpeed()){ ?>
    <?php include TEMPLATE . LAYOUT . "strucdata.php"; ?>
    <?= $addons->set('script-main', 'script-main', 2); ?>
    <?= $addons->get(); ?>
<?php } ?>

<!-- Js Body -->
<?php if (!$func->isGoogleSpeed()){ ?>
    <?=$func->decodeHtmlChars($setting['bodyjs'])?>
<?php } ?>
