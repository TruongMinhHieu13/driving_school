<?php   
if(!defined('SOURCES')) die("Error");

/* Kiểm tra active export */

switch($act)
{
    case "man":
    $template = "export/man/mans";
    break;

    case "exportExcel":
    exportExcelBC1();
    break;

    case "exportExcelBC2":
    exportExcelBC2();
    break;

    case "exportXMLBC1":
    exportXmlBc1();
    break;

    case "exportXMLBC2":
    exportXMLBC2();
    break;

    case "exportExcelTC":
    exportExcelTC();
    break;

    case "exportXMLTC":
    exportXMLTC();
    break;

    case "exportExcelCar":
    exportExcelCar();
    break;

    case "exportXMLCar":
    exportXMLCar();
    break;

    default:
    $template = "404";
}

function exportExcelBC1()
{
    global $d, $func, $act,$loginAdmin;

    /* Setting */
    $setting = $d->rawQueryOne("select * from #_setting limit 0,1");
    $optsetting = (!empty($setting['options']) && $setting['options'] != '') ? json_decode($setting['options'],true) : null;
    $quantitySucess = 0;

    if(!empty($_POST['exportExcel']) || 1)
    {
        /* PHPExcel */
        require_once LIBRARIES.'PHPExcel.php';

        /* Khởi tọa đối tượng */
        $PHPExcel = new PHPExcel();

        /* Khởi tạo thông tin người tạo */
        $PHPExcel->getProperties()->setCreator($setting['namevi']);
        $PHPExcel->getProperties()->setLastModifiedBy($setting['namevi']);
        $PHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
        $PHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
        $PHPExcel->getProperties()->setDescription("Document for Office 2007 XLSX, generated using PHP classes.");

        /* Khởi tạo mảng column */
        $alphas = range('A','Z');
        $alphas2 = range('A','Z');
        for ($i = 0; $i < 26 ; ++$i) {
            $tem = $alphas2[0].$alphas2[$i];
            array_push($alphas, $tem);
        }
        for ($i = 0; $i < 26 ; ++$i) {
            $tem = $alphas2[1].$alphas2[$i];
            array_push($alphas, $tem);
        }
        for ($i = 0; $i < 26 ; ++$i) {
            $tem = $alphas2[2].$alphas2[$i];
            array_push($alphas, $tem);
        }

        $array_columns = array('MA_GIAO_DICH'=>'MA_GIAO_DICH','MA_DV_GUI'=>'MA_DV_GUI','TEN_DV_GUI'=>'TEN_DV_GUI','NGAY_GUI'=>'NGAY_GUI','NGUOI_GUI'=>'NGUOI_GUI','TONG_SO_BAN_GHI'=>'TONG_SO_BAN_GHI','MA_BCI'=>'MA_BCI','MA_SO_GTVT'=>'MA_SO_GTVT','TEN_SO_GTVT'=>'TEN_SO_GTVT','MA_CSDT'=>'MA_CSDT','TEN_CSDT'=>'TEN_CSDT','MA_KHOA_HOC'=>'MA_KHOA_HOC','TEN_KHOA_HOC'=>'TEN_KHOA_HOC','MA_HANG_DAO_TAO'=>'MA_HANG_DAO_TAO','HANG_GPLX'=>'HANG_GPLX','SO_BCI'=>'SO_BCI','NGAY_BCI'=>'NGAY_BCI','LUU_LUONG'=>'LUU_LUONG','SO_HOC_SINH'=>'SO_HOC_SINH','NGAY_KHAI_GIANG'=>'NGAY_KHAI_GIANG','NGAY_BE_GIANG'=>'NGAY_BE_GIANG','SO_QD_KG'=>'SO_QD_KG','NGAY_QD_KG'=>'NGAY_QD_KG','NGAY_SAT_HACH'=>'NGAY_SAT_HACH','THOI_GIAN_DT'=>'THOI_GIAN_DT','SO_TT'=>'SO_TT','MA_DK'=>'MA_DK','HO_TEN_DEM'=>'HO_TEN_DEM','TEN'=>'TEN','HO_VA_TEN'=>'HO_VA_TEN','NGAY_SINH'=>'NGAY_SINH','MA_QUOC_TICH'=>'MA_QUOC_TICH','TEN_QUOC_TICH'=>'TEN_QUOC_TICH','NOI_TT'=>'NOI_TT','NOI_TT_MA_DVHC'=>'NOI_TT_MA_DVHC','NOI_TT_MA_DVQL'=>'NOI_TT_MA_DVQL','NOI_CT'=>'NOI_CT','NOI_CT_MA_DVHC'=>'NOI_CT_MA_DVHC','NOI_CT_MA_DVQL'=>'NOI_CT_MA_DVQL','SO_CMT'=>'SO_CMT','NGAY_CAP_CMT'=>'NGAY_CAP_CMT','NOI_CAP_CMT'=>'NOI_CAP_CMT','GIOI_TINH'=>'GIOI_TINH','HO_VA_TEN_IN'=>'HO_VA_TEN_IN','SO_CMND_CU'=>'SO_CMND_CU','SO_HO_SO'=>'SO_HO_SO','MA_DV_NHAN_HOSO'=>'MA_DV_NHAN_HOSO','TEN_DV_NHAN_HOSO'=>'TEN_DV_NHAN_HOSO','NGAY_NHAN_HOSO'=>'NGAY_NHAN_HOSO','NGUOI_NHAN_HOSO'=>'NGUOI_NHAN_HOSO','MA_LOAI_HOSO'=>'MA_LOAI_HOSO','TEN_LOAI_HOSO'=>'TEN_LOAI_HOSO','ANH_CHAN_DUNG'=>'ANH_CHAN_DUNG','CHAT_LUONG_ANH'=>'CHAT_LUONG_ANH','NGAY_THU_NHAN_ANH'=>'NGAY_THU_NHAN_ANH','NGUOI_THU_NHAN_ANH'=>'NGUOI_THU_NHAN_ANH','SO_GPLX_DA_CO'=>'SO_GPLX_DA_CO','HANG_GPLX_DA_CO'=>'HANG_GPLX_DA_CO','DV_CAP_GPLX_DACO'=>'DV_CAP_GPLX_DACO','TEN_DV_CAP_GPLX_DACO'=>'TEN_DV_CAP_GPLX_DACO','NOI_CAP_GPLX_DACO'=>'NOI_CAP_GPLX_DACO','NGAY_CAP_GPLX_DACO'=>'NGAY_CAP_GPLX_DACO','NGAY_HH_GPLX_DACO'=>'NGAY_HH_GPLX_DACO','NGAY_TT_GPLX_DACO'=>'NGAY_TT_GPLX_DACO','MA_NOI_HOC_LAIXE'=>'MA_NOI_HOC_LAIXE','TEN_NOI_HOC_LAIXE'=>'TEN_NOI_HOC_LAIXE','NAM_HOC_LAIXE'=>'NAM_HOC_LAIXE','SO_NAM_LAIXE'=>'SO_NAM_LAIXE','SO_KM_ANTOAN'=>'SO_KM_ANTOAN','GIAY_CNSK'=>'GIAY_CNSK','HINH_THUC_CAP'=>'HINH_THUC_CAP','HANG_GPLX2'=>'HANG_GPLX2','HANG_DAOTAO'=>'HANG_DAOTAO','CHON_IN_GPLX'=>'CHON_IN_GPLX','MA_GIAY_TO'=>'MA_GIAY_TO','TEN_GIAY_TO'=>'TEN_GIAY_TO');

        $array_header = array('MA_GIAO_DICH'=>'MA_GIAO_DICH','MA_DV_GUI'=>'MA_DV_GUI','TEN_DV_GUI'=>'TEN_DV_GUI','NGAY_GUI'=>'NGAY_GUI','NGUOI_GUI'=>'NGUOI_GUI','TONG_SO_BAN_GHI'=>'TONG_SO_BAN_GHI',);

        $array_courses = array('MA_BCI'=>'MA_BCI','MA_SO_GTVT'=>'MA_SO_GTVT','TEN_SO_GTVT'=>'TEN_SO_GTVT','MA_CSDT'=>'MA_CSDT','TEN_CSDT'=>'TEN_CSDT','MA_KHOA_HOC'=>'MA_KHOA_HOC','TEN_KHOA_HOC'=>'TEN_KHOA_HOC','MA_HANG_DAO_TAO'=>'MA_HANG_DAO_TAO','HANG_GPLX'=>'HANG_GPLX','SO_BCI'=>'SO_BCI','NGAY_BCI'=>'NGAY_BCI','LUU_LUONG'=>'LUU_LUONG','SO_HOC_SINH'=>'SO_HOC_SINH','NGAY_KHAI_GIANG'=>'NGAY_KHAI_GIANG','NGAY_BE_GIANG'=>'NGAY_BE_GIANG','SO_QD_KG'=>'SO_QD_KG','NGAY_QD_KG'=>'NGAY_QD_KG','NGAY_SAT_HACH'=>'NGAY_SAT_HACH','THOI_GIAN_DT'=>'THOI_GIAN_DT',);

        $array_info = array('HO_TEN_DEM'=>'HO_TEN_DEM','TEN'=>'TEN','NGAY_SINH'=>'NGAY_SINH','MA_QUOC_TICH'=>'MA_QUOC_TICH','TEN_QUOC_TICH'=>'TEN_QUOC_TICH','NOI_TT'=>'NOI_TT','NOI_TT_MA_DVHC'=>'NOI_TT_MA_DVHC','NOI_TT_MA_DVQL'=>'NOI_TT_MA_DVQL','NOI_CT'=>'NOI_CT','NOI_CT_MA_DVHC'=>'NOI_CT_MA_DVHC','NOI_CT_MA_DVQL'=>'NOI_CT_MA_DVQL','NGAY_CAP_CMT'=>'NGAY_CAP_CMT','NOI_CAP_CMT'=>'NOI_CAP_CMT','GIOI_TINH'=>'GIOI_TINH','HO_VA_TEN_IN'=>'HO_VA_TEN_IN','SO_CMND_CU'=>'SO_CMND_CU','SO_HO_SO'=>'SO_HO_SO','MA_DV_NHAN_HOSO'=>'MA_DV_NHAN_HOSO','TEN_DV_NHAN_HOSO'=>'TEN_DV_NHAN_HOSO','NGAY_NHAN_HOSO'=>'NGAY_NHAN_HOSO','NGUOI_NHAN_HOSO'=>'NGUOI_NHAN_HOSO','MA_LOAI_HOSO'=>'MA_LOAI_HOSO','TEN_LOAI_HOSO'=>'TEN_LOAI_HOSO','CHAT_LUONG_ANH'=>'CHAT_LUONG_ANH','NGAY_THU_NHAN_ANH'=>'NGAY_THU_NHAN_ANH','NGUOI_THU_NHAN_ANH'=>'NGUOI_THU_NHAN_ANH','SO_GPLX_DA_CO'=>'SO_GPLX_DA_CO','HANG_GPLX_DA_CO'=>'HANG_GPLX_DA_CO','DV_CAP_GPLX_DACO'=>'DV_CAP_GPLX_DACO','TEN_DV_CAP_GPLX_DACO'=>'TEN_DV_CAP_GPLX_DACO','NOI_CAP_GPLX_DACO'=>'NOI_CAP_GPLX_DACO','NGAY_CAP_GPLX_DACO'=>'NGAY_CAP_GPLX_DACO','NGAY_HH_GPLX_DACO'=>'NGAY_HH_GPLX_DACO','NGAY_TT_GPLX_DACO'=>'NGAY_TT_GPLX_DACO','MA_NOI_HOC_LAIXE'=>'MA_NOI_HOC_LAIXE','TEN_NOI_HOC_LAIXE'=>'TEN_NOI_HOC_LAIXE','NAM_HOC_LAIXE'=>'NAM_HOC_LAIXE','SO_NAM_LAIXE'=>'SO_NAM_LAIXE','SO_KM_ANTOAN'=>'SO_KM_ANTOAN','GIAY_CNSK'=>'GIAY_CNSK','HINH_THUC_CAP'=>'HINH_THUC_CAP','CHON_IN_GPLX'=>'CHON_IN_GPLX',);

        $array_info = array('HO_TEN_DEM','TEN','NGAY_SINH','MA_QUOC_TICH','TEN_QUOC_TICH','NOI_TT','NOI_TT_MA_DVHC','NOI_TT_MA_DVQL','NOI_CT','NOI_CT_MA_DVHC','NOI_CT_MA_DVQL','NGAY_CAP_CMT','NOI_CAP_CMT','GIOI_TINH','HO_VA_TEN_IN','SO_CMND_CU','SO_HO_SO','MA_DV_NHAN_HOSO','NGAY_NHAN_HOSO','NGUOI_NHAN_HOSO','MA_LOAI_HOSO','TEN_LOAI_HOSO','CHAT_LUONG_ANH','NGAY_THU_NHAN_ANH','DV_CAP_GPLX_DACO','TEN_DV_CAP_GPLX_DACO','NOI_CAP_GPLX_DACO','NGAY_CAP_GPLX_DACO','NGAY_HH_GPLX_DACO','NGAY_TT_GPLX_DACO','MA_NOI_HOC_LAIXE','NAM_HOC_LAIXE','SO_NAM_LAIXE','SO_KM_ANTOAN','GIAY_CNSK','HINH_THUC_CAP','CHON_IN_GPLX');

        /* Khởi tạo và style cho row đầu tiên */
        $i=0;
        foreach($array_columns as $k=>$v)
        {
            if($k=='MA_GIAO_DICH' || $k=='TEN_DV_GUI' || $k=='TEN_CSDT' || $k == 'MA_DK')
            {
                $PHPExcel->getActiveSheet()->getColumnDimension($alphas[$i])->setWidth(50);
            }elseif($k=='NGAY_GUI' || $k == 'TONG_SO_BAN_GHI' || $k == 'MA_KHOA_HOC' || $k == 'MA_KHOA_HOC'){
                $PHPExcel->getActiveSheet()->getColumnDimension($alphas[$i])->setWidth(35);
            }elseif($k=='ANH_CHAN_DUNG'){
                $PHPExcel->getActiveSheet()->getColumnDimension($alphas[$i])->setWidth(200);
            }elseif($k == 'TEN_GIAY_TO'){
                $PHPExcel->getActiveSheet()->getColumnDimension($alphas[$i])->setWidth(100);
            }else{
                $PHPExcel->getActiveSheet()->getColumnDimension($alphas[$i])->setWidth(30);
            }
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[$i].'1', $v);
            if($k == 'ANH_CHAN_DUNG'){
                $PHPExcel->getActiveSheet()->getStyle($alphas[$i].'1')->applyFromArray( array( 'font' => array( 'color' => array( 'rgb' => 'ffffff' ), 'name' => 'Calibri', 'bold' => true, 'italic' => false, 'size' => 11 ), 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'wrap' => false ),'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb'=>'5b9bd5'))));
            } else {
                $PHPExcel->getActiveSheet()->getStyle($alphas[$i].'1')->applyFromArray( array( 'font' => array( 'color' => array( 'rgb' => 'ffffff' ), 'name' => 'Calibri', 'bold' => true, 'italic' => false, 'size' => 11 ), 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'wrap' => false ),'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb'=>'5b9bd5'))));
            }
            $i++; 
        }
        /* Lấy và Xuất dữ liệu */
        $where = " ";
        $validate = (!empty($_GET)) ? $_GET : null;

        if (!empty($_REQUEST['date'])) {
            $where .= " JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.NGAY_RA_QDTN')) > 0";
            $where .= " and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.theory.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.geometry.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.cabin.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.dat.point')) > 0";
            $where .= " and (NOT JSON_CONTAINS_PATH(data_student, 'one', '$.KET_QUA_SH') OR JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) IS NULL OR JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) = '' OR JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) != 'DA') ";
        }

        if (!empty($_REQUEST['gplx'])) {
            $arrayGPLX = explode(",", $_REQUEST['gplx']);
            $where = $func->getCondition($arrayGPLX,'HANG_GPLX',$where);
        }

        if (!empty($_REQUEST['student-name'])) {
            $dataResult['student-name'] = explode(",", $_REQUEST['student-name']);
            $where = $func->getCondition($dataResult['student-name'],'HO_VA_TEN',$where);
        }

        if (!empty($_REQUEST['student-id'])) {
            $dataResult['student-id'] = explode(",", $_REQUEST['student-id']);
            $where = $func->getCondition( $dataResult['student-id'],'MA_DK',$where);
        }

        if ($_REQUEST['student-id'] == 0 && $_REQUEST['student-id'] != '') {
            (!empty($where) && $where == " " ? $where .= 'id <> 0' : $where);
            $where .= " and `MA_DK` = ''";
        }

        if (!empty($_REQUEST['student-cmt'])) {
            $dataResult['student-cmt'] = explode(",", $_REQUEST['student-cmt']);
            $where = $func->getCondition($dataResult['student-cmt'],'SO_CMT',$where);
        }

        if (!empty($_REQUEST['courses-name'])) {

            // Show data search
            $dataResult['courses-name'] = explode(",", $_REQUEST['courses-name']);
    
            $condition = '';
            foreach($dataResult['courses-name'] as $s => $vc){
                $condition .= ($s == 0 ? ' (' : ' or') ." TEN_KHOA_HOC = '".$vc."'";
            }
            $condition = $condition.")";
    
            // Lấy id khoá học
            $id_courses = $d->rawQuery("select MA_KHOA_HOC from #_courses where ".$condition);
            if(!empty($id_courses)){
                $where = $func->getCondition($id_courses,'MA_KHOA_HOC',$where);
            }else {
                (!empty($where) && $where == " " ? $where .= 'id <> 0' : $where);
                $where .= ' and  numb < 0';
            }
        }

    if (!empty($date_open)) {
        $date_open = explode("-", $date_open);
        $date_from = trim($date_open[0] . ' 12:00:00 AM');
        $date_to = trim($date_open[1] . ' 11:59:59 PM');
        $date_from = strtotime(str_replace("/", "-", $date_from));
        $date_to = strtotime(str_replace("/", "-", $date_to));
        $whereCourses .= " and NGAY_KHAI_GIANG<=$date_to and NGAY_KHAI_GIANG>=$date_from";
    }

    if (!empty($date_close)) {
        $date_close = explode("-", $date_close);
        $date_from = trim($date_close[0] . ' 12:00:00 AM');
        $date_to = trim($date_close[1] . ' 11:59:59 PM');
        $date_from = strtotime(str_replace("/", "-", $date_from));
        $date_to = strtotime(str_replace("/", "-", $date_to));
        $whereCourses .= " and NGAY_BE_GIANG<=$date_to and NGAY_BE_GIANG>=$date_from";
    }

    if (!empty($date_sh)) {
        $date_sh = explode("-", $date_sh);
        $date_from = trim($date_sh[0] . ' 12:00:00 AM');
        $date_to = trim($date_sh[1] . ' 11:59:59 PM');
        $date_from = strtotime(str_replace("/", "-", $date_from));
        $date_to = strtotime(str_replace("/", "-", $date_to));
        $whereCourses .= " and NGAY_SAT_HACH<=$date_to and NGAY_SAT_HACH>=$date_from";
    } 

    $statusGraduate = (!empty($_REQUEST['graduate-status']) ? $_REQUEST['graduate-status'] : 0);
    $statusTest = (!empty($_REQUEST['test-status']) ? $_REQUEST['test-status'] : 0);
    $result_bc2 = (!empty($_REQUEST['result-bc2']) ? $_REQUEST['result-bc2'] : 0);

    if (!empty($result_bc2) && $result_bc2 == 1) {
        (!empty($where) && $where == " " ? $where .= 'id <> 0' : $where);
        $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KQ_BC2')) = 1";
    }
    if (!empty($result_bc2) && $result_bc2 == 2) {
        (!empty($where) && $where == " " ? $where .= 'id <> 0' : $where);
        $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KQ_BC2')) = 0";
    }

    if (!empty($statusGraduate) && $statusGraduate > 0) {
        (!empty($where) && $where == " " ? $where .= 'id <> 0' : $where);
        $where .= " and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.theory.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.geometry.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.cabin.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.dat.point')) > 0";
    }

    if (!empty($statusTest)) {
        if($statusTest == 1) $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) = 'DA'";
        elseif($statusTest == 3) $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) = 'KDDK'";
        elseif($statusTest == 2) $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) != 'KDDK' and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) != 'DA'";
    }

    if (!empty($whereCourses) && $whereCourses != '') {
        // Lấy id khoá học
        $idCourses = $d->rawQuery("select MA_KHOA_HOC from #_courses where id <> 0 ".$whereCourses);

        if(!empty($idCourses)){
            $where = $func->getCondition($id_courses,'MA_KHOA_HOC',$where, false);
        }else {
            (!empty($where) && $where == " " ? $where .= 'id <> 0' : $where);
            $where .= ' and  numb < 0';
        }
    }

    // Khỏi tạo mảng tên file excel để xíu nén lại tải xuống
    $files_to_zip = array();
    // Lấy course ID
    if ($where == " ") $where .= " id <> 0 ";

    $courseID = $d->rawQuery("select MA_KHOA_HOC from #_student where $where group by MA_KHOA_HOC");

    if (!empty($courseID)) {
        foreach($courseID as $n => $course){
            if (!empty($course['MA_KHOA_HOC'])) {
                $student = $d->rawQuery("select * from #_student where $where and MA_KHOA_HOC = ? order by SO_TT asc", array($course['MA_KHOA_HOC']));

                $quantitySucess += count($student);

                if (!empty($student)) {
                    $position=2;
                    for($i=0;$i<count($student);$i++)
                    {
                        
                        $optstudent = (!empty($student[$i]['data_student']) && $student[$i]['data_student'] != '') ? json_decode($student[$i]['data_student'],true) : null;

                        $optgiayto = (!empty($student[$i]['data_hoso']) && $student[$i]['data_hoso'] != '') ? json_decode($student[$i]['data_hoso'],true) : null;

                        /* Lấy data từ MA_KHOA_HOC */
                        $dataCoursesBC1 = $d->rawQueryOne("select * from #_courses where MA_KHOA_HOC = ? limit 1 ", array($course['MA_KHOA_HOC']));
                        foreach($optgiayto['GIAY_TO'] as $row => $giayto){
                            $j=0;
                           foreach($array_columns as $k=>$v)
                            {
                                if(in_array($k,$array_header)){

                                    $header = json_decode($dataCoursesBC1['data_header'],true);
                                    $datacell = $header[$k]; 

                                }elseif(in_array($k,$array_courses)){

                                    $courses = json_decode($dataCoursesBC1['data_courses'],true);
                                    if($k == 'MA_KHOA_HOC' || $k == 'TEN_KHOA_HOC' || $k == 'MA_HANG_DAO_TAO' || $k == 'SO_QD_KG'){
                                        $datacell = $dataCoursesBC1[$k]; 
                                    } elseif ($k == 'NGAY_KHAI_GIANG' || $k == 'NGAY_BE_GIANG' || $k == 'NGAY_SAT_HACH'){
                                        if(!empty($dataCoursesBC1[$k]) && $dataCoursesBC1[$k] > 0) $datacell = date('Y-m-d',$dataCoursesBC1[$k]); 
                                    }elseif ($k == 'HANG_GPLX'){
                                        $datacell = $dataCoursesBC1['MA_HANG_DAO_TAO'];  
                                    }else{
                                        $datacell = $courses[$k];
                                    }

                                }elseif(in_array($k,$array_info)){

                                    if ($k == 'NGAY_THU_NHAN_ANH' || $k == 'NOI_CAP_CMT' || $k == 'NGAY_NHAN_HOSO') {
                                        $datacell = (!empty($optstudent[$k])) ? date('Y-m-d',$optstudent[$k]) : '';
                                    } elseif($k == 'NGAY_SINH' || $k == 'NGAY_CAP_GPLX_DACO' || $k == 'NGAY_HH_GPLX_DACO' || $k == 'NGAY_TT_GPLX_DACO') {
                                        $date = (!empty($optstudent[$k])) ? date('Y-m-d',$optstudent[$k]) : '';
                                        $datacell = str_replace("-", "", $date);
                                    } else {
                                        $datacell = $optstudent[$k]; 
                                    }
                                } elseif($k == 'HANG_GPLX2') {
                                    $datacell = $student[$i]["HANG_DAOTAO"];
                                } elseif($k == 'TEN_GIAY_TO' || $k == 'MA_GIAY_TO') {
                                    $datacell = $giayto[$k];
                                } else {
                                    $datacell = $student[$i][$k];
                                }
                                $PHPExcel->setActiveSheetIndex(0)->setCellValueExplicit($alphas[$j].$position, htmlspecialchars_decode($datacell),PHPExcel_Cell_DataType::TYPE_STRING);
                                $j++;
                            }
                            $position++;
                        }
                    }

                    /* Style cho các row dữ liệu */
                    $position=2;
                    for($i=0;$i<count($student);$i++)
                    {
                        $j=0;
                        foreach($array_columns as $k=>$v)
                        {
                            $PHPExcel->getActiveSheet()->getStyle($alphas[$j].$position)->applyFromArray(
                                array( 
                                    'font' => array( 
                                        'color' => array('rgb' => '000000'), 
                                        'name' => 'Calibri', 
                                        'bold' => false, 
                                        'italic' => false, 
                                        'size' => 11 
                                    ), 
                                    'alignment' => array( 
                                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 
                                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 
                                        'wrap' => false 
                                    )
                                )
                            );
                            $j++;
                        }
                        $position++;
                    }
                }

                /* Rename title */
                $PHPExcel->getActiveSheet()->setTitle('DSHV');

                /* Khởi tạo chỉ mục ở đầu sheet */
                $PHPExcel->setActiveSheetIndex(0);

                /* Xuất file */
                $time = time();
                $nameFile = $d->rawQueryOne("select TEN_KHOA_HOC from #_courses where MA_KHOA_HOC = ? limit 0,1", array($course['MA_KHOA_HOC']));
                $filename="BC1-".$nameFile['TEN_KHOA_HOC'].(!empty($nameFile['TEN_KHOA_HOC']) ? '-' : '').$time.".xlsx";
                $objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel2007');
                $objWriter->save($filename);
                array_push($files_to_zip,$filename);

                $highestRow = $PHPExcel->getActiveSheet()->getHighestRow();

                for ($row = $highestRow; $row >= 2; $row--) {
                    $PHPExcel->getActiveSheet()->removeRow($row);
                }
                
            }
        }
    }

    // Lấy DS theo HANG_GPLX và chưa có MA_KHOA_HOC
    $gplxID = $d->rawQuery("select HANG_GPLX from #_student where $where group by HANG_GPLX");
    foreach($gplxID as $n => $course){
        if (!empty($course['HANG_GPLX'])) {
            $student = $d->rawQuery("select * from #_student where ($where) and HANG_GPLX = ? and MA_KHOA_HOC = '' and MA_KHOA_HOC IS NULL order by numb,id desc", array($course['HANG_GPLX']));
            $quantitySucess += count($student);
            if (!empty($student)) {
                $position=2;
                for($i=0;$i<count($student);$i++)
                {
                    $j=0;
                    $optstudent = (!empty($student[$i]['data_student']) && $student[$i]['data_student'] != '') ? json_decode($student[$i]['data_student'],true) : null;

                    foreach($array_columns as $k=>$v)
                    {
                        if(in_array($k,$array_info)){
                            if ($k == 'NGAY_SINH' || $k == 'NGAY_THU_NHAN_ANH' || $k == 'NOI_CAP_CMT' || $k == 'NGAY_NHAN_HOSO' || $k == 'NGAY_CAP_GPLX_DACO' || $k == 'NGAY_CAP_CMT' || $k == 'NGAY_HH_GPLX_DACO' || $k == 'NGAY_TT_GPLX_DACO') {
                                $datacell = (!empty($optstudent[$k])) ? date('Y-m-d',$optstudent[$k]) : '';
                            } else {
                                $datacell = $optstudent[$k]; 
                            }
                        }
                        elseif($k=='HANG_GPLX')
                        {
                            $namegplx = $d->rawQueryOne("select namevi from #_gplx where id = ? limit 0,1",array($student[$i][$k]));
                            $datacell = (!empty($namegplx['namevi'])) ? $namegplx['namevi'] : '';
                        } else {
                            $datacell = $student[$i][$k];
                        }
                        $PHPExcel->setActiveSheetIndex(0)->setCellValueExplicit($alphas[$j].$position, htmlspecialchars_decode($datacell),PHPExcel_Cell_DataType::TYPE_STRING);
                        $j++;
                    }
                    $position++;
                }

                /* Style cho các row dữ liệu */
                $position=2;
                for($i=0;$i<count($student);$i++)
                {
                    $j=0;
                    foreach($array_columns as $k=>$v)
                    {
                        $PHPExcel->getActiveSheet()->getStyle($alphas[$j].$position)->applyFromArray(
                            array( 
                                'font' => array( 
                                    'color' => array('rgb' => '000000'), 
                                    'name' => 'Calibri', 
                                    'bold' => false, 
                                    'italic' => false, 
                                    'size' => 11 
                                ), 
                                'alignment' => array( 
                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 
                                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 
                                    'wrap' => true 
                                )
                            )
                        );
                        $j++;
                    }
                    $position++;
                }

                /* Rename title */
                $PHPExcel->getActiveSheet()->setTitle('DSHV');

                /* Khởi tạo chỉ mục ở đầu sheet */
                $PHPExcel->setActiveSheetIndex(0);

                /* Xuất file */
                $time = time();
                $filename="BC1-".$func->getInfoDetail('namevi','gplx',$course['HANG_GPLX'])['namevi']."-".$time.".xlsx";
                $objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel2007');
                $objWriter->save($filename);
                array_push($files_to_zip,$filename);
                $highestRow = $PHPExcel->getActiveSheet()->getHighestRow();

                for ($row = $highestRow; $row >= 2; $row--) {
                    $PHPExcel->getActiveSheet()->removeRow($row);
                }
            }
        }
    }
    if ($quantitySucess == 0) {
        foreach ($files_to_zip as $file) {
            if (file_exists($file)) {
               unlink($file);
           }
       }
       $func->transfer("Không tồn tại học viên hợp lệ !!!","index.php?com=student&act=man&fill=man",false);
   }

   $zip = new ZipArchive();
   $filename = "BC1-EXCEL-".time().".zip";

   if ($zip->open($filename, ZipArchive::CREATE) !== TRUE) {
    exit("Không thể mở file <$filename>\n");
}

