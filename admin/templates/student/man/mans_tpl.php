<?php
$linkView = $configBase;
if ($act == 'getBC1') {
    $linkMan = $linkFilter = "index.php?com=student&act=getBC1";
} elseif($act == 'collect-graduation') {
    $linkMan = $linkFilter = "index.php?com=student&act=collect-graduation";
} else {
    $linkMan = $linkFilter = "index.php?com=student&act=man";
}
$linkAdd = "index.php?com=student&act=add";
$linkCopy = "index.php?com=student&act=copy";
$linkEdit = "index.php?com=student&act=edit";
$linkDelete = "index.php?com=student&act=delete";
$linkMulti = "index.php?com=student&act=man_photo&kind=man";
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

$linkPrint = "index.php?com=student&act=print".$validate_filter;

$fill = (!empty($_GET['fill']) ? $_GET['fill'] : '');

if (!empty($fill)) {
    $linkMan = $linkFilter .= "&fill=".$fill;
}

$none = "";
if($func->checkRole()) if ($func->checkPermission('student', 'filter', '', '', 'phrase-1')) $none = "d-none";
if ($act == 'getBC1') $none = "d-block";

/* Hạng GPLX */
$gplx = $d->rawQuery("select id, namevi, age from #_gplx where id <> 0 and find_in_set('hienthi',status) order by id asc");
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="<?= dashboard ?>"><?= dashboard ?></a></li>
                <li class="breadcrumb-item active">Học viên</li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <?php if ($com == "student" && $act == "man"){ ?>
        <div class="bar-action">
            <ul>
                <li class="<?=(!empty($fill) && $fill == 'man' ? 'act' : '')?>"> <a href="?com=student&act=man&fill=man">Tổng kho học viên</a></li>
                <li class="<?=(!empty($fill) && $fill == 'theory' ? 'act' : '')?>"> <a href="?com=student&act=man&fill=theory">Đậu Lý Thuyết</a></li>
                <li class="<?=(!empty($fill) && $fill == 'geometry' ? 'act' : '')?>"> <a href="?com=student&act=man&fill=geometry">Đậu Hình</a></li>
                <li class="<?=(!empty($fill) && $fill == 'cabin' ? 'act' : '')?>"> <a href="?com=student&act=man&fill=cabin">Đậu Cabin</a> </li>
                <li class="<?=(!empty($fill) && $fill == 'dat' ? 'act' : '')?>"> <a href="?com=student&act=man&fill=dat">Đậu DAT</a> </li>
                <li class="<?=(!empty($fill) && $fill == 'graduate' ? 'act' : '')?>"> <a href="?com=student&act=man&fill=graduate">Tốt Nghiệp</a> </li>
                <li class="<?=(!empty($fill) && $fill == 'KDDK' ? 'act' : '')?>"> <a href="?com=student&act=man&fill=KDDK">Không đủ ĐK thi SH</a> </li>
                <li class="<?=(!empty($fill) && $fill == 'failed-examination' ? 'act' : '')?>"> <a href="?com=student&act=man&fill=failed-examination">Rớt Sát Hạch</a> </li>
                <li class="<?=(!empty($fill) && $fill == 'pass-examination' ? 'act' : '')?>"> <a href="?com=student&act=man&fill=pass-examination">Đậu Sát Hạch</a> </li>
            </ul>
        </div>
    <?php } ?>
    <div class="card-footer text-sm sticky-top">
        <a class="btn btn-sm bg-gradient-primary text-white" href="<?= $linkAdd ?>" title="Thêm mới"><i class="fas fa-plus mr-2"></i><?= themmoi ?> học viên</a>
        <a class="btn btn-sm bg-gradient-danger text-white" id="delete-all" data-url="<?= $linkDelete ?><?= $strUrl ?>" title="<?= xoatatca ?>"><i class="far fa-trash-alt mr-2"></i><?= xoatatca ?></a>
    </div>
    <div class="card card-primary card-outline text-sm <?=$none?>">
        <div class="card-header">
            <h3 class="card-title"><b>Bộ lọc tìm kiếm</b></h3>
        </div>
        <div class="card-body row">
            <div class="form-group col-md-3 col-sm-3">
                <div class="input-group">
                    <input type="text" class="form-control float-right text-sm" placeholder="Khóa học" name="courses_id" id="courses_id" value="">
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
                    <input type="text" class="form-control float-right text-sm date_range" placeholder="Chọn từ - đến ngày khai giảng" name="date_open" id="date_open" value="<?= (isset($_GET['date_open'])) ? $_GET['date_open'] : '' ?>" readonly>
                </div>
            </div>
            <div class="form-group col-md-3 col-sm-3">
                <div class="input-group">
                    <input type="text" class="form-control float-right text-sm" placeholder="Tên học viên" name="student_name" id="student_name" value="<?= (isset($_GET['student_name'])) ? $_GET['student_name'] : '' ?>">
                </div>
            </div>
            <?php if($act != 'getBC1') { ?>
                <div class="form-group col-md-3 col-sm-3">
                    <div class="input-group">
                        <input type="text" class="form-control float-right text-sm" placeholder="Mã học viên" name="student_id" id="student_id" value="<?= (isset($_GET['student_id'])) ? $_GET['student_id'] : '' ?>">
                    </div>
                </div>
            <?php } ?>
            <div class="form-group col-md-3 col-sm-3">
                <div class="input-group">
                    <input type="text" class="form-control float-right text-sm" placeholder="CCCD/CMND" name="student_cmt" id="student_cmt" value="<?= (isset($_GET['student_cmt'])) ? $_GET['student_cmt'] : '' ?>">
                </div>
            </div>
            <div class="form-group col-md-3 col-sm-3">
                <div class="input-group">
                    <input type="text" class="form-control float-right text-sm date_range" placeholder="Chọn từ - đến ngày bế giảng" name="date_close" id="date_close" value="<?= (isset($_GET['date_close'])) ? $_GET['date_close'] : '' ?>" readonly>
                </div>
            </div>
            <?php (!empty($_GET['graduate-status']) ? $statusGraduate = $_GET['graduate-status'] : $statusGraduate = 0);  ?>
            <div class="form-group col-md-3 col-sm-3">
                <div class="input-group">
                    <select name="graduate_status" id="graduate_status" class="select2 form-control text-sm">
                        <option value="0">Tình trạng tốt nghiệp (Chưa - Đậu)</option>
                        <option value="1" <?=(!empty($statusGraduate) && $statusGraduate == 1) ? 'selected' : ''?>>Đậu</option>
                        <option value="2" <?=(!empty($statusGraduate) && $statusGraduate == 2) ? 'selected' : ''?>>Chưa</option>
                    </select>
                </div>
            </div>
            <div class="form-group col-md-3 col-sm-3">
                <div class="input-group">
                    <select name="test_status" id="test_status" class="form-control text-sm">
                        <option value="0">Tình trạng sát hạch(Đậu-Rớt-KĐĐK thi) </option>
                        <option value="1" <?=(!empty($statusTest) && $statusTest == 1) ? 'selected' : ''?>>Đậu</option>
                        <option value="2" <?=(!empty($statusTest) && $statusTest == 2) ? 'selected' : ''?>>Rớt</option>
                        <option value="3" <?=(!empty($statusTest) && $statusTest == 3) ? 'selected' : ''?>>KĐĐK</option>
                    </select>
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
                <?php if ($com == 'student' && $act == 'man'): ?>
                    <a class="btn btn-sm bg-gradient-warning text-dark ml-1" onclick="printStudent('<?= $linkFilter ?>')" title="Print"><i class="fa-solid fa-print mr-1"></i>In</a>
                <?php endif ?>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <div class="title-box text-sm font-weight-normal mb-2"><b>Import file XML</b></div>
                        <form method="post" action="<?= $linkImportXML ?>" enctype="multipart/form-data">
                            <div class="flex-input-file">
                                <div class="form-group mb-0">
                                    <div class="custom-file my-custom-file">
                                        <input type="file" class="custom-file-input ex-im-input" name="file-xml" id="file-xml">
                                        <label class="custom-file-label mb-0 custom-upload-file" for="file-xml"><?= chonfile ?></label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-sm bg-gradient-success ex-im-btn" name="importExcel">Import</button>
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
                        <div class="title-box text-sm font-weight-normal mb-2"><b>Export file Excel <a href="<?=UPLOAD_FILE?>File-Mau-HocVien.xlsx" class="link-file-example" name="exportExcel">File mẫu</a></b></div>
                         <a href="<?=$linkExportExcel?>" class="btn btn-sm bg-gradient-success flex-shrink-0 w-100" name="exportExcel"><i class="fas fa-upload mr-2"></i>Export file Excel</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="search-result">
                <div class="box-result">
                    <?php if (!empty($dataResult['courses-id'])) { ?>
                        <div class="title-result">Khoá học</div>
                        <?php foreach ($dataResult['courses-id'] as $k => $name) { ?>
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
                    <?php if (!empty($dataResult['student-name'])) { ?>
                        <div class="title-result">Tên học viên</div>
                        <?php foreach ($dataResult['student-name'] as $k => $name) { ?>
                            <p class="result-btn" data-result="<?= $name ?>" data-category="student_name"><?= $name ?> <span class="cancle-btn">x</span></p>
                        <?php }
                    } ?>
                </div>

                <div class="box-result">
                    <?php if (!empty($dataResult['student-id'])) { ?>
                        <div class="title-result">Mã học viên</div>
                        <?php foreach ($dataResult['student-id'] as $k => $name) { ?>
                            <p class="result-btn" data-result="<?= $name ?>" data-category="student_id"><?= $name ?> <span class="cancle-btn">x</span></p>
                        <?php }
                    } ?>
                </div>

                <div class="box-result">
                    <?php if (!empty($dataResult['student-cmt'])) { ?>
                        <div class="title-result">CMT/HC</div>
                        <?php foreach ($dataResult['student-cmt'] as $k => $name) { ?>
                            <p class="result-btn" data-result="<?= $name ?>" data-category="student_cmt"><?= $name ?> <span class="cancle-btn">x</span></p>
                        <?php }
                    } ?>
                </div>
            </div>
        </div>

        <?php if ($com == 'student' && $act == 'man'){ ?>
<<<<<<< HEAD
            <div class="col-12 d-flex justify-content-between">
                <p class="w-25"><b>Tổng số học viên</b>: <span class="font-weight-bold text-danger"><?=(!empty($countAll)) ? $countAll['num'] : 0?></p>
                <div class=" w-25 d-flex justify-content-end">
                    <p class="mr-2"><b>Tổng tiền</b>: <span class="font-weight-bold text-danger format-price"><?=(!empty($fee) ? $fee : 0)?></span></p>
                    <p><b>Số học viên</b>: <span class="font-weight-bold text-danger"><?=(!empty($count)) ? $count['num'] : 0?></p>
                </div>
=======
            <div class="d-flex justify-content-end col-12">
                <p class="mr-2"><b>Tổng tiền</b>: <span class="font-weight-bold text-danger format-price"><?=(!empty($fee) ? $fee : 0)?></span></p>
                <p><b>Tổng số học viên</b>: <span class="font-weight-bold text-danger"><?=(!empty($count)) ? $count['num'] : 0?></p>
>>>>>>> 9b29925d519b88e424a6ac27d59f4ea93f3cff3f
            </div>
        <?php } ?>
    </div>

    <div class="card card-primary card-outline text-sm mb-0">
        <div class="card-header">
            <h3 class="card-title"><b><?= danhsach ?> học viên</b></h3>
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
                        <th class="align-middle text-center" width="3%">STT</th>
                        <th class="align-middle">Mã học viên</th>
                        <th class="align-middle">Họ tên</th>
                        <th class="align-middle">CCCD/HC</th>
                        <th class="align-middle">Ngày sinh</th>
                        <th class="align-middle">Mã khóa học</th>
                        <th class="align-middle">Tên khóa học </th>
                        <th class="align-middle">Hạng xe</th>
                        <th class="align-middle">Ngày CNSK</th>
                        <th class="align-middle">Thâm niên lái</th>
                        <?php if($act != 'getBC1') { ?>
                            <th class="align-middle">Học phí</th>
                        <?php } ?>
                        <th class="align-middle"><?= thaotac ?></th>
                    </tr>
                </thead>
                <?php if (empty($items)) { ?>
                    <tbody>
                        <tr>
                            <td colspan="100" class="text-center"><?= khongcodulieu ?></td>
                        </tr>
                    </tbody>
                <?php } else { ?>
                    <tbody>
                        <?php for ($i = 0; $i < count($items); $i++) {
                            $dataStudent = json_decode($items[$i]['data_student'], true);
                            $infoStudent = json_decode($items[$i]['infor_student'], true);
                            ?>
                            <tr>
                                <td class="align-middle">
                                    <div class="custom-control custom-checkbox my-checkbox">
                                        <input type="checkbox" class="custom-control-input select-checkbox" id="select-checkbox-<?= $items[$i]['id'] ?>" value="<?= $items[$i]['id'] ?>">
                                        <label for="select-checkbox-<?= $items[$i]['id'] ?>" class="custom-control-label"></label>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <input type="number" class="form-control form-control-mini m-auto update-numb" min="0" value="<?= $items[$i]['numb'] ?>" data-id="<?= $items[$i]['id'] ?>" data-table="student">
                                </td>
                                <td class="align-middle">
                                    <?= $items[$i]['MA_DK'] ?>
                                </td>
                                <td class="align-middle">
                                    <?= $items[$i]['HO_VA_TEN'] ?>
                                </td>
                                <td class="align-middle">
                                    <?= $items[$i]['SO_CMT'] ?>
                                </td>
                                <td class="align-middle">
                                    <?= (!empty($dataStudent['NGAY_SINH']) ? date('Y-m-d', $dataStudent['NGAY_SINH']) : '') ?>
                                </td>
                                <td class="align-middle">
                                    <?= $items[$i]['MA_KHOA_HOC'] ?>
                                </td>
                                <td class="align-middle">
                                    <?php $nameCourses = $d->rawQueryOne("select `TEN_KHOA_HOC` from #_courses where MA_KHOA_HOC = '" . $items[$i]['MA_KHOA_HOC'] . "' limit 0,1");
                                    ?>
                                    <?= $nameCourses['TEN_KHOA_HOC'] ?>
                                </td>
                                <td class="align-middle">
                                    <?= $func->getColDetail('namevi', 'gplx', $items[$i]['HANG_GPLX']) ?>
                                </td>
                                <td class="align-middle">
                                    <?= (!empty($infoStudent['health_certificate']) ? date('Y-m-d', $infoStudent['health_certificate']) : '') ?>
                                </td>
                                <td class="align-middle">
                                    <?=(!empty( $infoStudent['driving_seniority'] ) ?  date('Y-m-d', $infoStudent['driving_seniority']) : '') ?>
                                </td>
                                <?php if($act != 'getBC1') { ?>
                                    <td class="align-middle" style="width: 10%;">
                                        <input data-id="<?= $items[$i]['id'] ?>" type="text" class="form-control text-sm format-price tuition-fee tuition-fee-<?= $items[$i]['id'] ?>" value="<?=(!empty($infoStudent['tuition_fee']) ? $infoStudent['tuition_fee'] : 0)?>">
                                    </td>
                                <?php } ?>
                                <td class="align-middle text-center text-md text-nowrap">
                                    <a class="text-primary mr-2" href="<?= $linkEdit ?><?= $linkID ?>&id=<?= $items[$i]['id'] ?>" title="<?= chinhsua ?>"><i class="fas fa-edit"></i></a>
                                    <a class="text-danger" id="delete-item" data-url="<?= $linkDelete ?><?= $linkID ?>&id=<?= $items[$i]['id'] ?>" title="Xóa"><i class="fas fa-trash-alt"></i></a>
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
        <a class="btn btn-sm bg-gradient-primary text-white" href="<?= $linkAdd ?>" title="Thêm mới"><i class="fas fa-plus mr-2"></i><?= themmoi ?></a>
        <a class="btn btn-sm bg-gradient-danger text-white" id="delete-all" data-url="<?= $linkDelete ?><?= $strUrl ?>" title="<?= xoatatca ?>"><i class="far fa-trash-alt mr-2"></i><?= xoatatca ?></a>
    </div>
</section>