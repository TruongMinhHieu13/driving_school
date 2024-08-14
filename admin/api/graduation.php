<?php
include "config.php";

$value = (!empty($_POST['value'])) ? str_replace(",", "", $_POST['value']) : 0;
$idStudent = (!empty($_POST['idStudent'])) ? htmlspecialchars($_POST['idStudent']) : 0;
$type = (!empty($_POST['type'])) ? htmlspecialchars($_POST['type']) : 0;


if ($type == 'updateGraduate') {	
	$typeGraduate = (!empty($_POST['typeGraduate']) ? $_POST['typeGraduate'] : '');
	$pointGraduate = (!empty($_POST['pointGraduate']) ? $_POST['pointGraduate'] : '');
	$noteGraduate = (!empty($_POST['noteGraduate']) ? $_POST['noteGraduate'] : '');

	$data= array();
	$row = $d->rawQueryOne("select graduate,id from #_student where id = ?",array($idStudent));
	$dataGraduate = json_decode($row['graduate'],true);
	$dataGraduate[$typeGraduate]['note'] = (!empty($noteGraduate) ? $noteGraduate : '');
	$dataGraduate[$typeGraduate]['point'] = (!empty($pointGraduate) ? $pointGraduate : 0);
	$data['graduate'] = json_encode($dataGraduate);
	$d->where('id', $idStudent);
	$d->update('student', $data);
}	

if ($type == 'fee') {	
	$data=array();
	$row = $d->rawQueryOne("select graduate,id, HO_VA_TEN, SO_CMT from #_student where id = ?",array($idStudent));
	$dataGraduate = json_decode($row['graduate'],true);

	$txt = '';
	if ($dataGraduate['fee-graduation'] > 0 ) $txt = 'Cập nhật phí tốt nghiệp'; else $txt = 'Thu phí tốt nghiệp';

	$dataGraduate['fee-graduation'] = (!empty($value) ? $value : 0);
	$data['graduate'] = json_encode($dataGraduate);
	$d->where('id', $idStudent);
	$d->update('student', $data);

	// Lưu lại lịch sử
	$dataHistory['namevi'] = '';
	$dataHistory['descvi'] = $txt.' - '.$row['HO_VA_TEN'].' - '.$row['SO_CMT'].' - '.$func->formatMoney($dataGraduate['fee-graduation']);
	$dataHistory['file'] = '';
	$dataHistory['type'] = 'fee';
	$dataHistory['quantity'] = 0;
	$dataHistory['date_created'] = time();
	$dataHistory['id_downloader'] = $_SESSION[$loginAdmin]['id'];
	$dataHistory['downloads'] = 0;
	$d->insert('user_operation', $dataHistory);

	echo json_encode($dataGraduate['fee-graduation']);
}

if ($type == 'tuition_fee') {	
	$data=array();
	$row = $d->rawQueryOne("select infor_student,graduate,id, HO_VA_TEN, SO_CMT from #_student where id = ?",array($idStudent));
	$dataGraduate = json_decode($row['infor_student'],true);
	$txt = '';
	if ($dataGraduate['tuition_fee'] > 0 ) $txt = 'Cập nhật học phí'; else $txt = 'Thu học phí';

	$dataGraduate['tuition_fee'] = (!empty($value) ? $value : 0);
	$data['infor_student'] = json_encode($dataGraduate);
	$d->where('id', $idStudent);
	$d->update('student', $data);

	// Lưu lại lịch sử
	$dataHistory['namevi'] = '';
	$dataHistory['descvi'] = $txt.' - '.$row['HO_VA_TEN'].' - '.$row['SO_CMT'].' - '.$func->formatMoney($dataGraduate['tuition_fee']);
	$dataHistory['file'] = '';
	$dataHistory['type'] = 'fee';
	$dataHistory['quantity'] = 0;
	$dataHistory['date_created'] = time();
	$dataHistory['id_downloader'] = $_SESSION[$loginAdmin]['id'];
	$dataHistory['downloads'] = 0;
	$d->insert('user_operation', $dataHistory);

	echo json_encode($dataGraduate['tuition_fee']);
}

if ($type == 'date-graduation') {	
	$data= array();
	$row = $d->rawQueryOne("select data_student,id from #_student where id = ?",array($idStudent));
	$dataStudent = json_decode($row['data_student'],true);
	$dataStudent['NGAY_RA_QDTN'] = (!empty($value) ? strtotime(str_replace("/", "-", $value)) : 0);
	$data['data_student'] = json_encode($dataStudent);
	$d->where('id', $idStudent);
	$d->update('student', $data);
}

if ($type == 'fee-retest') {	
	$data= array();
	$txt = '';
	$row = $d->rawQueryOne("select infor_student,id, HO_VA_TEN, SO_CMT from #_student where id = ?",array($idStudent));
	$dataStudent = json_decode($row['infor_student'],true);
	if ($dataStudent['fee-retest'] > 0 ) $txt = 'Cập nhật phí thi lại'; else $txt = 'Thu phí thi lại';
	$dataStudent['fee-retest'] = (!empty($value) ? $value : 0);
	$data['infor_student'] = json_encode($dataStudent);
	$d->where('id', $idStudent);
	$d->update('student', $data);

	// Lưu lại lịch sử
	$dataHistory['namevi'] = '';
	$dataHistory['descvi'] = $txt.' - '.$row['HO_VA_TEN'].' - '.$row['SO_CMT'].' - '.$func->formatMoney($dataStudent['fee-retest']);
	$dataHistory['file'] = '';
	$dataHistory['type'] = 'fee';
	$dataHistory['quantity'] = 0;
	$dataHistory['date_created'] = time();
	$dataHistory['id_downloader'] = $_SESSION[$loginAdmin]['id'];
	$dataHistory['downloads'] = 0;
	$d->insert('user_operation', $dataHistory);

	echo json_encode($dataGraduate['fee-retest']);
}

if ($type == 'date-retest') {	
	$data= array();
	$row = $d->rawQueryOne("select infor_student,id from #_student where id = ?",array($idStudent));
	$dataStudent = json_decode($row['infor_student'],true);
	$dataStudent['date-retest'] = (!empty($value) ? strtotime(str_replace("/", "-", $value)) : 0);
	$data['infor_student'] = json_encode($dataStudent);
	$d->where('id', $idStudent);
	$d->update('student', $data);
}

?>
