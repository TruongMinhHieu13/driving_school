<div class="wrap-login">
    <div class="row">
        <div class="col-md-6">
            <h2 class="title-user-page">Welcome back</h2>
            <form class="form-user validation-user p-0" novalidate method="post" action="account/dang-nhap" enctype="multipart/form-data">
                <?=$flash->getMessages("frontend")?>
                <div class="input-user">
                    <label><b>Tài khoản</b></label>
                    <input type="text" class="form-control text-sm" id="username" name="username" placeholder="<?=taikhoan?>" required>
                    <div class="invalid-feedback"><?=vuilongnhaptaikhoan?></div>
                </div>
                <div class="input-user">
                    <label><b>Mật khẩu</b></label>
                    <input type="password" class="form-control text-sm" id="password" name="password" placeholder="<?=matkhau?>" required>
                    <div class="invalid-feedback"><?=vuilongnhapmatkhau?></div>
                </div>
                <div class="button-user d-flex align-items-center justify-content-between">
                    <div class="checkbox-user custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="remember-user" id="remember-user" value="1">
                        <label class="custom-control-label" for="remember-user"><?=nhomatkhau?></label>
                    </div>
                    <div class="input-forgot-password">
                        <a href="quen-mat-khau" title="Quên mật khẩu">Quên mật khẩu</a>
                    </div>
                </div>
                <div class="btn-login"><input type="submit" class="btn " name="login-user" value="<?=dangnhap?>" disabled></div>
                <div class="note-user">
                    <span><?=banchuacotaikhoan?> ! </span>
                    <a href="account/dang-ky" title="<?=dangkytaiday?>"><?=dangkytaiday?></a>
                </div>
            </form>
        </div>
        <div class="col-md-6 d-flex justify-content-center align-items-center">
            <div class="logo-header">
                <a href="">
                    <?=$func->getImage(['sizes' => '120x80x2', 'upload' => UPLOAD_PHOTO_L, 'image' => $logo['photo'], 'alt' => $setting['name'.$lang]])?>
                </a>
            </div>
        </div>
    </div>
</div>