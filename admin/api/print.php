<?php
include "config.php";
$act = !empty($_POST['act']) ? $_POST['act'] : '';
$fill = !empty($_POST['fill']) ? $_POST['fill'] : '';
$coursesName = !empty($_POST['coursesName']) ? $_POST['coursesName'] : '';
$coursesId = !empty($_POST['coursesId']) ? $_POST['coursesId'] : '';
$gplx = !empty($_POST['gplx']) ? $_POST['gplx'] : '';
$dateOpen = !empty($_POST['dateOpen']) ? $_POST['dateOpen'] : '';
$dateClose = !empty($_POST['dateClose']) ? $_POST['dateClose'] : '';
$dateSH = !empty($_POST['dateSH']) ? $_POST['dateSH'] : '';
$studentName = !empty($_POST['studentName']) ? $_POST['studentName'] : '';
$studentId = !empty($_POST['studentId']) ? $_POST['studentId'] : '';
$studentCMT = !empty($_POST['studentCMT']) ? $_POST['studentCMT'] : '';
$graduateStatus = !empty($_POST['graduateStatus']) ? $_POST['graduateStatus'] : '';
$testStatus = !empty($_POST['testStatus']) ? $_POST['testStatus'] : '';
$where = "";

if (!empty($fill) && $fill == 'theory') {
	$where .= " and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.theory.point')) > 0";
}

if (!empty($fill) && $fill == 'geometry') {
	$where .= " and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.geometry.point')) > 0";
}

if (!empty($fill) && $fill == 'cabin') {
	$where .= " and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.cabin.point')) > 0";
}

if (!empty($fill) && $fill == 'dat') {
	$where .= " and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.dat.point')) > 0";
}

if (!empty($fill) && $fill == 'graduate') {
	$where .= " and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.theory.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.geometry.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.cabin.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.dat.point')) > 0";  
}

if (!empty($fill) && $fill == 'KDDK') {
	$where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) = 'KDDK'";  
}

if (!empty($fill) && $fill == 'failed-examination') {
	$where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) != 'DA'";  
}
if (!empty($fill) && $fill == 'pass-examination') {
	$where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) = 'DA'";  
}


if (!empty($coursesId)) {
        // Show data search
	$dataResult['courses_id'] = explode(",", $coursesId);

	foreach($dataResult['courses_id'] as $s => $vc){
		$where .= ($s == 0 ? ' and (' : ' or') ." MA_KHOA_HOC = '".$vc."'";
	}
	$where = $where.")";
}

    // echo $where;

if (!empty($gplx)) {
        // Show data search
	$arrayGPLX = explode(",", $gplx);

	foreach($arrayGPLX as $s => $v){
		$where .= ($s == 0 ? ' and (' : ' or') ." HANG_GPLX = '".$v."'";
	}
	$where = $where.")";
}

if (!empty($studentName)) {
        // Show data search
	$dataResult['student-name'] = explode(",", $studentName);

	foreach($dataResult['student-name'] as $s => $vc){
		$where .= ($s == 0 ? ' and (' : ' or') ." HO_VA_TEN LIKE '%".$vc."%'";
	}
	$where = $where.")";
}

if (!empty($studentId)) {
        // Show data search
	$dataResult['student-id'] = explode(",", $studentId);

	foreach($dataResult['student-id'] as $s => $vc){
		$where .= ($s == 0 ? ' and (' : ' or') ." MA_DK = '".$vc."'";
	}
	$where = $where.")";
}

if (!empty($studentCMT)) {
        // Show data search
	$dataResult['student-cmt'] = explode(",", $studentCMT);

	foreach($dataResult['student-cmt'] as $s => $vc){
		$where .= ($s == 0 ? ' and (' : ' or') ." SO_CMT = '".$vc."'";
	}
	$where = $where.")";
}

    // Lấy thông tin khoá học. Truy vấn học viên của khoá đó

if (!empty($coursesName)) {
        // Show data search
	$dataResult['courses-name'] = explode(",", $coursesName);

	$condition = '';
	foreach($dataResult['courses-name'] as $s => $vc){
		$condition .= ($s == 0 ? ' (' : ' or') ." TEN_KHOA_HOC = '".$vc."'";
	}
	$condition = $condition.")";

        // Lấy id khoá học
	$id_courses = $d->rawQuery("select MA_KHOA_HOC from #_courses where ".$condition);

	if(!empty($id_courses)){
		foreach ($id_courses as $s => $course) {
			$where .= ($s == 0 ? ' and (' : ' or') ." MA_KHOA_HOC = '".$course['MA_KHOA_HOC']."'";
		}
		$where = $where.")";
	}else {
		$where = ' and  numb < 0';
	}
}

if (!empty($dateOpen)) {
	$dateOpen = explode("-", $dateOpen);
	$date_from = trim($dateOpen[0] . ' 12:00:00 AM');
	$date_to = trim($dateOpen[1] . ' 11:59:59 PM');
	$date_from = strtotime(str_replace("/", "-", $date_from));
	$date_to = strtotime(str_replace("/", "-", $date_to));
	$whereCourses .= " and NGAY_KHAI_GIANG<=$date_to and NGAY_KHAI_GIANG>=$date_from";
}

