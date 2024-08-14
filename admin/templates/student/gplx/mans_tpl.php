<?php
$linkView = $configBase;
$linkMan = $linkFilter = "index.php?com=student&act=gplx";
$linkAdd = "index.php?com=student&act=add-gplx";
$linkEdit = "index.php?com=student&act=edit-gplx";
$linkDelete = "index.php?com=student&act=delete-gplx";
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="<?=dashboard?>"><?=dashboard?></a></li>
                <li class="breadcrumb-item active">hạng GPLX</li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="card-footer text-sm sticky-top">
        <a class="btn btn-sm bg-gradient-primary text-white" href="<?= $linkAdd ?>" title="Thêm mới"><i class="fas fa-plus mr-2"></i><?=themmoi?></a>
        <a class="btn btn-sm bg-gradient-danger text-white" id="delete-all" data-url="<?= $linkDelete ?><?= $strUrl ?>" title="<?=xoatatca?>"><i class="far fa-trash-alt mr-2"></i><?=xoatatca?></a>
        <div class="form-inline form-search d-inline-block align-middle ml-3">
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
            <h3 class="card-title"><?=danhsach?> hạng GPLX</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover" style="min-width: 100%;">
                <thead>
                    <tr>
                        <th class="align-middle" width="5%">
                            <div class="custom-control custom-checkbox my-checkbox">
                                <input type="checkbox" class="custom-control-input" id="selectall-checkbox">
                                <label for="selectall-checkbox" class="custom-control-label"></label>
                            </div>
                        </th>
                        <th class="align-middle text-center" width="10%">STT</th>
                        <th class="align-middle" style="width:30%"><?=tieude?></th>
                        <th class="align-middle text-center">Hiển thị</th>
                        <th class="align-middle text-center"><?=thaotac?></th>
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
                            $linkID = "";?>
                            <tr>
                                <td class="align-middle">
                                    <div class="custom-control custom-checkbox my-checkbox">
                                        <?php if($items[$i]['id'] != 4) { ?>
                                            <input type="checkbox" class="custom-control-input select-checkbox" id="select-checkbox-<?= $items[$i]['id'] ?>" value="<?= $items[$i]['id'] ?>">
                                            <label for="select-checkbox-<?= $items[$i]['id'] ?>" class="custom-control-label"></label>
                                        <?php } else { ?>
                                            <span class="note note-danger" data-tippy-content="Bạn không được phép xoá hạng gplx này"><i class="fa-solid fa-circle-exclamation"></i></span>
                                        <?php } ?>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <input type="number" class="form-control form-control-mini m-auto" min="0" value="<?= $i  + 1?>">
                                </td>
                                <td class="align-middle">
                                    <a class="text-dark text-break" href="<?= $linkEdit ?><?= $linkID ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['namevi'] ?>"><?= $items[$i]['namevi'] ?></a>
                                    <div class="tool-action mt-2 w-clear">
                                        <a class="text-info mr-3" href="<?= $linkEdit ?><?= $linkID ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['namevi'] ?>"><i class="far fa-edit mr-1"></i>Edit</a>

                                        <?php if($items[$i]['id'] != 4 ) { ?> <a class="text-danger" id="delete-item" data-url="<?= $linkDelete ?><?= $linkID ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['namevi'] ?>"><i class="far fa-trash-alt mr-1"></i>Delete</a><?php } ?>
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="custom-control custom-checkbox my-checkbox">
                                        <input type="checkbox" class="custom-control-input show-checkbox" id="show-checkbox-hienthi-<?=$items[$i]['id']?>" data-table="gplx" data-id="<?=$items[$i]['id']?>" data-attr="hienthi" <?=(!empty($items[$i]['status']) ? 'checked' : '')?>>
                                        <label for="show-checkbox-<?= $key ?>-<?= $items[$i]['id'] ?>" class="custom-control-label"></label>
                                    </div>
                                </td>
                                <td class="align-middle text-center text-md text-nowrap">
                                    <a class="text-primary mr-2" href="<?= $linkEdit ?><?= $linkID ?>&id=<?= $items[$i]['id'] ?>" title="<?=chinhsua?>"><i class="fas fa-edit"></i></a>
                                    <?php if($items[$i]['id'] != 4 ) { ?>
                                        <a class="text-danger" id="delete-item" data-url="<?= $linkDelete ?><?= $linkID ?>&id=<?= $items[$i]['id'] ?>" title="Xóa"><i class="fas fa-trash-alt"></i></a>
                                    <?php } ?>
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
    <div class="card-footer text-sm">
        <a class="btn btn-sm bg-gradient-primary text-white" href="<?= $linkAdd ?>" title="Thêm mới"><i class="fas fa-plus mr-2"></i><?=themmoi?></a>
        <a class="btn btn-sm bg-gradient-danger text-white" id="delete-all" data-url="<?= $linkDelete ?><?= $strUrl ?>" title="<?=xoatatca?>"><i class="far fa-trash-alt mr-2"></i><?=xoatatca?></a>
    </div>
</section>