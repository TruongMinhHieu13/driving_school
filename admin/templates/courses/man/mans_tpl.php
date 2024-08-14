<?php
$linkView = $configBase;
$linkMan = $linkFilter = "index.php?com=courses&act=man";
$linkAdd = "index.php?com=courses&act=add";
$linkCopy = "index.php?com=courses&act=copy";
$linkEdit = "index.php?com=courses&act=edit";
$linkDelete = "index.php?com=courses&act=delete";
$linkMulti = "index.php?com=courses&act=man_photo&kind=man";
$copyImg = (isset($config['student'][$type]['copy_image']) && $config['student'][$type]['copy_image'] == true) ? TRUE : FALSE;

$none = "";
if($func->checkRole()) if ($func->checkPermission('courses', 'filter', '', '', 'phrase-1')) $none = "d-none";

/* Hạng GPLX */
$gplx = $d->rawQuery("select id, namevi, age from #_gplx where id <> 0 and find_in_set('hienthi',status) order by id asc");

$linkImportXML = "index.php?com=import&act=uploadXMLBC1";
$linkImportExcel = "index.php?com=import&act=uploadExcelBC1";

$validate_filter = '';
foreach($_GET as $k => $v){
    if ($k == 'com' || $k == 'act') {
        $validate_filter .= '';
    } else {
        $validate_filter .= '&'.$k.'='.$v;
    }
}

if ($act == 'getBC1') {
    $linkExportExcel = "index.php?com=export&act=exportExcel&student-id=0".$validate_filter;
    $linkExportXML = "index.php?com=export&act=exportXMLBC1&student-id=0".$validate_filter;
} else {
    $linkExportExcel = "index.php?com=export&act=exportExcel".$validate_filter;
    $linkExportXML = "index.php?com=export&act=exportXMLBC1".$validate_filter;
}

$fill = (!empty($_GET['fill']) ? $_GET['fill'] : '');

