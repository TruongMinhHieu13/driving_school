<?php
if ($act == "add") $labelAct = "Thêm mới";
else if ($act == "edit") $labelAct = chinhsua;
else if ($act == "copy")  $labelAct = "Sao chép";

$linkMan = "index.php?com=student&act=man";
if ($act == 'add') $linkFilter = "index.php?com=student&act=add";
else if ($act == 'edit') $linkFilter = "index.php?com=student&act=edit" . "&id=" . $id;
$linkSave = "index.php?com=student&act=save";

/* Hạng GPLX */
$gplx = $d->rawQuery("select id, namevi, age from #_gplx where id <> 0 and find_in_set('hienthi',status) order by id asc");

$colLeft = "col-12";
$colRight = "d-none";

$flashGPLX = $flash->get('HANG_GPLX');
$flashNS = $flash->get('NGAY_SINH');
if (!empty(@$item['HANG_GPLX'])) {
    $gplxNH = $d->rawQueryOne("select id, namevi, age from #_gplx where id = '" . $item['HANG_GPLX'] . "' limit 1");
    $age = 'P' . $gplxNH['age'] . 'Y';
} else {
    if (!empty($flashGPLX) && $flashGPLX > 0) {
        $gplxNH = $d->rawQueryOne("select id, namevi, age from #_gplx where id = '" . $flashGPLX . "' limit 1");
        $age = 'P' . $gplxNH['age'] . 'Y';
    } else {
        $age = 'P' . $gplx[0]['age'] . 'Y';
    }
}

