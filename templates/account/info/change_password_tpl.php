<form class="validation-user" novalidate method="post" action="account/doi-mat-khau" enctype="multipart/form-data">
    <div class="wrap-infomation">
        <div class="row">
            <div class="col-lg-3">
                <?php include TEMPLATE.LAYOUT."menu_user.php"; ?>
            </div>
            <div class="col-lg-9">
                <div class="wrap-user mw-100">
                    <div class="title-user">
                        <span>Đổi mật khẩu</span>
                    </div>
                    <div class="form-user">
                        <?=$flash->getMessages("frontend")?>
                        <label><?= matkhaucu ?></label>
                        <div class="input-group input-user">
                            <input type="password" class="form-control text-sm" id="old-password" name="old-password" placeholder="<?= nhapmatkhaucu ?>">
                        </div>
                        <label><?= matkhaumoi ?></label>
                        <div class="input-group input-user">
                            <input type="password" class="form-control text-sm" id="new-password" name="new-password" placeholder="<?= nhapmatkhaumoi ?>">
                        </div>
                        <label><?= nhaplaimatkhaumoi ?></label>
                        <div class="input-group input-user">
                            <input type="password" class="form-control text-sm" id="new-password-confirm" name="new-password-confirm" placeholder="<?= nhaplaimatkhaumoi ?>">
                        </div>
                        <div class="button-user mb-0">
                            <input type="submit" class="btn btn-primary" name="change-password-user" value="Đổi mật khẩu" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>