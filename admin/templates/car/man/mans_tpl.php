<?php
$linkView = $configBase;
$linkMan = $linkFilter = "index.php?com=car&act=man";
$linkAdd = "index.php?com=car&act=add";
$linkCopy = "index.php?com=car&act=copy";
$linkEdit = "index.php?com=car&act=edit";
$linkDelete = "index.php?com=car&act=delete";
$linkMulti = "index.php?com=car&act=man_photo&kind=man";
$copyImg = (isset($config['student'][$type]['copy_image']) && $config['student'][$type]['copy_image'] == true) ? TRUE : FALSE;

$linkImportExcel = "index.php?com=import&act=uploadExcelCar";
$linkImportXML = "index.php?com=import&act=uploadXMLCAR";
$validate_filter = '';
foreach($_GET as $k => $v){
    if ($k == 'com' || $k == 'act') {
        $validate_filter .= '';
    } else {
        $validate_filter .= '&'.$k.'='.$v;
    }
}
$linkExportExcel = "index.php?com=export&act=exportExcelCar".$validate_filter;
$linkExportXML = "index.php?com=export&act=exportXMLCar".$validate_filter;

$none = "";
if($func->checkRole()) if ($func->checkPermission('car', 'filter', '', '', 'phrase-1')) $none = "d-none";