if (!empty($fill)) {
    $linkMan = $linkFilter .= "&fill=".$fill;
}
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
    <div class="card card-primary card-outline text-sm <?=$none?> d-none">
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
                <div class="input-group w-100 select-w-100">
                    <select name="array_gplx[]" id="gplx" class="select multiselect-gplx" multiple="multiple">
                        <?php foreach ($gplx as $v) { ?>
                            <option class="opt-<?= $v['id'] ?>" <?= (!empty($arrayGPLX) ? (in_array($v['id'], $arrayGPLX) ? 'selected' : '') : '') ?> value="<?= $v['id'] ?>"><?= $v['namevi'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group col-md-3 col-sm-3">
                <div class="input-group">
                    <input type="text" class="form-control float-right text-sm" placeholder="Số quyết định khai giảng" name="code_open" id="code_open" value="<?= (isset($_GET['code_open'])) ? $_GET['code_open'] : '' ?>">
                </div>
            </div>
            <div class="form-group col-md-3 col-sm-3">
                <div class="input-group">
                    <input type="text" class="form-control float-right text-sm date_range" placeholder="Chọn từ - đến ngày khai giảng" name="date_open" id="date_open" value="<?= (isset($_GET['date_open'])) ? $_GET['date_open'] : '' ?>" readonly>
                </div>
            </div>
            <div class="form-group col-md-3 col-sm-3">
                <div class="input-group">
                    <input type="text" class="form-control float-right text-sm date_range" placeholder="Chọn từ - đến ngày bế giảng" name="date_close" id="date_close" value="<?= (isset($_GET['date_close'])) ? $_GET['date_close'] : '' ?>" readonly>
                </div>
            </div>
            <div class="form-group col-md-3 col-sm-3">
                <div class="input-group">
                    <input type="text" class="form-control float-right text-sm date_range" placeholder="Chọn từ ngày đến ngày Thi SH" name="date_sh" id="date_sh" value="<?= (isset($_GET['date_sh'])) ? $_GET['date_sh'] : '' ?>" readonly>
                </div>
            </div>
            <div class="form-group col-md-3 col-sm-3">
                <a class="btn btn-sm bg-gradient-primary text-white" onclick="searchMultiple('<?= $linkFilter ?>')" title="<?= timkiem ?>"><i class="fas fa-search mr-1"></i><?= timkiem ?></a>
                <a class="btn btn-sm bg-gradient-success text-white ml-1" href="<?= $linkMan ?>" title="Refresh"><i class="fas fa-times mr-1"></i><?= huyloc ?></a>
            </div>
            <div class="col-12">
                <div class="row">
            <div class="col-md-3 col-sm-3">
                <div class="title-box text-sm font-weight-normal mb-2"><b>Import file XML (BC1)</b></div>
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
                <div class="title-box text-sm font-weight-normal mb-2"><b>Import file Excel (BC1)</b></div>
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
                <div class="title-box text-sm font-weight-normal mb-2"><b>Export file XML (BC1)</b> </div>
                <form method="post" action="<?= $linkUploadExcel ?>" enctype="multipart/form-data">
                    <a href="<?=$linkExportXML?>" class="btn btn-sm bg-gradient-success flex-shrink-0 w-100" name="exportExcel"><i class="fas fa-upload mr-2"></i>Export file XML</a>
                </form>
            </div>
            <div class="col-md-3 col-sm-3">
                <div class="title-box text-sm font-weight-normal mb-2"><b>Export file Excel (BC1)<a href="<?=UPLOAD_FILE?>file_example.xlsx" class="link-file-example" name="exportExcel">File mẫu</a></b></div>
                    <a href="<?=$linkExportExcel?>" class="btn btn-sm bg-gradient-success flex-shrink-0 w-100" name="exportExcel"><i class="fas fa-upload mr-2"></i>Export file Excel</a>
                </div>
            </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="search-result">
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
                    <?php if (!empty($arrayGPLX)) { ?>
                        <div class="title-result">Hạng GPLX</div>
                        <?php foreach ($arrayGPLX as $k => $name) { ?>
                            <p class="result-btn result-gplx"><?= $func->getColDetail('namevi', 'gplx', $name); ?> <span class="cancle-btn" data-id="<?= $name ?>">x</span></p>
                    <?php }
                    } ?>
                </div>
                <div class="box-result">
                    <?php if (!empty($dataResult['code-open'])) { ?>
                        <div class="title-result">Số QĐ Khai giảng</div>
                        <?php foreach ($dataResult['code-open'] as $k => $name) { ?>
                            <p class="result-btn" data-result="<?= $name ?>" data-category="code_open"><?= $name ?> <span class="cancle-btn">x</span></p>
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
            <h3 class="card-title"><?=danhsach?> khoá học</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-max-width">
                <thead>
                    <tr>
                        <th class="align-middle" width="5%">
                            <div class="custom-control custom-checkbox my-checkbox">
                                <input type="checkbox" class="custom-control-input" id="selectall-checkbox">
                                <label for="selectall-checkbox" class="custom-control-label"></label>
                            </div>
                        </th>
                        <th class="align-middle text-center" width="5%">STT</th>
                        <th class="align-middle">Mã khóa học</th>
                        <th class="align-middle">Tên khóa học</th>
                        <th class="align-middle">Hạng xe</th>
                        <th class="align-middle">Loại đào tạo</th>
                        <th class="align-middle">Số QĐ Khai Giảng</th>
                        <th class="align-middle">Ngày QĐ KG</th>
                        <th class="align-middle">Ngày KG</th>
                        <th class="align-middle">Ngày BG</th>
                        <th class="align-middle">Ngày SH</th>
                        <th class="align-middle">Tổng HV</th>
                        <th class="align-middle">Tổng GV</th>
                        <th class="align-middle">Tống Xe</th>
                        <th class="align-middle"><?=thaotac?></th>
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
                            $dataCourses = json_decode($items[$i]['data_courses'],true);
                        ?>
                            <tr>
                                <td class="align-middle">
                                    <div class="custom-control custom-checkbox my-checkbox">
                                        <input type="checkbox" class="custom-control-input select-checkbox" id="select-checkbox-<?= $items[$i]['id'] ?>" value="<?= $items[$i]['id'] ?>">
                                        <label for="select-checkbox-<?= $items[$i]['id'] ?>" class="custom-control-label"></label>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <input type="number" class="form-control form-control-mini m-auto update-numb" min="0" value="<?= $items[$i]['numb'] ?>" data-id="<?= $items[$i]['id'] ?>" data-table="courses">
                                </td>
                                <td class="align-middle">
                                    <a class="text-dark" href="<?= $linkEdit ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['MA_KHOA_HOC'] ?>"><?= $items[$i]['MA_KHOA_HOC'] ?></a>
                                </td>
                                <td class="align-middle">
                                    <a class="text-dark" href="<?= $linkEdit ?>&id=<?= $items[$i]['id'] ?>" title="<?=chinhsua?>"><?= $items[$i]['TEN_KHOA_HOC'] ?></a>
                                </td>
                                <td class="align-middle">
                                    <?=$func->getColDetail('namevi','gplx',$items[$i]['HANG_GPLX'])?>
                                </td>
                                <td class="align-middle">
                                    <?= $items[$i]['MA_HANG_DAO_TAO'] ?>
                                </td>
                                <td class="align-middle">
                                    <?= $items[$i]['SO_QD_KG'] ?>
                                </td>
                                <td class="align-middle">
                                   <?= (!empty($items[$i]['NGAY_QD_KG']) ? date('Y-m-d',$items[$i]['NGAY_QD_KG']) : '') ?>
                                </td>
                                <td class="align-middle">
                                    <?= (!empty($items[$i]['NGAY_KHAI_GIANG']) ? date('Y-m-d',$items[$i]['NGAY_KHAI_GIANG']) : '') ?>
                                </td>
                                <td class="align-middle">
                                    <?= (!empty($items[$i]['NGAY_BE_GIANG']) ? date('Y-m-d',$items[$i]['NGAY_BE_GIANG']) : '') ?>
                                </td>
                                <td class="align-middle">
                                    <?= (!empty($items[$i]['NGAY_SAT_HACH']) ? date('Y-m-d',$items[$i]['NGAY_SAT_HACH']) : '') ?>
                                </td>

                                <?php $countStudent = $d->rawQueryOne('select count(id) as quanlity from #_student where MA_KHOA_HOC = ? limit 1', array($items[$i]['MA_KHOA_HOC'])); ?>

                                <td class="align-middle">
                                    <?= $countStudent['quanlity']?>
                                </td>
                                <td class="align-middle">
                                    <?=count(json_decode($items[$i]['data_teacher']));?>
                                </td>

                                <td class="align-middle"> 
                                    <?=count(json_decode($items[$i]['data_car']));?>
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