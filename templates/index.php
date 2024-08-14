<!DOCTYPE html>
<html lang="<?= $config['website']['lang-doc'] ?>">

<head>
    <?php include TEMPLATE . LAYOUT . "head.php"; ?>
    <?php include TEMPLATE . LAYOUT . "css.php"; ?>
</head>

<body>
    <div class="wrap-full-page">
        <?php
        include TEMPLATE . LAYOUT . "seo.php";
        include TEMPLATE . LAYOUT . "header.php";
        include TEMPLATE . LAYOUT . "mmenu.php";
        if ($source == 'index') include TEMPLATE . LAYOUT . "slide.php";
        else include TEMPLATE . LAYOUT . "breadcrumb.php";
        ?>
        <div class="<?= ($source == 'index') ? 'wrap-home' : 'wrap-content padding-top-bottom' ?>">
            <?php include TEMPLATE . $template . "_tpl.php"; ?>
        </div>
        <?php
        include TEMPLATE . LAYOUT . "footer.php";
        include TEMPLATE . LAYOUT . "modal.php";
        include TEMPLATE . LAYOUT . "phone.php"; 
        include TEMPLATE . LAYOUT . "js.php";
        ?>
    </div>
</body>
</html>