/* Hạng GPLX */
$gplx = $d->rawQuery("select id, namevi, age from #_gplx where id <> 0 and find_in_set('hienthi',status) order by id asc");
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
    <div class="card card-primary card-outline text-sm <?=$none?>">
        <div class="card-header">
            <h3 class="card-title"><b>Bộ lọc tìm kiếm</b></h3>
        </div>
        <div class="card-body row">
            <div class="form-group col-md-3 col-sm-3">
                <div class="input-group">
                    <input type="text" class="form-control float-right text-sm" placeholder="Mã khóa học" name="courses_id" id="courses_id" value="">
                </div>
            </div>
            <div class="form-group col-md-3 col-sm-3">
                <div class="input-group">
                    <input type="text" class="form-control float-right text-sm" placeholder="Tên khóa học" name="courses_name" id="courses_name" value="<?= (isset($_GET['courses_name'])) ? $_GET['courses_name'] : '' ?>">
                </div>
            </div>
            <div class="form-group col-md-3 col-sm-3">
                <div class="input-group">
                    <input type="text" class="form-control float-right text-sm" placeholder="Mã ID xe ( Biển số xe )" name="car_id" id="car_id" value="<?= (isset($_GET['car_id'])) ? $_GET['car_id'] : '' ?>">
                </div>
            </div>
            <div class="form-group col-md-3 col-sm-3">
                <div class="input-group">
                    <input type="text" class="form-control float-right text-sm" placeholder="Loại xe" name="car_loai" id="car_loai" value="<?= (isset($_GET['car_loai'])) ? $_GET['car_loai'] : '' ?>">
                </div>
            </div>
            <div class="form-group col-md-3 col-sm-3">
                <a class="btn btn-sm bg-gradient-primary text-white" onclick="searchMultiple('<?= $linkFilter ?>')" title="<?= timkiem ?>"><i class="fas fa-search mr-1"></i><?= timkiem ?></a>
                <a class="btn btn-sm bg-gradient-success text-white ml-1" href="<?= $linkMan ?>" title="Refresh"><i class="fas fa-times mr-1"></i><?= huyloc ?></a>
            </div>
            <div class="col-12">
                <div class="row">
            <div class="col-md-3 col-sm-3">
                <div class="title-box text-sm font-weight-normal mb-2"><b>Import file XML</b></div>
                <form method="post" action="<?= $linkImportXML ?>" enctype="multipart/form-data">
                    <div class="flex-input-file">
                        <div class="form-group">
                            <div class="custom-file my-custom-file">
                                <input type="file" class="custom-file-input" name="file-xml" id="file-xml">
                                <label class="custom-file-label custom-upload-file" for="file-xml"><?= chonfile ?></label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm bg-gradient-success" name="importExcel">Import</button>
                    </div>
                </form>
            </div>
            <div class="col-md-3 col-sm-3">
                <div class="title-box text-sm font-weight-normal mb-2"><b>Import file Excel</b></div>
                <form method="post" action="<?= $linkImportExcel ?>" enctype="multipart/form-data">
                    <div class="flex-input-file">
                        <div class="form-group">
                            <div class="custom-file my-custom-file">
                                <input type="file" class="custom-file-input" name="file-excel" id="file-excel">
                                <label class="custom-file-label custom-upload-file" for="file-excel"><?= chonfile ?></label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm bg-gradient-success" name="importExcel">Import</button>
                    </div>
                </form>
            </div>
            <div class="col-md-3 col-sm-3">
                <div class="title-box text-sm font-weight-normal mb-2"><b>Export file XML</b> </div>
                <form method="post" action="<?= $linkUploadExcel ?>" enctype="multipart/form-data">
                    <a href="<?=$linkExportXML?>" class="btn btn-sm bg-gradient-success flex-shrink-0 w-100" name="exportExcel"><i class="fas fa-upload mr-2"></i>Export file XML</a>
                </form>
            </div>
            <div class="col-md-3 col-sm-3">
                <div class="title-box text-sm font-weight-normal mb-2"><b>Export file Excel <a href="<?=UPLOAD_FILE?>File-Mau-Xe.xlsx" class="link-file-example" name="exportExcel">File mẫu</a></b></div>
                    <a href="<?=$linkExportExcel?>" class="btn btn-sm bg-gradient-success flex-shrink-0 w-100" name="exportExcel"><i class="fas fa-upload mr-2"></i>Export file Excel</a>
            </div>
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="search-result">
                <div class="box-result">
                    <?php if (!empty($dataResult['car_id'])) { ?>
                        <div class="title-result">Mã ID Xe</div>
                        <?php foreach ($dataResult['car_id'] as $k => $name) { ?>
                            <p class="result-btn" data-result="<?= $name ?>" data-category="car_id"><?= $name ?> <span class="cancle-btn">x</span></p>
                    <?php }
                    } ?>
                </div>
                <div class="box-result">
                    <?php if (!empty($dataResult['courses_id'])) { ?>
                        <div class="title-result">Khoá học</div>
                        <?php foreach ($dataResult['courses_id'] as $k => $name) { ?>
                            <p class="result-btn" data-result="<?= $name ?>" data-category="courses_id"><?= $name ?> <span class="cancle-btn">x</span></p>
                        <?php }
                    } ?>
                </div>
                <div class="box-result">
                    <?php if (!empty($dataResult['courses-name'])) { ?>
                        <div class="title-result">Tên khoá học</div>
                        <?php foreach ($dataResult['courses-name'] as $k => $name) { ?>
                            <p class="result-btn" data-result="<?= $name ?>" data-category="courses_name"><?= $name ?> <span class="cancle-btn">x</span></p>
                        <?php }
                    } ?>
                </div>
                <div class="box-result">
                    <?php if (!empty($dataResult['car_loai'])) { ?>
                        <div class="title-result">Loại xe</div>
                        <?php foreach ($dataResult['car_loai'] as $k => $name) { ?>
                            <p class="result-btn" data-result="<?= $name ?>" data-category="car_loai"><?= $name ?> <span class="cancle-btn">x</span></p>
                    <?php }
                    } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-sm sticky-top">
        <a class="btn btn-sm bg-gradient-primary text-white" href="<?= $linkAdd ?>" title="Thêm mới"><i class="fas fa-plus mr-2"></i><?=themmoi?></a>
        <a class="btn btn-sm bg-gradient-danger text-white" id="delete-all" data-url="<?= $linkDelete ?><?= $strUrl ?>" title="<?=xoatatca?>"><i class="far fa-trash-alt mr-2"></i><?=xoatatca?></a>
        
    </div>
    <div class="card card-primary card-outline text-sm mb-0">
        <div class="card-header">
            <h3 class="card-title"><?=danhsach?> xe</h3>
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
                        <th class="align-middle text-center" width="5%">STT</th>
                        <th class="align-middle">Mã ID xe </th>
                        <th class="align-middle">Biển số xe</th>
                        <th class="align-middle">Loại xe</th>
                        <th class="align-middle">Thuộc sở hữu</th>
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
                            $datacar = json_decode($items[$i]['data_car'],true);
                        ?>
                            <tr>
                                <td class="align-middle">
                                    <div class="custom-control custom-checkbox my-checkbox">
                                        <input type="checkbox" class="custom-control-input select-checkbox" id="select-checkbox-<?= $items[$i]['id'] ?>" value="<?= $items[$i]['id'] ?>">
                                        <label for="select-checkbox-<?= $items[$i]['id'] ?>" class="custom-control-label"></label>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <input type="number" class="form-control form-control-mini m-auto update-numb" min="0" value="<?= $items[$i]['numb'] ?>" data-id="<?= $items[$i]['id'] ?>" data-table="car">
                                </td>
                                <td class="align-middle">
                                    <?= $items[$i]['id_xe'] ?>
                                </td>
                                <td class="align-middle">
                                    <?= $items[$i]['biensoxe'] ?>
                                </td>
                                <td class="align-middle">
                                    <?= $items[$i]['loaixe'] ?>
                                </td>
                                <td class="align-middle">
                                    <?= $items[$i]['chuxe'] ?>
                                </td>
                                <td class="align-middle text-center text-md text-nowrap">
                                    <a class="text-primary mr-2" href="<?= $linkEdit ?>&id=<?= $items[$i]['id'] ?>" title="<?=chinhsua?>"><i class="fas fa-edit"></i></a>
                                    <a class="text-danger" id="delete-item" data-url="<?= $linkDelete ?>&id=<?= $items[$i]['id'] ?>" title="Xóa"><i class="fas fa-trash-alt"></i></a>
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