<?php
if ($act == "add") $labelAct = "Thêm mới";
else if ($act == "edit") $labelAct = chinhsua;
else if ($act == "copy")  $labelAct = "Sao chép";

$linkMan = "index.php?com=car&act=man";
if ($act == 'add') $linkFilter = "index.php?com=car&act=add";
else if ($act == 'edit') $linkFilter = "index.php?com=car&act=edit" . "&id=" . $id;
$linkSave = "index.php?com=car&act=save";

$colLeft = "col-12";
$colRight = "d-none";

/* Hạng GPLX */
$gplx = $d->rawQuery("select id, namevi, age from #_gplx where id <> 0 and find_in_set('hienthi',status) order by id asc");


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

            <div class="box-content-page" id="page-car">

                <div class="flex gplx-input qlhv-input">
                    <div class="title-gplx-input"> Số thứ tự</div>
                    <input type="number" class="form-control form-control-mini d-inline-block align-middle text-sm" min="0" name="data[numb]" id="numb" placeholder="<?=sothutu?>" value="<?= isset($item['numb']) ? $item['numb'] : 1 ?>">
                </div>
                <div class="row">
                    <?php if ($act == 'edit'){ ?>
                        <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                            <label for="id_xe">ID xe <span class="important-input">(*)</span></label>
                            <input type="text" class="form-control text-sm" name="data[id_xe]" id="id_xe" placeholder="ID xe" value="<?= (!empty($flash->has('id_xe'))) ? $flash->get('id_xe') : @$item['id_xe'] ?>" readonly autocomplete="off">
                        </div>
                    <?php } ?>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="biensoxe">Biển số xe <span class="important-input">(*)</span></label>
                        <input type="text" class="form-control text-sm" name="data[biensoxe]" id="biensoxe" placeholder="Biển số xe" value="<?= (!empty($flash->has('biensoxe'))) ? $flash->get('biensoxe') : @$item['biensoxe'] ?>" required autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="hieuxe">Hiệu xe</label>
                        <input type="text" class="form-control text-sm" name="data[hieuxe]" id="hieuxe" placeholder="Hiệu xe" value="<?= (!empty($flash->has('hieuxe'))) ? $flash->get('hieuxe') : @$item['hieuxe'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="loaixe">Loại xe</label>
                        <input type="text" class="form-control text-sm" name="data[loaixe]" id="loaixe" placeholder="Loại xe" value="<?= (!empty($flash->has('loaixe'))) ? $flash->get('loaixe') : @$item['loaixe'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="socho">Số chỗ</label>
                        <input type="text" class="form-control text-sm" name="data[socho]" id="socho" placeholder="Số chỗ" value="<?= (!empty($flash->has('socho'))) ? $flash->get('socho') : @$item['socho'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="namsx">Năm sản xuất</label>
                        <input type="text" class="form-control text-sm" name="data[namsx]" id="namsx" placeholder="Năm sản xuất" value="<?= (!empty($flash->has('namsx'))) ? $flash->get('namsx') : @$item['namsx'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="mauson">Màu sơn</label>
                        <input type="text" class="form-control text-sm" name="data[mauson]" id="mauson" placeholder="Màu sơn" value="<?= (!empty($flash->has('mauson'))) ? $flash->get('mauson') : @$item['mauson'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="hang">Hạng</label>
                        <input type="text" class="form-control text-sm" name="data[hang]" id="hang" placeholder="Hạng" value="<?= (!empty($flash->has('hang'))) ? $flash->get('hang') : @$item['hang'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="shhd">SH/HĐ</label>
                        <input type="text" class="form-control text-sm" name="data[shhd]" id="shhd" placeholder="SH/HĐ" value="<?= (!empty($flash->has('shhd'))) ? $flash->get('shhd') : @$item['shhd'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="sokhung">Số khung</label>
                        <input type="text" class="form-control text-sm" name="data[sokhung]" id="sokhung" placeholder="Số khung" value="<?= (!empty($flash->has('sokhung'))) ? $flash->get('sokhung') : @$item['sokhung'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="somay">Số máy</label>
                        <input type="text" class="form-control text-sm" name="data[somay]" id="somay" placeholder="Số máy" value="<?= (!empty($flash->has('somay'))) ? $flash->get('somay') : @$item['somay'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="sogplx">Số GPLX</label>
                        <input type="text" class="form-control text-sm" name="data[sogplx]" id="sogplx" placeholder="Số GPLX" value="<?= (!empty($flash->has('sogplx'))) ? $flash->get('sogplx') : @$item['sogplx'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="ngaycapgplx">Ngày cấp GPLX</label>
                        <input type="date" class="form-control text-sm" name="data[ngaycapgplx]" id="ngaycapgplx" placeholder="Ngày cấp GPLX" value="<?= (!empty($flash->has('ngaycapgplx'))) ? $flash->get('ngaycapgplx') : ((!empty(@$item['ngaycapgplx']) ? date('Y-m-d',@$item['ngaycapgplx']) : '')) ?>" autocomplete="off" max="<?=date('Y-m-d')?>">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="hethan">Ngày hết hạn GPTL</label>
                        <input type="date" class="form-control text-sm" name="data[hethan]" id="hethan" placeholder="Ngày hết hạn GPTL" value="<?= (!empty($flash->has('hethan'))) ? $flash->get('hethan') : ((!empty(@$item['hethan']) ? date('Y-m-d',@$item['hethan']) : '')) ?>" autocomplete="off" max="<?=date('Y-m-d')?>">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="seridat">Số Seri DAT</label>
                        <input type="text" class="form-control text-sm" name="data[seridat]" id="seridat" placeholder="Số Seri DAT" value="<?= (!empty($flash->has('seridat'))) ? $flash->get('seridat') : @$item['seridat'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="imei1">IMEI 1</label>
                        <input type="text" class="form-control text-sm" name="data[imei1]" id="imei1" placeholder="IMEI 1" value="<?= (!empty($flash->has('imei1'))) ? $flash->get('imei1') : @$item['imei1'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="imei2">IMEI 2</label>
                        <input type="text" class="form-control text-sm" name="data[imei2]" id="imei2" placeholder="IMEI 2" value="<?= (!empty($flash->has('imei2'))) ? $flash->get('imei2') : @$item['imei2'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="chuxe">Chủ xe  (Thuộc sở hữu )</label>
                        <input type="text" class="form-control text-sm" name="data[chuxe]" id="chuxe" placeholder="Chủ xe" value="<?= (!empty($flash->has('chuxe'))) ? $flash->get('chuxe') : @$item['chuxe'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="sdt">SĐT</label>
                        <input type="phone" class="form-control text-sm" name="data[sdt]" id="sdt" placeholder="SĐT" value="<?= (!empty($flash->has('sdt'))) ? $flash->get('sdt') : @$item['sdt'] ?>" autocomplete="off">
                    </div>
                    <div class="form-group ol-xl-3 col-lg-3 col-md-4 col-sm-4 mb-6">
                        <label for="kiemdinh">Số GCN Kiểm định ATKT & BVMT</label>
                        <input type="phone" class="form-control text-sm" name="data[kiemdinh]" id="kiemdinh" placeholder="SĐT" value="<?= (!empty($flash->has('kiemdinh'))) ? $flash->get('kiemdinh') : @$item['kiemdinh'] ?>" autocomplete="off">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group ol-xl-6 col-lg-6 col-md-12 col-sm-12 mb-6">
                        <div class="">
                            <label class="" for="avatar_student">Upload hình ảnh </label>
                            <?php
                            /* Photo detail */
                            $photoDetail = array();
                            $photoDetail['upload'] = UPLOAD_STUDENT_L;
                            $photoAction = 'photo';
                            $photoDetail['image'] = (!empty($item)) ? $item['photo'] : '';
                            $photoDetail['dimension'] = "Width: 300px - Height: 400px (" . '.jpg|.gif|.png|.jpeg|.gif|.webp|.WEBP' . ") ";
                            ?>
                            <div class="photoUpload-zone">
                                <div class="photoUpload-detail mb-2 text-left" id="photoUpload-preview">
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
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-check" disabled><i class="far fa-save mr-2"></i><?=luu?></button>
            <button type="submit" class="btn btn-sm bg-gradient-success submit-check" name="save-here" disabled><i class="far fa-save mr-2"></i><?=luutaitrang?></button>
            <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i><?=lamlai?></button>
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="<?=thoat?>"><i class="fas fa-sign-out-alt mr-2"></i><?=thoat?></a>
            <input type="hidden" name="id" value="<?= (isset($item['id']) && $item['id'] > 0) ? $item['id'] : '' ?>">
        </div>
    </form>
</section>