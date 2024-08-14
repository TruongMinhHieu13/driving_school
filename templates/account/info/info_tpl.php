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