<?php
$linkView = $configBase;
$linkMan = $linkFilter = "index.php?com=student&act=manGraduate&type=".$type;

$validate_filter = '';
foreach($_GET as $k => $v){
    if ($k == 'com' || $k == 'act') {
        $validate_filter .= '';
    } else {
        $validate_filter .= '&'.$k.'='.$v;
    }
}

$linkExportExcel = "index.php?com=export&act=exportExcel".$validate_filter;
$linkExportXML = "index.php?com=export&act=exportXMLBC1".$validate_filter;

$status = (!empty($_GET['status']) ? $_GET['status'] : '');

if (!empty($status)) {
    $linkMan = $linkFilter .= "&status=".$status;
}


if($type == "theory") $titleFill = 'Lý thuyết';
elseif($type == "theory") $titleFill = 'Hình';
elseif($type == "cabin") $titleFill = 'Cabin';
elseif($type == "dat") $titleFill = 'DAT';

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
<div class="bar-action">
        <ul class="justify-content-start">
            <li class="<?=(!empty($status) && $status == 'all' ? 'act' : '')?>"> <a href="index.php?com=student&act=manGraduate&type=<?=$type?>&status=all">Duyệt <?=$titleFill?></a></li>
            <li class="<?=(!empty($status) && $status == 'pass' ? 'act' : '')?>"> <a href="index.php?com=student&act=manGraduate&type=<?=$type?>&status=pass">Đã duyệt</a></li>
        </ul>
    </div>
<!-- Main content -->
<section class="content">
    <div class="card-footer text-sm sticky-top">
        <a class="btn btn-sm bg-gradient-primary text-white" href="<?= $linkAdd ?>" title="Thêm mới"><i class="fas fa-plus mr-2"></i><?= themmoi ?> học viên</a>
        <a class="btn btn-sm bg-gradient-danger text-white" id="delete-all" data-url="<?= $linkDelete ?><?= $strUrl ?>" title="<?= xoatatca ?>"><i class="far fa-trash-alt mr-2"></i><?= xoatatca ?></a>
    </div>
    
    <div class="card card-primary card-outline text-sm">
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
            <div class="form-group col-md-3 col-sm-3">
                <div class="input-group">
                    <select name="subject_status" id="subject_status" class="select2 form-control text-sm">
                        <option value="0">Tình trạng tốt nghiệp (Chưa - Đậu)</option>
                        <option value="1" <?=(!empty($subjectStatus) && $subjectStatus == 1) ? 'selected' : ''?>>Đậu</option>
                        <option value="2" <?=(!empty($subjectStatus) && $subjectStatus == 2) ? 'selected' : ''?>>Chưa</option>
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
                        <th class="align-middle">Duyệt</th>
                        <th class="align-middle text-center" style="width: 180px;">Nhập ngày TN Sở GTVT cấp</th>
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
                            $graduate= [];
                            $dataStudent = [];
                            $infoStudent = [];
                            if(!empty($items[$i]['data_student'])) $dataStudent = json_decode($items[$i]['data_student'], true);
                            if(!empty($items[$i]['infor_student'])) $infoStudent = json_decode($items[$i]['infor_student'], true);
                            if(!empty($items[$i]['graduate'])) $graduate = json_decode($items[$i]['graduate'], true);
                            ?>
                            <tr class="result-graduate-<?= $items[$i]['id'] ?>">
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
                                    <?=(!empty( $infoStudent['driving_seniority'] ) ? date('Y-m-d', $infoStudent['driving_seniority']) : '') ?>
                                </td>
                                <td class="align-middle d-flex align-items-start">
                                    <div class="btn-result-graduate <?=((!empty($graduate[$type]['point']) && $graduate[$type]['point'] > 0) ? 'dau' : 'chua')?>" data-point="<?=((!empty($graduate[$type]['point']) && $graduate[$type]['point'] > 0) ? '0' : '1')?>" data-type="<?=$type?>" data-id="<?= $items[$i]['id'] ?>">
                                        <?=((!empty($graduate[$type]['point']) && $graduate[$type]['point'] > 0) ? 'Đậu' : 'Chưa')?>
                                    </div>
                                    <?php if (!empty($graduate[$type]['point']) && $graduate[$type]['point'] > 0) { ?>
                                        
                                        <div class="note-graduate note" data-tippy-content="<?=$graduate[$type]['note']?>" >Ghi chú</div>
                                    <?php } ?>
                                </td>   

                                <td class="align-middle text-center text-md text-nowrap">
                                   <input type="date" class="form-control test-sm date-graduation" value="<?=(!empty($dataStudent['NGAY_RA_QDTN']) ? date('Y-m-d',$dataStudent['NGAY_RA_QDTN']) : 0)?>" id="date-graduation" data-id="<?= $items[$i]['id'] ?>" min="<?=date('Y-m-d')?>">
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