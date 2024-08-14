<?php
$linkView = $configBase;
$linkMan = $linkFilter = "index.php?com=history&act=man";
$linkDownload = $linkFilter = "?com=history&act=getFile";
if (!empty($fill)) $linkMan = $linkFilter = "index.php?com=history&act=man&fill=".$fill;
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="<?=dashboard?>"><?=dashboard?></a></li>
                <li class="breadcrumb-item active">Khoá học</li>
            </ol>
        </div>
    </div>
</section>
<!-- Main content -->
<section class="content">
    <div class="card card-warning card-outline text-sm ">
        <div class="card-header">
            <h3 class="card-title text-danger"><b>Lưu ý</b></h3>
        </div>
        <div class="card-body row">
            <b>Lịch sử lưu tối đa 90 ngày !!!!</b>
        </div>
    </div>
    <div class="card-footer text-sm sticky-top">
        <div class="form-inline form-search d-inline-block align-middle">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar text-sm" type="search" id="keyword" placeholder="<?=timkiem?>" aria-label="<?=timkiem?>" value="<?= (isset($_GET['keyword'])) ? $_GET['keyword'] : '' ?>" onkeypress="doEnter(event,'keyword','<?= $linkMan ?>')">
                <div class="input-group-append bg-primary rounded-right">
                    <button class="btn btn-navbar text-white" type="button" onclick="onSearch('keyword','<?= $linkMan ?>')">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="bar-action">
        <ul>
            <li class="<?=(!empty($fill) && $fill == 'man' ? 'act' : '')?>"> <a href="?com=history&act=man&fill=man">Tất cả</a></li>
            <li class="<?=(!empty($fill) && $fill == 'import' ? 'act' : '')?>"> <a href="?com=history&act=man&fill=import">Import</a></li>
            <li class="<?=(!empty($fill) && $fill == 'export' ? 'act' : '')?>"> <a href="?com=history&act=man&fill=export">Export</a></li>
        </ul>
    </div>
    <div class="card card-primary card-outline text-sm mb-0">
        <div class="card-header">
            <h3 class="card-title">Lịch sử thao tác</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover" style="min-width: 100%;">
                <thead>
                    <tr>
                        <th class="align-middle text-center" width="5%">STT</th>
                        <th class="align-middle">Trạng thái </th>
                        <th class="align-middle">Người tải</th>
                        <th class="align-middle">Kiểu dữ liệu</th>
                        <th class="align-middle">Ngày thao tác</th>
                        <th class="align-middle text-center">Số lượng học viên</th>
                        <th class="align-middle text-center">Thao tác</th>
                    </tr>
                </thead>
                <?php if (empty($items)) { ?>
                    <tbody>
                        <tr>
                            <td colspan="100" class="text-center"><?=khongcodulieu?></td>
                        </tr>
                    </tbody>
                <?php } else { ?>
                    <tbody>
                        <?php for ($i = 0; $i < count($items); $i++) { 
                            $datacar = json_decode($items[$i]['data_car'],true);
                        ?>
                            <tr>
                                <td class="align-middle text-center">
                                    <?=$i+1?>
                                </td>
                                <td class="align-middle">
                                    Đã tải <?= $items[$i]['downloads'] ?> lần
                                </td>
                                <td class="align-middle">
                                    <?= $func->getColDetail('username','user',$items[$i]['id_downloader']) ?>
                                </td>
                                <td class="align-middle">
                                    <?= $items[$i]['descvi'] ?>
                                </td>
                                <td class="align-middle ">
                                    <?= date('d-m-Y H:i:s',$items[$i]['date_created']) ?>
                                </td>
                                <td class="align-middle text-center text-md text-nowrap">
                                    <?= $items[$i]['quantity'] ?>
                                </td>
                                <td class="align-middle text-center text-md text-nowrap">
                                    <a href="<?=$linkDownload?>&id=<?=$items[$i]['id']?>" class="icon-download">
                                        <i class="fa-solid fa-download"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                <?php } ?>
            </table>
        </div>
    </div>
    <?php if ($paging) { ?>
        <div class="card-footer text-sm pb-0">
            <?= $paging ?>
        </div>
    <?php } ?>
</section>