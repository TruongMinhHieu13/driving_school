<?php
include "config.php";
$value = (!empty($_POST["value"])) ? htmlspecialchars($_POST["value"]) : 0;
$listStudent = $d->rawQuery("select id, HO_VA_TEN, SO_CMT, HANG_GPLX, data_student, MA_KHOA_HOC from #_student where id <> 0 and MA_KHOA_HOC = '' and HANG_GPLX = ? order by MA_KHOA_HOC asc", array($value));

if (!empty($value)) {
    if (!empty($listStudent)) {
        foreach ($listStudent as $v) {
            $str .= '<option value=' . $v["id"] . '>' . $v['HO_VA_TEN'] . '-' . $v['SO_CMT'] . '</option>';
        }
    }
} else {
    $str = '<option value="0">'.chondanhmuc.'</option>';
}

echo $str;
