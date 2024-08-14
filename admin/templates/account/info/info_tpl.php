<form class="validation-user" novalidate method="post" action="account/thong-tin" enctype="multipart/form-data">
    <div class="wrap-infomation">
        <div class="row">
            <div class="col-lg-3">
                <?php include TEMPLATE.LAYOUT."menu_user.php"; ?>
            </div>
            <div class="col-lg-9">
                <div class="wrap-user mw-100">
                    <div class="title-user">
                        <span><?= thongtincanhan ?></span>
                    </div>
                    <?= $flash->getMessages("frontend") ?>
                    <div class="form-user">
                        
                    
                    <label><?= hoten ?></label>
                    <div class="input-group input-user">
                        <input type="text" class="form-control text-sm" id="fullname" name="fullname" placeholder="<?= nhaphoten ?>" value="<?= (!empty($flash->has('fullname'))) ? $flash->get('fullname') : $rowDetail['fullname'] ?>" required>
                        <div class="invalid-feedback"><?= vuilongnhaphoten ?></div>
                    </div>
                    <label><?= taikhoan ?></label>
                    <div class="input-group input-user">
                        <input type="text" class="form-control text-sm" id="username" name="username" placeholder="<?= nhaptaikhoan ?>" value="<?= $rowDetail['username'] ?>" readonly required>
                    </div>
                
                    <label><?= ngaysinh ?></label>
                    <div class="input-group input-user">
                        <input type="text" class="form-control text-sm" id="birthday" name="birthday" placeholder="<?= nhapngaysinh ?>" value="<?= (!empty($flash->has('birthday'))) ? $flash->get('birthday') : date("d/m/Y", $rowDetail['birthday']) ?>"  autocomplete="off">
                        <div class="invalid-feedback"><?= vuilongnhapngaysinh ?></div>
                    </div>
                    <label>Email</label>
                    <div class="input-group input-user">
                        <input type="email" class="form-control text-sm" id="email" name="email" placeholder="<?= nhapemail ?>" value="<?= (!empty($flash->has('email'))) ? $flash->get('email') : $rowDetail['email'] ?>" >
                        <div class="invalid-feedback"><?= vuilongnhapdiachiemail ?></div>
                    </div>
                    <label><?= dienthoai ?></label>
                    <div class="input-group input-user">
                        <input type="number" class="form-control text-sm" id="phone" name="phone" placeholder="<?= nhapdienthoai ?>" value="<?= (!empty($flash->has('phone'))) ? $flash->get('phone') : $rowDetail['phone'] ?>" >
                        <div class="invalid-feedback"><?= vuilongnhapsodienthoai ?></div>
                    </div>
                    <label><?= diachi ?></label>
                    <div class="input-group input-user">
                        <input type="text" class="form-control text-sm" id="address" name="address" placeholder="<?= nhapdiachi ?>" value="<?= (!empty($flash->has('address'))) ? $flash->get('address') : $rowDetail['address'] ?>" >
                        <div class="invalid-feedback"><?= vuilongnhapdiachi ?></div>
                    </div>
                    <?php if ($rowDetail['type_account'] == 3 || $rowDetail['type_account'] == 4){ ?>
                   
                    <label><?= diachi ?> cửa tiệm</label>
                    <div class="input-group input-user">
                        <input type="text" class="form-control text-sm" id="address_store" name="address_store" placeholder="<?= nhapdiachi ?>" value="<?= (!empty($flash->has('address_store'))) ? $flash->get('address_store') : $rowDetail['address_store'] ?>" >
                        <div class="invalid-feedback"><?= vuilongnhapdiachi ?></div>
                    </div>
                     <?php } ?>
                    <?php if ($rowDetail['type_account'] == 4){ ?>
                   
                    <label>Số lượng nhân lực đã cung cấp</label>
                    <div class="input-group input-user">
                        <input type="text" class="form-control text-sm" id="quantity" name="quantity" placeholder="Số lượng" value="<?= (!empty($flash->has('quantity'))) ? $flash->get('quantity') : $rowDetail['quantity'] ?>"  readonly>
                    </div>
                     <?php } ?>
                    <label>Loại tài khoản</label>
                    <div class="input-group input-user">
                        <input type="text" class="form-control text-sm" id="type_account" name="type_account" placeholder="Loại tài khoản" value="<?=$arrTypeAccount[$rowDetail['type_account']]['name']?>" readonly>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="photo_account">Hình ảnh đi kèm:</label>
                        <div class="row row-10">
                            <?php if (!empty($personalImage)){ 
                                foreach ($personalImage as $v) { ?>
                                    <div class="items-photo-letter col-lg-2 col-md-3 col-sm-4 col-xs-6 items-photo-letter-<?=$v['id']?>">
                                        <a data-fancybox="gallery-user-<?=$v['id']?>" data-src="<?= ASSET . UPLOAD_ACCOUNT_L . $v['photo'] ?>" data-caption="">
                                            <img class="w-100" onerror="this.src='../<?= THUMBS ?>/200x200x2/assets/images/noimage.png';" src="<?= THUMBS ?>/200x200x2/<?= UPLOAD_ACCOUNT_L . $v['photo'] ?>" alt="<?= $v['namevi'] ?>" title="<?= $v['namevi'] ?>" />
                                        </a>
                                        <div class="delete-photo-user" data-id="<?=$v['id']?>">
                                            <i class="far fa-trash-alt"></i>
                                        </div>
                                    </div>
                                <?php }
                            } ?>
                        </div>
                    </div>
                    <div class="form-group col-md-12 mt-2">
                        <label for="photo_account"><?=($act == 'add_member') ? 'Hình ảnh đi kèm' : 'Bổ sung hình ảnh' ?>:</label>
                        <div class="review-file-uploader">
                            <input type="file" id="review-file-photo" name="review-file-photo">
                        </div>
                    </div>
                    <div class="button-user">
                        <input type="submit" class="btn btn-primary btn-block" name="info-user" value="<?= capnhat ?>" disabled>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>