/* Lấy ngày 18 tuổi*/
$today = new DateTime();
$interval = new DateInterval($age);
$today->sub($interval);
$timestamp = $today->getTimestamp();
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="<?= dashboard ?>"><?= dashboard ?></a></li>
                <li class="breadcrumb-item active"><?= $labelAct ?> <?= $config['news'][$type]['title_main'] ?></li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <form class="validation-form" novalidate method="post" action="<?= $linkSave ?>" enctype="multipart/form-data">
        <div class="card-footer text-sm sticky-top">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-check" disabled><i class="far fa-save mr-2"></i><?= luu ?></button>
            <button type="submit" class="btn btn-sm bg-gradient-success submit-check" name="save-here" disabled><i class="far fa-save mr-2"></i><?= luutaitrang ?></button>
            <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i><?= lamlai ?></button>
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="<?= thoat ?>"><i class="fas fa-sign-out-alt mr-2"></i><?= thoat ?></a>
        </div>

        <?= $flash->getMessages('admin'); ?>

        <div class="">
            <div class="title-page"><span>Thông tin học viên</span></div>

            <div class="box-content-page" id="page-qlhv">

                <div class="flex gplx-input qlhv-input">
                    <div class="title-gplx-input"> Hạng GPLX <span class="important-input">(*)</span></div>
                    <?php foreach ($gplx as $k => $v) { ?>
                        <input type="radio" id="gplx-<?= $v['id'] ?>" name="data[HANG_GPLX]" data-age="<?= $v['age'] ?>" value="<?= $v['id'] ?>" <?= (!empty($flashGPLX) && $flashGPLX == $v['id']) ? 'checked' : 
                                ((!empty($item['HANG_GPLX']) && $item['HANG_GPLX'] == $v['id']) ? 'checked' : ($k == 0 ? 'checked' : '')) 
                            ?>>
                        <label for="gplx-<?= $v['id'] ?>"><?= $v['namevi'] ?></label><br>
                    <?php } ?>
                </div>

                <div class="flex gplx-input qlhv-input">
                    <div class="title-gplx-input"> Số thứ tự</div>
                    <input type="number" class="form-control form-control-mini d-inline-block align-middle text-sm" min="0" name="data[numb]" id="numb" placeholder="<?= sothutu ?>" value="<?= isset($item['numb']) ? $item['numb'] : 1 ?>">
                </div>

                <div class="row">
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="MA_DK">Mã học viên - Sở GTVT cấp</label>
                        <input type="text" class="form-control text-sm" name="data[MA_DK]" id="MA_DK" placeholder="Mã học viên - Sở GTVT cấp" value="<?= (!empty($flash->has('MA_DK'))) ? $flash->get('MA_DK') : @$item['MA_DK'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="HO_TEN_DEM">Họ tên đệm <span class="important-input">(*)</span></label>
                        <input type="text" class="form-control text-sm" name="dataStudent[HO_TEN_DEM]" id="HO_TEN_DEM" placeholder="Họ tên đệm  " value="<?= (!empty($flash->has('HO_TEN_DEM'))) ? $flash->get('HO_TEN_DEM') : @$dataStudent['HO_TEN_DEM'] ?>" required autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="TEN">Tên <span class="important-input">(*)</span></label>
                        <input type="text" class="form-control text-sm" name="dataStudent[TEN]" id="TEN" placeholder="Tên" value="<?= (!empty($flash->has('TEN'))) ? $flash->get('TEN') : @$dataStudent['TEN'] ?>" required autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="HO_VA_TEN">Họ và tên <span class="important-input">(*)</span></label>
                        <input type="text" class="form-control text-sm" name="data[HO_VA_TEN]" id="HO_VA_TEN" placeholder="Họ và tên " value="<?= (!empty($flash->has('HO_VA_TEN'))) ? $flash->get('HO_VA_TEN') : @$item['HO_VA_TEN'] ?>" required autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <div class="d-flex justify-content-between align-items-center">
                            <label for="NGAY_SINH">Ngày sinh <span class="important-input">(*)</span></label>
                        </div>
                        <input type="date" class="form-control text-sm" name="dataStudent[NGAY_SINH]" id="NGAY_SINH" placeholder="Ngày sinh " value="<?= (!empty($flashNS)) ? $flashNS : (!empty(@$dataStudent['NGAY_SINH']) ? date('Y-m-d', @$dataStudent['NGAY_SINH']) : '') ?>" max="<?= date('Y-m-d', $timestamp) ?>" required>
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="MA_QUOC_TICH">Mã quốc tịch</label>
                        <input type="text" class="form-control text-sm" name="dataStudent[MA_QUOC_TICH]" id="MA_QUOC_TICH" placeholder="Mã quốc tịch" value="<?= (!empty($flash->has('MA_QUOC_TICH'))) ? $flash->get('MA_QUOC_TICH') : @$dataStudent['MA_QUOC_TICH'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="TEN_QUOC_TICH">Tên quốc tịch</label>
                        <input type="text" class="form-control text-sm" name="dataStudent[TEN_QUOC_TICH]" id="TEN_QUOC_TICH" placeholder="Tên quốc tịch" value="<?= (!empty($flash->has('TEN_QUOC_TICH'))) ? $flash->get('TEN_QUOC_TICH') : @$dataStudent['TEN_QUOC_TICH'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-6 col-lg-6 col-md-12 col-sm-12 mb-6">
                        <label for="NOI_TT">Nơi thường trú</label>
                        <input type="text" class="form-control text-sm" name="dataStudent[NOI_TT]" id="NOI_TT" placeholder="Nơi thường trú" value="<?= (!empty($flash->has('NOI_TT'))) ? $flash->get('NOI_TT') : @$dataStudent['NOI_TT'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-6 col-lg-6 col-md-12 col-sm-12 mb-6">
                        <label for="NOI_CT">Nơi cư trú</label>
                        <input type="text" class="form-control text-sm" name="dataStudent[NOI_CT]" id="NOI_CT" placeholder="Nơi cư trú" value="<?= (!empty($flash->has('NOI_CT'))) ? $flash->get('NOI_CT') : @$dataStudent['NOI_CT'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="SO_CMT">Số CMND/CCCD/Hộ Chiếu <span class="important-input">(*)</span></label>
                        <input type="text" class="form-control text-sm" name="data[SO_CMT]" id="SO_CMT" placeholder="Số CMND/CCCD/Hộ Chiếu" value="<?= (!empty($flash->has('SO_CMT'))) ? $flash->get('SO_CMT') : @$item['SO_CMT'] ?>" required autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="NGAY_CAP_CMT">Ngày cấp CMND/CCCD/Hộ Chiếu</label>
                        <input type="date" class="form-control text-sm" name="dataStudent[NGAY_CAP_CMT]" id="NGAY_CAP_CMT" placeholder="Ngày cấp CMND/CCCD/Hộ Chiếu" max="<?= date('Y-m-d') ?>" value="<?= (!empty($flash->has('NGAY_CAP_CMT'))) ? $flash->get('NGAY_CAP_CMT') : (!empty(@$dataStudent['NGAY_CAP_CMT']) ? date('Y-m-d', @$dataStudent['NGAY_CAP_CMT']) : '') ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="NOI_CAP_CMT">Nơi cấp CMND/CCCD/Hộ Chiếu</label>
                        <input type="text" class="form-control text-sm" name="dataStudent[NOI_CAP_CMT]" id="NOI_CAP_CMT" placeholder="Nơi cấp CMND/CCCD/Hộ Chiếu" value="<?= (!empty($flash->has('NOI_CAP_CMT'))) ? $flash->get('NOI_CAP_CMT') : @$dataStudent['NOI_CAP_CMT'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="GIOI_TINH">Giới tính <span class="important-input">(*)</span></label>
                        <input type="text" class="form-control text-sm" name="dataStudent[GIOI_TINH]" id="GIOI_TINH" placeholder="Giới tính" value="<?= (!empty($flash->has('GIOI_TINH'))) ? $flash->get('GIOI_TINH') : @$dataStudent['GIOI_TINH'] ?>" required autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="HO_VA_TEN_IN">Họ và tên In Hoa <span class="important-input">(*)</span></label>
                        <input type="text" class="form-control text-sm" name="dataStudent[HO_VA_TEN_IN]" id="HO_VA_TEN_IN" placeholder="Họ và tên In Hoa" value="<?= (!empty($flash->has('HO_VA_TEN_IN'))) ? $flash->get('HO_VA_TEN_IN') : @$dataStudent['HO_VA_TEN_IN'] ?>" required autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="SO_CMND_CU">Số CMND cũ</label>
                        <input type="text" class="form-control text-sm" name="dataStudent[SO_CMND_CU]" id="SO_CMND_CU" placeholder="Số CMND cũ" value="<?= (!empty($flash->has('SO_CMND_CU'))) ? $flash->get('SO_CMND_CU') : @$dataStudent['SO_CMND_CU'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="SO_GPLX_DA_CO">Số GPLX đã có </label>
                        <input type="text" class="form-control text-sm" name="dataStudent[SO_GPLX_DA_CO]" id="SO_GPLX_DA_CO" placeholder="Số GPLX đã có " value="<?= (!empty($flash->has('SO_GPLX_DA_CO'))) ? $flash->get('SO_GPLX_DA_CO') : @$dataStudent['SO_GPLX_DA_CO'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="HANG_GPLX_DA_CO">Hạng GPLX đã có </label>
                        <input type="text" class="form-control text-sm" name="dataStudent[HANG_GPLX_DA_CO]" id="HANG_GPLX_DA_CO" placeholder="Hạng GPLX đã có " value="<?= (!empty($flash->has('HANG_GPLX_DA_CO'))) ? $flash->get('HANG_GPLX_DA_CO') : @$dataStudent['HANG_GPLX_DA_CO'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="DV_CAP_GPLX_DACO">Dịch vụ cấp GPLX đã có </label>
                        <input type="text" class="form-control text-sm" name="dataStudent[DV_CAP_GPLX_DACO]" id="DV_CAP_GPLX_DACO" placeholder="Dịch vụ cấp GPLX đã có  " value="<?= (!empty($flash->has('DV_CAP_GPLX_DACO'))) ? $flash->get('DV_CAP_GPLX_DACO') : @$dataStudent['DV_CAP_GPLX_DACO'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="TEN_DV_CAP_GPLX_DACO">Tên dịch vụ cấp GPLX đã có </label>
                        <input type="text" class="form-control text-sm" name="dataStudent[TEN_DV_CAP_GPLX_DACO]" id="TEN_DV_CAP_GPLX_DACO" placeholder="Tên dịch vụ cấp GPLX đã có  " value="<?= (!empty($flash->has('TEN_DV_CAP_GPLX_DACO'))) ? $flash->get('TEN_DV_CAP_GPLX_DACO') : @$dataStudent['TEN_DV_CAP_GPLX_DACO'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="NOI_CAP_GPLX_DACO">Nơi cấp GPLX đã có </label>
                        <input type="text" class="form-control text-sm" name="dataStudent[NOI_CAP_GPLX_DACO]" id="NOI_CAP_GPLX_DACO" placeholder="Nơi cấp GPLX đã có " value="<?= (!empty($flash->has('NOI_CAP_GPLX_DACO'))) ? $flash->get('NOI_CAP_GPLX_DACO') : @$dataStudent['NOI_CAP_GPLX_DACO'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="NGAY_CAP_GPLX_DACO">Ngày cấp GPLX đã có </label>
                        <input type="date" class="form-control text-sm" name="dataStudent[NGAY_CAP_GPLX_DACO]" id="NGAY_CAP_GPLX_DACO" placeholder="Ngày cấp GPLX đã có " value="<?= (!empty($flash->has('NGAY_CAP_GPLX_DACO'))) ? $flash->get('NGAY_CAP_GPLX_DACO') : (!empty(@$dataStudent['NGAY_CAP_GPLX_DACO']) ? date('Y-m-d', @$dataStudent['NGAY_CAP_GPLX_DACO']) : '') ?>" autocomplete="off" max="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="NGAY_HH_GPLX_DACO">Ngày HH GPLX đã có </label>
                        <input type="date" class="form-control text-sm" name="dataStudent[NGAY_HH_GPLX_DACO]" id="NGAY_HH_GPLX_DACO" placeholder="Ngày HH GPLX đã có " value="<?= (!empty($flash->has('NGAY_HH_GPLX_DACO'))) ? $flash->get('NGAY_HH_GPLX_DACO') : (!empty(@$dataStudent['NGAY_HH_GPLX_DACO']) ? date('Y-m-d', @$dataStudent['NGAY_HH_GPLX_DACO']) : '') ?>" autocomplete="off" max="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="NGAY_TT_GPLX_DACO">Ngày TT GPLX đã có </label>
                        <input type="date" class="form-control text-sm" name="dataStudent[NGAY_TT_GPLX_DACO]" id="NGAY_TT_GPLX_DACO" placeholder="Ngày TT GPLX đã có " value="<?= (!empty($flash->has('NGAY_TT_GPLX_DACO'))) ? $flash->get('NGAY_TT_GPLX_DACO') : (!empty(@$dataStudent['NGAY_TT_GPLX_DACO']) ? date('Y-m-d', @$dataStudent['NGAY_TT_GPLX_DACO']) : '') ?>" autocomplete="off" max="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="NAM_HOC_LAIXE">Năm học lái xe </label>
                        <input type="number" class="form-control text-sm" name="dataStudent[NAM_HOC_LAIXE]" id="NAM_HOC_LAIXE" placeholder="Năm học lái xe " value="<?= (!empty($flash->has('NAM_HOC_LAIXE'))) ? $flash->get('NAM_HOC_LAIXE') : @$dataStudent['NAM_HOC_LAIXE'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="SO_NAM_LAIXE">Số năm lái xe</label>
                        <input type="number" class="form-control text-sm" name="dataStudent[SO_NAM_LAIXE]" id="SO_NAM_LAIXE" placeholder="Số năm lái xe" value="<?= (!empty($flash->has('SO_NAM_LAIXE'))) ? $flash->get('SO_NAM_LAIXE') : @$dataStudent['SO_NAM_LAIXE'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="SO_KM_ANTOAN">Số km an toàn </label>
                        <input type="number" class="form-control text-sm" name="dataStudent[SO_KM_ANTOAN]" id="SO_KM_ANTOAN" placeholder="Số km an toàn " value="<?= (!empty($flash->has('SO_KM_ANTOAN'))) ? $flash->get('SO_KM_ANTOAN') : @$dataStudent['SO_KM_ANTOAN'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="GIAY_CNSK">Giấy chứng nhận sức khỏe </label>
                        <input type="text" class="form-control text-sm" name="dataStudent[GIAY_CNSK]" id="GIAY_CNSK" placeholder="Giấy chứng nhận sức khỏe " value="<?= (!empty($flash->has('GIAY_CNSK'))) ? $flash->get('GIAY_CNSK') : @$dataStudent['GIAY_CNSK'] ?>" autocomplete="off">
                    </div>

                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="health_certificate">Ngày hết hạn giấy chứng nhận sức khỏe <span class="note note-danger check-certificate" data-tippy-content="Ngày hết hạn trước 15 ngày tính theo ngày hết hạn trên Giấy CNSK"><i class="fa-solid fa-circle-exclamation"></i></span> </label>
                        <input type="date" class="form-control text-sm" name="dataInternal[health_certificate]" id="health_certificate" placeholder="Ngày hết hạn sức khỏe" value="<?= (!empty($flash->has('health_certificate'))) ? $flash->get('health_certificate') : (!empty(@$infoStudent['health_certificate']) ? date('Y-m-d', @$infoStudent['health_certificate']) : '') ?>" autocomplete="off">
                    </div>

                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="phone_number">Số điện thoại </label>
                        <input type="number" class="form-control text-sm" name="dataInternal[phone_number]" id="phone_number" placeholder="Số điện thoại" value="<?= (!empty($flash->has('phone_number'))) ? $flash->get('phone_number') : @$infoStudent['phone_number'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="tuition_fee">Học phí </label>
                        <input type="text" class="form-control text-sm format-price" name="dataInternal[tuition_fee]" id="tuition_fee" placeholder="Học phí" value="<?= (!empty($flash->has('tuition_fee'))) ? $flash->get('tuition_fee') : @$infoStudent['tuition_fee'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="date_receipt">Ngày nhận hồ sơ </label>
                        <input type="date" class="form-control text-sm" name="dataInternal[date_receipt]" id="date_receipt" placeholder="Ngày nhận hồ sơ" max="<?= date('Y-m-d') ?>" value="<?= (!empty($flash->has('date_receipt'))) ? $flash->get('date_receipt') : (!empty(@$infoStudent['date_receipt']) ? date('Y-m-d', @$infoStudent['date_receipt']) : '') ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="email">Email học viên</label>
                        <input type="email" class="form-control text-sm" name="dataInternal[email]" id="email" placeholder="Email học viên" value="<?= (!empty($flash->has('email'))) ? $flash->get('email') : @$infoStudent['email'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group col-12 mb-6">
                        <label for="note">Ghi chú</label>
                        <textarea rows='5' class="form-control text-sm" name="dataInternal[note]" id="note" placeholder="Ghi chú"><?= (!empty($flash->has('note'))) ? $flash->get('note') : @$infoStudent['note'] ?></textarea>
                    </div>

                    <div class="form-group ol-xl-6 col-lg-6 col-md-12 col-sm-12 mb-6">
                        <div class="box-c-grade">
                            <div class="title-c-grade">DÀNH CHO NÂNG HẠNG C</div>
                            <div class="d-flex justify-content-between">
                                <label for="driving_seniority">Thâm niên lái xe</label>
                                <span class="note" data-tippy-content="Bạn phải nhập ngày cấp GPLX đã có"><i class="fa-solid fa-square-question"></i></span>
                            </div>
                            <input type="date" class="form-control text-sm" name="dataInternal[driving_seniority]" id="driving_seniority" placeholder="Thâm niên lái xe" value="<?= (!empty($flash->has('driving_seniority'))) ? $flash->get('driving_seniority') : (!empty(@$infoStudent['driving_seniority']) ? date('Y-m-d', @$infoStudent['driving_seniority']) : '') ?>" <?=($flashGPLX == 4 || $item['HANG_GPLX'] == 4 ? '' : 'readonly')?>>
                        </div>
                    </div>
                    <div class="form-group ol-xl-6 col-lg-6 col-md-12 col-sm-12 mb-6">
                        <div class="card-body avatar-student">
                            <label class="title-avatar-center" for="avatar_student">Upload hình ảnh </label>
                            <?php
                            /* Photo detail */
                            $photoDetail = array();
                            $photoDetail['upload'] = UPLOAD_STUDENT_L;
                            $photoAction = 'photo';
                            $photoDetail['image'] = (!empty($item)) ? $item['photo'] : '';
                            $photoDetail['dimension'] = "Width: 300px - Height: 400px (" . '.jpg|.gif|.png|.jpeg|.gif|.webp|.WEBP' . ") ";
                            ?>
                            <div class="photoUpload-zone">
                                <div class="photoUpload-detail mb-2" id="photoUpload-preview">
                                    <?php if (!empty($photoDetail['image'])) { ?>
                                        <a data-fancybox href="../<?= $photoDetail['upload'] ?><?= $photoDetail['image'] ?>"><?= $func->getImage(['class' => 'rounded', 'size-error' => '300x400x1', 'sizes' => '300x400x2', 'upload' => $photoDetail['upload'], 'image' => $photoDetail['image'], 'alt' => 'Alt Photo']) ?></a>
                                    <?php } else { ?>
                                        <?= $func->getImage(['class' => 'rounded', 'size-error' => '300x400x1', 'upload' => $photoDetail['upload'], 'image' => $photoDetail['image'], 'alt' => 'Alt Photo']) ?>
                                    <?php } ?>
                                </div>
                                <label id="photo-zone" for="file-zone">
                                    <div class="custom-file my-custom-file">
                                        <input type="file" class="custom-file-input" name="file" id="file-zone">
                                        <label class="custom-file-label mb-0" data-browse="Chọn" for="file_attach"><?= chonfile ?></label>
                                    </div>
                                </label>
                                <div class="photoUpload-dimension"><?= $photoDetail['dimension'] ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-sm">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-check" disabled><i class="far fa-save mr-2"></i><?= luu ?></button>
            <button type="submit" class="btn btn-sm bg-gradient-success submit-check" name="save-here" disabled><i class="far fa-save mr-2"></i><?= luutaitrang ?></button>
            <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i><?= lamlai ?></button>
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="<?= thoat ?>"><i class="fas fa-sign-out-alt mr-2"></i><?= thoat ?></a>
            <input type="hidden" name="id" value="<?= (isset($item['id']) && $item['id'] > 0) ? $item['id'] : '' ?>">
        </div>
    </form>
</section>