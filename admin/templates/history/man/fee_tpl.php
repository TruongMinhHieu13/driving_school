<?php
$linkView = $configBase;
$linkMan = $linkFilter = "index.php?com=history&act=fee";
$linkDownload = $linkFilter = "?com=history&act=getFile";
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
    <div class="card card-primary card-outline text-sm mb-0">
        <div class="card-header">
            <h3 class="card-title">Lịch sử thao tác</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover" style="min-width: 100%;">
                <thead>
                    <tr>
                        <th class="align-middle text-center" width="5%">STT</th>
                        <th class="align-middle">Người tải</th>
                        <th class="align-middle">Kiểu dữ liệu</th>
                        <th class="align-middle">Ngày thao tác</th>
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
                        ?>
                            <tr>
                                <td class="align-middle text-center">
                                    <?=$i+1?>
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
                            </tr>
                        <?php } ?>
                    </tbody>
                <?php } ?>
            </table>
        </div>
    </div>
    <?php if ($paging) { ?>
        <div class="card-footer text-sm pb-0 pb-2">
            <?= $paging ?>
        </div>
    <?php } ?>
</section>