foreach ($files_to_zip as $file) {
    if (file_exists($file)) {
        $zip->addFile($file, basename($file));
    } else {
        echo "File không tồn tại: $file\n";
    }
}

$zip->close();

            // Lưu lại lịch sử
$dataHistory['namevi'] = '';
$dataHistory['descvi'] = 'Export File Excel báo cáo 1';
$dataHistory['file'] = $filename;
$dataHistory['type'] = 'export-excel-bc1';
$dataHistory['quantity'] = $quantitySucess;
$dataHistory['date_created'] = time();
$dataHistory['id_downloader'] = $_SESSION[$loginAdmin]['id'];
$dataHistory['downloads'] = 1;
$d->insert('user_operation', $dataHistory);

            // Gửi file xuống trình duyệt
header('Content-Type: application/zip');
header('Content-disposition: attachment; filename='.$filename);
header('Content-Length: ' . filesize($filename));
readfile($filename);

            // Xoá file zip sau khi tải xuống
            // unlink($filename);

            // Chuyển file vào thư mục lưu lại
rename($filename, UPLOAD_FILE.'operation/'.$filename);

foreach ($files_to_zip as $file) {
    if (file_exists($file)) {
     unlink($file);
 }
}

exit;
}
else
{
    $func->transfer("Dữ liệu rỗng", "index.php?com=student&act=man", false);
}
}

