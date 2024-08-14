 <?php $type = ((int)($flash->get('type_account'))); ?>
<div class="row">
    <div class="col-md-6">
        <div class="content-ck">
            <?=htmlspecialchars_decode($optsetting['note-login'])?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="wrap-user ml-auto mw-100">
            <div class="title-user">
                <span class="fw-bold text-uppercase fs-5"><?=dangky?></span>
            </div>
            <form class="form-user validation-user" id="form-signup" novalidate method="post" action="<?=($type == 2 ? 'thanh-toan-hoc-vien' : 'account/dang-ky')?>" enctype="multipart/form-data">
                <?=$flash->getMessages("frontend")?>
                <label><?=hoten?></label>
                <div class="input-group input-user">
                    <input type="text" class="form-control text-sm" id="fullname" name="fullname" placeholder="<?=nhaphoten?>" value="<?=$flash->get('fullname')?>" required>
                    <div class="invalid-feedback"><?=vuilongnhaphoten?></div>
                </div>
                <label><?=taikhoan?></label>
                <div class="input-group input-user">
                    <input type="text" class="form-control text-sm" id="username" name="username" placeholder="<?=nhaptaikhoan?>" value="<?=$flash->get('username')?>" required>
                    <div class="invalid-feedback"><?=vuilongnhaptaikhoan?></div>
                </div>
                <label><?=matkhau?></label>
                <div class="input-group input-user">
                    <input type="password" class="form-control text-sm" id="password" name="password" placeholder="<?=nhapmatkhau?>" required>
                    <div class="invalid-feedback"><?=vuilongnhapmatkhau?></div>
                </div>
                <label><?=nhaplaimatkhau?></label>
                <div class="input-group input-user">
                    <input type="password" class="form-control text-sm" id="repassword" name="repassword" placeholder="<?=nhaplaimatkhau?>" required>
                    <div class="invalid-feedback"><?=vuilongnhaplaimatkhau?></div>
                </div>
                <label><?=ngaysinh?></label>
                <div class="input-group input-user">
                    <input type="text" class="form-control text-sm" id="birthday" name="birthday" placeholder="<?=nhapngaysinh?>" value="<?=$flash->get('birthday')?>" required autocomplete="off" readonly>
                    <div class="invalid-feedback"><?=vuilongnhapngaysinh?></div>
                </div>
                <label>Email</label>
                <div class="input-group input-user">
                    <input type="email" class="form-control text-sm" id="email" name="email" placeholder="<?=nhapemail?>" value="<?=$flash->get('email')?>" required >
                    <div class="invalid-feedback"><?=vuilongnhapdiachiemail?></div>
                </div>
                <label><?=dienthoai?></label>
                <div class="input-group input-user">
                    <input type="number" class="form-control text-sm" id="phone" name="phone" placeholder="<?=nhapdienthoai?>" value="<?=$flash->get('phone')?>" required>
                    <div class="invalid-feedback"><?=vuilongnhapsodienthoai?></div>
                </div>
                <label><?=diachi?></label>
                <div class="input-group input-user">
                    <input type="text" class="form-control text-sm" id="address" name="address" placeholder="<?=nhapdiachi?>" value="<?=$flash->get('address')?>" required>
                    <div class="invalid-feedback"><?=vuilongnhapdiachi?></div>
                </div>
                <label>Bạn đăng ký để trở thành:</label>
                <div class="input-group input-user">
                    <select id="type_account" name="type_account" class="form-control text-sm">
                        <?php foreach ($arrTypeAccount as $v){ ?>
                            <option value="<?=$v['value']?>" <?=($v['value'] == $type ? 'selected' : '')?>  ><?=$v['name']?></option>
                        <?php } ?>
                    </select>
                    <div class="invalid-feedback"><?=vuilongnhapdiachi?></div>
                </div>
                <div class="form-hidden">
                    <label>Địa chỉ tiệm:</label>
                    <div class="input-group input-user">
                        <input type="text" class="form-control text-sm" id="address_store" name="address_store" placeholder="Nhập địa chỉ tiệm của bạn" value="<?=$flash->get('address_store')?>">
                    </div>
                </div>
                <label>Hình ảnh:</label>
                <div class=" input-user">
                    <div class="form-group mb-2">
                        <div class="review-file-uploader">
                            <input type="file" id="review-file-photo" name="review-file-photo">
                        </div>
                    </div>
                </div>
                <div class="button-user mb-0">
                    <input type="submit" class="btn btn-main btn-block" name="registration-user" value="<?=dangky?>" disabled>
                </div>
            </form>
        </div>
    </div>
</div>