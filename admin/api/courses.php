<?php 
	include "config.php";

	$id = $_POST['id'];
	$action = $_POST['act'];
	$courses = (!empty($_POST['courses']) ? $_POST['courses'] : 0);
	$coursesCar = (!empty($_POST['coursesCar']) ? $_POST['coursesCar'] : 0);

	if ($action == 'del-student') {
		$updateHV = $d->rawQueryOne("update #_student set `MA_KHOA_HOC` = '' WHERE id = ?", array($id));
	}
	if ($action == 'del-teacher') {
		if ($courses > 0) {
			$rowCourses = $d->rawQueryOne("select id, data_teacher from #_courses where id = ?", array($courses));
			$rowUpdate = json_decode($rowCourses['data_teacher'],true);

			$key = array_search($id, $rowUpdate);
			if ($key !== false) {
				unset($rowUpdate[$key]);
			}

			$update = $d->rawQueryOne("update #_courses set data_teacher = ? WHERE id = ?", array(json_encode($rowUpdate),$courses));
		}
	}
	if ($action == 'del-car') {
		if ($coursesCar > 0) {
			$rowCourses = $d->rawQueryOne("select id, data_car from #_courses where id = ?", array($coursesCar));
			$rowUpdate = json_decode($rowCourses['data_car'],true);

			$key = array_search($id, $rowUpdate);
			if ($key !== false) {
				unset($rowUpdate[$key]);
			}

			$update = $d->rawQueryOne("update #_courses set data_car = ? WHERE id = ?", array(json_encode($rowUpdate),$coursesCar));
		}
	}
 ?>