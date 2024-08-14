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

?>
