<?php
$linkView = $configBase;

if ($type == 'lythuyet') $linkMan = $linkFilter = "account/duyet-ly-thuyet?type=".$type;
elseif ($type == 'hinh') $linkMan = $linkFilter = "account/duyet-hinh?type=".$type;
elseif ($type == 'cabin') $linkMan = $linkFilter = "account/duyet-cabin?type=".$type;
elseif ($type == 'dat') $linkMan = $linkFilter = "account/duyet-dat?type=".$type;

$validate_filter = '';
foreach($_GET as $k => $v){
    if ($k == 'com' || $k == 'act') {
        $validate_filter .= '';
    } else {
        $validate_filter .= '&'.$k.'='.$v;
    }
}

$gplx = $d->rawQuery("select namevi, id from #_gplx");

?>
<form class="validation-user" novalidate method="post" action="account/thong-tin" enctype="multipart/form-data">
    <div class="wrap-infomation">
        <div class="row">
            <div class="col-lg-3">
                <?php include TEMPLATE.LAYOUT."menu_user.php"; ?>
            </div>
            <div class="col-lg-9">
                <div class="card card-primary-card-outline text-sm mb-3">
                    <div class="card-header">
                     <div class="title-main text-start mb-0"><h5>Bộ lọc tìm kiếm</h5></div>
                 </div>
                 <div class="card-body">
                    <div class="row row-10">
                        <div class="form-group mb-2 col-md-4 col-sm-4">
                            <div class="">
                                <label class="d-block fw-bold ">Mã khóa học</label>
                                <input type="text" class="form-control float-right text-sm" placeholder="Mã khóa học" name="courses_id" id="courses_id" value="<?=(!empty($_GET['courses-id']) ? $_GET['courses-id'] : '')?>">
                            </div>
                        </div>
                        <?php (!empty($_GET['gplx']) ? $gplxID = $_GET['gplx'] : $gplxID = 0);?>
                        <div class="form-group mb-2 col-md-4 col-sm-4">
                            <label class="d-block fw-bold">Hạng GPLX</label>
                            <select name="" id="gplx" class="form-control text-sm">
                                <option value="0">Chọn hạng GPLX</option>
                                <?php foreach ($gplx as $v) { ?>
                                    <option class="opt-<?= $v['id'] ?>" <?= ($gplxID == $v['id'] ? 'selected' : '') ?> value="<?= $v['id'] ?>"><?= $v['namevi'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group mb-2 col-md-4 col-sm-4">
                            <label class="d-block fw-bold">Tên học viên</label>
                            <div class="">
                                <input type="text" class="form-control float-right text-sm" placeholder="Tên học viên" name="student_name" id="student_name" value="<?= (isset($_GET['student-name'])) ? $_GET['student-name'] : '' ?>">
                            </div>
                        </div>
                        <div class="form-group mb-2 col-md-4 col-sm-4">
                            <div class="">
                                <label class="d-block fw-bold">Mã học viên</label>
                                <input type="text" class="form-control float-right text-sm" placeholder="Mã học viên" name="student_id" id="student_id" value="<?= (isset($_GET['student-id'])) ? $_GET['student-id'] : '' ?>">
                            </div>
                        </div>
                        <div class="form-group mb-2 col-md-4 col-sm-4">
                            <div class="">
                                <label class="d-block fw-bold">CCCD/CMND</label>
                                <input type="text" class="form-control float-right text-sm" placeholder="CCCD/CMND" name="student_cmt" id="student_cmt" value="<?= (isset($_GET['student-cmt'])) ? $_GET['student-cmt'] : '' ?>">
                            </div>
                        </div>
                        <?php (!empty($_GET['status-pass']) ? $status = $_GET['status-pass'] : $status = 0);?>
                        <div class="form-group mb-2 col-md-4 col-sm-4">
                            <div class="">
                                <label class="d-block fw-bold">Tình trạng tốt nghiệp</label>
                                <select name="status_pass" id="status_pass" class="form-control text-sm">
                                    <option value="0">Tình trạng</option>
                                    <option value="1" <?=($status == 1 ? 'selected' : '')?>>Đậu</option>
                                    <option value="2" <?=($status == 2 ? 'selected' : '')?>>Chưa</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="form-group col-md-3 col-sm-3 text-end">
                                <a class="btn btn-sm bg-primary text-white" onclick="searchTeacher('<?= $configBase.$linkFilter ?>')" title="<?= timkiem ?>"><i class="fas fa-search me-1"></i><?= timkiem ?></a>
                                <a class="btn btn-sm bg-success text-white ml-1" href="<?= $linkMan ?>" title="Refresh"><i class="fas fa-times me-1"></i>Huỷ lọc</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-primary card-outline text-sm mb-0">
                <div class="card-header">
                 <div class="title-main text-start mb-0"><h5><?= thongtincanhan ?></h5></div>
             </div>
             <div class="card-body table-responsive p-0">
                <table class="table table-hover table-max-width">
                    <thead>
                        <tr>
                            <th class="align-middle">Mã học viên</th>
                            <th class="align-middle">Họ tên</th>
                            <th class="align-middle">CCCD/HC</th>
                            <th class="align-middle">Mã khóa học</th>
                            <th class="align-middle">Hạng xe</th>
                            <th class="align-middle">Duyệt</th>
                        </tr>
                    </thead>
                    <?php if (empty($items)) { ?>
                        <tbody>
                            <tr>
                                <td colspan="100" class="text-center">Không có dữ liệu</td>
                            </tr>
                        </tbody>
                    <?php } else { ?>
                        <tbody>
                            <?php for ($i = 0; $i < count($items); $i++) {
                                $graduate= [];
                                $dataStudent = [];
                                $infoStudent = [];
                                if(!empty($items[$i]['data_student'])) $dataStudent = json_decode($items[$i]['data_student'], true);
                                if(!empty($items[$i]['infor_student'])) $infoStudent = json_decode($items[$i]['infor_student'], true);
                                if(!empty($items[$i]['graduate'])) $graduate = json_decode($items[$i]['graduate'], true);
                            // $func->dump($graduate);
                                ?>
                                <tr class="result-graduate-<?= $items[$i]['id'] ?>">
                                    <td class="align-middle">
                                        <?= $items[$i]['MA_DK'] ?>
                                    </td>
                                    <td class="align-middle">
                                        <?= $items[$i]['HO_VA_TEN'] ?>
                                    </td>
                                    <td class="align-middle">
                                        <?= $items[$i]['SO_CMT'] ?>
                                    </td>
                                    <td class="align-middle">
                                        <?= $items[$i]['MA_KHOA_HOC'] ?>
                                    </td>
                                    <td class="align-middle">
                                        <?= $func->getColDetail('namevi', 'gplx', $items[$i]['HANG_GPLX']) ?>
                                    </td>
                                    <td class="align-middle d-flex align-items-start">
                                        <div class="btn-result-graduate <?=((!empty($graduate[$typeData]['point']) && $graduate[$typeData]['point'] > 0) ? 'dau' : 'chua')?>" data-point="<?=((!empty($graduate[$typeData]['point']) && $graduate[$typeData]['point'] > 0) ? '0' : '1')?>" data-typeData="<?=$typeData?>" data-id="<?= $items[$i]['id'] ?>">
                                            <?=((!empty($graduate[$typeData]['point']) && $graduate[$typeData]['point'] > 0) ? 'Đậu' : 'Chưa')?>
                                        </div>
                                        <?php if (!empty($graduate[$typeData]['point']) && $graduate[$typeData]['point'] > 0) { ?>

                                            <div class="note-graduate note" data-tippy-content="<?=$graduate[$typeData]['note']?>" >Ghi chú</div>
                                        <?php } ?>
                                    </td>  
                                </tr>
                            <?php } ?>
                        </tbody>
                    <?php } ?>
                </table>
            </div>
        </div>
        <?php if ($paging) { ?>
            <div class="card-footer text-sm pb-0">
                <?= $paging ?>
            </div>
        <?php } ?>
    </div>
</div>
</div>
</div>
</form>