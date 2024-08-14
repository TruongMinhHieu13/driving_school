<div class="wrap-user">
    <div class="title-user">
        <span><?=quenmatkhau?></span>
    </div>
    <form class="form-user validation-user" novalidate method="post" action="account/quen-mat-khau" enctype="multipart/form-data">
        <?=$flash->getMessages("frontend")?>
        <div class="input-user">
            <label class="d-block"><?=taikhoan?></label>
            <input type="text" class="form-control text-sm" id="username" name="username" placeholder="<?=taikhoan?>" required>
            <div class="invalid-feedback"><?=vuilongnhaptaikhoan?></div>
        </div>
        <div class="input-user">
            <label class="d-block"><?=nhapemail?></label>
            <input type="email" class="form-control text-sm" id="email" name="email" placeholder="<?=nhapemail?>" required>
            <div class="invalid-feedback"><?=vuilongnhapdiachiemail?></div>
        </div>
        <div class="button-user btn-login ms-0 mb-0">
            <input type="submit" class="btn btn-primary" name="forgot-password-user" value="<?=laymatkhau?>" disabled>
        </div>
    </form>
</div>