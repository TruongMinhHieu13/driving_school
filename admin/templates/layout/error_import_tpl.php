<?php 
    $act = !empty($_GET['act']) ? $_GET['act'] : '';
    if($act == 'uploadXMLBC1') $linkreturn = "index.php?com=student&act=man&fill=man"; 
    elseif($act == 'uploadXMLBC2') $linkreturn = "index.php?com=graduate&act=man";
?>

<?php if (!empty($errormsg)) { ?>
    <div class="d-flex justify-content-center align-items-center">
        <div class="box w-75 p-5">
            <div class="icon-err"><i class="fa-regular fa-triangle-exclamation"></i></div>
            <div class="title-err">Lỗi import</div>
            <ul class="list-error">
                <?php foreach ($errormsg as $v) { ?>
                    <li><?= $v ?></li>
                <?php } ?>
            </ul>
            <div class="btn-err text-center"><a class="btn btn-sm bg-gradient-danger text-white" href="index.php?com=student&act=man" title="Quay trở về"><i class="fa-solid fa-circle-left mr-2"></i></i>Quay trở về</a></div>
        </div>
    </div>
<?php } ?>
<?php if (!empty($studentError)) {?>
    
    <div class="wrap-err">
        <div class="box p-5">
            <div class="icon-err"><i class="fa-regular fa-triangle-exclamation"></i></div>
            <div class="title-err">Error</div>
            <div class="row">
                <div class="col-12"><div class="wrap-success p-3 mb-3 bg-success text-white">Đã cập nhật <?=$savedSuccess?> học viên</div></div>
                <?php foreach ($studentError as $v) { ?>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="box-info-err">
                            <p><b>- Thông tin người bị lỗi:</b></p>
                            <p><b>- Mã ĐK:</b> <?= $v['info']['MA_DK'] ?></p>
                        </div>
                        <div class="box-reason">
                            <ul class="list-error">
                                <?php foreach ($v['msg'] as $r) { ?>
                                    <li class="text-sm"><?= $r ?></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="btn-err text-center"><a class="btn btn-sm bg-gradient-danger text-white" href="<?=$linkreturn?>" title="Quay trở về"><i class="fa-solid fa-circle-left mr-2"></i></i>Quay trở về</a></div>
        </div>
    </div>
<?php } ?>