if (!empty($dateClose)) {
	$dateClose = explode("-", $dateClose);
	$date_from = trim($dateClose[0] . ' 12:00:00 AM');
	$date_to = trim($dateClose[1] . ' 11:59:59 PM');
	$date_from = strtotime(str_replace("/", "-", $date_from));
	$date_to = strtotime(str_replace("/", "-", $date_to));
	$whereCourses .= " and NGAY_BE_GIANG<=$date_to and NGAY_BE_GIANG>=$date_from";
}

if (!empty($dateSH)) {
	$dateSH = explode("-", $dateSH);
	$date_from = trim($dateSH[0] . ' 12:00:00 AM');
	$date_to = trim($dateSH[1] . ' 11:59:59 PM');
	$date_from = strtotime(str_replace("/", "-", $date_from));
	$date_to = strtotime(str_replace("/", "-", $date_to));
	$whereCourses .= " and NGAY_SAT_HACH<=$date_to and NGAY_SAT_HACH>=$date_from";
}

if (!empty($whereCourses) && $whereCourses != '') {
        // Lấy id khoá học
	$idCourses = $d->rawQuery("select MA_KHOA_HOC from #_courses where id <> 0 ".$whereCourses);

	if(!empty($idCourses)){
		foreach ($idCourses as $s => $course) {
			$where .= ($s == 0 ? ' and (' : ' or') ." MA_KHOA_HOC = '".$course['MA_KHOA_HOC']."'";
		}
		$where = $where.")";
	}else {
		$where = ' and  numb < 0';
	}
}
if (!empty($graduateStatus) && $graduateStatus > 0) {
	$where .= " and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.theory.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.geometry.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.cabin.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.dat.point')) > 0";
}

if (!empty($testStatus)) {
	if($testStatus == 1) $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) = 'DA'";
	elseif($testStatus == 3) $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) = 'KDDK'";
	elseif($testStatus == 2) $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) != 'KDDK' and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) != 'DA'";
} 


$sql = "select * from #_student where id <> 0 $where order by numb,id desc";
$items = $d->rawQuery($sql);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>In thẻ tập lái</title>
	<style>
		body {font-family: 'Times New Roman', sans-serif;font-size: 10px;position: relative;margin: 0;}
		.wrap-content {max-width: 874px;margin: 0 auto;}
		.grid-card {display: grid; grid-template-columns: repeat(2, 1fr); grid-gap: 5px;}
		.items-card {border: 4px solid #000;display: inline-block;}
		.header-card { text-align: center; padding: 7px; font-weight: 500; border-bottom: 3px solid; }
		.header-card p { margin-top: 0; margin-bottom: 5px; }
		.header-card p:nth-child(2) { margin-bottom: 0; }
		.pic-3x4 { width: 113.386px; height: 151.181px; border: 2px solid; }
		.information { width: calc(100% - 130px); }
		.in4-student { display: flex; justify-content: space-between; align-items: center; }
		.in4-student {padding: 8px;}
		.name, .title { font-weight: 700; font-size: 16px; margin-bottom: 12px; }
		.name { margin: 20px 0; }
		.btn-print a { background: #ffc107 linear-gradient(180deg, #ffca2c, #ffc107) repeat-x !important; padding: .25rem .5rem; font-size: .875rem; line-height: 1.5; border-radius: .2rem; font-family: 'Arial'; min-width: 150px; display: inline-block; text-align: center; cursor: pointer; }
		.btn-print { position: sticky; top: 0; z-index: 11; background: #fff; padding: 5px 0; box-shadow: 0 7px 10px #ccc; }
		@media print {
			.no-print { display: none; }
		}
		.header-card { font-size: 15px; }
		.gplx { font-size: 15px; }
	</style>
</head>
	<body>
		<div class="page-print">
			<div class="btn-print no-print">
				<div class="wrap-content">
					<a class="btn btn-sm bg-gradient-warning text-dark ml-1" onclick="window.print();" title="Print"><i class="fa-solid fa-print mr-1"></i>In thẻ</a>
				</div>
			</div>
			<div class="wrap-content">
				<div class="grid-card">
					<?php foreach ($items as $v){ ?>
						<div class="items-card">
							<div class="header-card">
								<p>CÔNG TY TNHH VẬN TẢI HOÀNG PHÚC</p>
								<p>TRUNG TÂM GDNN LÁI XE TIẾN ĐẠT</p>
							</div>
							<div class="in4-student">
								<div class="pic-3x4">

								</div>
								<div class="information">
									<div class="title">HỌC VIÊN TẬP LÁI XE</div>
									<div class="name"><?=$v['HO_VA_TEN']?></div>
									<div class="gplx">Tập lái xe hạng: <?=$func->getInfoDetail('namevi','gplx',$v['HANG_GPLX'])['namevi']?></div>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</body>
</html>