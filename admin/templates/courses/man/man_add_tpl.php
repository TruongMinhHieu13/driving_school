<?php
if ($act == "add") $labelAct = "Thêm mới";
else if ($act == "edit") $labelAct = chinhsua;
else if ($act == "copy")  $labelAct = "Sao chép";

$linkMan = "index.php?com=courses&act=man";
if ($act == 'add') $linkFilter = "index.php?com=courses&act=add";
else if ($act == 'edit') $linkFilter = "index.php?com=courses&act=edit" . "&id=" . $id;
$linkSave = "index.php?com=courses&act=save";

$colLeft = "col-12";
$colRight = "d-none";

?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="<?=dashboard?>"><?=dashboard?></a></li>
                <li class="breadcrumb-item active"><?= $labelAct ?> Khoá học</li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <form class="validation-form" novalidate method="post" action="<?= $linkSave ?>" enctype="multipart/form-data">
        <div class="card-footer text-sm sticky-top">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-check" disabled><i class="far fa-save mr-2"></i><?=luu?></button>
            <button type="submit" class="btn btn-sm bg-gradient-success submit-check" name="save-here" disabled><i class="far fa-save mr-2"></i><?=luutaitrang?></button>
            <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i><?=lamlai?></button>
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="<?=thoat?>"><i class="fas fa-sign-out-alt mr-2"></i><?=thoat?></a>
        </div>

        <?= $flash->getMessages('admin') ; ?>

        <div class="">
            <div class="title-page"><span>Thông tin khoá học</span></div>

            <div class="box-content-page" id="page-courses">

                <div class="flex gplx-input qlhv-input">
                    <div class="title-gplx-input"> Số thứ tự</div>
                    <input type="number" class="form-control form-control-mini d-inline-block align-middle text-sm" min="0" name="data[numb]" id="numb" placeholder="<?=sothutu?>" value="<?= isset($item['numb']) ? $item['numb'] : 1 ?>">
                </div>

                <div class="row">
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="TEN_KHOA_HOC">Tên khóa học <span class="important-input">(*)</span></label>
                        <input type="text" class="form-control text-sm" name="data[TEN_KHOA_HOC]" id="TEN_KHOA_HOC" placeholder="Tên khóa học" value="<?= (!empty($flash->has('TEN_KHOA_HOC'))) ? $flash->get('TEN_KHOA_HOC') : @$item['TEN_KHOA_HOC'] ?>" required autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="MA_KHOA_HOC">Mã khóa học<span class="important-input">(*)</span></label>
                        <input type="text" class="form-control text-sm" name="data[MA_KHOA_HOC]" id="MA_KHOA_HOC" placeholder="Mã khóa học" value="<?= (!empty($flash->has('MA_KHOA_HOC'))) ? $flash->get('MA_KHOA_HOC') : @$item['MA_KHOA_HOC'] ?>" required autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="MA_BCI">Mã báo cáo 1</label>
                        <input type="text" class="form-control text-sm" name="dataCourses[MA_BCI]" id="MA_BCI" placeholder="Mã báo cáo 1" value="<?= (!empty($flash->has('MA_BCI'))) ? $flash->get('MA_BCI') : $dataCourses['MA_BCI'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="MA_SO_GTVT">Mã sở giao thông vận tải </label>
                        <input type="text" class="form-control text-sm" name="dataCourses[MA_SO_GTVT]" id="MA_SO_GTVT" placeholder="Mã sở giao thông vận tải " value="<?= (!empty($flash->has('MA_SO_GTVT'))) ? $flash->get('MA_SO_GTVT') : $dataCourses['MA_SO_GTVT'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="TEN_SO_GTVT">Tên sở giao thông vận tải </label>
                        <input type="text" class="form-control text-sm" name="dataCourses[TEN_SO_GTVT]" id="TEN_SO_GTVT" placeholder="Tên sở giao thông vận tải " value="<?= (!empty($flash->has('TEN_SO_GTVT'))) ? $flash->get('TEN_SO_GTVT') : $dataCourses['TEN_SO_GTVT'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="MA_CSDT">Mã cơ sở đào tạo</label>
                        <input type="text" class="form-control text-sm" name="dataCourses[MA_CSDT]" id="MA_CSDT" placeholder="Mã cơ sở đào tạo" value="<?= (!empty($flash->has('MA_CSDT'))) ? $flash->get('MA_CSDT') : $dataCourses['MA_CSDT'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="TEN_CSDT">Tên cơ sở đào tạo</label>
                        <input type="text" class="form-control text-sm" name="dataCourses[TEN_CSDT]" id="TEN_CSDT" placeholder="Tên cơ sở đào tạo" value="<?= (!empty($flash->has('TEN_CSDT'))) ? $flash->get('TEN_CSDT') : @$dataCourses['TEN_CSDT'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="MA_HANG_DAO_TAO">Mã hạng đào tạo <span class="important-input">(*)</span></label>
                        <input type="text" class="form-control text-sm" name="data[MA_HANG_DAO_TAO]" id="MA_HANG_DAO_TAO" placeholder="Mã hạng đào tạo" value="<?= (!empty($flash->has('MA_HANG_DAO_TAO'))) ? $flash->get('MA_HANG_DAO_TAO') : @$item['MA_HANG_DAO_TAO'] ?>" autocomplete="off" required>
                    </div>
                    <?php $flashGPLX = $flash->get('HANG_GPLX'); ?>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label class="d-block" for="HANG_GPLX">Hạng giấy phép lái xe <span class="important-input">(*)</span></label>
                        <select name="data[HANG_GPLX]" id="HANG_GPLX" class="edit-courses-gplx form-control text-sm <?=$act=='edit' ? 'readonly' : ''?>" required <?=$act=='edit' ? 'readonly' : ''?>>
                            <?php foreach($gplx as $v){ ?>
                                <option <?= (!empty($flashGPLX) && $flashGPLX == $v['id']) ? 'selected' : 
                                ((!empty($item['HANG_GPLX']) && $item['HANG_GPLX'] == $v['id']) ? 'selected' : '') 
                            ?> value="<?=$v['id']?>"><?=$v['namevi']?></option>
                            
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="SO_BCI">Số báo cáo 1</label>
                        <input type="text" class="form-control text-sm" name="dataCourses[SO_BCI]" id="SO_BCI" placeholder="Số báo cáo 1" value="<?= (!empty($flash->has('SO_BCI'))) ? $flash->get('SO_BCI') : @$dataCourses['SO_BCI'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="NGAY_BCI">Ngày báo cáo 1</label>
                        <input type="date" class="form-control text-sm" name="dataCourses[NGAY_BCI]" id="NGAY_BCI" placeholder="Ngày báo cáo 1" value="<?= (!empty($flash->has('NGAY_BCI'))) ? date('Y-m-d',$flash->get('NGAY_BCI')) : (!empty(@$dataCourses['NGAY_BCI']) ? date('Y-m-d',@$dataCourses['NGAY_BCI']) : '') ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="LUU_LUONG">Lưu lượng</label>
                        <input type="text" class="form-control text-sm" name="dataCourses[LUU_LUONG]" id="LUU_LUONG" placeholder="Lưu lượng" value="<?= (!empty($flash->has('LUU_LUONG'))) ? $flash->get('LUU_LUONG') : @$dataCourses['LUU_LUONG'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="SO_HOC_SINH">Số học sinh</label>
                        <input type="text" class="form-control text-sm" name="dataCourses[SO_HOC_SINH]" id="SO_HOC_SINH" placeholder="Số học sinh" value="<?= (!empty($flash->has('SO_HOC_SINH'))) ? $flash->get('SO_HOC_SINH') : @$dataCourses['SO_HOC_SINH'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="NGAY_KHAI_GIANG">Ngày khai giảng <span class="important-input">(*)</span></label>
                        <input type="date" class="form-control text-sm" name="data[NGAY_KHAI_GIANG]" id="NGAY_KHAI_GIANG" placeholder="Ngày khai giảng" value="<?= (!empty($flash->has('NGAY_KHAI_GIANG'))) ? date('Y-m-d',$flash->get('NGAY_KHAI_GIANG')) : (!empty(@$item['NGAY_KHAI_GIANG']) ? date('Y-m-d',@$item['NGAY_KHAI_GIANG']) : '') ?>" autocomplete="off" required>
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="NGAY_BE_GIANG">Ngày bế giảng <span class="important-input">(*)</span></label>
                        <input type="date" class="form-control text-sm" name="data[NGAY_BE_GIANG]" id="NGAY_BE_GIANG" placeholder="Ngày bế giảng" value="<?= (!empty($flash->has('NGAY_BE_GIANG'))) ? date('Y-m-d',$flash->get('NGAY_BE_GIANG')) : (!empty(@$item['NGAY_BE_GIANG']) ? date('Y-m-d',@$item['NGAY_BE_GIANG']) : '') ?>" autocomplete="off" required>
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="SO_QD_KG">Số quyết định khai giảng</label>
                        <input type="text" class="form-control text-sm" name="data[SO_QD_KG]" id="SO_QD_KG" placeholder="Số quyết định khai giảng" value="<?= (!empty($flash->has('SO_QD_KG'))) ? $flash->get('SO_QD_KG') : @$item['SO_QD_KG'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="NGAY_QD_KG">Ngày quyết định khai giảng</label>
                        <input type="date" class="form-control text-sm" name="dataCourses[NGAY_QD_KG]" id="NGAY_QD_KG" placeholder="Ngày quyết định khai giảng" value="<?= (!empty($flash->has('NGAY_QD_KG'))) ? date('Y-m-d',$flash->get('NGAY_QD_KG')) : (!empty(@$dataCourses['NGAY_QD_KG']) ? date('Y-m-d',@$dataCourses['NGAY_QD_KG']) : '') ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="NGAY_SAT_HACH">Ngày sát hạch</label>
                        <input type="date" class="form-control text-sm" name="data[NGAY_SAT_HACH]" id="NGAY_SAT_HACH" placeholder="Ngày sát hạch" value="<?= (!empty($flash->has('NGAY_SAT_HACH'))) ? date('Y-m-d',$flash->get('NGAY_SAT_HACH')) : (!empty(@$item['NGAY_SAT_HACH']) ? date('Y-m-d',@$item['NGAY_SAT_HACH']) : '') ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="THOI_GIAN_DT">Thời gian đào tạo</label>
                        <input type="text" class="form-control text-sm" name="dataCourses[THOI_GIAN_DT]" id="THOI_GIAN_DT" placeholder="Thời gian đào tạo" value="<?= (!empty($flash->has('THOI_GIAN_DT'))) ? $flash->get('THOI_GIAN_DT') : @$dataCourses['THOI_GIAN_DT'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-6 col-lg-6 col-md-12 col-sm-12 mb-6">
                        <label for="list-student" class="d-block">Chọn học viên cho khóa </label>
                        <div class="wrap-select-student">
                            <select name="list-student[]" id="list-student" data-course="<?=$id?>" class="select multiselect-notall form-control text-sm w-100" multiple="multiple">
                                <?php foreach($listStudent as $v) {?> 
                                    <option <?=(!empty($item) ? ($v['MA_KHOA_HOC'] == $item['MA_KHOA_HOC'] ? 'selected' : '') : '')?> value="<?=$v['id']?>"><?=$v['HO_VA_TEN']?> - <?=$v['SO_CMT']?></option>
                                <?php } ?> 
                            </select>
                        </div>
                        <div class="row row-show-student">
                            <?php if (!empty($studentOfCourses)){ ?>
                                <div class="form-group col-xl-12 mt-2">
                                    <div class="box-name-table">HỌC VIÊN ĐÃ CHỌN</div>
                                    <div class="show-table">
                                        <table class="table table-striped mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">STT</th>
                                                    <th scope="col">Họ và tên</th>
                                                    <th scope="col">Ngày sinh</th>
                                                    <th scope="col">CMT</th>
                                                    <th scope="col">Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($studentOfCourses as $k => $v) { 
                                                    $dataStudent = json_decode($v['data_student'],true);
                                                    ?>
                                                    <tr>
                                                        <th scope="row"><?=$k+1?></th>
                                                        <td><?=$v['HO_VA_TEN']?></td>
                                                        <td><?=date('Y-m-d',$dataStudent['NGAY_SINH'])?></td>
                                                        <td><?=$v['SO_CMT']?></td>
                                                        <td class="text-center">
                                                            <a class="text-danger" id="del-student" data-act="del-student" data-id="<?=$v['id']?>" title="Xóa"><i class="fas fa-trash-alt"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group ol-xl-6 col-lg-6 col-md-12 col-sm-12 mb-6">
                        <label for="list-teacher" class="d-block">Chọn giáo viên cho khóa </label>
                        <div class="wrap-select-student">
                            <select name="list-teacher[]" id="list-teacher" data-course="<?=$id?>" class="select multiselect-notall form-control text-sm w-100" multiple="multiple">
                                <?php foreach($listTeacher as $v) {?> 
                                    <option <?=(!empty($dataTeacher) && (in_array($v['id'],$dataTeacher)) ? 'selected' : '')?> value="<?=$v['id']?>"><?=$v['fullname']?> - <?=$v['id_code']?></option>
                                <?php } ?> 
                            </select>
                        </div>
                        <div class="row row-show-teacher" id-courses="<?=$item['id']?>">
                            <?php if (!empty($teacherOfCourses)){ ?>
                                <div class="form-group col-xl-12 mt-2">
                                    <div class="box-name-table">GIÁO VIÊN ĐÃ CHỌN</div>
                                    <div class="show-table">
                                        <table class="table table-striped mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">STT</th>
                                                    <th scope="col">Họ và tên</th>
                                                    <th scope="col">Ngày sinh</th>
                                                    <th scope="col">CMT</th>
                                                    <th scope="col">Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($teacherOfCourses as $k => $v) { 
                                                    ?>
                                                    <tr>
                                                        <th scope="row"><?=$k+1?></th>
                                                        <td><?=$v['fullname']?></td>
                                                        <td><?=date('Y-m-d',$v['birthday'])?></td>
                                                        <td><?=$v['cccd']?></td>
                                                        <td class="text-center">
                                                            <a class="text-danger" id="del-teacher" data-id="<?=$v['id']?>" title="Xóa"><i class="fas fa-trash-alt"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group ol-xl-6 col-lg-6 col-md-12 col-sm-12 mb-6">
                        <label for="list-car" class="d-block">Chọn xe cho khóa </label>
                        <div class="wrap-select-student">
                            <select name="list-car[]" id="list-car" data-course="<?=$id?>" class="select multiselect-notall form-control text-sm w-100" multiple="multiple">
                                <?php foreach($listCar as $v) {?> 
                                    <option <?=(!empty($dataCar) && (in_array($v['id'],$dataCar)) ? 'selected' : '')?> value="<?=$v['id']?>"><?=$v['biensoxe']?> - <?=$v['socho']?> - <?=$v['hang']?></option>
                                <?php } ?> 
                            </select>
                        </div>
                        <div class="row row-show-car" id-courses="<?=$item['id']?>">
                            <?php if (!empty($carOfCourses)){ ?>
                                <div class="form-group col-xl-12 mt-2">
                                    <div class="box-name-table">GIÁO VIÊN ĐÃ CHỌN</div>
                                    <div class="show-table">
                                        <table class="table table-striped mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">STT</th>
                                                    <th scope="col">Biển số xe</th>
                                                    <th scope="col">Hạng</th>
                                                    <th scope="col">Số chỗ</th>
                                                    <th scope="col">Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($carOfCourses as $k => $v) { 
                                                    ?>
                                                    <tr>
                                                        <th scope="row"><?=$k+1?></th>
                                                        <td><?=$v['biensoxe']?></td>
                                                        <td><?=$v['hang']?></td>
                                                        <td><?=$v['socho']?></td>
                                                        <td class="text-center">
                                                            <a class="text-danger" id="del-car" data-id="<?=$v['id']?>" title="Xóa"><i class="fas fa-trash-alt"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="card-footer text-sm">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-check" disabled><i class="far fa-save mr-2"></i><?=luu?></button>
            <button type="submit" class="btn btn-sm bg-gradient-success submit-check" name="save-here" disabled><i class="far fa-save mr-2"></i><?=luutaitrang?></button>
            <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i><?=lamlai?></button>
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="<?=thoat?>"><i class="fas fa-sign-out-alt mr-2"></i><?=thoat?></a>
            <input type="hidden" name="id" value="<?= (isset($item['id']) && $item['id'] > 0) ? $item['id'] : '' ?>">
        </div>
    </form>
</section>