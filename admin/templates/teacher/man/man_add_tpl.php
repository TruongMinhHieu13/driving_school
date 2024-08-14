<?php
if ($act == "add") $labelAct = "Thêm mới";
else if ($act == "edit") $labelAct = chinhsua;
else if ($act == "copy")  $labelAct = "Sao chép";

$linkMan = "index.php?com=teacher&act=man";
$linkSave = "index.php?com=teacher&act=save";

$colLeft = "col-12";
$colRight = "d-none";

$dataCourses = json_decode($item['data_courses'],true);

/* Hạng GPLX */
$gplx = $d->rawQuery("select id, namevi, age from #_gplx where id <> 0 and find_in_set('hienthi',status) order by id asc");


?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="<?=dashboard?>"><?=dashboard?></a></li>
                <li class="breadcrumb-item active"><?= $labelAct ?> <?= $config['news'][$type]['title_main'] ?></li>
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
            <div class="title-page"><span>Thông tin giáo viên</span></div>

            <div class="box-content-page" id="page-courses">

                <div class="flex gplx-input qlhv-input">
                    <div class="title-gplx-input"> Số thứ tự</div>
                    <input type="number" class="form-control form-control-mini d-inline-block align-middle text-sm" min="0" name="data[numb]" id="numb" placeholder="<?=sothutu?>" value="<?= isset($item['numb']) ? $item['numb'] : 1 ?>">
                </div>

                <div class="row">
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="username">Tên đăng nhập <span class="important-input">(*)</span></label>
                        <input type="text" class="form-control text-sm" name="data[username]" id="username" placeholder="Tên đăng nhập" value="<?= (!empty($flash->has('username'))) ? $flash->get('username') : @$item['username'] ?>" required autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="password">Mật khẩu <span class="important-input">(*)</span></label>
                        <input type="password" class="form-control text-sm" name="data[password]" id="password" placeholder="Mật khẩu" value="<?= (!empty($flash->has('password'))) ? $flash->get('password') : '' ?>" <?= ($act == "add") ? 'required' : ''; ?> autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="id_code">ID Giáo viên <span class="important-input">(*)</span></label>
                        <input type="text" class="form-control text-sm" name="data[id_code]" id="id_code" placeholder="ID Giáo viên" value="<?= (!empty($flash->has('id_code'))) ? $flash->get('id_code') : @$item['id_code'] ?>" required autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="fullname">Họ và tên <span class="important-input">(*)</span></label>
                        <input type="text" class="form-control text-sm" name="data[fullname]" id="fullname" placeholder="Họ và tên" value="<?= (!empty($flash->has('fullname'))) ? $flash->get('fullname') : @$item['fullname'] ?>" required autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="birthday">Ngày sinh<span class="important-input">(*)</span></label>
                        <input type="date" class="form-control text-sm" name="data[birthday]" id="birthday" placeholder="Ngày sinh" value="<?= (!empty($flash->has('birthday'))) ? date("Y-m-d", $flash->get('birthday')) : ((!empty($item['birthday'])) ? date("Y-m-d", $item['birthday']) : '') ?>" required autocomplete="off" max="<?=date('Y-m-d')?>">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="phone">Số điện thoại</label>
                        <input type="number" class="form-control text-sm" name="data[phone]" id="phone" placeholder="Số điện thoại" value="<?= (!empty($flash->has('phone'))) ? $flash->get('phone') : $item['phone'] ?>" autocomplete="off">
                    </div>

                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="cccd">CCCD <span class="important-input">(*)</span></label>
                        <input type="number" class="form-control text-sm" name="data[cccd]" id="cccd" placeholder="CCCD" value="<?= (!empty($flash->has('cccd'))) ? $flash->get('cccd') : $item['cccd'] ?>" required autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="date-cccd">Ngày cấp CCCD</label>
                        <input type="date" class="form-control text-sm" name="data[date-cccd]" id="date-cccd" placeholder="Ngày cấp CCCD" value="<?= (!empty($flash->has('date-cccd'))) ? date("Y-m-d", $flash->get('date-cccd')) : ((!empty($item['date-cccd'])) ? date("Y-m-d", $item['date-cccd']) : '') ?>" max="<?=date('Y-m-d')?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="noicap">Nơi cấp</label>
                        <input type="text" class="form-control text-sm" name="data[noicap]" id="noicap" placeholder="Nơi cấp" value="<?= (!empty($flash->has('noicap'))) ? $flash->get('noicap') : $item['noicap'] ?>" autocomplete="off">
                    </div>

                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="address">Địa chỉ thường chú</label>
                        <input type="text" class="form-control text-sm" name="data[address]" id="address" placeholder="Địa chỉ thường chú" value="<?= (!empty($flash->has('address'))) ? $flash->get('address') : $item['address'] ?>" autocomplete="off">
                    </div>

                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="gender">Giới tính <span class="important-input">(*)</span></label>
                        <?php $flashGender = $flash->get('gender'); ?>
                        <select class="custom-select text-sm" name="data[gender]" id="gender" required>
                            <option value=""><?=chongioitinh?></option>
                            <option <?= (!empty($flashGender) && $flashGender == 1) ? 'selected' : ((@$item['gender'] == 1) ? 'selected' : '') ?> value="1"><?=nam?></option>
                            <option <?= (!empty($flashGender) && $flashGender == 2) ? 'selected' : ((@$item['gender'] == 2) ? 'selected' : '') ?> value="2"><?=nu?></option>
                        </select>                        
                    </div>

                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="congtac">Đơn vị công tác</label>
                        <input type="text" class="form-control text-sm" name="data[congtac]" id="congtac" placeholder="Đơn vị công tác" value="<?= (!empty($flash->has('congtac'))) ? $flash->get('congtac') : $item['congtac'] ?>" autocomplete="off">
                    </div>

                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="tuyendung">Hình thức tuyển dụng</label>
                        <?php $flashTD = $flash->get('tuyendung'); ?>
                        <select class="form-control text-sm" name="data[tuyendung]" id="tuyendung">
                            <option value="0">Chọn hình thức</option>
                            <option value="bienche" <?= (!empty($flashTD) && $flashTD == 'bienche') ? 'selected' : ((@$item['tuyendung'] == 'bienche') ? 'selected' : '') ?>>Biên chế</option>
                            <option value="hopdong" <?= (!empty($flashTD) && $flashTD == 'hopdong') ? 'selected' : ((@$item['tuyendung'] == 'hopdong') ? 'selected' : '') ?>>Hợp đồng</option>
                        </select>
                    </div>
                </div>
                <?php if(!empty($item['academic'])) $dataAcademic = json_decode($item['academic'],true);?>
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="box-academic">
                            <div class="title-box">TRÌNH ĐỘ</div>
                            <div class="row">
                                <div class="form-group ol-xl-6 col-lg-6 col-md-12 col-sm-12 mb-6">
                                    <label for="vanhoa">Văn hóa</label>
                                    <input type="text" class="form-control text-sm" name="dataAcademic[vanhoa]" id="vanhoa" placeholder="Văn hóa" value="<?= (!empty($flash->has('vanhoa'))) ? $flash->get('vanhoa') : $dataAcademic['vanhoa'] ?>" autocomplete="off">
                                </div>
                                <div class="form-group ol-xl-6 col-lg-6 col-md-12 col-sm-12 mb-6">
                                    <label for="supham">Sư phạm</label>
                                    <input type="text" class="form-control text-sm" name="dataAcademic[supham]" id="supham" placeholder="Sư phạm" value="<?= (!empty($flash->has('supham'))) ? $flash->get('supham') : $dataAcademic['supham'] ?>" autocomplete="off">
                                </div>
                                <div class="form-group ol-xl-6 col-lg-6 col-md-12 col-sm-12 mb-6">
                                    <label for="chuyenmon">Chuyên môn</label>
                                    <input type="text" class="form-control text-sm" name="dataAcademic[chuyenmon]" id="chuyenmon" placeholder="Chuyên môn" value="<?= (!empty($flash->has('chuyenmon'))) ? $flash->get('chuyenmon') : $dataAcademic['chuyenmon'] ?>" autocomplete="off">
                                </div>
                                <div class="form-group ol-xl-6 col-lg-6 col-md-12 col-sm-12 mb-6">
                                    <label for="anhvan">Anh văn</label>
                                    <input type="text" class="form-control text-sm" name="dataAcademic[anhvan]" id="anhvan" placeholder="Anh văn" value="<?= (!empty($flash->has('anhvan'))) ? $flash->get('anhvan') : $dataAcademic['anhvan'] ?>" autocomplete="off">
                                </div>
                                <div class="form-group ol-xl-6 col-lg-6 col-md-12 col-sm-12 mb-6">
                                    <label for="level">Level</label>
                                    <input type="text" class="form-control text-sm" name="dataAcademic[level]" id="level" placeholder="Level" value="<?= (!empty($flash->has('level'))) ? $flash->get('level') : $dataAcademic['level'] ?>" autocomplete="off">
                                </div>
                                <div class="form-group ol-xl-6 col-lg-6 col-md-12 col-sm-12 mb-6">
                                    <label for="tinhoc">Tin học</label>
                                    <input type="text" class="form-control text-sm" name="dataAcademic[tinhoc]" id="tinhoc" placeholder="Tin học" value="<?= (!empty($flash->has('tinhoc'))) ? $flash->get('tinhoc') : $dataAcademic['tinhoc'] ?>" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="box-academic mb-4">
                            <div class="title-box">GIẤP PHÉP LÁI XE</div>
                            <div class="row">
                                <div class="form-group ol-xl-6 col-lg-6 col-md-12 col-sm-12 mb-6">
                                    <label for="hanggplx">Hạng giấy phép lái xe</label>
                                    <input type="text" class="form-control text-sm" name="data[hanggplx]" id="hanggplx" placeholder="Hạng giấy phép lái xe" value="<?= (!empty($flash->has('hanggplx'))) ? $flash->get('hanggplx') : $item['hanggplx'] ?>" autocomplete="off">
                                </div>
                                <div class="form-group ol-xl-6 col-lg-6 col-md-12 col-sm-12 mb-6">
                                    <label for="ngaygplx">Ngày cấp</label>
                                    <input type="date" class="form-control text-sm" name="data[ngaygplx]" id="ngaygplx" placeholder="Ngày cấp" value="<?= (!empty($flash->has('ngaygplx'))) ? date("Y-m-d", $flash->get('ngaygplx')) : ((!empty($item['ngaygplx'])) ? date("Y-m-d", $item['ngaygplx']) : '') ?>" autocomplete="off" max="<?=date('Y-m-d')?>">
                                </div>
                            </div>
                        </div>

                        <div class="box-academic">
                            <div class="title-box">PHÂN CÔNG GIẢNG DẠY</div>
                            <div class="row">
                                <div class="form-group ol-xl-6 col-lg-6 col-md-12 col-sm-12 mb-6">
                                    <label for="vanhoa">Hạng xe dạy</label>
                                    <select name="data[hangxe]" id="hangxe" class="form-control text-sm" required>
                                        <option>Chọn hạng</option>
                                        <?php foreach($gplx as $v){ ?>
                                            <option <?=(!empty($flashGPLX) && $flashGPLX == $v['id'] ? 'selected' : (!empty($item['hangxe']) && $item['hangxe'] == $v['id']) ? 'selected' : '' )?> value="<?=$v['id']?>"><?=$v['namevi']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <?php if(!empty($item['chucnang'])) $functionGV = explode(',',$item['chucnang']);?>
                                <div class="form-group ol-xl-6 col-lg-6 col-md-12 col-sm-12 mb-6 select-w-100">
                                    <label for="supham">Chức năng</label>
                                    <select class="form-control text-sm multiselect-notall w-100" name="data[chucnang][]" id="supham" multiple="multiple">
                                        <option value="lythuyet" <?= (in_array("lythuyet",$functionGV) ? 'selected' : '')?> >Lý thuyết</option>
                                        <option value="hinh" <?= (in_array("hinh",$functionGV) ? 'selected' : '')?>>Hình</option>
                                        <option value="cabin" <?= (in_array("cabin",$functionGV) ? 'selected' : '')?>>Cabin</option>
                                        <option value="dat" <?= (in_array("dat",$functionGV) ? 'selected' : '')?>>DAT</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="form-group ol-xl-6 col-lg-6 col-md-12 col-sm-12 mb-6">
                        <label for="note">Ghi chú</label>
                        <textarea type="text" class="form-control text-sm" name="data[note]" id="note" placeholder="Ghi chú"  autocomplete="off" rows="5"><?= (!empty($flash->has('note'))) ? $flash->get('note') : $item['note'] ?></textarea>
                    </div> 
                </div>
                <div class="row">
                    <div class="form-group ol-xl-6 col-lg-6 col-md-12 col-sm-12 mb-6">
                        <div class="">
                            <label class="text-center" for="avatar_student">Upload hình ảnh </label>
                            <?php
                            /* Photo detail */
                            $photoDetail = array();
                            $photoDetail['upload'] = UPLOAD_USER_L;
                            $photoAction = 'avatar';
                            $photoDetail['avatar'] = (!empty($item)) ? $item['avatar'] : '';
                            $photoDetail['dimension'] = "Width: 300px - Height: 400px (" . '.jpg|.gif|.png|.jpeg|.gif|.webp|.WEBP' . ") ";
                            ?>
                            <div class="photoUpload-zone d-flex justify-content-left flex-wrap">
                                <div class="photoUpload-detail mb-2 w-100 text-left" id="photoUpload-preview">
                                    <?php if (!empty($photoDetail['avatar'])) { ?>
                                        <a data-fancybox href="../<?= $photoDetail['upload'] ?><?= $photoDetail['avatar'] ?>"><?= $func->getImage(['class' => 'rounded', 'size-error' => '300x400x1', 'sizes' => '300x400x2', 'upload' => $photoDetail['upload'], 'image' => $photoDetail['avatar'], 'alt' => 'Alt Photo']) ?></a>
                                    <?php } else { ?>
                                        <?= $func->getImage(['class' => 'rounded', 'size-error' => '300x400x1', 'upload' => $photoDetail['upload'], 'image' => $photoDetail['avatar'], 'alt' => 'Alt Photo']) ?>
                                    <?php } ?>
                                </div>
                                <label id="photo-zone" class="" for="file-zone">
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
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-check" disabled><i class="far fa-save mr-2"></i><?=luu?></button>
            <button type="submit" class="btn btn-sm bg-gradient-success submit-check" name="save-here" disabled><i class="far fa-save mr-2"></i><?=luutaitrang?></button>
            <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i><?=lamlai?></button>
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="<?=thoat?>"><i class="fas fa-sign-out-alt mr-2"></i><?=thoat?></a>
            <input type="hidden" name="id" value="<?= (isset($item['id']) && $item['id'] > 0) ? $item['id'] : '' ?>">
        </div>
    </form>
</section>