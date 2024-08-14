<?php
	include "config.php";
	require_once LIBRARIES."config-type.php";

	/* Xử lý color */
	$dataColor = (!empty($_POST['dataColor'])) ? $_POST['dataColor'] : [];
	$dataSize = (!empty($_POST['dataSize'])) ? $_POST['dataSize'] : [];
	$color = (!empty($_POST['color'])) ? $_POST['color'] : [];
	$size = (!empty($_POST['size'])) ? $_POST['size'] : [];
	$type = (!empty($_POST['type'])) ? $_POST['type'] : 'san-pham';
	$regular_price = (!empty($_POST['regular_price'])) ? $_POST['regular_price'] : 0;
	$sale_price = (!empty($_POST['sale_price'])) ? $_POST['sale_price'] : 0;

	if(!empty($size)){
		$idSize = implode(',', $size);
	}
	if(!empty($color)){
		$idColor = implode(',', $color);
	}
	$htmlColor = '';
	$htmlSize = '';
	$arrHtmlSize = [];

	$compareColorAdd = array_values(array_diff($color, $dataColor));
	$compareColorRemove = array_values(array_diff($dataColor, $color));
	$compareSizeAdd = array_values(array_diff($size, $dataSize));
	$compareSizeRemove = array_values(array_diff($dataSize, $size));

	if(!empty($compareColorAdd)){
		$rowColor = $d->rawQueryOne("select namevi, id from #_color where find_in_set(id, ?) and type = ? and find_in_set('hienthi',status) order by numb,id desc", array($compareColorAdd[0], $type));
		$rowSize = $d->rawQuery("select namevi, id from #_size where find_in_set(id, ?) and type = ? and find_in_set('hienthi',status) order by numb,id desc", array($idSize, $type));

		if(!empty($rowSize)){
			foreach ($rowSize as $key => $value) {
				$htmlColor .= '<div class="variation-model-table-cell row-price variation-model-table-cell-' . $rowColor['id'] . '-' . $value['id'] . ' variation-model-table-cell-color-' . $rowColor['id'] . ' variation-model-table-cell-size-' . $value['id'] . '">
					<div class="table-cell-content body-cell-content cell-label">' . $rowColor['namevi'] . '</div>
					<div class="table-cell-content body-cell-content cell-label">' . $value['namevi'] . '</div>
					<div class="table-cell-content body-cell-content">
						<input type="text" class="form-control format-price regular_price text-sm" name="dataVariation[' .$rowColor['id']. '][' .$value['id']. '][regular_price]" value='.$regular_price.'  placeholder="Giá bán">
					</div>
					<div class="table-cell-content body-cell-content">
						<input type="text" class="form-control format-price sale_price text-sm" name="dataVariation[' .$rowColor['id']. '][' .$value['id']. '][sale_price]"value='.$sale_price.' placeholder="Giá mới">
					</div>
					<div class="table-cell-content body-cell-content cell-option">
						<div class="custom-control custom-checkbox d-inline-block align-middle">
							<input type="checkbox" class="custom-control-input '.$rowColor['id'].'-'.$value['id'].'-checkbox" name="dataVariation['.$rowColor['id'].']['.$value['id'].'][status]" id="'.$rowColor['id'].'-'.$value['id'].'-checkbox" checked value="1">
							<label for="'.$rowColor['id'].'-'.$value['id'].'-checkbox" class="custom-control-label"></label>
						</div>
					</div>
				</div>';
			}
		}else{
			$htmlColor .= '<div class="variation-model-table-cell row-price variation-model-table-cell-' . $rowColor['id'] . '-0 variation-model-table-cell-color-' . $rowColor['id'] . ' variation-model-table-cell-size-0">
					<div class="table-cell-content body-cell-content cell-label">' . $rowColor['namevi'] . '</div>
					<div class="table-cell-content body-cell-content cell-label"></div>
					<div class="table-cell-content body-cell-content">
						<input type="text" class="form-control format-price regular_price text-sm" name="dataVariation[' .$rowColor['id']. '][0][regular_price]" value='.$regular_price.'   placeholder="Giá bán">
					</div>
					<div class="table-cell-content body-cell-content">
						<input type="text" class="form-control format-price sale_price text-sm" name="dataVariation[' .$rowColor['id']. '][0][sale_price]"  value='.$sale_price.' placeholder="Giá mới">
					</div>
					<div class="table-cell-content body-cell-content cell-option">
						<div class="custom-control custom-checkbox d-inline-block align-middle">
							<input type="checkbox" class="custom-control-input '.$rowColor['id'].'-0-checkbox" name="dataVariation['.$rowColor['id'].'][0][status]" id="'.$rowColor['id'].'-0-checkbox" checked value="1">
							<label for="'.$rowColor['id'].'-0-checkbox" class="custom-control-label"></label>
						</div>
					</div>
				</div>';
		}
	}
	if(!empty($compareSizeAdd)){
		$rowSize = $d->rawQueryOne("select namevi, id from #_size where find_in_set(id, ?) and type = ? and find_in_set('hienthi',status) order by numb,id desc", array($compareSizeAdd[0], $type));
		$rowColor = $d->rawQuery("select namevi, id from #_color where find_in_set(id, ?) and type = ? and find_in_set('hienthi',status) order by numb,id desc", array($idColor, $type));
		if(!empty($rowColor)){
			if(!empty($dataSize)){
				foreach ($rowColor as $key => $value) {
					$arrHtmlSize[$value['id']] = '<div class="variation-model-table-cell row-price variation-model-table-cell-' . $value['id'] . '-' . $rowSize['id'] . ' variation-model-table-cell-color-' . $value['id'] . ' variation-model-table-cell-size-' . $rowSize['id'] . '">
						<div class="table-cell-content body-cell-content cell-label">' . $value['namevi'] . '</div>
						<div class="table-cell-content body-cell-content cell-label">' . $rowSize['namevi'] . '</div>
						<div class="table-cell-content body-cell-content">
							<input type="text" class="form-control format-price regular_price text-sm" name="dataVariation[' .$value['id']. '][' .$rowSize['id']. '][regular_price]" value='.$regular_price.' placeholder="Giá bán">
						</div>
						<div class="table-cell-content body-cell-content">
							<input type="text" class="form-control format-price sale_price text-sm" name="dataVariation[' .$value['id']. '][' .$rowSize['id']. '][sale_price]" value='.$sale_price.' placeholder="Giá mới">
						</div>
						<div class="table-cell-content body-cell-content cell-option">
							<div class="custom-control custom-checkbox d-inline-block align-middle">
								<input type="checkbox" class="custom-control-input '.$value['id'].'-'.$rowSize['id'].'-checkbox" name="dataVariation['.$value['id'].']['.$rowSize['id'].'][status]" id="'.$value['id'].'-'.$rowSize['id'].'-checkbox" checked value="1">
								<label for="'.$value['id'].'-'.$rowSize['id'].'-checkbox" class="custom-control-label"></label>
							</div>
						</div>
					</div>';
				}
			}else{
				foreach ($rowColor as $key => $value) {
					$htmlSize .= '<div class="variation-model-table-cell row-price variation-model-table-cell-' . $value['id'] . '-' . $rowSize['id'] . ' variation-model-table-cell-color-' . $value['id'] . ' variation-model-table-cell-size-' . $rowSize['id'] . '">
						<div class="table-cell-content body-cell-content cell-label">' . $value['namevi'] . '</div>
						<div class="table-cell-content body-cell-content cell-label">' . $rowSize['namevi'] . '</div>
						<div class="table-cell-content body-cell-content">
							<input type="text" class="form-control format-price regular_price text-sm" name="dataVariation[' .$value['id']. '][' .$rowSize['id']. '][regular_price]" value='.$regular_price.' placeholder="Giá bán">
						</div>
						<div class="table-cell-content body-cell-content">
							<input type="text" class="form-control format-price sale_price text-sm" name="dataVariation[' .$value['id']. '][' .$rowSize['id']. '][sale_price]" value='.$sale_price.' placeholder="Giá mới">
						</div>
						<div class="table-cell-content body-cell-content cell-option">
							<div class="custom-control custom-checkbox d-inline-block align-middle">
								<input type="checkbox" class="custom-control-input 0-'.$rowSize['id'].'-checkbox" name="dataVariation[0]['.$rowSize['id'].'][status]" id="0-'.$rowSize['id'].'-checkbox" checked value="1">
								<label for="0-'.$rowSize['id'].'-checkbox" class="custom-control-label"></label>
							</div>
						</div>
					</div>';
				}
			}
		}else{
			$htmlSize .= '<div class="variation-model-table-cell row-price variation-model-table-cell-0-' . $rowSize['id'] . ' variation-model-table-cell-color-0 variation-model-table-cell-size-' . $rowSize['id'] . '">
				<div class="table-cell-content body-cell-content cell-label"></div>
				<div class="table-cell-content body-cell-content cell-label">' . $rowSize['namevi'] . '</div>
				<div class="table-cell-content body-cell-content">
					<input type="text" class="form-control format-price regular_price text-sm" name="dataVariation[0][' .$rowSize['id']. '][regular_price]" value='.$regular_price.' placeholder="Giá bán">
				</div>
				<div class="table-cell-content body-cell-content">
					<input type="text" class="form-control format-price sale_price text-sm" name="dataVariation[0][' .$rowSize['id']. '][sale_price]" value='.$sale_price.' placeholder="Giá mới">
				</div>
				<div class="table-cell-content body-cell-content cell-option">
					<div class="custom-control custom-checkbox d-inline-block align-middle">
						<input type="checkbox" class="custom-control-input 0-'.$rowSize['id'].'-checkbox" name="dataVariation[0]['.$rowSize['id'].'][status]" id="0-'.$rowSize['id'].'-checkbox" checked value="1">
						<label for="0-'.$rowSize['id'].'-checkbox" class="custom-control-label"></label>
					</div>
				</div>
			</div>';
		}
	}
	if(!empty($compareColorRemove)){
		if(empty($color) && !empty($size)){
			$rowSize = $d->rawQuery("select namevi, id from #_size where find_in_set(id, ?) and type = ? and find_in_set('hienthi',status) order by numb,id desc", array($idSize, $type));
			foreach ($rowSize as $key => $value) {
				$htmlSize .= '<div class="variation-model-table-cell row-price variation-model-table-cell-0-' . $value['id'] . ' variation-model-table-cell-color-0 variation-model-table-cell-size-' . $value['id'] . '">
					<div class="table-cell-content body-cell-content cell-label"></div>
					<div class="table-cell-content body-cell-content cell-label">' . $value['namevi'] . '</div>
					<div class="table-cell-content body-cell-content">
						<input type="text" class="form-control format-price regular_price text-sm" name="dataVariation[0][' .$value['id']. '][regular_price]" value='.$regular_price.' placeholder="Giá bán">
					</div>
					<div class="table-cell-content body-cell-content">
						<input type="text" class="form-control format-price sale_price text-sm" name="dataVariation[0][' .$value['id']. '][sale_price]" value='.$sale_price.' placeholder="Giá mới">
					</div>
					<div class="table-cell-content body-cell-content cell-option">
						<div class="custom-control custom-checkbox d-inline-block align-middle">
							<input type="checkbox" class="custom-control-input 0-'.$value['id'].'-checkbox" name="dataVariation[0]['.$value['id'].'][status]" id="0-'.$value['id'].'-checkbox" checked value="1">
							<label for="0-'.$value['id'].'-checkbox" class="custom-control-label"></label>
						</div>
					</div>
				</div>';
			}
		}
	}
	if(!empty($compareSizeRemove)){
		if(empty($size) && !empty($color)){
			$rowColor = $d->rawQuery("select namevi, id from #_color where find_in_set(id, ?) and type = ? and find_in_set('hienthi',status) order by numb,id desc", array($idColor, $type));
			foreach ($rowColor as $key => $value) {
				$htmlColor .= '<div class="variation-model-table-cell row-price variation-model-table-cell-' . $value['id'] . '-0 variation-model-table-cell-color-' . $value['id'] . ' variation-model-table-cell-size-0">
					<div class="table-cell-content body-cell-content cell-label">' . $value['namevi'] . '</div>
					<div class="table-cell-content body-cell-content cell-label"></div>
					<div class="table-cell-content body-cell-content">
						<input type="text" class="form-control format-price regular_price text-sm" name="dataVariation[' .$value['id']. '][0][regular_price]" value='.$regular_price.' placeholder="Giá bán">
					</div>
					<div class="table-cell-content body-cell-content">
						<input type="text" class="form-control format-price sale_price text-sm" name="dataVariation[' .$value['id']. '][0][sale_price]" value='.$sale_price.' placeholder="Giá mới">
					</div>
					<div class="table-cell-content body-cell-content cell-option">
						<div class="custom-control custom-checkbox d-inline-block align-middle">
							<input type="checkbox" class="custom-control-input '.$value['id'].'-0-checkbox" name="dataVariation['.$value['id'].'][0][status]" id="'.$value['id'].'-0-checkbox" checked value="1">
							<label for="'.$value['id'].'-0-checkbox" class="custom-control-label"></label>
						</div>
					</div>
				</div>';
			}
		}
	}

	$data = array('htmlColor' => $htmlColor, 'htmlSize' => $htmlSize, 'arrHtmlSize' => $arrHtmlSize);

	echo json_encode($data);
?>