function exportXmlBc1() {
    global $d, $func, $loginAdmin;

    /* Lấy và Xuất dữ liệu */
    $where = "";    
    $validate = (!empty($_GET)) ? $_GET : null;


    if (!empty($_REQUEST['date'])) {
        $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.NGAY_RA_QDTN')) > 0";
        $where .= " and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.theory.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.geometry.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.cabin.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.dat.point')) > 0";
        $where .= " and (NOT JSON_CONTAINS_PATH(data_student, 'one', '$.KET_QUA_SH') OR JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) IS NULL OR JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) = '' OR JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) != 'DA') ";
    }

    if (!empty($_REQUEST['courses-id'])) {
        // Show data search
        $dataResult['courses_id'] = explode(",", $_REQUEST['courses-id']);

        foreach($dataResult['courses_id'] as $s => $vc){
            $where .= ($s == 0 ? ' and (' : ' or') ." MA_KHOA_HOC = '".$vc."'";
        }
        $where = $where.")";
    }

    if (!empty($_REQUEST['gplx'])) {
        $arrayGPLX = explode(",", $_REQUEST['gplx']);

        foreach($arrayGPLX as $s => $v){
            $where .= ($s == 0 ? ' and (' : ' or') ." HANG_GPLX = '".$v."'";
        }
        $where = $where.")";
    }

    if (!empty($_REQUEST['student-name'])) {
        $dataResult['student-name'] = explode(",", $_REQUEST['student-name']);

        foreach($dataResult['student-name'] as $s => $vc){
            $where .= ($s == 0 ? ' and (' : ' or') ." HO_VA_TEN LIKE '%".$vc."%'";
        }
        $where = $where.")";
    }


    if (!empty($_REQUEST['student-id'])) {
        $dataResult['student-id'] = explode(",", $_REQUEST['student-id']);

        foreach($dataResult['student-id'] as $s => $vc){
            $where .= ($s == 0 ? ' and (' : ' or') ." MA_DK = '".$vc."'";
        }
        $where = $where.")";
    }

    if ($_REQUEST['student-id'] == 0 && $_REQUEST['student-id'] != '') {
        $where .= " and `MA_DK` = '' ";
    }


    if (!empty($_REQUEST['student-cmt'])) {
        $dataResult['student-cmt'] = explode(",", $_REQUEST['student-cmt']);

        foreach($dataResult['student-cmt'] as $s => $vc){
            $where .= ($s == 0 ? ' and (' : ' or') ." SO_CMT = '".$vc."'";
        }
        $where = $where.")";
    }

    if (!empty($_REQUEST['courses-name'])) {
                // Show data search
        $dataResult['courses-name'] = explode(",", $_REQUEST['courses-name']);

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
    if (!empty($date_open)) {
        $date_open = explode("-", $date_open);
        $date_from = trim($date_open[0] . ' 12:00:00 AM');
        $date_to = trim($date_open[1] . ' 11:59:59 PM');
        $date_from = strtotime(str_replace("/", "-", $date_from));
        $date_to = strtotime(str_replace("/", "-", $date_to));
        $whereCourses .= " and NGAY_KHAI_GIANG<=$date_to and NGAY_KHAI_GIANG>=$date_from";
    }

    if (!empty($date_close)) {
        $date_close = explode("-", $date_close);
        $date_from = trim($date_close[0] . ' 12:00:00 AM');
        $date_to = trim($date_close[1] . ' 11:59:59 PM');
        $date_from = strtotime(str_replace("/", "-", $date_from));
        $date_to = strtotime(str_replace("/", "-", $date_to));
        $whereCourses .= " and NGAY_BE_GIANG<=$date_to and NGAY_BE_GIANG>=$date_from";
    }

    if (!empty($date_sh)) {
        $date_sh = explode("-", $date_sh);
        $date_from = trim($date_sh[0] . ' 12:00:00 AM');
        $date_to = trim($date_sh[1] . ' 11:59:59 PM');
        $date_from = strtotime(str_replace("/", "-", $date_from));
        $date_to = strtotime(str_replace("/", "-", $date_to));
        $whereCourses .= " and NGAY_SAT_HACH<=$date_to and NGAY_SAT_HACH>=$date_from";
    } 

    $statusGraduate = (!empty($_REQUEST['graduate-status']) ? $_REQUEST['graduate-status'] : 0);
    $statusTest = (!empty($_REQUEST['test-status']) ? $_REQUEST['test-status'] : 0);
    $result_bc2 = (!empty($_REQUEST['result-bc2']) ? $_REQUEST['result-bc2'] : 0);

    if (!empty($result_bc2) && $result_bc2 == 1) {
        $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KQ_BC2')) = 1";
    }
    if (!empty($result_bc2) && $result_bc2 == 2) {
        $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KQ_BC2')) = 0";
    }

    if (!empty($statusGraduate) && $statusGraduate > 0) {
        $where .= " and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.theory.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.geometry.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.cabin.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.dat.point')) > 0";
    }

    if (!empty($statusTest)) {
        if($statusTest == 1) $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) = 'DA'";
        elseif($statusTest == 3) $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) = 'KDDK'";
        elseif($statusTest == 2) $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) != 'KDDK' and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) != 'DA'";
    }

    if (!empty($whereCourses) && $whereCourses != '') {

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

    



    // Khỏi tạo mảng tên file xml để xíu nén lại tải xuống
    $files_to_zip = array();
    $quantitySucess = 0;
    
    // Lấy DS theo khoá học
    // Lấy course ID
    
    $courseID = $d->rawQuery("select MA_KHOA_HOC from #_student where id <> 0 $where group by MA_KHOA_HOC");

    foreach ($courseID as $n => $courses) {
        if(!empty($courses['MA_KHOA_HOC'])){
            $courseIn4 = $d->rawQueryOne("select * from #_courses where MA_KHOA_HOC = '".$courses['MA_KHOA_HOC']."'");
            $courseHeader = json_decode($courseIn4['data_header'],true);
            $courseData = json_decode($courseIn4['data_courses'],true);

                 // Lấy danh sách người LX
            $listStudent = $d->rawQuery("select * from #_student where id <> 0 $where and MA_KHOA_HOC = '".$courses['MA_KHOA_HOC']."'");


            if (!empty($listStudent)) {
                $quantitySucess += count($listStudent);

                    // Tạo một đối tượng DOMDocument mới
                $dom = new DOMDocument('1.0', 'UTF-8');

                    // Tạo phần tử gốc
                $bao_cao1 = $dom->createElement('BAO_CAO1');
                $dom->appendChild($bao_cao1);



                    // Tạo phần tử HEADER
                $header = $dom->createElement('HEADER');
                $bao_cao1->appendChild($header);

                    // Thêm các phần tử con vào HEADER
                $header->appendChild($dom->createElement('MA_GIAO_DICH', !empty($courseHeader['MA_GIAO_DICH']) ? $courseHeader['MA_GIAO_DICH'] : ''));
                $header->appendChild($dom->createElement('MA_DV_GUI', '79038'));
                $header->appendChild($dom->createElement('TEN_DV_GUI', 'Trung Tâm Giáo Dục Nghề Nghiệp Lái Xe Tiến Đạt'));
                $header->appendChild($dom->createElement('NGAY_GUI', date('Y-m-d H:i:s')));
                $header->appendChild($dom->createElement('NGUOI_GUI', 'ADMIN'));
                $header->appendChild($dom->createElement('TONG_SO_BAN_GHI', count($listStudent)));


                    // Tạo phần tử DATA
                $data = $dom->createElement('DATA');
                $bao_cao1->appendChild($data);

                    // Tạo phần tử KHOA_HOC
                $khoa_hoc = $dom->createElement('KHOA_HOC');
                $data->appendChild($khoa_hoc);

                    // Thêm các phần tử con vào KHOA_HOC
                $khoa_hoc->appendChild($dom->createElement('MA_BCI', !empty($courseData['MA_BCI']) ? $courseData['MA_BCI'] : ''));
                $khoa_hoc->appendChild($dom->createElement('MA_SO_GTVT', !empty($courseData['MA_SO_GTVT']) ? $courseData['MA_SO_GTVT'] : ''));
                $khoa_hoc->appendChild($dom->createElement('TEN_SO_GTVT', !empty($courseData['TEN_SO_GTVT']) ? $courseData['TEN_SO_GTVT'] : ''));
                $khoa_hoc->appendChild($dom->createElement('MA_CSDT', !empty($courseData['MA_CSDT']) ? $courseData['MA_CSDT'] : ''));
                $khoa_hoc->appendChild($dom->createElement('TEN_CSDT', !empty($courseData['TEN_CSDT']) ? $courseData['TEN_CSDT'] : ''));
                $khoa_hoc->appendChild($dom->createElement('MA_KHOA_HOC', !empty($courseIn4['MA_KHOA_HOC']) ? $courseIn4['MA_KHOA_HOC'] : ''));
                $khoa_hoc->appendChild($dom->createElement('TEN_KHOA_HOC', !empty($courseIn4['TEN_KHOA_HOC']) ? $courseIn4['TEN_KHOA_HOC'] : ''));
                $khoa_hoc->appendChild($dom->createElement('MA_HANG_DAO_TAO', !empty($courseIn4['MA_HANG_DAO_TAO']) ? $courseIn4['MA_HANG_DAO_TAO'] : ''));
                $khoa_hoc->appendChild($dom->createElement('HANG_GPLX', !empty($courseIn4['MA_HANG_DAO_TAO']) ? $courseIn4['MA_HANG_DAO_TAO'] : ''));
                $khoa_hoc->appendChild($dom->createElement('SO_BCI', !empty($courseData['SO_BCI']) ? $courseData['SO_BCI'] : ''));
                $khoa_hoc->appendChild($dom->createElement('NGAY_BCI', !empty($courseData['NGAY_BCI']) ? $courseData['NGAY_BCI'] : ''));
                $khoa_hoc->appendChild($dom->createElement('LUU_LUONG', !empty($courseData['LUU_LUONG']) ? $courseData['LUU_LUONG'] : ''));
                $khoa_hoc->appendChild($dom->createElement('SO_HOC_SINH', !empty($courseData['SO_HOC_SINH']) ? $courseData['SO_HOC_SINH'] : ''));
                $khoa_hoc->appendChild($dom->createElement('NGAY_KHAI_GIANG', !empty($courseIn4['NGAY_KHAI_GIANG']) ? date('Y-m-d', $courseIn4['NGAY_KHAI_GIANG']) : ''));
                $khoa_hoc->appendChild($dom->createElement('NGAY_BE_GIANG', !empty($courseIn4['NGAY_BE_GIANG']) ? date('Y-m-d', $courseIn4['NGAY_BE_GIANG']) : ''));
                $khoa_hoc->appendChild($dom->createElement('SO_QD_KG', !empty($courseIn4['SO_QD_KG']) ? $courseIn4['SO_QD_KG'] : ''));
                $khoa_hoc->appendChild($dom->createElement('NGAY_QD_KG', !empty($courseData['NGAY_QD_KG']) ? date('Y-m-d', $courseData['NGAY_QD_KG']) : ''));
                $khoa_hoc->appendChild($dom->createElement('NGAY_SAT_HACH', !empty($courseIn4['NGAY_SAT_HACH']) ? date('Y-m-d', $courseIn4['NGAY_SAT_HACH']) : ''));
                $khoa_hoc->appendChild($dom->createElement('THOI_GIAN_DT', !empty($courseData['THOI_GIAN_DT']) ? $courseData['THOI_GIAN_DT'] : ''));


                    // Tạo phần tử NGUOI_LXS
                $nguoi_lxs = $dom->createElement('NGUOI_LXS');
                $data->appendChild($nguoi_lxs);


                    // Tạo phần tử NGUOI_LX

                foreach ($listStudent as $numb => $v) {
                    $data_student = json_decode($v['data_student'],true);

                    $numb = $numb + 1;

                    ${'nguoi_lx' . ($numb)} = $dom->createElement('NGUOI_LX');
                    $nguoi_lxs->appendChild(${'nguoi_lx' . ($numb)});

                        // Thêm các phần tử con vào NGUOI_LX
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('SO_TT', !empty($v['SO_TT']) ? $v['SO_TT'] : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('MA_DK', !empty($v['MA_DK']) ? $v['MA_DK'] : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('HO_TEN_DEM', !empty($data_student['HO_TEN_DEM']) ? $data_student['HO_TEN_DEM'] : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('TEN', !empty($data_student['TEN']) ? $data_student['TEN'] : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('HO_VA_TEN', !empty($v['HO_VA_TEN']) ? $v['HO_VA_TEN'] : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('NGAY_SINH', !empty($data_student['NGAY_SINH']) ? $func->formatDateString(date('Y-m-d', $data_student['NGAY_SINH'])) : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('MA_QUOC_TICH', !empty($data_student['MA_QUOC_TICH']) ? $data_student['MA_QUOC_TICH'] : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('TEN_QUOC_TICH', !empty($data_student['TEN_QUOC_TICH']) ? $data_student['TEN_QUOC_TICH'] : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('NOI_TT', !empty($data_student['NOI_TT']) ? $data_student['NOI_TT'] : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('NOI_TT_MA_DVHC', !empty($data_student['NOI_TT_MA_DVHC']) ? $data_student['NOI_TT_MA_DVHC'] : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('NOI_TT_MA_DVQL', !empty($data_student['NOI_TT_MA_DVQL']) ? $data_student['NOI_TT_MA_DVQL'] : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('NOI_CT', !empty($data_student['NOI_CT']) ? $data_student['NOI_CT'] : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('NOI_CT_MA_DVHC', !empty($data_student['NOI_CT_MA_DVHC']) ? $data_student['NOI_CT_MA_DVHC'] : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('NOI_CT_MA_DVQL', !empty($data_student['NOI_CT_MA_DVQL']) ? $data_student['NOI_CT_MA_DVQL'] : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('SO_CMT', !empty($v['SO_CMT']) ? $v['SO_CMT'] : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('NGAY_CAP_CMT', !empty($data_student['NGAY_CAP_CMT']) ? date('Y-m-d', $data_student['NGAY_CAP_CMT']) : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('NOI_CAP_CMT', !empty($data_student['NOI_CAP_CMT']) ? $data_student['NOI_CAP_CMT'] : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('GIOI_TINH', !empty($data_student['GIOI_TINH']) ? $data_student['GIOI_TINH'] : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('HO_VA_TEN_IN', !empty($data_student['HO_VA_TEN_IN']) ? $data_student['HO_VA_TEN_IN'] : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('SO_CMND_CU', !empty($data_student['SO_CMND_CU']) ? $data_student['SO_CMND_CU'] : ''));


                        // Tạo phần tử HO_SO
                    $ho_so = $dom->createElement('HO_SO');
                    ${'nguoi_lx' . ($numb)}->appendChild($ho_so);

                        // Thêm các phần tử con vào HO_SO
                    $ho_so->appendChild($dom->createElement('SO_HO_SO', !empty($data_student['SO_HO_SO']) ? $data_student['SO_HO_SO'] : ''));
                    $ho_so->appendChild($dom->createElement('MA_DV_NHAN_HOSO', !empty($data_student['MA_DV_NHAN_HOSO']) ? $data_student['MA_DV_NHAN_HOSO'] : ''));
                    $ho_so->appendChild($dom->createElement('TEN_DV_NHAN_HOSO', !empty($data_student['TEN_DV_NHAN_HOSO']) ? $data_student['TEN_DV_NHAN_HOSO'] : ''));
                    $ho_so->appendChild($dom->createElement('NGAY_NHAN_HOSO', !empty($data_student['NGAY_NHAN_HOSO']) ? date('Y-m-d', $data_student['NGAY_NHAN_HOSO']) : ''));
                    $ho_so->appendChild($dom->createElement('NGUOI_NHAN_HOSO', !empty($data_student['NGUOI_NHAN_HOSO']) ? $data_student['NGUOI_NHAN_HOSO'] : ''));
                    $ho_so->appendChild($dom->createElement('MA_LOAI_HOSO', !empty($data_student['MA_LOAI_HOSO']) ? $data_student['MA_LOAI_HOSO'] : ''));
                    $ho_so->appendChild($dom->createElement('TEN_LOAI_HOSO', !empty($data_student['TEN_LOAI_HOSO']) ? $data_student['TEN_LOAI_HOSO'] : ''));
                    $ho_so->appendChild($dom->createElement('ANH_CHAN_DUNG', !empty($v['ANH_CHAN_DUNG']) ? $v['ANH_CHAN_DUNG'] : ''));
                    $ho_so->appendChild($dom->createElement('CHAT_LUONG_ANH', !empty($data_student['CHAT_LUONG_ANH']) ? $data_student['CHAT_LUONG_ANH'] : ''));
                    $ho_so->appendChild($dom->createElement('NGAY_THU_NHAN_ANH', !empty($data_student['NGAY_THU_NHAN_ANH']) ? $data_student['NGAY_THU_NHAN_ANH'] : ''));
                    $ho_so->appendChild($dom->createElement('NGUOI_THU_NHAN_ANH', !empty($data_student['NGUOI_THU_NHAN_ANH']) ? $data_student['NGUOI_THU_NHAN_ANH'] : ''));
                    $ho_so->appendChild($dom->createElement('SO_GPLX_DA_CO', !empty($data_student['SO_GPLX_DA_CO']) ? $data_student['SO_GPLX_DA_CO'] : ''));
                    $ho_so->appendChild($dom->createElement('HANG_GPLX_DA_CO', !empty($data_student['HANG_GPLX_DA_CO']) ? $data_student['HANG_GPLX_DA_CO'] : ''));
                    $ho_so->appendChild($dom->createElement('DV_CAP_GPLX_DACO', !empty($data_student['DV_CAP_GPLX_DACO']) ? $data_student['DV_CAP_GPLX_DACO'] : ''));
                    $ho_so->appendChild($dom->createElement('TEN_DV_CAP_GPLX_DACO', !empty($data_student['TEN_DV_CAP_GPLX_DACO']) ? $data_student['TEN_DV_CAP_GPLX_DACO'] : ''));
                    $ho_so->appendChild($dom->createElement('NOI_CAP_GPLX_DACO', !empty($data_student['NOI_CAP_GPLX_DACO']) ? $data_student['NOI_CAP_GPLX_DACO'] : ''));
                    $ho_so->appendChild($dom->createElement('NGAY_CAP_GPLX_DACO', !empty($data_student['NGAY_CAP_GPLX_DACO']) ? $data_student['NGAY_CAP_GPLX_DACO'] : ''));
                    $ho_so->appendChild($dom->createElement('NGAY_HH_GPLX_DACO', !empty($data_student['NGAY_HH_GPLX_DACO']) ? $data_student['NGAY_HH_GPLX_DACO'] : ''));
                    $ho_so->appendChild($dom->createElement('NGAY_TT_GPLX_DACO', !empty($data_student['NGAY_TT_GPLX_DACO']) ? $data_student['NGAY_TT_GPLX_DACO'] : ''));
                    $ho_so->appendChild($dom->createElement('MA_NOI_HOC_LAIXE', !empty($data_student['MA_NOI_HOC_LAIXE']) ? $data_student['MA_NOI_HOC_LAIXE'] : ''));
                    $ho_so->appendChild($dom->createElement('TEN_NOI_HOC_LAIXE', !empty($data_student['TEN_NOI_HOC_LAIXE']) ? $data_student['TEN_NOI_HOC_LAIXE'] : ''));
                    $ho_so->appendChild($dom->createElement('NAM_HOC_LAIXE', !empty($data_student['NAM_HOC_LAIXE']) ? $data_student['NAM_HOC_LAIXE'] : ''));
                    $ho_so->appendChild($dom->createElement('SO_NAM_LAIXE', !empty($data_student['SO_NAM_LAIXE']) ? $data_student['SO_NAM_LAIXE'] : 0));
                    $ho_so->appendChild($dom->createElement('SO_KM_ANTOAN', !empty($data_student['SO_KM_ANTOAN']) ? $data_student['SO_KM_ANTOAN'] : 0));
                    $ho_so->appendChild($dom->createElement('GIAY_CNSK', !empty($data_student['GIAY_CNSK']) ? $data_student['GIAY_CNSK'] : ''));
                    $ho_so->appendChild($dom->createElement('HINH_THUC_CAP', !empty($data_student['HINH_THUC_CAP']) ? $data_student['HINH_THUC_CAP'] : ''));
                    $ho_so->appendChild($dom->createElement('HANG_GPLX', !empty($v['HANG_GPLX']) ? $func->getColDetail('namevi','gplx',$v['HANG_GPLX']) : ''));
                    $ho_so->appendChild($dom->createElement('HANG_DAOTAO', !empty($v['HANG_DAOTAO']) ? $v['HANG_DAOTAO'] : ''));
                    $ho_so->appendChild($dom->createElement('CHON_IN_GPLX', !empty($data_student['CHON_IN_GPLX']) ? $data_student['CHON_IN_GPLX'] : ''));

                        // Tạo phần tử GIAY_TOS
                    $giay_tos = $dom->createElement('GIAY_TOS');
                    ${'nguoi_lx' . ($numb)}->appendChild($giay_tos);

                    $data_hoso = json_decode($v['data_hoso'],true);
                    foreach($data_hoso['GIAY_TO'] as $key => $v){
                            // Tạo phần tử GIAY_TO và thêm vào GIAY_TOS
                        ${'giay_to' . ($key)} = $dom->createElement('GIAY_TO');
                        ${'giay_to' . ($key)}->appendChild($dom->createElement('MA_GIAY_TO', $v['MA_GIAY_TO']));
                        ${'giay_to' . ($key)}->appendChild($dom->createElement('TEN_GIAY_TO', $v['TEN_GIAY_TO']));
                        $giay_tos->appendChild(${'giay_to' . ($key)});
                    }
                }
                    // Tạo phần tử Signature
                $signature = $dom->createElement('Signature');
                $signature->setAttribute('xmlns', 'http://www.w3.org/2000/09/xmldsig#');
                $bao_cao1->appendChild($signature);

                        // Tạo phần tử SignedInfo và thêm vào Signature
                $signedInfo = $dom->createElement('SignedInfo');
                $signature->appendChild($signedInfo);

                        // Tạo phần tử CanonicalizationMethod và thêm vào SignedInfo
                $canonicalizationMethod = $dom->createElement('CanonicalizationMethod');
                $canonicalizationMethod->setAttribute('Algorithm', 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315');
                $signedInfo->appendChild($canonicalizationMethod);

                        // Tạo phần tử SignatureMethod và thêm vào SignedInfo
                $signatureMethod = $dom->createElement('SignatureMethod');
                $signatureMethod->setAttribute('Algorithm', 'http://www.w3.org/2000/09/xmldsig#rsa-sha1');
                $signedInfo->appendChild($signatureMethod);

                        // Tạo phần tử Reference và thêm vào SignedInfo
                $reference = $dom->createElement('Reference');
                $reference->setAttribute('URI', '');
                $signedInfo->appendChild($reference);

                        // Tạo phần tử Transforms và thêm vào Reference
                $transforms = $dom->createElement('Transforms');
                $reference->appendChild($transforms);

                        // Tạo phần tử Transform và thêm vào Transforms
                $transform = $dom->createElement('Transform');
                $transform->setAttribute('Algorithm', 'http://www.w3.org/2000/09/xmldsig#enveloped-signature');
                $transforms->appendChild($transform);

                        // Tạo phần tử DigestMethod và thêm vào Reference
                $digestMethod = $dom->createElement('DigestMethod');
                $digestMethod->setAttribute('Algorithm', 'http://www.w3.org/2000/09/xmldsig#sha1');
                $reference->appendChild($digestMethod);

                        // Tạo phần tử DigestValue và thêm vào Reference
                $digestValue = $dom->createElement('DigestValue', '');
                $reference->appendChild($digestValue);

                        // Tạo phần tử SignatureValue và thêm vào Signature
                $signatureValue = $dom->createElement('SignatureValue', '');
                $signature->appendChild($signatureValue);
                    // Lưu XML vào file
                    $dom->formatOutput = true; // Định dạng đầu ra
                    $dom->save('BC1'.(!empty($courseIn4['TEN_KHOA_HOC']) ? '-' : '').$courseIn4['TEN_KHOA_HOC'].'-'.time().'.xml');
                    array_push($files_to_zip,'BC1'.(!empty($courseIn4['TEN_KHOA_HOC']) ? '-' : '').$courseIn4['TEN_KHOA_HOC'].'-'.time().'.xml');
                }
            }
        }

        // Lấy DS theo HANG_GPLX và chưa có MA_KHOA_HOC

        // Lấy HANG_GPLX ID
        $gplxID = $d->rawQuery("select HANG_GPLX from #_student where id <> 0 $where group by HANG_GPLX");

        foreach ($gplxID as $n => $courses) {
            if(!empty($courses['HANG_GPLX'])){

                 // Lấy danh sách người LX
                $listStudent = $d->rawQuery("select * from #_student where id <> 0 $where and HANG_GPLX = ? and (MA_KHOA_HOC = '')",array($courses['HANG_GPLX']));

                

                $quantitySucess += count($listStudent);

                if (!empty($listStudent)) {
                    // $func->dump($listStudent);
                    // Tạo một đối tượng DOMDocument mới
                $dom = new DOMDocument('1.0', 'UTF-8');

                // Tạo phần tử gốc
                $bao_cao1 = $dom->createElement('BAO_CAO1');
                $dom->appendChild($bao_cao1);

                // Tạo phần tử HEADER
                $header = $dom->createElement('HEADER');
                $bao_cao1->appendChild($header);

                // Thêm các phần tử con vào HEADER
                $header->appendChild($dom->createElement('MA_GIAO_DICH', !empty($courseHeader['MA_GIAO_DICH']) ? $courseHeader['MA_GIAO_DICH'] : ''));
                $header->appendChild($dom->createElement('MA_DV_GUI', '79038'));
                $header->appendChild($dom->createElement('TEN_DV_GUI', 'Trung Tâm Giáo Dục Nghề Nghiệp Lái Xe Tiến Đạt'));
                $header->appendChild($dom->createElement('NGAY_GUI', date('Y-m-d H:i:s')));
                $header->appendChild($dom->createElement('NGUOI_GUI', 'ADMIN'));
                $header->appendChild($dom->createElement('TONG_SO_BAN_GHI', count($listStudent)));


                // Tạo phần tử DATA
                $data = $dom->createElement('DATA');
                $bao_cao1->appendChild($data);

                // Tạo phần tử KHOA_HOC
                $khoa_hoc = $dom->createElement('KHOA_HOC');
                $data->appendChild($khoa_hoc);

                // Thêm các phần tử con vào KHOA_HOC
                $khoa_hoc->appendChild($dom->createElement('MA_BCI', ''));
                $khoa_hoc->appendChild($dom->createElement('MA_SO_GTVT', ''));
                $khoa_hoc->appendChild($dom->createElement('TEN_SO_GTVT', ''));
                $khoa_hoc->appendChild($dom->createElement('MA_CSDT', ''));
                $khoa_hoc->appendChild($dom->createElement('TEN_CSDT', ''));
                $khoa_hoc->appendChild($dom->createElement('MA_KHOA_HOC', ''));
                $khoa_hoc->appendChild($dom->createElement('TEN_KHOA_HOC', ''));
                $khoa_hoc->appendChild($dom->createElement('MA_HANG_DAO_TAO', ''));
                $khoa_hoc->appendChild($dom->createElement('HANG_GPLX', ''));
                $khoa_hoc->appendChild($dom->createElement('SO_BCI', ''));
                $khoa_hoc->appendChild($dom->createElement('NGAY_BCI', ''));
                $khoa_hoc->appendChild($dom->createElement('LUU_LUONG', ''));
                $khoa_hoc->appendChild($dom->createElement('SO_HOC_SINH', ''));
                $khoa_hoc->appendChild($dom->createElement('NGAY_KHAI_GIANG', ''));
                $khoa_hoc->appendChild($dom->createElement('NGAY_BE_GIANG', ''));
                $khoa_hoc->appendChild($dom->createElement('SO_QD_KG', ''));
                $khoa_hoc->appendChild($dom->createElement('NGAY_QD_KG', ''));
                $khoa_hoc->appendChild($dom->createElement('NGAY_SAT_HACH', ''));
                $khoa_hoc->appendChild($dom->createElement('THOI_GIAN_DT', ''));


                // Tạo phần tử NGUOI_LXS
                $nguoi_lxs = $dom->createElement('NGUOI_LXS');
                $data->appendChild($nguoi_lxs);

                // Tạo phần tử NGUOI_LX

                foreach ($listStudent as $numb => $v) {
                    $data_student = json_decode($v['data_student'],true);

                    $numb = $numb + 1;

                    ${'nguoi_lx' . ($numb)} = $dom->createElement('NGUOI_LX');
                    $nguoi_lxs->appendChild(${'nguoi_lx' . ($numb)});

                    // Thêm các phần tử con vào NGUOI_LX
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('SO_TT', !empty($v['SO_TT']) ? $v['SO_TT'] : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('MA_DK', !empty($v['MA_DK']) ? $v['MA_DK'] : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('HO_TEN_DEM', !empty($data_student['HO_TEN_DEM']) ? $data_student['HO_TEN_DEM'] : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('TEN', !empty($data_student['TEN']) ? $data_student['TEN'] : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('HO_VA_TEN', !empty($v['HO_VA_TEN']) ? $v['HO_VA_TEN'] : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('NGAY_SINH', !empty($data_student['NGAY_SINH']) ? $func->formatDateString(date('Y-m-d', $data_student['NGAY_SINH'])) : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('MA_QUOC_TICH', !empty($data_student['MA_QUOC_TICH']) ? $data_student['MA_QUOC_TICH'] : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('TEN_QUOC_TICH', !empty($data_student['TEN_QUOC_TICH']) ? $data_student['TEN_QUOC_TICH'] : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('NOI_TT', !empty($data_student['NOI_TT']) ? $data_student['NOI_TT'] : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('NOI_TT_MA_DVHC', !empty($data_student['NOI_TT_MA_DVHC']) ? $data_student['NOI_TT_MA_DVHC'] : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('NOI_TT_MA_DVQL', !empty($data_student['NOI_TT_MA_DVQL']) ? $data_student['NOI_TT_MA_DVQL'] : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('NOI_CT', !empty($data_student['NOI_CT']) ? $data_student['NOI_CT'] : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('NOI_CT_MA_DVHC', !empty($data_student['NOI_CT_MA_DVHC']) ? $data_student['NOI_CT_MA_DVHC'] : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('NOI_CT_MA_DVQL', !empty($data_student['NOI_CT_MA_DVQL']) ? $data_student['NOI_CT_MA_DVQL'] : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('SO_CMT', !empty($v['SO_CMT']) ? $v['SO_CMT'] : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('NGAY_CAP_CMT', !empty($data_student['NGAY_CAP_CMT']) ? date('Y-m-d', $data_student['NGAY_CAP_CMT']) : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('NOI_CAP_CMT', !empty($data_student['NOI_CAP_CMT']) ? $data_student['NOI_CAP_CMT'] : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('GIOI_TINH', !empty($data_student['GIOI_TINH']) ? $data_student['GIOI_TINH'] : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('HO_VA_TEN_IN', !empty($data_student['HO_VA_TEN_IN']) ? $data_student['HO_VA_TEN_IN'] : ''));
                    ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('SO_CMND_CU', !empty($data_student['SO_CMND_CU']) ? $data_student['SO_CMND_CU'] : ''));


                    // Tạo phần tử HO_SO
                    $ho_so = $dom->createElement('HO_SO');
                    ${'nguoi_lx' . ($numb)}->appendChild($ho_so);

                    // Thêm các phần tử con vào HO_SO
                    $ho_so->appendChild($dom->createElement('SO_HO_SO', !empty($data_student['SO_HO_SO']) ? $data_student['SO_HO_SO'] : ''));
                    $ho_so->appendChild($dom->createElement('MA_DV_NHAN_HOSO', !empty($data_student['MA_DV_NHAN_HOSO']) ? $data_student['MA_DV_NHAN_HOSO'] : ''));
                    $ho_so->appendChild($dom->createElement('TEN_DV_NHAN_HOSO', !empty($data_student['TEN_DV_NHAN_HOSO']) ? $data_student['TEN_DV_NHAN_HOSO'] : ''));
                    $ho_so->appendChild($dom->createElement('NGAY_NHAN_HOSO', !empty($data_student['NGAY_NHAN_HOSO']) ? date('Y-m-d', $data_student['NGAY_NHAN_HOSO']) : ''));
                    $ho_so->appendChild($dom->createElement('NGUOI_NHAN_HOSO', !empty($data_student['NGUOI_NHAN_HOSO']) ? $data_student['NGUOI_NHAN_HOSO'] : ''));
                    $ho_so->appendChild($dom->createElement('MA_LOAI_HOSO', !empty($data_student['MA_LOAI_HOSO']) ? $data_student['MA_LOAI_HOSO'] : ''));
                    $ho_so->appendChild($dom->createElement('TEN_LOAI_HOSO', !empty($data_student['TEN_LOAI_HOSO']) ? $data_student['TEN_LOAI_HOSO'] : ''));
                    $ho_so->appendChild($dom->createElement('ANH_CHAN_DUNG', !empty($v['ANH_CHAN_DUNG']) ? $v['ANH_CHAN_DUNG'] : ''));
                    $ho_so->appendChild($dom->createElement('CHAT_LUONG_ANH', !empty($data_student['CHAT_LUONG_ANH']) ? $data_student['CHAT_LUONG_ANH'] : ''));
                    $ho_so->appendChild($dom->createElement('NGAY_THU_NHAN_ANH', !empty($data_student['NGAY_THU_NHAN_ANH']) ? date('Y-m-d', $data_student['NGAY_THU_NHAN_ANH']) : ''));
                    $ho_so->appendChild($dom->createElement('NGUOI_THU_NHAN_ANH', !empty($data_student['NGUOI_THU_NHAN_ANH']) ? $data_student['NGUOI_THU_NHAN_ANH'] : ''));
                    $ho_so->appendChild($dom->createElement('SO_GPLX_DA_CO', !empty($data_student['SO_GPLX_DA_CO']) ? $data_student['SO_GPLX_DA_CO'] : ''));
                    $ho_so->appendChild($dom->createElement('HANG_GPLX_DA_CO', !empty($data_student['HANG_GPLX_DA_CO']) ? $data_student['HANG_GPLX_DA_CO'] : ''));
                    $ho_so->appendChild($dom->createElement('DV_CAP_GPLX_DACO', !empty($data_student['DV_CAP_GPLX_DACO']) ? $data_student['DV_CAP_GPLX_DACO'] : ''));
                    $ho_so->appendChild($dom->createElement('TEN_DV_CAP_GPLX_DACO', !empty($data_student['TEN_DV_CAP_GPLX_DACO']) ? $data_student['TEN_DV_CAP_GPLX_DACO'] : ''));
                    $ho_so->appendChild($dom->createElement('NOI_CAP_GPLX_DACO', !empty($data_student['NOI_CAP_GPLX_DACO']) ? $data_student['NOI_CAP_GPLX_DACO'] : ''));
                    $ho_so->appendChild($dom->createElement('NGAY_CAP_GPLX_DACO', !empty($data_student['NGAY_CAP_GPLX_DACO']) ? $func->formatDateString(date('Y-m-d', $data_student['NGAY_CAP_GPLX_DACO'])) : ''));
                    $ho_so->appendChild($dom->createElement('NGAY_HH_GPLX_DACO', !empty($data_student['NGAY_HH_GPLX_DACO']) ? $func->formatDateString(date('Y-m-d', $data_student['NGAY_HH_GPLX_DACO'])) : ''));
                    $ho_so->appendChild($dom->createElement('NGAY_TT_GPLX_DACO', !empty($data_student['NGAY_TT_GPLX_DACO']) ? $func->formatDateString(date('Y-m-d', $data_student['NGAY_TT_GPLX_DACO'])) : ''));
                    $ho_so->appendChild($dom->createElement('MA_NOI_HOC_LAIXE', !empty($data_student['MA_NOI_HOC_LAIXE']) ? $data_student['MA_NOI_HOC_LAIXE'] : ''));
                    $ho_so->appendChild($dom->createElement('TEN_NOI_HOC_LAIXE', !empty($data_student['TEN_NOI_HOC_LAIXE']) ? $data_student['TEN_NOI_HOC_LAIXE'] : ''));
                    $ho_so->appendChild($dom->createElement('NAM_HOC_LAIXE', !empty($data_student['NAM_HOC_LAIXE']) ? $data_student['NAM_HOC_LAIXE'] : ''));
                    $ho_so->appendChild($dom->createElement('SO_NAM_LAIXE', !empty($data_student['SO_NAM_LAIXE']) ? $data_student['SO_NAM_LAIXE'] : ''));
                    $ho_so->appendChild($dom->createElement('SO_KM_ANTOAN', !empty($data_student['SO_KM_ANTOAN']) ? $data_student['SO_KM_ANTOAN'] : ''));
                    $ho_so->appendChild($dom->createElement('GIAY_CNSK', !empty($data_student['GIAY_CNSK']) ? $data_student['GIAY_CNSK'] : ''));
                    $ho_so->appendChild($dom->createElement('HINH_THUC_CAP', !empty($data_student['HINH_THUC_CAP']) ? $data_student['HINH_THUC_CAP'] : ''));
                    $ho_so->appendChild($dom->createElement('HANG_GPLX', !empty($v['HANG_GPLX']) ? $func->getColDetail('namevi','gplx',$v['HANG_GPLX']) : ''));
                    $ho_so->appendChild($dom->createElement('HANG_DAOTAO', !empty($v['HANG_DAOTAO']) ? $v['HANG_DAOTAO'] : ''));
                    $ho_so->appendChild($dom->createElement('CHON_IN_GPLX', !empty($data_student['CHON_IN_GPLX']) ? $data_student['CHON_IN_GPLX'] : ''));

                    // Tạo phần tử GIAY_TOS
                    $giay_tos = $dom->createElement('GIAY_TOS');
                    ${'nguoi_lx' . ($numb)}->appendChild($giay_tos);

                    $data_hoso = json_decode($v['data_hoso'],true);
                    foreach($data_hoso['GIAY_TO'] as $key => $v){
                        // Tạo phần tử GIAY_TO và thêm vào GIAY_TOS
                        ${'giay_to' . ($key)} = $dom->createElement('GIAY_TO');
                        ${'giay_to' . ($key)}->appendChild($dom->createElement('MA_GIAY_TO', $v['MA_GIAY_TO']));
                        ${'giay_to' . ($key)}->appendChild($dom->createElement('TEN_GIAY_TO', $v['TEN_GIAY_TO']));
                        $giay_tos->appendChild(${'giay_to' . ($key)});
                    }
                }
                // Tạo phần tử Signature
                $signature = $dom->createElement('Signature');
                $signature->setAttribute('xmlns', 'http://www.w3.org/2000/09/xmldsig#');
                $bao_cao1->appendChild($signature);

                    // Tạo phần tử SignedInfo và thêm vào Signature
                $signedInfo = $dom->createElement('SignedInfo');
                $signature->appendChild($signedInfo);

                    // Tạo phần tử CanonicalizationMethod và thêm vào SignedInfo
                $canonicalizationMethod = $dom->createElement('CanonicalizationMethod');
                $canonicalizationMethod->setAttribute('Algorithm', 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315');
                $signedInfo->appendChild($canonicalizationMethod);

                    // Tạo phần tử SignatureMethod và thêm vào SignedInfo
                $signatureMethod = $dom->createElement('SignatureMethod');
                $signatureMethod->setAttribute('Algorithm', 'http://www.w3.org/2000/09/xmldsig#rsa-sha1');
                $signedInfo->appendChild($signatureMethod);

                    // Tạo phần tử Reference và thêm vào SignedInfo
                $reference = $dom->createElement('Reference');
                $reference->setAttribute('URI', '');
                $signedInfo->appendChild($reference);

                    // Tạo phần tử Transforms và thêm vào Reference
                $transforms = $dom->createElement('Transforms');
                $reference->appendChild($transforms);

                    // Tạo phần tử Transform và thêm vào Transforms
                $transform = $dom->createElement('Transform');
                $transform->setAttribute('Algorithm', 'http://www.w3.org/2000/09/xmldsig#enveloped-signature');
                $transforms->appendChild($transform);

                    // Tạo phần tử DigestMethod và thêm vào Reference
                $digestMethod = $dom->createElement('DigestMethod');
                $digestMethod->setAttribute('Algorithm', 'http://www.w3.org/2000/09/xmldsig#sha1');
                $reference->appendChild($digestMethod);

                    // Tạo phần tử DigestValue và thêm vào Reference
                $digestValue = $dom->createElement('DigestValue', '');
                $reference->appendChild($digestValue);

                    // Tạo phần tử SignatureValue và thêm vào Signature
                $signatureValue = $dom->createElement('SignatureValue', '');
                $signature->appendChild($signatureValue);
                // Lưu XML vào file
                $dom->formatOutput = true; // Định dạng đầu ra

                $dom->save('BC1-'.$func->getInfoDetail('namevi','gplx',$courses['HANG_GPLX'])['namevi'].'-'.time().'.xml');
                array_push($files_to_zip,'BC1-'.$func->getInfoDetail('namevi','gplx',$courses['HANG_GPLX'])['namevi'].'-'.time().'.xml');
                }
            }
        }

        if ($quantitySucess == 0) {
            foreach ($files_to_zip as $file) {
                if (file_exists($file)) {
                 unlink($file);
             }
         }
         $func->transfer("Không tồn tại học viên hợp lệ !!!","index.php?com=student&act=man&fill=man",false);
     }
     // die;
     $zip = new ZipArchive();
     $filename = "BC1-XML-".time().".zip";

     if ($zip->open($filename, ZipArchive::CREATE) !== TRUE) {
        exit("Không thể mở file <$filename>\n");
    }

    foreach ($files_to_zip as $file) {
        if (file_exists($file)) {
            $zip->addFile($file, basename($file));
        } else {
            echo "File không tồn tại: $file\n";
        }
    }

    $zip->close();

        // Lưu lại lịch sử
    $dataHistory['namevi'] = '';
    $dataHistory['descvi'] = 'Export File XML báo cáo 1';
    $dataHistory['file'] = $filename;
    $dataHistory['type'] = 'export-xml-bc1';
    $dataHistory['quantity'] = $quantitySucess;
    $dataHistory['date_created'] = time();
    $dataHistory['id_downloader'] = $_SESSION[$loginAdmin]['id'];
    $dataHistory['downloads'] = 1;
    $d->insert('user_operation', $dataHistory);


        // Xoá file zip sau khi tải xuống
        // unlink($filename);

            // Gửi file xuống trình duyệt
    header('Content-Type: application/zip');
    header('Content-disposition: attachment; filename='.$filename);
    header('Content-Length: ' . filesize($filename));
    readfile($filename);

        // Chuyển file vào thư mục lưu lại
    rename($filename, UPLOAD_FILE.'operation/'.$filename);


    foreach ($files_to_zip as $file) {
        if (file_exists($file)) {
           unlink($file);
       }
   }

   exit;

}

function exportExcelTC()
{
    global $d, $func, $type;

    /* Setting */
    $setting = $d->rawQueryOne("select * from #_setting limit 0,1");
    $optsetting = (isset($setting['options']) && $setting['options'] != '') ? json_decode($setting['options'],true) : null;

    if(isset($_POST['exportExcel']) || 1)
    {
        /* PHPExcel */
        require_once LIBRARIES.'PHPExcel.php';

        /* Khởi tọa đối tượng */
        $PHPExcel = new PHPExcel();

        /* Khởi tạo thông tin người tạo */
        $PHPExcel->getProperties()->setCreator($setting['namevi']);
        $PHPExcel->getProperties()->setLastModifiedBy($setting['namevi']);
        $PHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
        $PHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
        $PHPExcel->getProperties()->setDescription("Document for Office 2007 XLSX, generated using PHP classes.");

        /* Merge cells */
        $PHPExcel->setActiveSheetIndex(0);
        $PHPExcel->setActiveSheetIndex(0)->mergeCells('A1:AA1');
        $PHPExcel->setActiveSheetIndex(0)->mergeCells('A2:AA2');
        $PHPExcel->setActiveSheetIndex(0)->mergeCells('A3:AA3');
        $PHPExcel->setActiveSheetIndex(0)->mergeCells('A4:AA4');
        $PHPExcel->setActiveSheetIndex(0)->mergeCells('A7:AA7');
        $PHPExcel->setActiveSheetIndex(0)->mergeCells('A5:A6');
        $PHPExcel->setActiveSheetIndex(0)->mergeCells('B5:B6');
        $PHPExcel->setActiveSheetIndex(0)->mergeCells('C5:C6');
        $PHPExcel->setActiveSheetIndex(0)->mergeCells('D5:D6');
        $PHPExcel->setActiveSheetIndex(0)->mergeCells('E5:E6');
        $PHPExcel->setActiveSheetIndex(0)->mergeCells('F5:F6');
        $PHPExcel->setActiveSheetIndex(0)->mergeCells('G5:G6');
        $PHPExcel->setActiveSheetIndex(0)->mergeCells('H5:H6');
        $PHPExcel->setActiveSheetIndex(0)->mergeCells('I5:I6');
        $PHPExcel->setActiveSheetIndex(0)->mergeCells('J5:J6');
        $PHPExcel->setActiveSheetIndex(0)->mergeCells('K5:K6');
        $PHPExcel->setActiveSheetIndex(0)->mergeCells('L5:M5');
        $PHPExcel->setActiveSheetIndex(0)->mergeCells('N5:S5');
        $PHPExcel->setActiveSheetIndex(0)->mergeCells('T5:U5');
        $PHPExcel->setActiveSheetIndex(0)->mergeCells('V5:Z5');
        $PHPExcel->setActiveSheetIndex(0)->mergeCells('AA5:AA6');

        /* set Cell Value */
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Phụ lục 3.1c');
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'BÁO CÁO CHI TIẾT');
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('A3', 'Danh sách giáo viên dạy thực hành');
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('A4', '(Kèm theo báo cáo số:     /BC-TĐ ngày      tháng       năm 20      của Trung tâm Giáo dục nghề nghiệp lái xe Tiến Đạt)

            ');
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('A5', 'TT');
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('B5', 'Họ và tên');
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('C5', 'Ngày sinh');
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('D5', '');
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('E5', '');
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('F5', 'CCCD');
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('G5', 'Ngày cấp CCCD');
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('H5', 'Nơi cấp');
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('I5', 'Thường trú');
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('J5', 'Giới tính');
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('K5', 'Đơn vị công tác');
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('L5', 'Hình thức tuyển dụng');
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('L5', 'Hình thức tuyển dụng');
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('L6', 'Biên chế');
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('M6', 'Hợp đồng');
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('N5', 'Trình độ');
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('N6', 'Văn hóa');
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('O6', 'Chuyên môn');
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('P6', '');
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('Q6', 'Sư phạm');
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('R6', 'Anh văn');
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('S6', 'Tin học');
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('T5', 'Hạng');
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('T6', 'Giấy phép lái xe');
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('U6', 'Ngày cấp');
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('V5', 'Phân công giảng dạy');
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('V6', 'Hạng xe dạy');
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('W6', 'Kiêm dạy lý thuyết');
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('X6', 'Kiêm dạy Hình');
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('Y6', 'Kiêm dạy Cabin');
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('Z6', 'Kiêm dạy DAT');
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('AA5', 'Ghi chú (Ghi rõ giáo viên cơ hữu');
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('A7', 'GIÁO VIÊN');

        /* set Cell Value */
        $PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(3);
        $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(19);
        $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(14);
        $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(8);
        $PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(8);
        $PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(13);
        $PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(13);
        $PHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(13);
        $PHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(49);
        $PHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(13);
        $PHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(6);
        $PHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(5);
        $PHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(5);
        $PHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(6);
        $PHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(32);
        $PHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(7);
        $PHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(22);
        $PHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(5);
        $PHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(5);
        $PHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(5);
        $PHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(18);
        $PHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(6);
        $PHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(6);
        $PHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(6);
        $PHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(6);
        $PHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(6);
        $PHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(8);
        $PHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(22);
        $PHPExcel->getActiveSheet()->getRowDimension('5')->setRowHeight(50);
        $PHPExcel->getActiveSheet()->getRowDimension('6')->setRowHeight(50);
        $PHPExcel->getActiveSheet()->getRowDimension('7')->setRowHeight(22);

        /* Style */
        $PHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray(
            array(
                'font' => array(
                    'color' => array(
                        'rgb' => '000000'
                    ),
                    'name' => 'Times New Roman',
                    'bold' => false,
                    'italic' => false,
                    'size' => 9
                ),
            )
        );
        $PHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray(
            array(
                'font' => array(
                    'color' => array(
                        'rgb' => '000000'
                    ),
                    'name' => 'Times New Roman',
                    'bold' => true,
                    'italic' => false,
                    'size' => 9
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'wrap' => true
                ),
            )
        );
        $PHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray(
            array(
                'font' => array(
                    'color' => array(
                        'rgb' => '000000'
                    ),
                    'name' => 'Times New Roman',
                    'bold' => true,
                    'italic' => false,
                    'size' => 9
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'wrap' => true
                ),
            )
        );
        $PHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray(
            array(
                'font' => array(
                    'color' => array(
                        'rgb' => '000000'
                    ),
                    'name' => 'Times New Roman',
                    'bold' => false,
                    'italic' => false,
                    'size' => 9
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'wrap' => true
                ),
            )
        );
        $PHPExcel->getActiveSheet()->getStyle('A7')->applyFromArray(
            array(
                'font' => array(
                    'color' => array(
                        'rgb' => 'FF0000'
                    ),
                    'name' => 'Times New Roman',
                    'bold' => true,
                    'italic' => false,
                    'size' => 9
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'wrap' => true
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb'=>'FFFF00')
                ),
            )
        );
        $PHPExcel->getActiveSheet()->getStyle('A5:AA5')->applyFromArray(
            array(
                'font' => array(
                    'color' => array(
                        'rgb' => '000000'
                    ),
                    'name' => 'Times New Roman',
                    'bold' => true,
                    'italic' => false,
                    'size' => 9
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'wrap' => true
                ),
                'borders' => array(
                    'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                    'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                    'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                    'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                )
            )
        );
        $PHPExcel->getActiveSheet()->getStyle('A6:AA6')->applyFromArray(
            array(
                'font' => array(
                    'color' => array(
                        'rgb' => '000000'
                    ),
                    'name' => 'Times New Roman',
                    'bold' => true,
                    'italic' => false,
                    'size' => 9
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'wrap' => true
                ),
                'borders' => array(
                    'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                    'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                    'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                    'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                )
            )
        );

            // Define the starting row and column
        $startRow = 5;
        $endRow = 6;
        $startColumn = 'A';
            $numberOfCells = 11; // Number of cells you want to merge

            for ($i = 0; $i < $numberOfCells; $i++) {
                // Calculate current column letter
                $currentColumn = chr(ord($startColumn) + $i);
                // Merge cells
                $PHPExcel->getActiveSheet()->getStyle($currentColumn . $startRow . ':' . $currentColumn . $endRow)->applyFromArray(
                    array(
                        'borders' => array(
                            'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                        )
                    )
                );
            }

            $startColumn = 'L';
            $numberOfCells = 15;
            $Row = 6;

            for ($i = 0; $i < $numberOfCells; $i++) {
                // Calculate current column letter
                $currentColumn = chr(ord($startColumn) + $i);
                // Merge cells
                $PHPExcel->getActiveSheet()->getStyle($currentColumn . $Row)->applyFromArray(
                    array(
                        'borders' => array(
                            'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                        )
                    )
                );
            }

            $PHPExcel->getActiveSheet()->getStyle('M5')->applyFromArray(
                array(
                    'borders' => array(
                        'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                    )
                )
            );

            $PHPExcel->getActiveSheet()->getStyle('S5')->applyFromArray(
                array(
                    'borders' => array(
                        'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                    )
                )
            );

            $PHPExcel->getActiveSheet()->getStyle('U5')->applyFromArray(
                array(
                    'borders' => array(
                        'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                    )
                )
            );

            $PHPExcel->getActiveSheet()->getStyle('Z5')->applyFromArray(
                array(
                    'borders' => array(
                        'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                    )
                )
            );

            $alphas = range('A','Z');
            $alphas2 = range('A','Z');
            for ($i = 0; $i < 26 ; ++$i) {
                $tem = $alphas2[0].$alphas2[$i];
                array_push($alphas, $tem);
            }
            $array_columns = array(
                'numb'=>'STT',
                'fullname'=>'Họ và tên',
                'birthday'=>'Ngày sinh',
                'namsinh'=>'',
                'dotuoi'=>'',
                'cccd'=>'CCCD',
                'date-cccd'=>'Ngày cấp CCCD',
                'noicap'=>'Nơi cấp',
                'address'=>'Thường trú',
                'gender'=>'Giới tính',
                'congtac'=>'Đơn vị công tác',
                'tuyendung'=>'Hình thức tuyển dụng',
                'tuyendung2'=>'Hình thức tuyển dụng',
                'vanhoa'=>'Trình độ',
                'chuyenmon'=>'Trình độ',
                'level'=>'Trình độ',
                'supham'=>'Trình độ',
                'anhvan'=>'Trình độ',
                'tinhoc'=>'Trình độ',
                'hanggplx'=>'Hạng GPLX',
                'ngaygplx'=>'Ngày cấp GP',
                'hangxe'=>'Hạng xe dạy',
                'lythuyet'=>'Ngày cấp GP',
                'hinh'=>'Ngày cấp GP',
                'cabin'=>'Ngày cấp GP',
                'dat'=>'Ngày cấp GP',
                'note'=>'Ghi chú (Ghi rõ giáo viên cơ hữu',
            );

            /* Lấy và Xuất dữ liệu */
            $where = "";
            if (!empty($_REQUEST['hangxe'])) {
                $arrayGPLX = explode(",", $_REQUEST['hangxe']);

                foreach($arrayGPLX as $s => $v){
                    $where .= ($s == 0 ? ' and (' : ' or') ." hangxe = '".$v."'";
                }
                $where = $where.")";
            }

            if (!empty($_REQUEST['courses-id'])) {
                $dataResult['courses_id'] = explode(",", $_REQUEST['courses-id']);
                $arrId = '';

                foreach($dataResult['courses_id'] as $key => $id_courses){
                    $rowCourses = $d->rawQueryOne("select data_teacher from #_courses where MA_KHOA_HOC = ? limit 1",array($id_courses));
                    if(!empty($rowCourses['data_teacher'])) $arrId .= ($arrId != '' ? ',' : '') . implode(",", json_decode($rowCourses['data_teacher'],true));
                }

                if($arrId != '') {
                    $arrayTeacher = array_unique(explode(',',$arrId));
                    $arrayTeacher = array_values($arrayTeacher);
                    $where .= " and id IN (".implode(',',$arrayTeacher).")";
                }
            }

            if (!empty($_REQUEST['courses-name'])) {
                $dataResult['courses-name'] = explode(",", $_REQUEST['courses-name']);

                foreach($dataResult['courses-name'] as $key => $name_courses){
                    $rowCourses = $d->rawQueryOne("select data_teacher from #_courses where TEN_KHOA_HOC = ? limit 1",array($name_courses));

                    if(!empty($rowCourses['data_teacher'])) $arrId .= ($arrId != '' ? ',' : '') . implode(",", json_decode($rowCourses['data_teacher'],true));
                }

                if($arrId != '') {
                    $arrayTeacher = array_unique(explode(',',$arrId));
                    $arrayTeacher = array_values($arrayTeacher);
                    $where .= " and id IN (".implode(',',$arrayTeacher).")";
                }
            }



            if (!empty($_REQUEST['teacher-code'])) {
                $dataResult['teacher-code'] = explode(",", $_REQUEST['teacher-code']);

                foreach($dataResult['teacher-code'] as $s => $vc){
                    $where .= ($s == 0 ? ' and (' : ' or') ." id_code = '".$vc."'";
                }
                $where = $where.")";
            }

            if (!empty($_REQUEST['teacher-name'])) {
                $dataResult['teacher-name'] = explode(",", $_REQUEST['teacher-name']);

                foreach($dataResult['teacher-name'] as $s => $vc){
                    $where .= ($s == 0 ? ' and (' : ' or') ." fullname LIKE '%".$vc."%'";
                }
                $where = $where.")";
            }

            if (!empty($_REQUEST['teacher-cmt'])) {
                $dataResult['teacher-cmt'] = explode(",", $_REQUEST['teacher-cmt']);

                foreach($dataResult['teacher-cmt'] as $s => $vc){
                    $where .= ($s == 0 ? ' and (' : ' or') ." cccd = '".$vc."'";
                }
                $where = $where.")";
            }

            if (!empty($_REQUEST['function-teacher'])) {
                $dataResult['function-teacher'] = explode(",", $_REQUEST['function-teacher']);

                $where .= ' and find_in_set("'.$_REQUEST['function-teacher'].'",chucnang)';
            }

            $data = (isset($_POST['data'])) ? $_POST['data'] : null;

            if($data)
            {
                foreach($data as $column => $value)
                {
                    if($value > 0)
                    {
                        $where .= " and ".$column." = ".$value;
                    }
                }
            }

            $product = $d->rawQuery("select * from #_member where id <> 0 $where order by numb,id desc");

            $position=8;
            for($i=0;$i<count($product);$i++)
            {
                $j=0;
                $academic = json_decode($product[$i]['academic'],true);
                foreach($array_columns as $k=>$v)
                {
                    if ($k == 'gender') {
                        $datacell = $product[$i][$k];
                        if ( $datacell == 1) $datacell = 'Nam'; elseif($datacell == 2) $datacell = 'Nữ'; else $datacell = '';
                        $PHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[$j].$position, htmlspecialchars_decode($datacell));
                    } elseif ($k == 'birthday'|| $k == 'date-cccd'||$k == 'ngaygplx') {
                        (!empty($product[$i][$k]) ? $datacell = date('d-m-Y',$product[$i][$k]) : $datacell = '');
                        $PHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[$j].$position, $datacell);
                        
                    }elseif ($k == 'tuyendung'||$k == 'tuyendung2') {
                        $datacell = $product[$i]['tuyendung'];
                        if ( $datacell == 'bienche'){
                            $PHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$position, htmlspecialchars_decode('X'));
                        } elseif ( $datacell == 'hopdong'){
                            $PHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$position, htmlspecialchars_decode('X'));
                        } 
                    }elseif ($k == 'vanhoa' || $k == 'chuyenmon' || $k == 'level' || $k == 'supham' || $k == 'anhvan' || $k == 'tinhoc') {
                        $datacell = $academic[$k];
                        $PHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[$j].$position, htmlspecialchars_decode($datacell));
                    }elseif ($k == 'lythuyet' || $k == 'hinh' || $k == 'cabin' || $k == 'dat') {
                        $row = $d->rawQueryOne("select id from #_member where id = ? and find_in_set(?,chucnang) order by numb,id desc limit 1",array($product[$i]['id'],$k));
                        if(!empty($row)){
                            $PHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[$j].$position, htmlspecialchars_decode('x'));
                        } else {
                            $PHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[$j].$position, htmlspecialchars_decode(''));
                        }
                    }elseif ($k == 'namsinh') {
                        $datacell = '=RIGHT(C'.$position.',4)';
                        $PHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[$j].$position, $datacell);
                    }elseif ($k == 'dotuoi') {
                        $datacell = '=2023-D'.$position;
                        $PHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[$j].$position, $datacell);
                    }else {
                        $datacell = $product[$i][$k];
                        $PHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[$j].$position, htmlspecialchars_decode($datacell));
                    }
                    
                    $j++;
                }
                $position++;
            }

            /* Style cho các row dữ liệu */
            $position=8;
            for($i=0;$i<count($product);$i++)
            {
                $j=0;
                foreach($array_columns as $k=>$v)
                {
                    if ($k == 'fullname' || $k == 'chuyenmon' || $k == 'level'|| $k == 'supham') {
                        $PHPExcel->getActiveSheet()->getStyle($alphas[$j].$position)->applyFromArray(
                            array( 
                                'font' => array( 
                                    'color' => array('rgb' => '000000'), 
                                    'name' => 'Times New Roman', 
                                    'bold' => false, 
                                    'italic' => false, 
                                    'size' => 10 
                                ), 
                                'alignment' => array( 
                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 
                                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 
                                    'wrap' => true 
                                ),
                                'borders' => array(
                                    'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                                    'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                                    'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                                    'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                                )
                            )
                        );
                    } else {
                        $PHPExcel->getActiveSheet()->getStyle($alphas[$j].$position)->applyFromArray(
                            array( 
                                'font' => array( 
                                    'color' => array('rgb' => '000000'), 
                                    'name' => 'Times New Roman', 
                                    'bold' => false, 
                                    'italic' => false, 
                                    'size' => 10 
                                ), 
                                'alignment' => array( 
                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
                                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 
                                    'wrap' => true 
                                ),
                                'borders' => array(
                                    'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                                    'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                                    'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                                    'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                                )
                            )
                        );
                    }
                    $j++;
                }
                $PHPExcel->getActiveSheet()->getRowDimension($position)->setRowHeight(22);
                $position++;
            }

            /* Rename title */
            $PHPExcel->getActiveSheet()->setTitle('GV Tiến Đạt');

            $PHPExcel->getActiveSheet()->setShowGridlines(false);

            /* Khởi tạo chỉ mục ở đầu sheet */
            $PHPExcel->setActiveSheetIndex(0);

            /* Xuất file */
            $time = time();
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="DSGV_'.$time.'_'.date('d_m_Y').'.xlsx"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel2007');
            $objWriter->save('php://output');
            exit();
        }
    }

    function exportXMLTC() {
        global $d, $func;

        /* Lấy và Xuất dữ liệu */
        $where = "";

        if (!empty($_REQUEST['hangxe'])) {
            $arrayGPLX = explode(",", $_REQUEST['hangxe']);

            foreach($arrayGPLX as $s => $v){
                $where .= ($s == 0 ? ' and (' : ' or') ." hangxe = '".$v."'";
            }
            $where = $where.")";
        }

        if (!empty($_REQUEST['courses-id'])) {
            $dataResult['courses_id'] = explode(",", $_REQUEST['courses-id']);
            $arrId = '';

            foreach($dataResult['courses_id'] as $key => $id_courses){
                $rowCourses = $d->rawQueryOne("select data_teacher from #_courses where MA_KHOA_HOC = ? limit 1",array($id_courses));
                if(!empty($rowCourses['data_teacher'])) $arrId .= ($arrId != '' ? ',' : '') . implode(",", json_decode($rowCourses['data_teacher'],true));
            }

            if($arrId != '') {
                $arrayTeacher = array_unique(explode(',',$arrId));
                $arrayTeacher = array_values($arrayTeacher);
                $where .= " and id IN (".implode(',',$arrayTeacher).")";
            }
        }

        if (!empty($_REQUEST['courses-name'])) {
            $dataResult['courses-name'] = explode(",", $_REQUEST['courses-name']);

            foreach($dataResult['courses-name'] as $key => $name_courses){
                $rowCourses = $d->rawQueryOne("select data_teacher from #_courses where TEN_KHOA_HOC = ? limit 1",array($name_courses));

                if(!empty($rowCourses['data_teacher'])) $arrId .= ($arrId != '' ? ',' : '') . implode(",", json_decode($rowCourses['data_teacher'],true));
            }

            if($arrId != '') {
                $arrayTeacher = array_unique(explode(',',$arrId));
                $arrayTeacher = array_values($arrayTeacher);
                $where .= " and id IN (".implode(',',$arrayTeacher).")";
            }
        }



        if (!empty($_REQUEST['teacher-code'])) {
            $dataResult['teacher-code'] = explode(",", $_REQUEST['teacher-code']);

            foreach($dataResult['teacher-code'] as $s => $vc){
                $where .= ($s == 0 ? ' and (' : ' or') ." id_code = '".$vc."'";
            }
            $where = $where.")";
        }

        if (!empty($_REQUEST['teacher-name'])) {
            $dataResult['teacher-name'] = explode(",", $_REQUEST['teacher-name']);

            foreach($dataResult['teacher-name'] as $s => $vc){
                $where .= ($s == 0 ? ' and (' : ' or') ." fullname LIKE '%".$vc."%'";
            }
            $where = $where.")";
        }

        if (!empty($_REQUEST['teacher-cmt'])) {
            $dataResult['teacher-cmt'] = explode(",", $_REQUEST['teacher-cmt']);

            foreach($dataResult['teacher-cmt'] as $s => $vc){
                $where .= ($s == 0 ? ' and (' : ' or') ." cccd = '".$vc."'";
            }
            $where = $where.")";
        }

        if (!empty($_REQUEST['function-teacher'])) {
            $dataResult['function-teacher'] = explode(",", $_REQUEST['function-teacher']);

            $where .= ' and find_in_set("'.$_REQUEST['function-teacher'].'",chucnang)';
        }
        $listTeacher = $d->rawQuery("select * from #_member where id <> 0 ".$where);

        // Tạo đối tượng DOMDocument mới
        $dom = new DOMDocument('1.0', 'UTF-8');

        // Tạo phần tử gốc GIAOVIEN
        $giaovien = $dom->createElement('GIAOVIEN');
        $dom->appendChild($giaovien);

        // Tạo phần tử DATA
        $data = $dom->createElement('DATA');
        $giaovien->appendChild($data);

        // Tạo phần tử GIAO_VIENS
        $giao_viens = $dom->createElement('GIAO_VIENS');
        $data->appendChild($giao_viens);




        foreach($listTeacher as $numb => $v){
            $data_academic = json_decode($v['academic'],true);
            // Tạo phần tử GIAO_VIEN
            $numb = $numb + 1;
            ${'giao_vien'.($numb)} = $dom->createElement('GIAO_VIEN');
            $giao_viens->appendChild(${'giao_vien'.($numb)});

            // Thêm các phần tử con vào GIAO_VIEN
            ${'giao_vien' . ($numb)}->appendChild($dom->createElement('MA_GIAO_VIEN', $v['id_code']));
            ${'giao_vien' . ($numb)}->appendChild($dom->createElement('HO_VA_TEN', $v['fullname']));
            ${'giao_vien' . ($numb)}->appendChild($dom->createElement('NGAY_SINH', date('Y-m-d', $v['birthday'])));
            ${'giao_vien' . ($numb)}->appendChild($dom->createElement('CCCD', $v['cccd']));
            ${'giao_vien' . ($numb)}->appendChild($dom->createElement('NGAY_CAP_CCCD', date('Y-m-d', $v['date-cccd'])));
            ${'giao_vien' . ($numb)}->appendChild($dom->createElement('NOI_CAP_CCCD', $v['noicap']));
            ${'giao_vien' . ($numb)}->appendChild($dom->createElement('THUONG_TRU', $v['address']));
            ${'giao_vien' . ($numb)}->appendChild($dom->createElement('GIOI_TINH', (!empty($v['gender']) ? ($v['gender'] == 1 ? 'Nam' : 'Nữ') : '')));
            ${'giao_vien' . ($numb)}->appendChild($dom->createElement('DON_VI_CT', $v['congtac']));
            ${'giao_vien' . ($numb)}->appendChild($dom->createElement('HT_TUYEN_DUNG', (!empty($v['tuyendung']) ? ($v['tuyendung'] == 'hopdong' ? 'Hợp đồng' : 'Biên chế') : '')));
            ${'giao_vien' . ($numb)}->appendChild($dom->createElement('VAN_HOA', $data_academic['vanhoa']));
            ${'giao_vien' . ($numb)}->appendChild($dom->createElement('CHUYEN_MON', $data_academic['chuyenmon']));
            ${'giao_vien' . ($numb)}->appendChild($dom->createElement('LEVEL', $data_academic['level']));
            ${'giao_vien' . ($numb)}->appendChild($dom->createElement('SU_PHAM', $data_academic['supham']));
            ${'giao_vien' . ($numb)}->appendChild($dom->createElement('ANH_VAN', $data_academic['anhvan']));
            ${'giao_vien' . ($numb)}->appendChild($dom->createElement('TIN_HOC', $data_academic['tinhoc']));
            ${'giao_vien' . ($numb)}->appendChild($dom->createElement('HANG_GPLX', $v['hanggplx']));
            ${'giao_vien' . ($numb)}->appendChild($dom->createElement('NGAY_CAP_GPLX', date('Y-m-d', $v['ngaygplx'])));
            ${'giao_vien' . ($numb)}->appendChild($dom->createElement('HANG_XE_DAY', !empty($v['hangxe']) ? $func->getColDetail('namevi','gplx',$v['hangxe']) : ''));
            ${'giao_vien' . ($numb)}->appendChild($dom->createElement('GHI_CHU', $v['note']));

            // Tạo phần tử GIANG_DAYS
            $giang_days = $dom->createElement('GIANG_DAYS');
            ${'giao_vien' . ($numb)}->appendChild($giang_days);

            $data_chucnang = explode(",",$v['chucnang']);

            foreach($data_chucnang as $key => $v){
                    // Tạo phần tử GIANG_DAY và thêm vào GIANG_DAYS
                ${'giang_day' . ($key)} = $dom->createElement('GIANG_DAY');
                ${'giang_day' . ($key)}->appendChild($dom->createElement('STT', $key + 1));
                if ($v == 'lythuyet') {
                    ${'giang_day' . ($key)}->appendChild($dom->createElement('TEN', 'Lý thuyết'));
                }elseif ($v == 'hinh') {
                    ${'giang_day' . ($key)}->appendChild($dom->createElement('TEN', 'Hình'));
                }
                elseif ($v == 'cabin') {
                    ${'giang_day' . ($key)}->appendChild($dom->createElement('TEN', 'Cabin'));
                }
                elseif ($v == 'dat') {
                    ${'giang_day' . ($key)}->appendChild($dom->createElement('TEN', 'DAT'));
                }
                $giang_days->appendChild(${'giang_day' . ($key)});
            }
        }
        
        // Tạo phần tử Signature
        $signature = $dom->createElement('Signature');
        $signature->setAttribute('xmlns', 'http://www.w3.org/2000/09/xmldsig#');
        $giaovien->appendChild($signature);

        // Tạo phần tử SignedInfo và thêm vào Signature
        $signedInfo = $dom->createElement('SignedInfo');
        $signature->appendChild($signedInfo);

        // Tạo phần tử CanonicalizationMethod và thêm vào SignedInfo
        $canonicalizationMethod = $dom->createElement('CanonicalizationMethod');
        $canonicalizationMethod->setAttribute('Algorithm', 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315');
        $signedInfo->appendChild($canonicalizationMethod);

        // Tạo phần tử SignatureMethod và thêm vào SignedInfo
        $signatureMethod = $dom->createElement('SignatureMethod');
        $signatureMethod->setAttribute('Algorithm', 'http://www.w3.org/2000/09/xmldsig#rsa-sha1');
        $signedInfo->appendChild($signatureMethod);

        // Tạo phần tử Reference và thêm vào SignedInfo
        $reference = $dom->createElement('Reference');
        $reference->setAttribute('URI', '');
        $signedInfo->appendChild($reference);

        // Tạo phần tử Transforms và thêm vào Reference
        $transforms = $dom->createElement('Transforms');
        $reference->appendChild($transforms);

        // Tạo phần tử Transform và thêm vào Transforms
        $transform = $dom->createElement('Transform');
        $transform->setAttribute('Algorithm', 'http://www.w3.org/2000/09/xmldsig#enveloped-signature');
        $transforms->appendChild($transform);

        // Tạo phần tử DigestMethod và thêm vào Reference
        $digestMethod = $dom->createElement('DigestMethod');
        $digestMethod->setAttribute('Algorithm', 'http://www.w3.org/2000/09/xmldsig#sha1');
        $reference->appendChild($digestMethod);

        // Tạo phần tử DigestValue và thêm vào Reference
        $digestValue = $dom->createElement('DigestValue', '');
        $reference->appendChild($digestValue);

        // Tạo phần tử SignatureValue và thêm vào Signature
        $signatureValue = $dom->createElement('SignatureValue', '');
        $signature->appendChild($signatureValue);

        // Khỏi tạo mảng tên file xml để xíu nén lại tải xuống
        $files_to_zip = array();

        // Lưu XML vào file
        $dom->formatOutput = true; // Định dạng đầu ra
        $dom->save('DSGV-'.time().'.xml');
        array_push($files_to_zip,'DSGV-'.time().'.xml');
        $zip = new ZipArchive();
        $filename = "GV-".time().".zip";



        if ($zip->open($filename, ZipArchive::CREATE) !== TRUE) {
            exit("Không thể mở file <$filename>\n");
        }

        foreach ($files_to_zip as $file) {
            if (file_exists($file)) {
                $zip->addFile($file, basename($file));
            } else {
                echo "File không tồn tại: $file\n";
            }
        }

        $zip->close();

        // Gửi file xuống trình duyệt
        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename='.$filename);
        header('Content-Length: ' . filesize($filename));
        readfile($filename);



        // Xoá file zip sau khi tải xuống
        unlink($filename);

        foreach ($files_to_zip as $file) {
            if (file_exists($file)) {
               unlink($file);
           }
       }

       exit;

   }
   function exportExcelCar()
   {
    global $d, $func, $type;

    /* Setting */
    $setting = $d->rawQueryOne("select * from #_setting limit 0,1");
    $optsetting = (isset($setting['options']) && $setting['options'] != '') ? json_decode($setting['options'],true) : null;

    if(isset($_POST['exportExcel']) || 1)
    {
        /* PHPExcel */
        require_once LIBRARIES.'PHPExcel.php';

        /* Khởi tọa đối tượng */
        $PHPExcel = new PHPExcel();

        /* Khởi tạo thông tin người tạo */
        $PHPExcel->getProperties()->setCreator($setting['namevi']);
        $PHPExcel->getProperties()->setLastModifiedBy($setting['namevi']);
        $PHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
        $PHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
        $PHPExcel->getProperties()->setDescription("Document for Office 2007 XLSX, generated using PHP classes.");

        /* Khởi tạo mảng column */
        $alphas = range('A','Z');
        $array_columns = array(
            'numb' => 'STT',
            'biensoxe' => 'Biển số xe',
            'hieuxe' => 'Hiệu xe',
            'loaixe' => 'Loại xe',
            'socho' => 'Số chỗ',
            'namsx' => 'Năm sản xuất',
            'mauson' => 'Màu sơn',
            'hang' => 'Hãng',
            'shhd' => 'SH/HD',
            'sokhung' => 'Số khung',
            'somay' => 'Số máy',
            'sogplx' => 'Số GPLX',
            'ngaycapgplx' => 'Ngày cấp GPLX',
            'hethan' => 'Ngày hết hạn GPTL',
            'seridat' => 'Số Seri DAT',
            'imei1' => 'IMEI 1',
            'imei2' => 'IMEI 2',
            'chuxe' => 'Chủ xe',
            'sdt' => 'SĐT',
            'kiemdinh' => 'Số GCN Kiểm định ATKT & BVMT'
        );

        /* Khởi tạo và style cho row đầu tiên */
        $i=0;
        foreach($array_columns as $k=>$v)
        {
            if($k=='numb')
            {
                $PHPExcel->getActiveSheet()->getColumnDimension($alphas[$i])->setWidth(5);
            }
            else if($k=='chuxe' || $k=='kiemdinh')
            {
                $PHPExcel->getActiveSheet()->getColumnDimension($alphas[$i])->setWidth(40);
            }
            else
            {
                $PHPExcel->getActiveSheet()->getColumnDimension($alphas[$i])->setWidth(25);
            }
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[$i].'1', $v);
            $PHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
            $PHPExcel->getActiveSheet()->getStyle($alphas[$i].'1')->applyFromArray( 
                array( 
                    'font' => array( 
                        'color' => array( 'rgb' => '000000' ), 
                        'name' => 'Calibri', 
                        'bold' => true, 
                        'italic' => false, 
                        'size' => 10 
                    ), 
                    'alignment' => array( 
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 
                        'wrap' => true 
                    ),
                    'borders' => array(
                        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                        'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                    )
                )
            );
            $i++; 
        }
        /* Lấy và Xuất dữ liệu */
        $where = "";
        $data = (isset($_REQUEST)) ? $_REQUEST : null;
        if($data)
        {
            foreach($data as $column => $value)
            {
                if($value > 0)
                {
                    $where .= " and ".$column." = ".$value;
                }
            }
        }

        if (!empty($_REQUEST['car-id'])) {
        // Show data search
            $dataResult['car_id'] = explode(",", $_REQUEST['car-id']);

            foreach($dataResult['car_id'] as $s => $vc){
                $where .= ($s == 0 ? ' and (' : ' or') ." id_xe = '".$vc."'";
            }
            $where = $where.")";
        }

        if (!empty($_REQUEST['car-loai'])) {
        // Show data search
            $dataResult['car_loai'] = explode(",", $_REQUEST['car-loai']);

            foreach($dataResult['car_loai'] as $s => $vc){
                $where .= ($s == 0 ? ' and (' : ' or') ." loaixe = '".$vc."'";
            }
            $where = $where.")";
        }

        if (!empty($_REQUEST['courses-id'])) {
        // Show data search
            $dataResult['courses_id'] = explode(",", $_REQUEST['courses-id']);
            $arrId = '';

            foreach($dataResult['courses_id'] as $key => $id_courses){
                $rowCourses = $d->rawQueryOne("select data_car from #_courses where MA_KHOA_HOC = ? limit 1",array($id_courses));
                if(!empty($rowCourses['data_car'])) $arrId .= ($arrId != '' ? ',' : '') . implode(",", json_decode($rowCourses['data_car'],true));
            }

            if($arrId != '') {
                $arrayTeacher = array_unique(explode(',',$arrId));
                $arrayTeacher = array_values($arrayTeacher);
                $where .= " and id IN (".implode(',',$arrayTeacher).")";
            }
        }

        if (!empty($_REQUEST['courses-name'])) {
        // Show data search
            $dataResult['courses-name'] = explode(",", $_REQUEST['courses-name']);

            foreach($dataResult['courses-name'] as $key => $name_courses){
                $rowCourses = $d->rawQueryOne("select data_car from #_courses where TEN_KHOA_HOC = ? limit 1",array($name_courses));

                if(!empty($rowCourses['data_car'])) $arrId .= ($arrId != '' ? ',' : '') . implode(",", json_decode($rowCourses['data_car'],true));
            }

            if($arrId != '') {
                $arrayTeacher = array_unique(explode(',',$arrId));
                $arrayTeacher = array_values($arrayTeacher);
                $where .= " and id IN (".implode(',',$arrayTeacher).")";
            }
        }

        $product = $d->rawQuery("select * from #_car where id <> 0 $whereCategory order by numb,id desc");

        $position=2;
        for($i=0;$i<count($product);$i++)
        {
            $j=0;
            foreach($array_columns as $k=>$v)
            {
                if($k=='hethan' || $k=='ngaycapgplx')
                {
                    $datacell = (!empty($product[$i][$k])) ? date('Y-m-d',$product[$i][$k]) : '';
                }
                else
                {
                    $datacell = $product[$i][$k];
                }

                $PHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[$j].$position, htmlspecialchars_decode($datacell));
                $j++;
            }
            $PHPExcel->getActiveSheet()->getRowDimension($position)->setRowHeight(25);
            $position++;
        }

        /* Style cho các row dữ liệu */
        $position=2;
        for($i=0;$i<count($product);$i++)
        {
            $j=0;
            foreach($array_columns as $k=>$v)
            {
                $PHPExcel->getActiveSheet()->getStyle($alphas[$j].$position)->applyFromArray(
                    array( 
                        'font' => array( 
                            'color' => array('rgb' => '000000'), 
                            'name' => 'Calibri', 
                            'bold' => false, 
                            'italic' => false, 
                            'size' => 10 
                        ), 
                        'alignment' => array( 
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 
                            'wrap' => true 
                        ),
                        'borders' => array(
                            'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                        )
                    )
                );
                $j++;
            }
            $position++;
        }

        /* Rename title */
        $PHPExcel->getActiveSheet()->setTitle('Danh sách Xe');

        /* Khởi tạo chỉ mục ở đầu sheet */
        $PHPExcel->setActiveSheetIndex(0);

        /* Xuất file */
        $time = time();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="cars_'.$time.'_'.date('d_m_Y').'.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit();
    }
    else
    {
        $func->transfer("Dữ liệu rỗng", "index.php?com=export&act=man&type=".$type, false);
    }
}

function exportXMLCar() {
    global $d, $func;

    /* Lấy và Xuất dữ liệu */
    $where = "";
    $listCar = $d->rawQuery("select * from #_car where id <> 0 ".$where);

    $array_fields = array(
        'numb' => 'STT',
        'id_xe' => 'IDXE',
        'biensoxe' => 'BIEN_SO_XE',
        'hieuxe' => 'HIEU_XE',
        'loaixe' => 'LOAI_XE',
        'socho' => 'SO_CHO',
        'namsx' => 'NAM_SX',
        'mauson' => 'MAU_SON',
        'hang' => 'HANG',
        'shhd' => 'SHHD',
        'sokhung' => 'SO_KHUNG',
        'somay' => 'SO_MAY',
        'sogplx' => 'SO_GPLX',
        'ngaycapgplx' => 'NGAY_CAP_GPLX',
        'hethan' => 'NGAY_HH_GPLX',
        'seridat' => 'SERI_DAT',
        'imei1' => 'IMEI1',
        'imei2' => 'IMEI2',
        'chuxe' => 'CHU_XE',
        'sdt' => 'SĐT',
        'kiemdinh' => 'SO_KIEM_DINH'
    );

    header('Content-Disposition: attachment; filename="dsxe-'.time().'.xml"');
    header('Content-Type: application/xml; charset=utf-8');

        // Tạo đối tượng DOMDocument mới
    $dom = new DOMDocument('1.0', 'UTF-8');

        // Tạo phần tử gốc DSXE
    $dsxe = $dom->createElement('DSXE');
    $dom->appendChild($dsxe);

        // Tạo phần tử DATA
    $data = $dom->createElement('DATA');
    $dsxe->appendChild($data);

        // Tạo phần tử XES
    $xes = $dom->createElement('XES');
    $data->appendChild($xes);


    foreach($listCar as $numb => $v){
            // Tạo phần tử XE
        $numb = $numb + 1;
            // Tạo phần tử XE
        ${'xe'.($numb)} = $dom->createElement('XE');
        $xes->appendChild(${'xe'.($numb)});

            // Thêm các phần tử con vào XE
        foreach ($array_fields as $k => $f) {
            if ($f == 'NGAY_CAP_GPLX' || $f == 'NGAY_HH_GPLX') {
                if (!empty($v[$k])) ${'xe' . ($numb)}->appendChild($dom->createElement($f, date('Y-m-d',$v[$k])));
                else ${'xe' . ($numb)}->appendChild($dom->createElement($f, ''));
            } else {
                ${'xe' . ($numb)}->appendChild($dom->createElement($f, $v[$k]));
            }
        }   
    }
    
        // Tạo phần tử Signature
    $signature = $dom->createElement('Signature');
    $signature->setAttribute('xmlns', 'http://www.w3.org/2000/09/xmldsig#');
    $dsxe->appendChild($signature);

        // Tạo phần tử SignedInfo và thêm vào Signature
    $signedInfo = $dom->createElement('SignedInfo');
    $signature->appendChild($signedInfo);

        // Tạo phần tử CanonicalizationMethod và thêm vào SignedInfo
    $canonicalizationMethod = $dom->createElement('CanonicalizationMethod');
    $canonicalizationMethod->setAttribute('Algorithm', 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315');
    $signedInfo->appendChild($canonicalizationMethod);

        // Tạo phần tử SignatureMethod và thêm vào SignedInfo
    $signatureMethod = $dom->createElement('SignatureMethod');
    $signatureMethod->setAttribute('Algorithm', 'http://www.w3.org/2000/09/xmldsig#rsa-sha1');
    $signedInfo->appendChild($signatureMethod);

        // Tạo phần tử Reference và thêm vào SignedInfo
    $reference = $dom->createElement('Reference');
    $reference->setAttribute('URI', '');
    $signedInfo->appendChild($reference);

        // Tạo phần tử Transforms và thêm vào Reference
    $transforms = $dom->createElement('Transforms');
    $reference->appendChild($transforms);

        // Tạo phần tử Transform và thêm vào Transforms
    $transform = $dom->createElement('Transform');
    $transform->setAttribute('Algorithm', 'http://www.w3.org/2000/09/xmldsig#enveloped-signature');
    $transforms->appendChild($transform);

        // Tạo phần tử DigestMethod và thêm vào Reference
    $digestMethod = $dom->createElement('DigestMethod');
    $digestMethod->setAttribute('Algorithm', 'http://www.w3.org/2000/09/xmldsig#sha1');
    $reference->appendChild($digestMethod);

        // Tạo phần tử DigestValue và thêm vào Reference
    $digestValue = $dom->createElement('DigestValue', '');
    $reference->appendChild($digestValue);

        // Tạo phần tử SignatureValue và thêm vào Signature
    $signatureValue = $dom->createElement('SignatureValue', '');
    $signature->appendChild($signatureValue);


      // Khỏi tạo mảng tên file xml để xíu nén lại tải xuống
    $files_to_zip = array();

        // Lưu XML vào file
        $dom->formatOutput = true; // Định dạng đầu ra
        echo $dom->saveXML();
        exit;
        
    }

    function exportXMLBC2() {
        global $d, $func, $loginAdmin;

        /* Lấy và Xuất dữ liệu */
        $where = "";
        $validate = (!empty($_GET)) ? $_GET : null;

        $quantitySucess = 0;

        $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.NGAY_RA_QDTN')) > 0";
        $where .= " and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.theory.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.geometry.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.cabin.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.dat.point')) > 0";
        $where .= " and (NOT JSON_CONTAINS_PATH(data_student, 'one', '$.KET_QUA_SH') OR JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) IS NULL OR JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) = '' OR JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) != 'DA') ";

        if (!empty($_REQUEST['courses-id'])) {
        // Show data search
            $dataResult['courses_id'] = explode(",", $_REQUEST['courses-id']);

            foreach($dataResult['courses_id'] as $s => $vc){
                $where .= ($s == 0 ? ' and (' : ' or') ." MA_KHOA_HOC = '".$vc."'";
            }
            $where = $where.")";
        }

        if (!empty($_REQUEST['gplx'])) {
            $arrayGPLX = explode(",", $_REQUEST['gplx']);

            foreach($arrayGPLX as $s => $v){
                $where .= ($s == 0 ? ' and (' : ' or') ." HANG_GPLX = '".$v."'";
            }
            $where = $where.")";
        }

        if (!empty($_REQUEST['student-name'])) {
            $dataResult['student-name'] = explode(",", $_REQUEST['student-name']);

            foreach($dataResult['student-name'] as $s => $vc){
                $where .= ($s == 0 ? ' and (' : ' or') ." HO_VA_TEN LIKE '%".$vc."%'";
            }
            $where = $where.")";
        }
        

        if (!empty($_REQUEST['student-id'])) {
            $dataResult['student-id'] = explode(",", $_REQUEST['student-id']);

            foreach($dataResult['student-id'] as $s => $vc){
                $where .= ($s == 0 ? ' and (' : ' or') ." MA_DK = '".$vc."'";
            }
            $where = $where.")";
        }

        if ($_REQUEST['student-id'] == 0 && $_REQUEST['student-id'] != '') {
            $where .= " and `MA_DK` = '' and JSON_EXTRACT(infor_student, '$.tuition_fee') > 0";
        }


        if (!empty($_REQUEST['student-cmt'])) {
            $dataResult['student-cmt'] = explode(",", $_REQUEST['student-cmt']);

            foreach($dataResult['student-cmt'] as $s => $vc){
                $where .= ($s == 0 ? ' and (' : ' or') ." SO_CMT = '".$vc."'";
            }
            $where = $where.")";
        }

        if (!empty($_REQUEST['courses-name'])) {
                // Show data search
            $dataResult['courses-name'] = explode(",", $_REQUEST['courses-name']);

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
        if (!empty($date_open)) {
            $date_open = explode("-", $date_open);
            $date_from = trim($date_open[0] . ' 12:00:00 AM');
            $date_to = trim($date_open[1] . ' 11:59:59 PM');
            $date_from = strtotime(str_replace("/", "-", $date_from));
            $date_to = strtotime(str_replace("/", "-", $date_to));
            $whereCourses .= " and NGAY_KHAI_GIANG<=$date_to and NGAY_KHAI_GIANG>=$date_from";
        }

        if (!empty($date_close)) {
            $date_close = explode("-", $date_close);
            $date_from = trim($date_close[0] . ' 12:00:00 AM');
            $date_to = trim($date_close[1] . ' 11:59:59 PM');
            $date_from = strtotime(str_replace("/", "-", $date_from));
            $date_to = strtotime(str_replace("/", "-", $date_to));
            $whereCourses .= " and NGAY_BE_GIANG<=$date_to and NGAY_BE_GIANG>=$date_from";
        }

        if (!empty($date_sh)) {
            $date_sh = explode("-", $date_sh);
            $date_from = trim($date_sh[0] . ' 12:00:00 AM');
            $date_to = trim($date_sh[1] . ' 11:59:59 PM');
            $date_from = strtotime(str_replace("/", "-", $date_from));
            $date_to = strtotime(str_replace("/", "-", $date_to));
            $whereCourses .= " and NGAY_SAT_HACH<=$date_to and NGAY_SAT_HACH>=$date_from";
        }

        $statusGraduate = (!empty($_REQUEST['graduate-status']) ? $_REQUEST['graduate-status'] : 0);
        $statusTest = (!empty($_REQUEST['test-status']) ? $_REQUEST['test-status'] : 0);
        $result_bc2 = (!empty($_REQUEST['result-bc2']) ? $_REQUEST['result-bc2'] : 0);

        if (!empty($result_bc2) && $result_bc2 == 1) {
            $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KQ_BC2')) = 1";
        }
        if (!empty($result_bc2) && $result_bc2 == 2) {
            $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KQ_BC2')) = 0";
        }

        if (!empty($statusGraduate) && $statusGraduate > 0) {
            $where .= " and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.theory.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.geometry.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.cabin.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.dat.point')) > 0";
        }

        if (!empty($statusTest)) {
            if($statusTest == 1) $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) = 'DA'";
            elseif($statusTest == 3) $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) = 'KDDK'";
            elseif($statusTest == 2) $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) != 'KDDK' and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) != 'DA'";
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

        
        // Lấy course ID
        $courseID = $d->rawQuery("select MA_KHOA_HOC from #_student where id <> 0 $where group by MA_KHOA_HOC");

        // Khỏi tạo mảng tên file xml để xíu nén lại tải xuống
        $files_to_zip = array();

        // Lấy Header
        foreach ($courseID as $n => $courses) {
            $courseIn4 = $d->rawQueryOne("select * from #_courses where MA_KHOA_HOC = '".$courses['MA_KHOA_HOC']."'");
            $courseHeader = json_decode($courseIn4['data_header'],true);
            $courseData = json_decode($courseIn4['data_courses'],true);

             // Lấy danh sách người LX
            $listStudent = $d->rawQuery("select * from #_student where id <> 0 $where and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.NGAY_RA_QDTN')) > 0 and MA_KHOA_HOC = '".$courses['MA_KHOA_HOC']."'");
            $quantitySucess += count($listStudent);


            // Tạo một đối tượng DOMDocument mới
            $dom = new DOMDocument('1.0', 'UTF-8');

            // Tạo phần tử gốc
            $bao_cao1 = $dom->createElement('BAO_CAO2');
            $dom->appendChild($bao_cao1);



            // Tạo phần tử HEADER
            $header = $dom->createElement('HEADER');
            $bao_cao1->appendChild($header);

            // Thêm các phần tử con vào HEADER
            $header->appendChild($dom->createElement('MA_GIAO_DICH', !empty($courseHeader['MA_GIAO_DICH']) ? $courseHeader['MA_GIAO_DICH'] : ''));
            $header->appendChild($dom->createElement('MA_DV_GUI', '79038'));
            $header->appendChild($dom->createElement('TEN_DV_GUI', 'Trung Tâm Giáo Dục Nghề Nghiệp Lái Xe Tiến Đạt'));
            $header->appendChild($dom->createElement('NGAY_GUI', date('Y-m-d H:i:s')));
            $header->appendChild($dom->createElement('NGUOI_GUI', 'ADMIN'));
            $header->appendChild($dom->createElement('TONG_SO_BAN_GHI', count($listStudent)));


            // Tạo phần tử DATA
            $data = $dom->createElement('DATA');
            $bao_cao1->appendChild($data);

            // Tạo phần tử BCII
            $bcii = $dom->createElement('BCII');
            $data->appendChild($bcii);

            // Thêm các phần tử con vào BCII
            $bcii->appendChild($dom->createElement('MA_BCII', !empty($courseData['MA_BCI']) ? $courseData['MA_BCI'] : ''));
            $bcii->appendChild($dom->createElement('MA_BCI', !empty($courseData['MA_BCI']) ? $courseData['MA_BCI'] : ''));
            $bcii->appendChild($dom->createElement('MA_CSDT', '79038'));
            $bcii->appendChild($dom->createElement('SO_CV_BCII', !empty($courseData['MA_BCI']) ? $courseData['MA_BCI'] : ''));
            $bcii->appendChild($dom->createElement('NGAY_CV_BCII', date('Y-m-d')));
            $bcii->appendChild($dom->createElement('SO_THI_SINH', count($listStudent)));


            // Tạo phần tử NGUOI_LXS
            $nguoi_lxs = $dom->createElement('NGUOI_LXS');
            $data->appendChild($nguoi_lxs);

            // Tạo phần tử NGUOI_LX

            foreach ($listStudent as $numb => $v) {
                $data_student = json_decode($v['data_student'],true);

                $numb = $numb + 1;

                ${'nguoi_lx' . ($numb)} = $dom->createElement('NGUOI_LX');
                $nguoi_lxs->appendChild(${'nguoi_lx' . ($numb)});

                // Thêm các phần tử con vào NGUOI_LX
                ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('SO_TT', $numb));
                ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('MA_DK', !empty($v['MA_DK']) ? $v['MA_DK'] : ''));
                ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('HO_TEN_DEM', !empty($data_student['HO_TEN_DEM']) ? $data_student['HO_TEN_DEM'] : ''));
                ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('TEN', !empty($data_student['TEN']) ? $data_student['TEN'] : ''));
                ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('HO_VA_TEN', !empty($v['HO_VA_TEN']) ? $v['HO_VA_TEN'] : ''));
                ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('NGAY_SINH', !empty($data_student['NGAY_SINH']) ? $func->formatDateString(date('Y-m-d', $data_student['NGAY_SINH'])) : ''));


                ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('NOI_CT', !empty($data_student['NOI_CT']) ? $data_student['NOI_CT'] : ''));
                ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('NOI_CT_MA_DVHC', !empty($data_student['NOI_CT_MA_DVHC']) ? $data_student['NOI_CT_MA_DVHC'] : ''));
                ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('NOI_CT_MA_DVQL', !empty($data_student['NOI_CT_MA_DVQL']) ? $data_student['NOI_CT_MA_DVQL'] : ''));
                ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('SO_CMT', !empty($v['SO_CMT']) ? $v['SO_CMT'] : ''));
                ${'nguoi_lx' . ($numb)}->appendChild($dom->createElement('HO_VA_TEN_IN', !empty($data_student['HO_VA_TEN_IN']) ? $data_student['HO_VA_TEN_IN'] : ''));


                // Tạo phần tử HO_SO
                $ho_so = $dom->createElement('HO_SO');
                ${'nguoi_lx' . ($numb)}->appendChild($ho_so);

                // Thêm các phần tử con vào HO_SO
                $ho_so->appendChild($dom->createElement('SO_HO_SO', !empty($data_student['SO_HO_SO']) ? $data_student['SO_HO_SO'] : ''));
                $ho_so->appendChild($dom->createElement('SO_GPLX_DA_CO', !empty($data_student['SO_GPLX_DA_CO']) ? $data_student['SO_GPLX_DA_CO'] : ''));
                $ho_so->appendChild($dom->createElement('HANG_GPLX_DA_CO', !empty($data_student['HANG_GPLX_DA_CO']) ? $data_student['HANG_GPLX_DA_CO'] : ''));
                $ho_so->appendChild($dom->createElement('NAM_HOC_LAIXE', !empty($data_student['NAM_HOC_LAIXE']) ? $data_student['NAM_HOC_LAIXE'] : ''));
                $ho_so->appendChild($dom->createElement('SO_NAM_LAIXE', !empty($data_student['SO_NAM_LAIXE']) ? $data_student['SO_NAM_LAIXE'] : ''));
                $ho_so->appendChild($dom->createElement('SO_KM_ANTOAN', !empty($data_student['SO_KM_ANTOAN']) ? $data_student['SO_KM_ANTOAN'] : ''));
                $ho_so->appendChild($dom->createElement('GIAY_CNSK', !empty($data_student['GIAY_CNSK']) ? $data_student['GIAY_CNSK'] : ''));
                $ho_so->appendChild($dom->createElement('SO_GIAY_CNTN', !empty($data_student['SO_GIAY_CNTN']) ? $data_student['SO_GIAY_CNTN'] : ''));
                $ho_so->appendChild($dom->createElement('SO_CCN', !empty($data_student['SO_CCN']) ? $data_student['SO_CCN'] : ''));
                $ho_so->appendChild($dom->createElement('BC2_GHICHU', !empty($data_student['BC2_GHICHU']) ? $data_student['BC2_GHICHU'] : ''));
                $ho_so->appendChild($dom->createElement('NGAY_RA_QDTN', !empty($data_student['NGAY_RA_QDTN']) ? date('Y-m-d',$data_student['NGAY_RA_QDTN']) : ''));
            }
            // Tạo phần tử Signature
            $signature = $dom->createElement('Signature');
            $signature->setAttribute('xmlns', 'http://www.w3.org/2000/09/xmldsig#');
            $bao_cao1->appendChild($signature);

                // Tạo phần tử SignedInfo và thêm vào Signature
            $signedInfo = $dom->createElement('SignedInfo');
            $signature->appendChild($signedInfo);

                // Tạo phần tử CanonicalizationMethod và thêm vào SignedInfo
            $canonicalizationMethod = $dom->createElement('CanonicalizationMethod');
            $canonicalizationMethod->setAttribute('Algorithm', 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315');
            $signedInfo->appendChild($canonicalizationMethod);

                // Tạo phần tử SignatureMethod và thêm vào SignedInfo
            $signatureMethod = $dom->createElement('SignatureMethod');
            $signatureMethod->setAttribute('Algorithm', 'http://www.w3.org/2000/09/xmldsig#rsa-sha1');
            $signedInfo->appendChild($signatureMethod);

                // Tạo phần tử Reference và thêm vào SignedInfo
            $reference = $dom->createElement('Reference');
            $reference->setAttribute('URI', '');
            $signedInfo->appendChild($reference);

                // Tạo phần tử Transforms và thêm vào Reference
            $transforms = $dom->createElement('Transforms');
            $reference->appendChild($transforms);

                // Tạo phần tử Transform và thêm vào Transforms
            $transform = $dom->createElement('Transform');
            $transform->setAttribute('Algorithm', 'http://www.w3.org/2000/09/xmldsig#enveloped-signature');
            $transforms->appendChild($transform);

                // Tạo phần tử DigestMethod và thêm vào Reference
            $digestMethod = $dom->createElement('DigestMethod');
            $digestMethod->setAttribute('Algorithm', 'http://www.w3.org/2000/09/xmldsig#sha1');
            $reference->appendChild($digestMethod);

                // Tạo phần tử DigestValue và thêm vào Reference
            $digestValue = $dom->createElement('DigestValue', '');
            $reference->appendChild($digestValue);

                // Tạo phần tử SignatureValue và thêm vào Signature
            $signatureValue = $dom->createElement('SignatureValue', '');
            $signature->appendChild($signatureValue);
            // Lưu XML vào file
            $dom->formatOutput = true; // Định dạng đầu ra
            $dom->save('BC2'.(!empty($courseIn4['TEN_KHOA_HOC']) ? '-' : '').$courseIn4['TEN_KHOA_HOC'].'-'.time().'.xml');
            array_push($files_to_zip,'BC2'.(!empty($courseIn4['TEN_KHOA_HOC']) ? '-' : '').$courseIn4['TEN_KHOA_HOC'].'-'.time().'.xml');
        }

        if ($quantitySucess == 0) {
            foreach ($files_to_zip as $file) {
                if (file_exists($file)) {
                 unlink($file);
             }
         }
         $func->transfer("Không tồn tại học viên hợp lệ !!!","index.php?com=graduate&act=man",false);
     }

     $zip = new ZipArchive();
     $filename = "BC2-XML-".time().".zip";

     if ($zip->open($filename, ZipArchive::CREATE) !== TRUE) {
        exit("Không thể mở file <$filename>\n");
    }

    foreach ($files_to_zip as $file) {
        if (file_exists($file)) {
            $zip->addFile($file, basename($file));
        } else {
            echo "File không tồn tại: $file\n";
        }
    }

    $zip->close();

        // Lưu lại lịch sử
    $dataHistory['namevi'] = '';
    $dataHistory['descvi'] = 'Export File XML báo cáo 2';
    $dataHistory['file'] = $filename;
    $dataHistory['type'] = 'export-xml-bc2';
    $dataHistory['quantity'] = $quantitySucess;
    $dataHistory['date_created'] = time();
    $dataHistory['id_downloader'] = $_SESSION[$loginAdmin]['id'];
    $dataHistory['downloads'] = 1;
    $d->insert('user_operation', $dataHistory);

        // Gửi file xuống trình duyệt
    header('Content-Type: application/zip');
    header('Content-disposition: attachment; filename='.$filename);
    header('Content-Length: ' . filesize($filename));
    readfile($filename);

        // Xoá file zip sau khi tải xuống
        // unlink($filename);

        // Chuyển file vào thư mục lưu lại
    rename($filename, UPLOAD_FILE.'operation/'.$filename);

    foreach ($files_to_zip as $file) {
        if (file_exists($file)) {
           unlink($file);
       }
   }

   exit;   
}

function exportExcelBC2()
{
    global $d, $func, $act, $loginAdmin;

    /* Setting */
    $setting = $d->rawQueryOne("select * from #_setting limit 0,1");
    $optsetting = (!empty($setting['options']) && $setting['options'] != '') ? json_decode($setting['options'],true) : null;
    $quantitySucess = 0;

    if(!empty($_POST['exportExcel']) || 1)
    {
        /* PHPExcel */
        require_once LIBRARIES.'PHPExcel.php';

        /* Khởi tọa đối tượng */
        $PHPExcel = new PHPExcel();

        /* Khởi tạo thông tin người tạo */
        $PHPExcel->getProperties()->setCreator($setting['namevi']);
        $PHPExcel->getProperties()->setLastModifiedBy($setting['namevi']);
        $PHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
        $PHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
        $PHPExcel->getProperties()->setDescription("Document for Office 2007 XLSX, generated using PHP classes.");

        /* Khởi tạo mảng column */
        $alphas = range('A','Z');
        $alphas2 = range('A','Z');
        for ($i = 0; $i < 26 ; ++$i) {
            $tem = $alphas2[0].$alphas2[$i];
            array_push($alphas, $tem);
        }
        $alphas2 = range('A','Z');
        for ($i = 0; $i < 26 ; ++$i) {
            $tem = $alphas2[0].$alphas2[$i];
            array_push($alphas, $tem);
        }
        $array_columns = array(
            'numb'=>'STT',
            'MA_DK'=>'MA_DK',
            'HO_TEN_DEM'=>'HO_TEN_DEM',
            'TEN'=>'TEN',
            'HO_VA_TEN'=>'HO_VA_TEN',
            'NGAY_SINH'=>'NGAY_SINH',
            'NOI_CT'=>'NOI_CT',
            'NOI_CT_MA_DVHC'=>'NOI_CT_MA_DVHC',
            'NOI_CT_MA_DVQL'=>'NOI_CT_MA_DVQL',
            'SO_CMT'=>'SO_CMT',
            'HO_VA_TEN_IN'=>'HO_VA_TEN_IN',
            'SO_HO_SO'=>'SO_HO_SO',
            'SO_GPLX_DA_CO'=>'SO_GPLX_DA_CO',
            'HANG_GPLX_DA_CO'=>'HANG_GPLX_DA_CO',
            'NAM_HOC_LAIXE'=>'NAM_HOC_LAIXE',
            'SO_NAM_LAIXE'=>'SO_NAM_LAIXE',
            'SO_KM_ANTOAN'=>'SO_KM_ANTOAN',
            'GIAY_CNSK'=>'GIAY_CNSK',
            'SO_GIAY_CNTN'=>'SO_GIAY_CNTN',
            'SO_CCN'=>'SO_CCN',
            'BC2_GHICHU'=>'BC2_GHICHU',
            'NGAY_RA_QDTN'=>'NGAY_RA_QDTN',
        );

        $array_info = array(
            'HO_TEN_DEM',
            'TEN',
            'NGAY_SINH',
            'MA_QUOC_TICH',
            'TEN_QUOC_TICH',
            'NOI_TT',
            'NOI_TT_MA_DVHC',
            'NOI_TT_MA_DVQL',
            'NOI_CT',
            'NOI_CT_MA_DVHC',
            'NOI_CT_MA_DVQL',
            'NGAY_CAP_CMT',
            'NOI_CAP_CMT',
            'GIOI_TINH',
            'HO_VA_TEN_IN',
            'SO_CMND_CU',
            'SO_HO_SO',
            'MA_DV_NHAN_HOSO',
            'NGAY_NHAN_HOSO',
            'NGUOI_NHAN_HOSO',
            'MA_LOAI_HOSO',
            'TEN_LOAI_HOSO',
            'CHAT_LUONG_ANH',
            'NGAY_THU_NHAN_ANH',
            'DV_CAP_GPLX_DACO',
            'TEN_DV_CAP_GPLX_DACO',
            'NOI_CAP_GPLX_DACO',
            'NGAY_CAP_GPLX_DACO',
            'NGAY_HH_GPLX_DACO',
            'NGAY_TT_GPLX_DACO',
            'MA_NOI_HOC_LAIXE',
            'NAM_HOC_LAIXE',
            'SO_NAM_LAIXE',
            'SO_KM_ANTOAN',
            'GIAY_CNSK',
            'HINH_THUC_CAP',
            'CHON_IN_GPLX',
            'SO_GIAY_CNTN'=>'SO_GIAY_CNTN',
            'SO_CCN'=>'SO_CCN',
            'BC2_GHICHU'=>'BC2_GHICHU',
            'NGAY_RA_QDTN'=>'NGAY_RA_QDTN',
        );


        /* Khởi tạo và style cho row tiêu đề */
        $i=0;
        foreach($array_columns as $k=>$v)
        {
            if($k=='numb')
            {
                $PHPExcel->getActiveSheet()->getColumnDimension($alphas[$i])->setWidth(5);
            }
            else{

                $PHPExcel->getActiveSheet()->getColumnDimension($alphas[$i])->setWidth(32);
            }

            $PHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[$i].'4', $v);
            $PHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(25);
            $PHPExcel->getActiveSheet()->getStyle($alphas[$i].'4')->applyFromArray( array( 'font' => array( 'color' => array( 'rgb' => 'ffffff' ), 'name' => 'Times New Roman', 'bold' => true, 'italic' => false, 'size' => 12 ), 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'wrap' => true ),'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb'=>'2F75B5'))));
            $i++; 
        }

        /* Lấy và Xuất dữ liệu */
        $where = "";
        $validate = (!empty($_GET)) ? $_GET : null;

        $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.NGAY_RA_QDTN')) > 0";
        $where .= " and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.theory.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.geometry.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.cabin.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.dat.point')) > 0";
        $where .= " and (NOT JSON_CONTAINS_PATH(data_student, 'one', '$.KET_QUA_SH') OR JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) IS NULL OR JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) = '' OR JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) != 'DA') ";

        if (!empty($_REQUEST['gplx'])) {
            $arrayGPLX = explode(",", $_REQUEST['gplx']);

            foreach($arrayGPLX as $s => $v){
                $where .= ($s == 0 ? ' and (' : ' or') ." HANG_GPLX = '".$v."'";
            }
            $where = $where.")";
        }

        if (!empty($_REQUEST['student-name'])) {
            $dataResult['student-name'] = explode(",", $_REQUEST['student-name']);

            foreach($dataResult['student-name'] as $s => $vc){
                $where .= ($s == 0 ? ' and (' : ' or') ." HO_VA_TEN LIKE '%".$vc."%'";
            }
            $where = $where.")";
        }
        if (!empty($_REQUEST['student-id'])) {
            $dataResult['student-id'] = explode(",", $_REQUEST['student-id']);

            foreach($dataResult['student-id'] as $s => $vc){
                $where .= ($s == 0 ? ' and (' : ' or') ." MA_DK = '".$vc."'";
            }
            $where = $where.")";
        }

        if ($_REQUEST['student-id'] == 0 && $_REQUEST['student-id'] != '') {
          $where .= " and `MA_DK` = '' and JSON_EXTRACT(infor_student, '$.tuition_fee') > 0";
      }

      if (!empty($_REQUEST['student-cmt'])) {
        $dataResult['student-cmt'] = explode(",", $_REQUEST['student-cmt']);

        foreach($dataResult['student-cmt'] as $s => $vc){
            $where .= ($s == 0 ? ' and (' : ' or') ." SO_CMT = '".$vc."'";
        }
        $where = $where.")";
    }

    if (!empty($_REQUEST['courses-name'])) {
                // Show data search
        $dataResult['courses-name'] = explode(",", $_REQUEST['courses-name']);

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
    if (!empty($date_open)) {
        $date_open = explode("-", $date_open);
        $date_from = trim($date_open[0] . ' 12:00:00 AM');
        $date_to = trim($date_open[1] . ' 11:59:59 PM');
        $date_from = strtotime(str_replace("/", "-", $date_from));
        $date_to = strtotime(str_replace("/", "-", $date_to));
        $whereCourses .= " and NGAY_KHAI_GIANG<=$date_to and NGAY_KHAI_GIANG>=$date_from";
    }

    if (!empty($date_close)) {
        $date_close = explode("-", $date_close);
        $date_from = trim($date_close[0] . ' 12:00:00 AM');
        $date_to = trim($date_close[1] . ' 11:59:59 PM');
        $date_from = strtotime(str_replace("/", "-", $date_from));
        $date_to = strtotime(str_replace("/", "-", $date_to));
        $whereCourses .= " and NGAY_BE_GIANG<=$date_to and NGAY_BE_GIANG>=$date_from";
    }

    if (!empty($date_sh)) {
        $date_sh = explode("-", $date_sh);
        $date_from = trim($date_sh[0] . ' 12:00:00 AM');
        $date_to = trim($date_sh[1] . ' 11:59:59 PM');
        $date_from = strtotime(str_replace("/", "-", $date_from));
        $date_to = strtotime(str_replace("/", "-", $date_to));
        $whereCourses .= " and NGAY_SAT_HACH<=$date_to and NGAY_SAT_HACH>=$date_from";
    }

    $statusGraduate = (!empty($_REQUEST['graduate-status']) ? $_REQUEST['graduate-status'] : 0);
    $statusTest = (!empty($_REQUEST['test-status']) ? $_REQUEST['test-status'] : 0);
     $result_bc2 = (!empty($_REQUEST['result-bc2']) ? $_REQUEST['result-bc2'] : 0);

        if (!empty($result_bc2) && $result_bc2 == 1) {
            $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KQ_BC2')) = 1";
        }
        if (!empty($result_bc2) && $result_bc2 == 2) {
            $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KQ_BC2')) = 0";
        }

    if (!empty($statusGraduate) && $statusGraduate > 0) {
        $where .= " and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.theory.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.geometry.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.cabin.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.dat.point')) > 0";
    }

    if (!empty($statusTest)) {
        if($statusTest == 1) $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) = 'DA'";
        elseif($statusTest == 3) $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) = 'KDDK'";
        elseif($statusTest == 2) $where .= " and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) != 'KDDK' and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.KET_QUA_SH')) != 'DA'";
    }

    if (!empty($whereCourses) && $whereCourses != '') {

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


            // Lấy course ID
    $courseID = $d->rawQuery("select MA_KHOA_HOC from #_student where id <> 0 $where group by MA_KHOA_HOC");

            // Khỏi tạo mảng tên file excel để xíu nén lại tải xuống
    $files_to_zip = array();

    if ($courseID) {
        foreach($courseID as $course){
            $student = $d->rawQuery("select * from #_student where id <> 0 $where and MA_KHOA_HOC = ? and JSON_UNQUOTE(JSON_EXTRACT(data_student, '$.NGAY_RA_QDTN')) > 0 order by numb,id desc", array($course['MA_KHOA_HOC']));

            $quantitySucess += count($student);

                    // Lấy SO_BCI và SO_BCII
            $rowBC  = $d->rawQueryOne("select TEN_KHOA_HOC,JSON_UNQUOTE(JSON_EXTRACT(data_courses, '$.MA_BCII')) AS BCII, 
                JSON_UNQUOTE(JSON_EXTRACT(data_courses, '$.MA_BCI')) AS BCI  from #_courses where id <> 0 and MA_KHOA_HOC = ?", array($course['MA_KHOA_HOC']));

            /* Merge cells */
            $PHPExcel->setActiveSheetIndex(0)->mergeCells('A1:V1');
            $PHPExcel->setActiveSheetIndex(0)->mergeCells('A2:V2');
            $PHPExcel->setActiveSheetIndex(0)->mergeCells('A3:V3');

            /* Khởi tạo và style cho row đầu tiên */
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[$i].'1', 'Trung Tâm Giáo Dục Nghề Nghiệp Lái Xe Tiến Đạt');
            $PHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(25);
            $PHPExcel->getActiveSheet()->getStyle($alphas[$i].'1')->applyFromArray( 
                array( 
                    'font' => array( 'color' => array( 'rgb' => '000000' ), 
                        'name' => 'Times New Roman', 'bold' => true, 
                        'italic' => false, 'size' => 12 ), 
                    'alignment' => array( 
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 
                        'wrap' => true )
                )
            );

            /* Khởi tạo và style cho row 2 */
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[$i].'2', $rowBC['BCI']);
            $PHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(25);
            $PHPExcel->getActiveSheet()->getStyle($alphas[$i].'2')->applyFromArray( 
                array( 
                    'font' => array( 'color' => array( 'rgb' => '000000' ), 
                        'name' => 'Times New Roman', 'bold' => true, 
                        'italic' => false, 'size' => 12 ), 
                    'alignment' => array( 
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 
                        'wrap' => true )
                )
            );

            /* Khởi tạo và style cho row 3 */
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[$i].'3', $rowBC['BCII']);
            $PHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(25);
            $PHPExcel->getActiveSheet()->getStyle($alphas[$i].'3')->applyFromArray( 
                array( 
                    'font' => array( 'color' => array( 'rgb' => '000000' ), 
                        'name' => 'Times New Roman', 'bold' => true, 
                        'italic' => false, 'size' => 12 ), 
                    'alignment' => array( 
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 
                        'wrap' => true )
                )
            );



            $position=5;
            for($i=0;$i<count($student);$i++)
            {
                $j=0;
                $optstudent = (!empty($student[$i]['data_student']) && $student[$i]['data_student'] != '') ? json_decode($student[$i]['data_student'],true) : null;

                foreach($array_columns as $k=>$v)
                {
                    if(in_array($k,$array_info)){
                        if ($k == 'NGAY_SINH' || $k == 'NGAY_RA_QDTN') {
                            $datacell = (!empty($optstudent[$k])) ? date('Y-m-d',$optstudent[$k]) : '';
                        } else {
                            $datacell = $optstudent[$k]; 
                        }
                    } else {
                        $datacell = $student[$i][$k];
                    }
                    $PHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[$j].$position, htmlspecialchars_decode($datacell));
                    $j++;
                }
                $position++;
            }

            /* Style cho các row dữ liệu */
            $position=5;
            for($i=0;$i<count($student);$i++)
            {
                $j=0;
                foreach($array_columns as $k=>$v)
                {
                    $PHPExcel->getActiveSheet()->getStyle($alphas[$j].$position)->applyFromArray(
                        array( 
                            'font' => array( 
                                'color' => array('rgb' => '000000'), 
                                'name' => 'Times New Roman', 
                                'bold' => false, 
                                'italic' => false, 
                                'size' => 12 
                            ), 
                            'alignment' => array( 
                                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 
                                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 
                                'wrap' => true 
                            )
                        )
                    );
                    $j++;
                }
                $PHPExcel->getActiveSheet()->getRowDimension($position)->setRowHeight(25);
                $position++;
            }

            /* Rename title */
            $PHPExcel->getActiveSheet()->setTitle('DSHV');

            /* Khởi tạo chỉ mục ở đầu sheet */
            $PHPExcel->setActiveSheetIndex(0);

            /* Xuất file */
            $time = time();
            $filename= "BC2".(!empty($rowBC['TEN_KHOA_HOC']) ? '-' : '').$rowBC['TEN_KHOA_HOC'].'-'.$time.".xlsx";

            $objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel2007');
            $objWriter->save($filename);
            array_push($files_to_zip,$filename);
        }
    }

    if ($quantitySucess == 0) {
        foreach ($files_to_zip as $file) {
            if (file_exists($file)) {
               unlink($file);
           }
       }
       $func->transfer("Không tồn tại học viên hợp lệ !!!","index.php?com=graduate&act=man",false);
   }

   $zip = new ZipArchive();
   $filename = "BC2-EXCEL-".time().".zip";



   if ($zip->open($filename, ZipArchive::CREATE) !== TRUE) {
    exit("Không thể mở file <$filename>\n");
}

foreach ($files_to_zip as $file) {
    if (file_exists($file)) {
        $zip->addFile($file, basename($file));
    } else {
        echo "File không tồn tại: $file\n";
    }
}

$zip->close();

            // Lưu lại lịch sử
$dataHistory['namevi'] = '';
$dataHistory['descvi'] = 'Export File Excel báo cáo 2';
$dataHistory['file'] = $filename;
$dataHistory['type'] = 'export-excel-bc2';
$dataHistory['quantity'] = $quantitySucess;
$dataHistory['date_created'] = time();
$dataHistory['id_downloader'] = $_SESSION[$loginAdmin]['id'];
$dataHistory['downloads'] = 1;
$d->insert('user_operation', $dataHistory);

            // Gửi file xuống trình duyệt
header('Content-Type: application/zip');
header('Content-disposition: attachment; filename='.$filename);
header('Content-Length: ' . filesize($filename));
readfile($filename);

            // Chuyển file vào thư mục lưu lại
rename($filename, UPLOAD_FILE.'operation/'.$filename);

        // Xoá file zip sau khi tải xuống
            // unlink($filename);

foreach ($files_to_zip as $file) {
    if (file_exists($file)) {
     unlink($file);
 }
}

exit;
}
else
{
    $func->transfer("Dữ liệu rỗng", "index.php?com=student&act=man", false);
}
}
?>