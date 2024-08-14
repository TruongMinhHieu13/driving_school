<?php
include "config.php";
$dataId = (!empty($_POST['dataId'])) ? $_POST['dataId'] : [];
$idCourse = (!empty($_POST['idCourse'])) ? htmlspecialchars_decode($_POST['idCourse']) : 0;
$where = '';
if ($idCourse > 0) $where .= ' and MA_KHOA_HOC = '.$idCourse;
$idStudent = implode(',', (json_decode($dataId,true)));
$listStudent = $d->rawQuery("select id, HO_VA_TEN, SO_CMT, HANG_GPLX, data_student from #_student where find_in_set(id, '".$idStudent."') $where order by HO_VA_TEN asc");
?>

<div class="form-group col-xl-12 mt-2">
    <div class="box-name-table">HỌC VIÊN ĐÃ CHỌN</div>
    <div class="show-table">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                <th scope="col">STT</th>
                <th scope="col">Họ và tên</th>
                <th scope="col">Ngày sinh</th>
                <th scope="col">CMT</th>
                <th scope="col">Hạng GPLX</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($listStudent as $k => $v) { 
                    $dataStudent = json_decode($v['data_student'],true);
                ?>
                    <tr>
                        <th scope="row"><?=$k+1?></th>
                        <td><?=$v['HO_VA_TEN']?></td>
                        <td><?=date('Y-m-d',$dataStudent['NGAY_SINH'])?></td>
                        <td><?=$v['SO_CMT']?></td>
                        <td><?=$func->getColDetail('namevi','gplx',$v['HANG_GPLX'])?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
