<?php
include "config.php";

/* Paginations */
include LIBRARIES . "class/class.PaginationsAjax.php";
$pagingAjax = new PaginationsAjax();
$pagingAjax->perpage = (!empty($_GET['perpage'])) ? htmlspecialchars($_GET['perpage']) : 1;
$eShow = htmlspecialchars($_GET['eShow']);
$idList = (!empty($_GET['idList'])) ? htmlspecialchars($_GET['idList']) : 0;
$idCat = (isset($_GET['idCat']) && $_GET['idCat'] > 0) ? htmlspecialchars($_GET['idCat']) : 0;
$p = (!empty($_GET['p'])) ? htmlspecialchars($_GET['p']) : 1;
$start = ($p - 1) * $pagingAjax->perpage;
$pageLink = "api/product.php?perpage=" . $pagingAjax->perpage;
$tempLink = "";
$where = "";
$params = array();

/* Math url */
if ($idList > 0) {
    $tempLink .= "&idList=" . $idList;
    $where .= " and id_list = ?";
    array_push($params, $idList);
}
if ($idCat > 0) {
    $tempLink .= "&idCat=" . $idCat;
    $where .= " and id_cat = ?";
    array_push($params, $idCat);
}
$tempLink .= "&p=";
$pageLink .= $tempLink;



/* Get data */
$sql = "select name$lang, slugvi, slugen, id, photo, regular_price, sale_price, discount from #_product where type='dich-vu' $where and find_in_set('noibat',status) and find_in_set('hienthi',status) order by numb,id desc";
$sqlCache = $sql . " limit $start, $pagingAjax->perpage";
$items = $d->rawQuery($sqlCache, $params);

/* Count all data */
$countItems = count($cache->get($sql, $params, 'result', 7200));

/* Get page result */
$pagingItems = $pagingAjax->getAllPageLinks($countItems, $pageLink, $eShow);
?>
<?php if ($countItems) { ?>
    <div class="grid-products">
        <?= $func->getProducts($items) ?>
    </div>
    <div class="pagination-ajax"><?= $pagingItems ?></div>
<?php } ?>