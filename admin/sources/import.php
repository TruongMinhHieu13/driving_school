<?php
if (!defined('SOURCES')) die("Error");

/* Kiểm tra active import */
// if (isset($config['product'])) {
//     $arrCheck = array();
//     foreach ($config['product'] as $k => $v) if (isset($v['import']) && $v['import'] == true) $arrCheck[] = $k;
//     if (!count($arrCheck) || !in_array($type, $arrCheck)) $func->transfer(trangkhongtontai, "index.php", false);
// } else {
//     $func->transfer(trangkhongtontai, "index.php", false);
// }

switch ($act) {
    case "uploadXMLBC1":
        uploadXMLBC1();
        break;

    case "uploadXMLBC2":
        uploadXMLBC2();
        break;

    case "uploadExcelBC2":
        uploadExcelBC2();
        break;

    case "uploadExcelBC1":
        uploadExcelBC1();
        break;

    case "uploadExcelGV":
        uploadExcelGV();
        break;

    case "uploadXMLGV":
        uploadXMLGV();
        break;

    case "uploadExcelCar":
        uploadExcelCar();
        break;

    case "uploadXMLCAR":
        uploadXMLCAR();
        break;

    case "uploadXMLKQBC2":
        uploadXMLKQBC2();
        break;

    case "uploadExcelKQBC2":
        uploadExcelKQBC2();
        break;

    case "uploadXMLFileSH":
        uploadXMLFileSH();
        break;

    case "uploadExcelFileSH":
        uploadExcelFileSH();
        break;

    default:
        $template = "404";
}

/* Upload XML */
function uploadXMLBC1()
{
    global $d, $errormsg, $func, $config, $template, $studentError, $savedSuccess, $loginAdmin;

    $id_pro = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if (isset($_POST['importExcel']) || 1) {
        $file_type = $_FILES['file-xml']['type'];

        if ($file_type == "text/xml") {
            $file_name = $func->uploadName($_FILES["file-xml"]["name"]);
            if ($file_attach = $func->uploadImage("file-xml", "text/xml", UPLOAD_FILE, $file_name)) {
                $xmlFile =  UPLOAD_FILE . $file_name . '.xml';
                // Kiểm tra xem file có tồn tại hay không
                if (file_exists($xmlFile)) {
                    // Tải file XML và chuyển đổi nó thành một đối tượng SimpleXMLElement
                    $xml = simplexml_load_file($xmlFile);

                    $errormsg = [];
                    $infoStudentError = [];
                    $studentError = [];
                    $savedSuccess = 0;
                    $savedError = 0;

                    // Lấy các trường từ phần KHOA_HOC
                    $khoaHoc = $xml->DATA->KHOA_HOC;
                    $courses = array();

                    // Lấy các hạng GPLX
                    $rowGPLX = $d->rawQueryOne("select * from #_gplx where namevi = ? ", array($khoaHoc->HANG_GPLX));
                    if (!empty($rowGPLX)) {
                        $courses['HANG_GPLX'] = $rowGPLX['id'];
                    } else array_push($errormsg, "Hệ thống không có hạng GPLX " . $khoaHoc->HANG_GPLX);

                    // Lưu trực tiếp vào các trường database
                    $courses['TEN_KHOA_HOC'] = (string) $khoaHoc->TEN_KHOA_HOC;
                    $courses['MA_KHOA_HOC'] = (string) $khoaHoc->MA_KHOA_HOC;;
                    $courses['MA_HANG_DAO_TAO'] = (string) $khoaHoc->MA_HANG_DAO_TAO;
                    $courses['SO_QD_KG'] = (string) $khoaHoc->SO_QD_KG;
                    $courses['NGAY_KHAI_GIANG'] = strtotime(str_replace("/", "-", $khoaHoc->NGAY_KHAI_GIANG));
                    $courses['NGAY_BE_GIANG'] = strtotime(str_replace("/", "-", $khoaHoc->NGAY_BE_GIANG));
                    $courses['NGAY_SAT_HACH'] = strtotime(str_replace("/", "-", $khoaHoc->NGAY_SAT_HACH));

                    // Lưu vào trường data_student dưới dạng JSON
                    $data_courses = array();
                    $data_courses['MA_BCI'] = (string) $khoaHoc->MA_BCI;
                    $data_courses['MA_SO_GTVT'] = (string) $khoaHoc->MA_SO_GTVT;
                    $data_courses['TEN_SO_GTVT'] = (string) $khoaHoc->TEN_SO_GTVT;
                    $data_courses['MA_CSDT'] = (string) $khoaHoc->MA_CSDT;
                    $data_courses['TEN_CSDT'] = (string) $khoaHoc->TEN_CSDT;
                    $data_courses['SO_BCI'] = (string) $khoaHoc->SO_BCI;
                    $data_courses['NGAY_BCI'] = (string) $khoaHoc->NGAY_BCI;
                    $data_courses['LUU_LUONG'] = (string) $khoaHoc->LUU_LUONG;
                    $data_courses['SO_HOC_SINH'] = (string) $khoaHoc->SO_HOC_SINH;
                    $data_courses['NGAY_QD_KG'] = (string) $khoaHoc->NGAY_QD_KG;
                    $data_courses['THOI_GIAN_DT'] = (string) $khoaHoc->THOI_GIAN_DT;
                    $courses['data_courses'] = json_encode($data_courses);

                    // Lấy các trường từ phần HEADER
                    $header = $xml->HEADER;
                    $data_header['MA_GIAO_DICH'] = (string) $header->MA_GIAO_DICH;
                    $data_header['MA_DV_GUI'] = (string) $header->MA_DV_GUI;
                    $data_header['TEN_DV_GUI'] = (string) $header->TEN_DV_GUI;
                    $data_header['NGAY_GUI'] = (string) $header->NGAY_GUI;
                    $data_header['NGUOI_GUI'] = (string) $header->NGUOI_GUI;
                    $data_header['TONG_SO_BAN_GHI'] = (string) $header->TONG_SO_BAN_GHI;
                    $courses['data_header'] = json_encode($data_header);

                    // Validate Courses
                    if (empty($courses['TEN_KHOA_HOC'])) array_push($errormsg, "Thiếu thông tin tên khoá học");
                    if (empty($courses['MA_KHOA_HOC'])) array_push($errormsg, "Thiếu thông tin mã khoá học");
                    if (empty($courses['MA_HANG_DAO_TAO'])) array_push($errormsg, "Thiếu thông tin mã hạng đào tạo");
                    if (empty($courses['NGAY_KHAI_GIANG'])) array_push($errormsg, "Thiếu thông tin ngày khai giảng");
                    if (empty($courses['NGAY_BE_GIANG'])) array_push($errormsg, "Thiếu thông tin ngày bế giảng");

                    if (empty($errormsg)) {
                        $courses['data_courses'] = json_encode($data_courses);
                        $rowCourses = $d->rawQueryOne("select * from #_courses where MA_KHOA_HOC = ? ", array($khoaHoc->MA_KHOA_HOC));
                        if (!empty($rowCourses)) {
                            $courses['date_updated'] = time();
                            $d->where('id', $rowCourses['id']);
                            $d->update('courses', $courses);
                        } else {
                            $courses['date_created'] = time();
                            $d->insert('courses', $courses);
                        }
                        // Duyệt qua các phần tử NGUOI_LX và lấy các trường tương ứng
                        foreach ($xml->DATA->NGUOI_LXS->NGUOI_LX as $k => $nguoiLx) {
                            /* Gán dữ liệu */
                            $msg = [];

                            // Lưu trực tiếp vào các trường database
                            $student = array();
                            $student['SO_TT'] = (string) $nguoiLx->SO_TT;
                            $student['MA_DK'] = (string) $nguoiLx->MA_DK;
                            $student['MA_KHOA_HOC'] = (string) $khoaHoc->MA_KHOA_HOC;;
                            $student['HO_VA_TEN'] = (string) $nguoiLx->HO_VA_TEN;
                            $student['SO_CMT'] = (string) $nguoiLx->SO_CMT;
                            $student['ANH_CHAN_DUNG'] = (string) $nguoiLx->HO_SO->ANH_CHAN_DUNG;
                            $student['HANG_GPLX'] = $rowGPLX['id'];
                            $student['HANG_DAOTAO'] = (string) $nguoiLx->HO_SO->HANG_DAOTAO;
                            
                            if (!empty($rowGPLX)) $courses['HANG_GPLX'] = (string) $khoaHoc->HANG_GPLX;
                            else array_push($errormsg, "Hệ thống không có hạng GPLX " . $khoaHoc->HANG_GPLX);

                            if (empty($student['HO_VA_TEN'])) {
                                array_push($msg, "Thiếu thông tin họ và tên");
                            }
                            if (empty($student['SO_CMT'])) {
                                array_push($msg, "Thiếu thông tin CCCD/CMT/Hộ chiếu");
                            }
                            if (empty($student['HANG_GPLX'])) {
                                array_push($msg, "Thiếu thông tin hạng gplx");
                            }
                            // if (empty($student['HANG_DAOTAO'])) {
                            //     array_push($msg, "Thiếu thông tin hạng đào tạo");
                            // }

                            // Khai báo mảng data student
                            

                            // Lấy các trường từ phần HOSO
                            $hoso = $nguoiLx->GIAY_TOS;
                            $student['data_hoso'] = json_encode($hoso);

                            // Lưu vào trường data_student dưới dạng JSON
                            if (!empty($student['MA_DK'])) {
                                $rowCheck = $d->rawQueryOne("select data_student from #_student where MA_DK = ?", array($student['MA_DK']));
                                if (!empty($rowCheck)) $data_student = json_decode($rowCheck['data_student'],true);
                                else $data_student = array();
                            } else {
                                $data_student = array();
                            }
                            $data_student['HO_TEN_DEM'] = (string) $nguoiLx->HO_TEN_DEM;
                            $data_student['TEN'] = (string) $nguoiLx->TEN;
                            $date = $func->formatDateString((string) $nguoiLx->NGAY_SINH);
                            $data_student['NGAY_SINH'] = strtotime(str_replace("/", "-", $date));
                            $data_student['MA_QUOC_TICH'] = (string) $nguoiLx->MA_QUOC_TICH;
                            $data_student['TEN_QUOC_TICH'] = (string) $nguoiLx->TEN_QUOC_TICH;
                            $data_student['NOI_TT'] = (string) $nguoiLx->NOI_TT;
                            $data_student['NOI_TT_MA_DVHC'] = (string) $nguoiLx->NOI_TT_MA_DVHC;
                            $data_student['NOI_TT_MA_DVQL'] = (string) $nguoiLx->NOI_TT_MA_DVQL;
                            $data_student['NOI_CT'] = (string) $nguoiLx->NOI_CT;
                            $data_student['NOI_CT_MA_DVHC'] = (string) $nguoiLx->NOI_CT_MA_DVHC;
                            $data_student['NOI_CT_MA_DVQL'] = (string) $nguoiLx->NOI_CT_MA_DVQL;
                            $data_student['NGAY_CAP_CMT'] = (string) $nguoiLx->NGAY_CAP_CMT;
                            $data_student['NOI_CAP_CMT'] = (string) $nguoiLx->NOI_CAP_CMT;
                            $data_student['GIOI_TINH'] = (string) $nguoiLx->GIOI_TINH;
                            $data_student['HO_VA_TEN_IN'] = (string) $nguoiLx->HO_VA_TEN_IN;
                            $data_student['SO_CMND_CU'] = (string) $nguoiLx->SO_CMND_CU;
                            $data_student['SO_HO_SO'] = (string) $nguoiLx->HO_SO->SO_HO_SO;
                            $data_student['MA_DV_NHAN_HOSO'] = (string) $nguoiLx->HO_SO->MA_DV_NHAN_HOSO;
                            $data_student['NGAY_NHAN_HOSO'] = strtotime(str_replace("/", "-", $nguoiLx->HO_SO->NGAY_NHAN_HOSO));
                            $data_student['NGUOI_NHAN_HOSO'] = (string) $nguoiLx->HO_SO->NGUOI_NHAN_HOSO;
                            $data_student['MA_LOAI_HOSO'] = (string) $nguoiLx->HO_SO->MA_LOAI_HOSO;
                            $data_student['TEN_LOAI_HOSO'] = (string) $nguoiLx->HO_SO->TEN_LOAI_HOSO;
                            $data_student['CHAT_LUONG_ANH'] = (string) $nguoiLx->HO_SO->CHAT_LUONG_ANH;
                            $data_student['NGAY_THU_NHAN_ANH'] = strtotime(str_replace("/", "-", $nguoiLx->HO_SO->NGAY_THU_NHAN_ANH));
                            $data_student['SO_GPLX_DA_CO'] = (string) $nguoiLx->HO_SO->SO_GPLX_DA_CO;
                            $data_student['HANG_GPLX_DA_CO'] = (string) $nguoiLx->HO_SO->HANG_GPLX_DA_CO;
                            $data_student['DV_CAP_GPLX_DACO'] = (string) $nguoiLx->HO_SO->DV_CAP_GPLX_DACO;
                            $data_student['TEN_DV_CAP_GPLX_DACO'] = (string) $nguoiLx->HO_SO->TEN_DV_CAP_GPLX_DACO;
                            $data_student['NOI_CAP_GPLX_DACO'] = (string) $nguoiLx->HO_SO->NOI_CAP_GPLX_DACO;
                            $data_student['NGAY_CAP_GPLX_DACO'] = (string) $nguoiLx->HO_SO->NGAY_CAP_GPLX_DACO;
                            $data_student['NGAY_HH_GPLX_DACO'] = (string) $nguoiLx->HO_SO->NGAY_HH_GPLX_DACO;
                            $data_student['NGAY_TT_GPLX_DACO'] = (string) $nguoiLx->HO_SO->NGAY_TT_GPLX_DACO;
                            $data_student['MA_NOI_HOC_LAIXE'] = (string) $nguoiLx->HO_SO->MA_NOI_HOC_LAIXE;
                            $data_student['NAM_HOC_LAIXE'] = (string) $nguoiLx->HO_SO->NAM_HOC_LAIXE;
                            $data_student['SO_NAM_LAIXE'] = (string) $nguoiLx->HO_SO->SO_NAM_LAIXE;
                            $data_student['SO_KM_ANTOAN'] = (string) $nguoiLx->HO_SO->SO_KM_ANTOAN;
                            $data_student['GIAY_CNSK'] = (string) $nguoiLx->HO_SO->GIAY_CNSK;
                            $data_student['MA_HANG_DAO_TAO'] = (string) $khoaHoc->MA_HANG_DAO_TAO;
                            $data_student['HINH_THUC_CAP'] = (string) $nguoiLx->HO_SO->HINH_THUC_CAP;
                            $data_student['CHON_IN_GPLX'] = (string) $nguoiLx->HO_SO->CHON_IN_GPLX;

                            if (!empty($msg)) {
                                $savedError ++;
                                $studentError[$savedError]['info'] = $student;
                                $studentError[$savedError]['msg'] = $msg;
                            } else {
                                $savedSuccess ++;
                                $student['data_student'] = json_encode($data_student);

                                $rowStudent = $d->rawQueryOne("select id from #_student where MA_KHOA_HOC = ? and SO_CMT = ?", array($khoaHoc->MA_KHOA_HOC, $student['SO_CMT']));
                                if (!empty($rowStudent)) {
                                    $student['date_updated'] = time();
                                    $d->where('id', $rowStudent['id']);
                                    $d->update('student', $student);
                                } else {

                                    $data_result_test['theory']['note'] = '';
                                    $data_result_test['theory']['point'] = 1;
                                    $data_result_test['geometry']['note'] = '';
                                    $data_result_test['geometry']['point'] = 1;
                                    $data_result_test['cabin']['note'] = '';
                                    $data_result_test['cabin']['point'] = 0;
                                    $data_result_test['dat']['note'] = '';
                                    $data_result_test['dat']['point'] = 0;
                                    $data_result_test['fee-graduation'] = 0;
                                    $student['graduate'] = json_encode($data_result_test);

                                    $student['date_created'] = time();
                                    $d->insert('student', $student);
                                }
                            }
                        }

                        // if ($savedSuccess == 0) $func->transfer("Không tìm thấy học viên hợp lệ !","index.php?com=graduate&act=man",false);

                        // Chuyển file vào thư mục lưu lại
                        $filenameUpload = $file_name.time();
                        rename(UPLOAD_FILE.$file_name. '.xml', UPLOAD_FILE.'operation/'.$filenameUpload . '.xml');

                        // Lưu lại lịch sử
                        $dataHistory['namevi'] = '';
                        $dataHistory['descvi'] = 'Import File XML báo cáo 1';
                        $dataHistory['file'] = $filenameUpload.'.xml';
                        $dataHistory['type'] = 'import-xml-bc1';
                        $dataHistory['quantity'] = $savedSuccess;
                        $dataHistory['date_created'] = time();
                        $dataHistory['id_downloader'] = $_SESSION[$loginAdmin]['id'];
                        $dataHistory['downloads'] = 1;
                        $d->insert('user_operation', $dataHistory);

                        if (!empty($studentError)) {
                            $template = "layout/error_import";
                        } else {
                            $func->transfer("Import file thành công", "?com=student&act=man&fill=man");
                        }
                    } else {
                        $template = "layout/error_import";
                    }
                } else {
                    // Hiển thị thông báo lỗi nếu file không tồn tại
                    exit('Failed to open');
                }
            }
        } else {
            $mess = "Không hỗ trợ kiểu tập tin này";
            $func->transfer($mess, "?com=student&act=man&fill=man", false);
        }
    } else {
        $func->transfer(dulieurong, "?com=student&act=man&fill=man", false);
    }
}

/* Upload Excel*/
function uploadExcelBC1()
{
    global $d, $langadmin, $type, $func, $config, $savedSuccess, $loginAdmin;

    $fields = [
        'MA_GIAO_DICH','MA_DV_GUI','TEN_DV_GUI','NGAY_GUI','NGUOI_GUI','TONG_SO_BAN_GHI','MA_BCI','MA_SO_GTVT','TEN_SO_GTVT','MA_CSDT','TEN_CSDT','MA_KHOA_HOC','TEN_KHOA_HOC','MA_HANG_DAO_TAO','HANG_GPLX','SO_BCI','NGAY_BCI','LUU_LUONG','SO_HOC_SINH','NGAY_KHAI_GIANG','NGAY_BE_GIANG','SO_QD_KG','NGAY_QD_KG','NGAY_SAT_HACH','THOI_GIAN_DT','SO_TT','MA_DK','HO_TEN_DEM','TEN','HO_VA_TEN','NGAY_SINH','MA_QUOC_TICH','TEN_QUOC_TICH','NOI_TT','NOI_TT_MA_DVHC','NOI_TT_MA_DVQL','NOI_CT','NOI_CT_MA_DVHC','NOI_CT_MA_DVQL','SO_CMT','NGAY_CAP_CMT','NOI_CAP_CMT','GIOI_TINH','HO_VA_TEN_IN','SO_CMND_CU','SO_HO_SO','MA_DV_NHAN_HOSO','TEN_DV_NHAN_HOSO','NGAY_NHAN_HOSO','NGUOI_NHAN_HOSO','MA_LOAI_HOSO','TEN_LOAI_HOSO','ANH_CHAN_DUNG','CHAT_LUONG_ANH','NGAY_THU_NHAN_ANH','NGUOI_THU_NHAN_ANH','SO_GPLX_DA_CO','HANG_GPLX_DA_CO','DV_CAP_GPLX_DACO','TEN_DV_CAP_GPLX_DACO','NOI_CAP_GPLX_DACO','NGAY_CAP_GPLX_DACO','NGAY_HH_GPLX_DACO','NGAY_TT_GPLX_DACO','MA_NOI_HOC_LAIXE','TEN_NOI_HOC_LAIXE','NAM_HOC_LAIXE','SO_NAM_LAIXE','SO_KM_ANTOAN','GIAY_CNSK','HINH_THUC_CAP','HANG_GPLX2','HANG_DAOTAO','CHON_IN_GPLX','MA_GIAY_TO','TEN_GIAY_TO',
    ];
    $array_info = array('HO_TEN_DEM'=>'HO_TEN_DEM','TEN'=>'TEN','NGAY_SINH'=>'NGAY_SINH','MA_QUOC_TICH'=>'MA_QUOC_TICH','TEN_QUOC_TICH'=>'TEN_QUOC_TICH','NOI_TT'=>'NOI_TT','NOI_TT_MA_DVHC'=>'NOI_TT_MA_DVHC','NOI_TT_MA_DVQL'=>'NOI_TT_MA_DVQL','NOI_CT'=>'NOI_CT','NOI_CT_MA_DVHC'=>'NOI_CT_MA_DVHC','NOI_CT_MA_DVQL'=>'NOI_CT_MA_DVQL','NGAY_CAP_CMT'=>'NGAY_CAP_CMT','NOI_CAP_CMT'=>'NOI_CAP_CMT','GIOI_TINH'=>'GIOI_TINH','HO_VA_TEN_IN'=>'HO_VA_TEN_IN','SO_CMND_CU'=>'SO_CMND_CU','SO_HO_SO'=>'SO_HO_SO','MA_DV_NHAN_HOSO'=>'MA_DV_NHAN_HOSO','TEN_DV_NHAN_HOSO'=>'TEN_DV_NHAN_HOSO','NGAY_NHAN_HOSO'=>'NGAY_NHAN_HOSO','NGUOI_NHAN_HOSO'=>'NGUOI_NHAN_HOSO','MA_LOAI_HOSO'=>'MA_LOAI_HOSO','TEN_LOAI_HOSO'=>'TEN_LOAI_HOSO','CHAT_LUONG_ANH'=>'CHAT_LUONG_ANH','NGAY_THU_NHAN_ANH'=>'NGAY_THU_NHAN_ANH','NGUOI_THU_NHAN_ANH'=>'NGUOI_THU_NHAN_ANH','SO_GPLX_DA_CO'=>'SO_GPLX_DA_CO','HANG_GPLX_DA_CO'=>'HANG_GPLX_DA_CO','DV_CAP_GPLX_DACO'=>'DV_CAP_GPLX_DACO','TEN_DV_CAP_GPLX_DACO'=>'TEN_DV_CAP_GPLX_DACO','NOI_CAP_GPLX_DACO'=>'NOI_CAP_GPLX_DACO','NGAY_CAP_GPLX_DACO'=>'NGAY_CAP_GPLX_DACO','NGAY_HH_GPLX_DACO'=>'NGAY_HH_GPLX_DACO','NGAY_TT_GPLX_DACO'=>'NGAY_TT_GPLX_DACO','MA_NOI_HOC_LAIXE'=>'MA_NOI_HOC_LAIXE','TEN_NOI_HOC_LAIXE'=>'TEN_NOI_HOC_LAIXE','NAM_HOC_LAIXE'=>'NAM_HOC_LAIXE','SO_NAM_LAIXE'=>'SO_NAM_LAIXE','SO_KM_ANTOAN'=>'SO_KM_ANTOAN','GIAY_CNSK'=>'GIAY_CNSK','HINH_THUC_CAP'=>'HINH_THUC_CAP','CHON_IN_GPLX'=>'CHON_IN_GPLX');

    $savedSuccess = 0;

    $where = " ";

    $type = (!empty($_REQUEST['type']) ? $_REQUEST['type'] : '');

    if (isset($_POST['importExcel']) || 1) {
        $file_type = $_FILES['file-excel']['type'];

        if ($file_type == "application/vnd.ms-excel" || $file_type == "application/x-ms-excel" || $file_type == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
            $mess = '';
            $filename = $func->changeTitle($_FILES["file-excel"]["name"]).time();
            move_uploaded_file($_FILES["file-excel"]["tmp_name"], UPLOAD_FILE.'operation/'.$filename);
            require LIBRARIES . 'PHPExcel.php';
            require_once LIBRARIES . 'PHPExcel/IOFactory.php';

            $objPHPExcel = PHPExcel_IOFactory::load(UPLOAD_FILE.'operation/'.$filename);

            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                for ($row = 2; $row <= $highestRow; ++$row) {
                    $cell = $worksheet->getCellByColumnAndRow(39, $row);
                    $SO_CMT = $cell->getValue();
                    $data_giayto = array();
                    
                    if (!empty($SO_CMT)) {
                        $data = array();
                        $savedSuccess++;

                        $rowCheck = $d->rawQueryOne("select data_student, data_hoso from #_student where SO_CMT = ?", array($SO_CMT));
                        if (!empty($rowCheck)) {
                            $data_student = json_decode($rowCheck['data_student'],true);
                            $giayto = json_decode($rowCheck['data_hoso'],true);
                        }
                        else {
                            $data_student = array();
                            $giayto = array();
                        }
                        foreach ($fields as $index => $field) {
                            $cell = $worksheet->getCellByColumnAndRow($index, $row);
                            $$field = $cell->getValue();
                            if($field == 'numb' || $field == 'MA_KHOA_HOC' || $field == 'HANG_DAOTAO' || $field == 'SO_TT' || $field == 'MA_DK' || $field == 'HO_VA_TEN' || $field == 'SO_CMT' || $field == 'ANH_CHAN_DUNG'){
                                $data[$field] = (!empty($$field) ? $$field : '');
                            } elseif($field == 'NGAY_SINH' || $field == 'NGAY_NHAN_HOSO' || $field == 'NGAY_CAP_GPLX_DACO' || $field == 'NGAY_TT_GPLX_DACO') {
                                $data_student[$field] = (!empty($$field) ? strtotime(str_replace("/", "-", $$field)) : '' );
                            }elseif($field == 'HANG_GPLX') {
                                $rowGPLX = $d->rawQueryOne("select * from #_gplx where namevi = ? ", array($$field));
                                if (!empty($rowGPLX)) {
                                    $data[$field] = $rowGPLX['id'];
                                } else {
                                    $data[$field] = '';
                                }
                            } elseif(in_array($field,$array_info)) {
                                $data_student[$field] = (!empty($$field) ? $$field : '');
                            } elseif($field == 'MA_GIAY_TO') {
                                $data_giayto['MA_GIAY_TO'] = (!empty($$field) ? $$field : '');
                            } elseif($field == 'TEN_GIAY_TO') {
                                $data_giayto['TEN_GIAY_TO'] = (!empty($$field) ? $$field : '');
                            }
                        }

                        $checkHS = $d->rawQueryOne("select data_student, data_hoso from #_student where SO_CMT = ?", array($SO_CMT));
                        if(!empty($checkHS['data_hoso'])){
                            $arr['GIAY_TO'] = json_decode($checkHS['data_hoso'],true)['GIAY_TO'];    
                        } else {
                            $arr['GIAY_TO'] = array();
                        }
                        $arr['GIAY_TO'][$data_giayto['MA_GIAY_TO']] = $data_giayto;
                        $data['data_hoso'] = json_encode($arr);
                        $data['data_student'] = json_encode($data_student);

                        if($type == 'bc1') $where .= "  and (`MA_DK` = '' or `MA_DK` is null)";

                        /* Lấy sản phẩm theo mã */
                        $studentImport = $d->rawQueryOne("select id from #_student where MA_KHOA_HOC = ? and SO_CMT = ? $where limit 0,1", array($MA_KHOA_HOC, $SO_CMT));
                        
                        /* Gán dữ liệu */
                        if (isset($studentImport['id']) && $studentImport['id'] > 0) {
                            $d->where('SO_CMT', $SO_CMT);
                            $d->where('MA_KHOA_HOC', $MA_KHOA_HOC);
                            if ($d->update('student', $data)) {
                                $mess = '';
                            } else {
                                $mess .= 'Lỗi tại dòng: ' . $row . "<br>";
                            }
                        } else {
                            if($type != 'bc1'){
                                $data_result_test['theory']['note'] = '';
                                $data_result_test['theory']['point'] = 1;
                                $data_result_test['geometry']['note'] = '';
                                $data_result_test['geometry']['point'] = 1;
                                $data_result_test['cabin']['note'] = '';
                                $data_result_test['cabin']['point'] = 0;
                                $data_result_test['dat']['note'] = '';
                                $data_result_test['dat']['point'] = 0;
                                $data_result_test['fee-graduation'] = 0;
                                $data['graduate'] = json_encode($data_result_test);

                                if ($d->insert('student', $data)) {
                                    $mess .= '';
                                } else {
                                    $mess .= 'Lỗi tại dòng: ' . $row . "<br>";
                                }
                            }
                        }
                    }
                }
            }


            if ($savedSuccess == 0) $func->transfer("Không tìm thấy học viên hợp lệ !","index.php?com=graduate&act=man",false);

            /* Xóa tập tin sau khi đã import xong */
            unlink($filename);

            // Lưu lại lịch sử
            $dataHistory['namevi'] = '';
            $dataHistory['descvi'] = 'Import File Excel báo cáo 1';
            $dataHistory['file'] = $filename;
            $dataHistory['type'] = 'import-excel-bc1';
            $dataHistory['quantity'] = $savedSuccess;
            $dataHistory['date_created'] = time();
            $dataHistory['id_downloader'] = $_SESSION[$loginAdmin]['id'];
            $dataHistory['downloads'] = 1;
            $d->insert('user_operation', $dataHistory);


            /* Kiểm tra kết quả import */
            if ($mess == '') {
                $mess = "Import danh sách thành công";
                $func->transfer($mess, "index.php?com=student&act=man&fill=man");
            } else {
                $func->transfer($mess, "index.php?com=student&act=man&fill=man", false);
            }
        } else {
            $mess = "Không hỗ trợ kiểu tập tin này";
            $func->transfer($mess, "index.php?com=student&act=man&fill=man", false);
        }
    } else {
        $func->transfer(dulieurong, "index.php?com=student&act=man&fill=man", false);
    }
}

/* Upload Excel*/
function uploadExcelGV()
{
    global $d, $langadmin, $type, $func, $config;

    $fields = [
        'numb','fullname','birthday','namsinh','dotuoi','cccd','date-cccd','noicap','address','gender','congtac','bienche','hopdong','vanhoa','chuyenmon','level','supham','anhvan','tinhoc','hanggplx','ngaygplx','hangxe','lythuyet','hinh','cabin','dat','note'
    ];

    if (isset($_POST['importExcel']) || 1) {
        $file_type = $_FILES['file-excel']['type'];

        if ($file_type == "application/vnd.ms-excel" || $file_type == "application/x-ms-excel" || $file_type == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
            $mess = '';
            $filename = $func->changeTitle($_FILES["file-excel"]["name"]);
            move_uploaded_file($_FILES["file-excel"]["tmp_name"], $filename);

            require LIBRARIES . 'PHPExcel.php';
            require_once LIBRARIES . 'PHPExcel/IOFactory.php';

            $objPHPExcel = PHPExcel_IOFactory::load($filename);

            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                for ($row = 8; $row <= $highestRow; ++$row) {
                    $cell = $worksheet->getCellByColumnAndRow(2, $row);
                    $fullname = $cell->getValue();
                    if (!empty($fullname)) {
                        $data = array();
                        $data_academic = array();
                        foreach ($fields as $index => $field) {
                            $cell = $worksheet->getCellByColumnAndRow($index, $row);
                            $$field = $cell->getValue();

                            if($field == 'vanhoa' || $field == 'chuyenmon' || $field == 'level' || $field == 'supham' || $field == 'anhvan' || $field == 'tinhoc') 
                            {
                                $data_academic[$field] = (!empty($$field) ? $$field : '');
                            } elseif($field == 'birthday' || $field == 'date-cccd' || $field == 'ngaygplx') {
                                $data[$field] = (!empty($$field) ? strtotime(str_replace("/", "-", $$field)) : '' );
                            }elseif($field == 'hangxe') {

                                $rowGPLX = $d->rawQueryOne("select * from #_gplx where namevi = ? ", array($$field));
                                if (!empty($rowGPLX)) {
                                    $data[$field] = $rowGPLX['id'];
                                } else {
                                    $data[$field] = '';
                                }

                            } else {
                                $data[$field] = (!empty($$field) ? $$field : '');
                            }
                            
                        }

                        // Lấy tuyển dụng
                        if (!empty($data['bienche'])) {
                            $data['tuyendung'] = 'bienche';
                        } elseif (!empty($data['hopdong'])) {
                            $data['tuyendung'] = 'hopdong';
                        } else {
                            $data['tuyendung'] = '';
                        }

                        // Lấy giới tính
                        if (!empty($data['gender']) && $func->changeTitle($data['gender']) == 'nu') {
                            $data['gender'] = 2;
                        } elseif (!empty($data['gender']) && $func->changeTitle($data['gender']) == 'nam') {
                            $data['gender'] = 1;
                        } else {
                            $data['gender'] = 0;
                        }

                        // Lấy chức năng
                        $stringFunc = '';
                        if (!empty($data['lythuyet'])) {
                            $stringFunc .= 'lythuyet';
                        } 
                        if (!empty($data['hinh'])) {
                            (!empty($stringFunc) ? $stringFunc.=',hinh' : $stringFunc ='hinh');
                        }
                        if (!empty($data['cabin'])) {
                            (!empty($stringFunc) ? $stringFunc.=',cabin' : $stringFunc ='cabin');
                        }
                        if (!empty($data['dat'])) {
                            (!empty($stringFunc) ? $stringFunc.=',dat' : $stringFunc ='dat');
                        }

                        // Xoá trường không sử dụng
                        unset($data['lythuyet']);
                        unset($data['hinh']);
                        unset($data['cabin']);
                        unset($data['dat']);
                        unset($data['bienche']);
                        unset($data['hopdong']);
                        unset($data['namsinh']);
                        unset($data['dotuoi']);

                        $data['academic'] = json_encode($data_academic);
                        $data['chucnang'] = ($stringFunc);

                        /* Lấy sản phẩm theo mã */
                        $teacherImport = $d->rawQueryOne("select id from #_member where cccd = ? limit 0,1", array($data['cccd']));
                        /* Gán dữ liệu */
                        if (isset($teacherImport['id']) && $teacherImport['id'] > 0) {
                            $d->where('cccd', $data['cccd']);
                            if ($d->update('member', $data)) {
                                $mess = '';
                            } else {
                                $mess .= 'Lỗi tại dòng: ' . $row . "<br>";
                            }
                        } else {
                            $data['status'] = 'hienthi';
                            $data['username'] = $data['cccd'];
                            $data['password'] = md5($data['cccd']);
                            if ($d->insert('member', $data)) {
                                $mess .= '';
                            } else {
                                $mess .= 'Lỗi tại dòng: ' . $row . "<br>";
                            }
                        }
                    }
                }
            }

            /* Xóa tập tin sau khi đã import xong */
            unlink($filename);

            /* Kiểm tra kết quả import */
            if ($mess == '') {
                $func->deleteFile(UPLOAD_FILE . $file_name . '.xml');
                $mess = "Import danh sách thành công";
                $func->transfer($mess, "index.php?com=teacher&act=man");
            } else {
                $func->deleteFile(UPLOAD_FILE . $file_name . '.xml');
                $func->transfer($mess, "index.php?com=teacher&act=man", false);
            }
        } else {
            $mess = "Không hỗ trợ kiểu tập tin này";
            $func->transfer($mess, "index.php?com=teacher&act=man", false);
        }
    } else {
        $func->transfer(dulieurong, "index.php?com=teacher&act=man", false);
    }
}

/* Upload Excel*/
function uploadExcelCar()
{
    global $d, $langadmin, $type, $func, $config;


    $fields = [
        'numb','biensoxe','hieuxe','loaixe','socho','namsx','mauson','hang','shhd','sokhung','somay','sogplx','ngaycapgplx','hethan','seridat','imei1','imei2','chuxe','sdt','kiemdinh'
    ];

    if (isset($_POST['importExcel']) || 1) {
        $file_type = $_FILES['file-excel']['type'];

        if ($file_type == "application/vnd.ms-excel" || $file_type == "application/x-ms-excel" || $file_type == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
            $mess = '';
            $filename = $func->changeTitle($_FILES["file-excel"]["name"]);
            move_uploaded_file($_FILES["file-excel"]["tmp_name"], $filename);

            require LIBRARIES . 'PHPExcel.php';
            require_once LIBRARIES . 'PHPExcel/IOFactory.php';

            $objPHPExcel = PHPExcel_IOFactory::load($filename);

            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                for ($row = 2; $row <= $highestRow; ++$row) {
                    $cell = $worksheet->getCellByColumnAndRow(2, $row);
                    $bsx = $cell->getValue();
                    if (!empty($bsx)) {
                        $data = array();
                        $data_academic = array();
                        foreach ($fields as $index => $field) {
                            $cell = $worksheet->getCellByColumnAndRow($index, $row);
                            $$field = $cell->getValue();
                             
                            if($field == 'hethan' || $field == 'ngaycapgplx') {
                                $data[$field] = (!empty($$field) ? strtotime(str_replace("/", "-", $$field)) : '' );
                            } else {
                                $data[$field] = (!empty($$field) ? $$field : '');
                            }
                        }

                        // Lấy tuyển dụng
                        $data['id_xe'] = $data['biensoxe'];

                        /* Lấy xe theo mã */
                        $carImport = $d->rawQueryOne("select id from #_car where biensoxe = ? limit 0,1", array($data['biensoxe']));
                        
                        /* Gán dữ liệu */
                        if (isset($carImport['id']) && $carImport['id'] > 0) {
                            $d->where('biensoxe', $data['biensoxe']);
                            if ($d->update('car', $data)) {
                                $mess = '';
                            } else {
                                $mess .= 'Lỗi tại dòng: ' . $row . "<br>";
                            }
                        } else {
                            if ($d->insert('car', $data)) {
                                $mess .= '';
                            } else {
                                $mess .= 'Lỗi tại dòng: ' . $row . "<br>";
                            }
                        }
                    }
                }
            }

            /* Xóa tập tin sau khi đã import xong */
            unlink($filename);

            /* Kiểm tra kết quả import */
            if ($mess == '') {
                $func->deleteFile(UPLOAD_FILE . $file_name . '.xml');
                $mess = "Import danh sách thành công";
                $func->transfer($mess, "index.php?com=car&act=man");
            } else {
                $func->deleteFile(UPLOAD_FILE . $file_name . '.xml');
                $func->transfer($mess, "index.php?com=car&act=man", false);
            }
        } else {
            $mess = "Không hỗ trợ kiểu tập tin này";
            $func->transfer($mess, "index.php?com=car&act=man", false);
        }
    } else {
        $func->transfer(dulieurong, "index.php?com=car&act=man", false);
    }
}

/* Upload XML */
function uploadXMLGV()
{
    global $d, $errormsg, $func, $config, $template, $studentError, $savedSuccess;


    $data = [];
    $academic = [];
    $funcGV = [];

    if (isset($_POST['importExcel'])) {
        $file_type = $_FILES['file-xml']['type'];

        if ($file_type == "text/xml") {
            $file_name = $func->uploadName($_FILES["file-xml"]["name"]);
            if ($file_attach = $func->uploadImage("file-xml", "text/xml", UPLOAD_FILE, $file_name)) {
                $xmlFile =  UPLOAD_FILE . $file_name . '.xml';
                // Kiểm tra xem file có tồn tại hay không
                if (file_exists($xmlFile)) {
                    // Tải file XML và chuyển đổi nó thành một đối tượng SimpleXMLElement
                    $xml = simplexml_load_file($xmlFile);
                     // Kiểm tra xem việc load file có thành công không
                    if ($xml !== false) {
                        // Duyệt qua các phần tử <GIAO_VIEN>
                        foreach ($xml->DATA->GIAO_VIENS->GIAO_VIEN as $gv) {
                            $data['id_code'] = !empty($gv->MA_GIAO_VIEN) ? (string)$gv->MA_GIAO_VIEN : '';
                            $data['fullname'] = !empty($gv->HO_VA_TEN) ? (string)$gv->HO_VA_TEN : '';
                            $data['birthday'] = !empty($gv->NGAY_SINH) ? (string)$gv->NGAY_SINH : '';
                            $data['cccd'] = !empty($gv->CCCD) ? (string)$gv->CCCD : '';
                            $data['date-cccd'] = !empty($gv->NGAY_CAP_CCCD) ? (string)$gv->NGAY_CAP_CCCD : '';
                            $data['noicap'] = !empty($gv->NOI_CAP_CCCD) ? (string)$gv->NOI_CAP_CCCD : '';
                            $data['address'] = !empty($gv->THUONG_TRU) ? (string)$gv->THUONG_TRU : '';
                            $data['gender'] = !empty($gv->GIOI_TINH) ? (string)$gv->GIOI_TINH : '';
                            $data['congtac'] = !empty($gv->DON_VI_CT) ? (string)$gv->DON_VI_CT : '';
                            $data['tuyendung'] = !empty($gv->HT_TUYEN_DUNG) ? (string)$gv->HT_TUYEN_DUNG : '';
                            $academic['vanhoa'] = !empty($gv->VAN_HOA) ? (string)$gv->VAN_HOA : '';
                            $academic['chuyenmon'] = !empty($gv->CHUYEN_MON) ? (string)$gv->CHUYEN_MON : '';
                            $academic['level'] = !empty($gv->LEVEL) ? (string)$gv->LEVEL : '';
                            $academic['supham'] = !empty($gv->SU_PHAM) ? (string)$gv->SU_PHAM : '';
                            $academic['anhvan'] = !empty($gv->ANH_VAN) ? (string)$gv->ANH_VAN : '';
                            $academic['tinhoc'] = !empty($gv->TIN_HOC) ? (string)$gv->TIN_HOC : '';
                            $data['hanggplx'] = !empty($gv->HANG_GPLX) ? (string)$gv->HANG_GPLX : '';
                            $data['ngaygplx'] = !empty($gv->NGAY_CAP_GPLX) ? (string)$gv->NGAY_CAP_GPLX : '';
                            $data['hangxe'] = !empty($gv->HANG_XE_DAY) ? (string)$gv->HANG_XE_DAY : '';
                            $data['chucnang'] = '';
                            $data['academic'] = json_encode($academic);

                            foreach ($gv->GIANG_DAYS->GIANG_DAY as $giangday) {
                                if (empty($data['chucnang'])) {
                                    $data['chucnang'] = str_replace("-","",$func->changeTitle((string)$giangday->TEN));
                                } else {
                                    $data['chucnang'] .= ','.str_replace("-","",$func->changeTitle((string)$giangday->TEN));
                                }
                            }
                        }

                        $data['birthday'] = strtotime(str_replace("/", "-", $data['birthday']));
                        $data['date-cccd'] = strtotime(str_replace("/", "-", $data['date-cccd']));
                        $data['ngaygplx'] = strtotime(str_replace("/", "-", $data['ngaygplx']));

                        if (!empty($data['gender'])) {
                            if ($func->changeTitle($data['gender']) == 'nam') {
                                $data['gender'] = 1;
                            } elseif($func->changeTitle($data['gender']) == 'nu') {
                                $data['gender'] = 2;
                            } else {
                                $data['gender'] = '';
                            }
                        }

                        if (!empty($data['hangxe'])) {
                            $rowGPLX = $d->rawQueryOne("select * from #_gplx where namevi = ? ", array($data['hangxe']));
                            if (!empty($rowGPLX)) {
                                $data['hangxe'] = $rowGPLX['id'];
                            } else {
                                $data['hangxe'] = '';
                            }
                        }

                        if (!empty($data['tuyendung'])) {
                            $data['tuyendung'] = str_replace("-","",$func->changeTitle((string)$data['tuyendung']));
                        }

                        /* Lấy sản phẩm theo mã */
                        $teacherImport = $d->rawQueryOne("select id from #_member where cccd = ? limit 0,1", array($data['cccd']));
                        /* Gán dữ liệu */
                        if (isset($teacherImport['id']) && $teacherImport['id'] > 0) {
                            $d->where('cccd', $data['cccd']);
                            if ($d->update('member', $data)) {
                                $mess = '';
                            } else {
                                $mess .= 'Lỗi tại dòng: ' . $row . "<br>";
                            }
                        } else {
                            $data['status'] = 'hienthi';
                            $data['username'] = $data['cccd'];
                            $data['password'] = md5($data['cccd']);
                            if ($d->insert('member', $data)) {
                                $mess .= '';
                            } else {
                                $mess .= 'Lỗi tại dòng: ' . $row . "<br>";
                            }
                        }
                        /* Xóa tập tin sau khi đã import xong */
                        unlink($filename);

                        /* Kiểm tra kết quả import */
                        if ($mess == '') {
                            $func->deleteFile(UPLOAD_FILE . $file_name . '.xml');
                            $mess = "Import danh sách thành công";
                            $func->transfer($mess, "index.php?com=teacher&act=man");
                        } else {
                            $func->deleteFile(UPLOAD_FILE . $file_name . '.xml');
                            $func->transfer($mess, "index.php?com=teacher&act=man", false);
                        }
                    } else {
                        $func->transfer('Failed to load XML file.',false);
                    }
                }
            }       
        } else {
            $mess = "Không hỗ trợ kiểu tập tin này";
            $func->transfer($mess, "?com=teacher&act=man", false);
        }
    } else {
        $func->transfer(dulieurong, "?com=teacher&act=man", false);
    }
}


/* Upload XML */
function uploadXMLCAR()
{
    global $d, $errormsg, $func, $config, $template, $studentError, $savedSuccess;
    $data = [];
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

    if (isset($_POST['importExcel'])) {
        $file_type = $_FILES['file-xml']['type'];

        if ($file_type == "text/xml") {
            $file_name = $func->uploadName($_FILES["file-xml"]["name"]);
            if ($file_attach = $func->uploadImage("file-xml", "text/xml", UPLOAD_FILE, $file_name)) {
                $xmlFile =  UPLOAD_FILE . $file_name . '.xml';
                // Kiểm tra xem file có tồn tại hay không
                if (file_exists($xmlFile)) {
                    // Tải file XML và chuyển đổi nó thành một đối tượng SimpleXMLElement
                    $xml = simplexml_load_file($xmlFile);
                     // Kiểm tra xem việc load file có thành công không
                    if ($xml !== false) {
                        // Duyệt qua các phần tử <GIAO_VIEN>
                        foreach ($xml->DATA->XES->XE as $xe) {
                            foreach($array_fields as $key => $field){
                                $data[$key] = !empty($xe->$field) ? (string)$xe->$field : '';
                            }
                        }
                        $data['ngaycapgplx'] = strtotime(str_replace("/", "-", $data['ngaycapgplx']));
                        $data['hethan'] = strtotime(str_replace("/", "-", $data['hethan']));

                        /* Lấy sản phẩm theo mã */
                        $carImport = $d->rawQueryOne("select id from #_car where biensoxe = ? limit 0,1", array($data['biensoxe']));
                        /* Gán dữ liệu */
                        if (isset($carImport['id']) && $carImport['id'] > 0) {
                            $d->where('biensoxe', $data['biensoxe']);
                            if ($d->update('car', $data)) {
                                $mess = '';
                            } else {
                                $mess .= 'Lỗi tại dòng: ' . $row . "<br>";
                            }
                        } else {
                            if ($d->insert('car', $data)) {
                                $mess .= '';
                            } else {
                                $mess .= 'Lỗi tại dòng: ' . $row . "<br>";
                            }
                        }
                        /* Xóa tập tin sau khi đã import xong */
                        unlink($filename);

                        /* Kiểm tra kết quả import */
                        if ($mess == '') {
                            $func->deleteFile(UPLOAD_FILE . $file_name . '.xml');
                            $mess = "Import danh sách thành công";
                            $func->transfer($mess, "index.php?com=car&act=man");
                        } else {
                            $func->deleteFile(UPLOAD_FILE . $file_name . '.xml');
                            $func->transfer($mess, "index.php?com=car&act=man", false);
                        }
                    } else {
                        $func->transfer('Failed to load XML file.',false);
                    }
                }
            }       
        } else {
            $mess = "Không hỗ trợ kiểu tập tin này";
            $func->transfer($mess, "?com=car&act=man", false);
        }
    } else {
        $func->transfer(dulieurong, "?com=car&act=man", false);
    }
}

/* Upload XML */
function uploadXMLBC2()
{
    global $d, $errormsg, $func, $config, $template, $studentError, $savedSuccess, $loginAdmin;
    if (isset($_POST['importExcel']) || 1) {
        $file_type = $_FILES['file-xml']['type'];

        if ($file_type == "text/xml") {
            $file_name = $func->uploadName($_FILES["file-xml"]["name"]);
            if ($file_attach = $func->uploadImage("file-xml", "text/xml", UPLOAD_FILE, $file_name)) {
                $xmlFile =  UPLOAD_FILE . $file_name . '.xml';
                // Kiểm tra xem file có tồn tại hay không
                if (file_exists($xmlFile)) {
                    // Tải file XML và chuyển đổi nó thành một đối tượng SimpleXMLElement
                    $xml = simplexml_load_file($xmlFile);

                    $errormsg = [];
                    $infoStudentError = [];
                    $studentError = [];
                    $savedSuccess = 0;
                    $savedError = 0;

                    // Lấy các trường từ phần BCII
                    $BCII = $xml->DATA->BCII;
                    $courses = array();

                    // Lấy dữ liệu khoá học theo MA_BCI
                    $rowCourses = $d->rawQueryOne("select id, data_courses from #_courses where JSON_UNQUOTE(JSON_EXTRACT(data_courses, '$.MA_BCI')) = ? limit 1",array($BCII->MA_BCI));

                    // Cập nhật mã BCII
                    if (!empty($rowCourses)) {
                        $bcii = json_decode($rowCourses['data_courses'],1);  
                        $bcii['MA_BCII'] = (string)$xml->DATA->BCII->MA_BCII;
                        $courses['data_courses'] = json_encode($bcii);
                        $courses['date_updated'] = time();
                        $d->where('id', $rowCourses['id']);
                        $d->update('courses', $courses);
                    } else {
                        array_push($errormsg, "Không tìm thấy mã BCI hợp lệ");
                    }

                    if (empty($errormsg)) {
                        
                        // Duyệt qua các phần tử NGUOI_LX và lấy các trường tương ứng
                        foreach ($xml->DATA->NGUOI_LXS->NGUOI_LX as $k => $nguoiLx) {
                            /* Gán dữ liệu */
                            $msg = [];

                            // Lưu trực tiếp vào các trường database
                            $student = array();
                            $student['SO_TT'] = (string) $nguoiLx->SO_TT;
                            $student['MA_DK'] = (string) $nguoiLx->MA_DK;
                            $student['HO_VA_TEN'] = (string) $nguoiLx->HO_VA_TEN;
                            $student['SO_CMT'] = (string) $nguoiLx->SO_CMT;

                            // Lấy học viên
                            $rowStudent = $d->rawQueryOne("select id, data_student from #_student where MA_DK = ? and SO_CMT = ?", array($student['MA_DK'], $student['SO_CMT']));

                            // Lưu vào trường data_student dưới dạng JSON
                            if (!empty($rowStudent)) {
                                $data_student = json_decode($rowStudent['data_student'],true);
                                $data_student['HO_TEN_DEM'] = (string) $nguoiLx->HO_TEN_DEM;
                                $data_student['TEN'] = (string) $nguoiLx->TEN;
                                $date = $func->formatDateString((string) $nguoiLx->NGAY_SINH);
                                $data_student['NGAY_SINH'] = strtotime(str_replace("/", "-", $date));
                                $data_student['NOI_CT'] = (string) $nguoiLx->NOI_CT;
                                $data_student['NOI_CT_MA_DVHC'] = (string) $nguoiLx->NOI_CT_MA_DVHC;
                                $data_student['NOI_CT_MA_DVQL'] = (string) $nguoiLx->NOI_CT_MA_DVQL;
                                $data_student['HO_VA_TEN_IN'] = (string) $nguoiLx->HO_VA_TEN_IN;
                                $data_student['SO_HO_SO'] = (string) $nguoiLx->HO_SO->SO_HO_SO;
                                $data_student['NAM_HOC_LAIXE'] = (string) $nguoiLx->HO_SO->NAM_HOC_LAIXE;
                                $data_student['SO_NAM_LAIXE'] = (string) $nguoiLx->HO_SO->SO_NAM_LAIXE;
                                $data_student['SO_KM_ANTOAN'] = (string) $nguoiLx->HO_SO->SO_KM_ANTOAN;
                                $data_student['GIAY_CNSK'] = (string) $nguoiLx->HO_SO->GIAY_CNSK;
                                $data_student['HANG_GPLX_DA_CO'] = (string) $nguoiLx->HO_SO->HANG_GPLX_DA_CO;
                                $data_student['SO_GPLX_DA_CO'] = (string) $nguoiLx->HO_SO->SO_GPLX_DA_CO;
                                $data_student['SO_GIAY_CNTN'] = (string) $nguoiLx->HO_SO->SO_GIAY_CNTN;
                                $data_student['SO_CCN'] = (string) $nguoiLx->HO_SO->SO_CCN;
                                $data_student['BC2_GHICHU'] = (string) $nguoiLx->HO_SO->BC2_GHICHU;
                                $data_student['NGAY_RA_QDTN'] = (string) strtotime(str_replace("/", "-", $nguoiLx->HO_SO->NGAY_RA_QDTN));;
                                $student['data_student'] = json_encode($data_student);
                            } else {
                                array_push($msg, "Không tìm thấy học viên trong csdl");
                            }

                            if (!empty($msg)) {
                                $savedError ++;
                                $studentError[$savedError]['info'] = $student;
                                $studentError[$savedError]['msg'] = $msg;
                            } else {
                                $savedSuccess ++;
                                if (!empty($rowStudent)) {
                                    $student['date_updated'] = time();
                                    $d->where('id', $rowStudent['id']);
                                    $d->update('student', $student);
                                } 
                            }
                        }

                        if ($savedSuccess == 0) $func->transfer("Không tìm thấy học viên hợp lệ !","index.php?com=graduate&act=man",false);

                        // Chuyển file vào thư mục lưu lại
                        $filenameUpload = $file_name.time();
                        rename(UPLOAD_FILE.$file_name. '.xml', UPLOAD_FILE.'operation/'.$filenameUpload.'.xml');

                        // Lưu lại lịch sử
                        $dataHistory['namevi'] = '';
                        $dataHistory['descvi'] = 'Import ngày tốt nghiệp sở GTVT cấp (XML)';
                        $dataHistory['file'] = $filenameUpload. '.xml';
                        $dataHistory['type'] = 'import-xml-bc2';
                        $dataHistory['quantity'] = $savedSuccess;
                        $dataHistory['date_created'] = time();
                        $dataHistory['id_downloader'] = $_SESSION[$loginAdmin]['id'];
                        $dataHistory['downloads'] = 1;
                        $d->insert('user_operation', $dataHistory);

                        if (!empty($studentError)) {
                            $template = "layout/error_import";
                        } else {
                            $func->transfer("Import file thành công", "?com=graduate&act=man");
                        }
                    } else {
                        $template = "layout/error_import";
                    }
                } else {
                    // Hiển thị thông báo lỗi nếu file không tồn tại
                    exit('Failed to open');
                }
            }
        } else {
            $mess = "Không hỗ trợ kiểu tập tin này";
            $func->transfer($mess, "?com=graduate&act=man", false);
        }
    } else {
        $func->transfer(dulieurong, "?com=graduate&act=man", false);
    }
}


/* Upload Excel*/
function uploadExcelBC2()
{
    global $d, $langadmin, $type, $func, $config, $loginAdmin, $savedSuccess;

    $fields = [
        'numb','MA_DK', 'HO_TEN_DEM', 'TEN', 'HO_VA_TEN', 'NGAY_SINH', 'NOI_CT', 'NOI_CT_MA_DVHC', 'NOI_CT_MA_DVQL', 'SO_CMT', 'HO_VA_TEN_IN', 'SO_HO_SO', 'SO_GPLX_DA_CO', 'HANG_GPLX_DA_CO', 'NAM_HOC_LAIXE','SO_NAM_LAIXE','SO_KM_ANTOAN','GIAY_CNSK','SO_GIAY_CNTN','SO_CCN','BC2_GHICHU','NGAY_RA_QDTN'
    ];

    if (isset($_POST['importExcel']) || 1) {
        $file_type = $_FILES['file-excel']['type'];

        if ($file_type == "application/vnd.ms-excel" || $file_type == "application/x-ms-excel" || $file_type == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
            $mess = '';
            $filename = $func->changeTitle($_FILES["file-excel"]["name"]).time();
            move_uploaded_file($_FILES["file-excel"]["tmp_name"], UPLOAD_FILE.'operation/'.$filename);

            require LIBRARIES . 'PHPExcel.php';
            require_once LIBRARIES . 'PHPExcel/IOFactory.php';

            $objPHPExcel = PHPExcel_IOFactory::load(UPLOAD_FILE.'operation/'.$filename);

            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                for ($row = 5; $row <= $highestRow; ++$row) {
                    $cell = $worksheet->getCellByColumnAndRow(1, $row);
                    $MA_DK = $cell->getValue();


                    // Cập nhật BCII vào table courses
                    $cell = $worksheet->getCellByColumnAndRow(0, 2);
                    $MA_BCI = $cell->getValue();

                    $cell = $worksheet->getCellByColumnAndRow(0, 3);
                    $MA_BCII = $cell->getValue();

                    $ipBCI = explode(" : ", $MA_BCI);
                    $ipBCI = $ipBCI[1];

                    $ipBCII = explode(" : ", $MA_BCII);
                    $ipBCII = $ipBCII[1];

                    // Validate
                    if (empty($ipBCI)) {
                        $func->transfer("Không nhận được mã BCI", "index.php?com=graduate&act=man", false);
                    }

                    if (empty($ipBCII)) {
                        $func->transfer("Không nhận được mã BCII", "index.php?com=graduate&act=man", false);
                    }

                    // Lấy dữ liệu khoá học theo MA_BCI
                    $rowCourses = $d->rawQueryOne("select id, data_courses from #_courses where JSON_UNQUOTE(JSON_EXTRACT(data_courses, '$.MA_BCI')) = ? limit 1",array($ipBCI));

                    // Cập nhật mã BCII
                    if (!empty($rowCourses)) {
                        $bcii = json_decode($rowCourses['data_courses'],1);  
                        $bcii['MA_BCII'] = $ipBCII;
                        $courses['data_courses'] = json_encode($bcii);
                        $courses['date_updated'] = time();
                        $d->where('id', $rowCourses['id']);
                        $d->update('courses', $courses);
                    } else {
                        $func->transfer("Không tìm thấy mã BCI hợp lệ !", "index.php?com=graduate&act=man", false);
                    }

                    if (!empty($MA_DK)) {
                        $studentImport = $d->rawQueryOne("select id, data_student from #_student where MA_DK = ? and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.theory.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.geometry.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.cabin.point')) > 0 and JSON_UNQUOTE(JSON_EXTRACT(graduate, '$.dat.point')) > 0 limit 0,1", array($MA_DK));
                        if (!empty($studentImport)) {
                            $savedSuccess ++;
                            $data = array();
                            $data_student = json_decode($studentImport['data_student'],true);
                            foreach ($fields as $index => $field) {
                                $cell = $worksheet->getCellByColumnAndRow($index, $row);
                                $$field = (string) $cell->getValue();
                                if($field == 'numb' || $field == 'MA_DK' || $field == 'HO_VA_TEN' || $field == 'SO_CMT'){
                                    $data[$field] = (!empty($$field) ? $$field : '');
                                } elseif($field == 'NGAY_SINH' || $field == 'NGAY_RA_QDTN') {
                                    $data_student[$field] = (!empty($$field) ? strtotime(str_replace("/", "-", $$field)) : '' );
                                } else {
                                    $data_student[$field] = (!empty($$field) ? $$field : '');
                                }
                            }
                            $data['data_student'] = json_encode($data_student);
                            /* Gán dữ liệu */
                            $d->where('id', $studentImport['id']);
                            if ($d->update('student', $data)) {
                                $mess = '';
                            } else {
                                $mess .= 'Lỗi tại dòng: ' . $row . "<br>";
                            }
                        } else {
                            $mess .= 'Lỗi tại dòng: ' . $row . "<br>";
                        }
                        
                    }
                }
            }

            if ($savedSuccess == 0) $func->transfer("Không tìm thấy học viên hợp lệ !","index.php?com=graduate&act=man",false);

            // Lưu lại lịch sử
            $dataHistory['namevi'] = '';
            $dataHistory['descvi'] = 'Import ngày tốt nghiệp sở GTVT cấp (Excel)';
            $dataHistory['file'] = $filename;
            $dataHistory['type'] = 'import-excel-bc2';
            $dataHistory['quantity'] = $savedSuccess;
            $dataHistory['date_created'] = time();
            $dataHistory['id_downloader'] = $_SESSION[$loginAdmin]['id'];
            $dataHistory['downloads'] = 1;
            $d->insert('user_operation', $dataHistory);

            /* Kiểm tra kết quả import */
            if ($mess == '') {
                $mess = "Import danh sách thành công";
                $func->transfer($mess, "index.php?com=graduate&act=man");
            } else {
                $func->transfer($mess, "index.php?com=graduate&act=man", false);
            }
        } else {
            $mess = "Không hỗ trợ kiểu tập tin này";
            $func->transfer($mess, "index.php?com=graduate&act=man", false);
        }
    } else {
        $func->transfer(dulieurong, "index.php?com=graduate&act=man", false);
    }
}

/* Upload XML */
function uploadXMLKQBC2()
{
    global $d, $errormsg, $func, $config, $template, $studentError, $savedSuccess, $loginAdmin;
    if (isset($_POST['importExcel']) || 1) {
        $file_type = $_FILES['file-xml']['type'];

        if ($file_type == "text/xml") {
            $file_name = $func->uploadName($_FILES["file-xml"]["name"]);
            if ($file_attach = $func->uploadImage("file-xml", "text/xml", UPLOAD_FILE, $file_name)) {
                $xmlFile =  UPLOAD_FILE . $file_name . '.xml';
                // Kiểm tra xem file có tồn tại hay không
                if (file_exists($xmlFile)) {
                    // Tải file XML và chuyển đổi nó thành một đối tượng SimpleXMLElement
                    $xml = simplexml_load_file($xmlFile);

                    $errormsg = [];
                    $infoStudentError = [];
                    $studentError = [];
                    $savedSuccess = 0;
                    $savedError = 0;

                    if (empty($errormsg)) {
                        
                        // Duyệt qua các phần tử NGUOI_LX và lấy các trường tương ứng
                        foreach ($xml->DATA->HO_SOS->HO_SO as $k => $nguoiLx) {
                            /* Gán dữ liệu */
                            $msg = [];

                            // Lưu trực tiếp vào các trường database
                            $student = array();
                            $student['MA_DK'] = (string)$nguoiLx->MA_DK;

                            // Lấy học viên
                            $rowStudent = $d->rawQueryOne("select id, data_student from #_student where MA_DK = ?", array($student['MA_DK']));

                            // Lưu vào trường data_student dưới dạng JSON
                            if (!empty($rowStudent)) {
                                $data_student = json_decode($rowStudent['data_student'],true);
                                $data_student['SO_HO_SO'] = (string) $nguoiLx->SO_HO_SO;
                                $data_student['MA_BC2'] = (string) $nguoiLx->MA_BC2;
                                $data_student['KQ_BC2'] = (string) $nguoiLx->KQ_BC2;
                                $data_student['BC2_KQ_LYDO_TUCHOI'] = (string) $nguoiLx->BC2_KQ_LYDO_TUCHOI;
                                $data_student['KQ_BC2_GHICHU'] = (string) $nguoiLx->KQ_BC2_GHICHU;
                                $data_student['MA_KY_SH'] = (string) $nguoiLx->MA_KY_SH;
                                $data_student['SO_BAO_DANH'] = (string) $nguoiLx->SO_BAO_DANH;
                                $data_student['LAN_SH'] = (string) $nguoiLx->LAN_SH;
                                $data_student['SO_QD_SH'] = (string) $nguoiLx->SO_QD_SH;
                                $data_student['NGAY_QD_SH'] = (string) $nguoiLx->NGAY_QD_SH;
                                $student['data_student'] = json_encode($data_student);
                            } else {
                                array_push($msg, "Không tìm thấy học viên trong csdl");
                            }

                            if (!empty($msg)) {
                                $savedError ++;
                                $studentError[$savedError]['info'] = $student;
                                $studentError[$savedError]['msg'] = $msg;
                            } else {
                                $savedSuccess ++;
                                if (!empty($rowStudent)) {
                                    $student['date_updated'] = time();
                                    $d->where('id', $rowStudent['id']);
                                    $d->update('student', $student);
                                } 
                            }
                        }

                        if ($savedSuccess == 0) $func->transfer("Không tìm thấy học viên hợp lệ !","index.php?com=graduate&act=man",false);

                        $filenameUpload = $file_name.time();
                        // Chuyển file vào thư mục lưu lại
                        rename(UPLOAD_FILE.$file_name. '.xml', UPLOAD_FILE.'operation/'.$filenameUpload. '.xml');

                        // Lưu lại lịch sử
                        $dataHistory['namevi'] = '';
                        $dataHistory['descvi'] = 'Import File XML kết quả báo cáo 2';
                        $dataHistory['file'] = $filenameUpload. '.xml';
                        $dataHistory['type'] = 'import-xml-kqbc2';
                        $dataHistory['quantity'] = $savedSuccess;
                        $dataHistory['date_created'] = time();
                        $dataHistory['id_downloader'] = $_SESSION[$loginAdmin]['id'];
                        $dataHistory['downloads'] = 1;
                        $d->insert('user_operation', $dataHistory);

                        if (!empty($studentError)) {
                            $template = "layout/error_import";
                        } else {
                            $func->transfer("Import file thành công", "?com=graduate&act=man");
                        }
                    } else {
                        $template = "layout/error_import";
                    }
                } else {
                    // Hiển thị thông báo lỗi nếu file không tồn tại
                    exit('Failed to open');
                }
            }
        } else {
            $mess = "Không hỗ trợ kiểu tập tin này";
            $func->transfer($mess, "?com=graduate&act=man", false);
        }
    } else {
        $func->transfer(dulieurong, "?com=graduate&act=man", false);
    }
}


/* Upload Excel*/
function uploadExcelFileSH()
{
    global $d, $langadmin, $type, $func, $config, $loginAdmin;

    $fields = [
        'numb','MA_DK', 'SO_HO_SO', 'MA_KY_SH', 'SO_BAO_DANH', 'KET_QUA_SH', 'LAN_SH', 'KQ_SH_LYTHUYET', 'KQ_SH_HINH', 'KQ_SH_DUONG', 'NX_SH_LYTHUYET', 'NX_SH_HINH','NX_SH_DUONG','SO_QD_TT','NGAY_QD_TT','SO_GPLX'
    ];

    $savedSuccess = 0;

    if (isset($_POST['importExcel']) || 1) {
        $file_type = $_FILES['file-excel']['type'];

        if ($file_type == "application/vnd.ms-excel" || $file_type == "application/x-ms-excel" || $file_type == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
            $mess = '';
            $filenameUpload = $func->changeTitle($_FILES["file-excel"]["name"]).time();
            $filename = $filenameUpload;
            move_uploaded_file($_FILES["file-excel"]["tmp_name"],UPLOAD_FILE.'operation/'.$filenameUpload);

            require LIBRARIES . 'PHPExcel.php';
            require_once LIBRARIES . 'PHPExcel/IOFactory.php';

            $objPHPExcel = PHPExcel_IOFactory::load(UPLOAD_FILE.'operation/'.$filenameUpload);

            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                for ($row = 3; $row <= $highestRow; ++$row) {
                    $cell = $worksheet->getCellByColumnAndRow(1, $row);
                    $MA_DK = $cell->getValue();

                    if (!empty($MA_DK)) {
                        $savedSuccess++;
                        $studentImport = $d->rawQueryOne("select id, data_student from #_student where MA_DK = ? limit 0,1", array($MA_DK));
                        if (!empty($studentImport)) {
                            $data = array();
                            $data_student = json_decode($studentImport['data_student'],true);
                            foreach ($fields as $index => $field) {
                                $cell = $worksheet->getCellByColumnAndRow($index, $row);
                                $$field = (string) $cell->getValue();
                                if($field == 'numb'){
                                    $data[$field] = (!empty($$field) ? $$field : '');
                                } elseif($field == 'NGAY_QD_TT') {
                                    $data_student[$field] = (!empty($$field) ? strtotime(str_replace("/", "-", $$field)) : '' );
                                } else {
                                    $data_student[$field] = (!empty($$field) ? $$field : '');
                                }
                            }
                            $data['data_student'] = json_encode($data_student);
                            /* Gán dữ liệu */
                            $d->where('id', $studentImport['id']);
                            if ($d->update('student', $data)) {
                                $mess = '';
                            } else {
                                $mess .= 'Lỗi tại dòng: ' . $row . "<br>";
                            }
                        } else {
                            $mess .= 'Lỗi tại dòng: ' . $row . "<br>";
                        }
                        
                    }
                }
            }

            if ($savedSuccess == 0) $func->transfer("Không tìm thấy học viên hợp lệ !","index.php?com=graduate&act=man",false);

            // Lưu lại lịch sử
            $dataHistory['namevi'] = '';
            $dataHistory['descvi'] = 'Import File Excel sát hạch';
            $dataHistory['file'] = $filenameUpload;
            $dataHistory['type'] = 'import-excel-sh';
            $dataHistory['quantity'] = $savedSuccess;
            $dataHistory['date_created'] = time();
            $dataHistory['id_downloader'] = $_SESSION[$loginAdmin]['id'];
            $dataHistory['downloads'] = 1;
            $d->insert('user_operation', $dataHistory);

            /* Kiểm tra kết quả import */
            if ($mess == '') {
                $mess = "Import danh sách thành công";
                $func->transfer($mess, "index.php?com=graduate&act=manImport");
            } else {
                $func->transfer($mess, "index.php?com=graduate&act=manImport", false);
            }
        } else {
            $mess = "Không hỗ trợ kiểu tập tin này";
            $func->transfer($mess, "index.php?com=graduate&act=manImport", false);
        }
    } else {
        $func->transfer(dulieurong, "index.php?com=graduate&act=manImport", false);
    }
}

/* Upload XML */
function uploadXMLFileSH()
{
    global $d, $errormsg, $func, $config, $template, $studentError, $savedSuccess, $loginAdmin;
    if (isset($_POST['importExcel']) || 1) {
        $file_type = $_FILES['file-xml']['type'];

        if ($file_type == "text/xml") {
            $file_name = $func->uploadName($_FILES["file-xml"]["name"]);
            if ($file_attach = $func->uploadImage("file-xml", "text/xml", UPLOAD_FILE, $file_name)) {
                $xmlFile =  UPLOAD_FILE . $file_name . '.xml';
                // Kiểm tra xem file có tồn tại hay không
                if (file_exists($xmlFile)) {
                    // Tải file XML và chuyển đổi nó thành một đối tượng SimpleXMLElement
                    $xml = simplexml_load_file($xmlFile);

                    $errormsg = [];
                    $infoStudentError = [];
                    $studentError = [];
                    $savedSuccess = 0;
                    $savedError = 0;

                    if (empty($errormsg)) {
                        
                        // Duyệt qua các phần tử NGUOI_LX và lấy các trường tương ứng
                        foreach ($xml->DATA->HO_SO as $k => $nguoiLx) {
                            /* Gán dữ liệu */
                            $msg = [];

                            // Lưu trực tiếp vào các trường database
                            $student = array();
                            $student['MA_DK'] = (string)$nguoiLx->MA_DK;

                            // Lấy học viên
                            $rowStudent = $d->rawQueryOne("select id, data_student from #_student where MA_DK = ?", array($student['MA_DK']));

                            // Lưu vào trường data_student dưới dạng JSON
                            if (!empty($rowStudent)) {
                                $data_student = json_decode($rowStudent['data_student'],true);
                                $data_student['SO_HO_SO'] = (string) $nguoiLx->SO_HO_SO;
                                $data_student['MA_KY_SH'] = (string) $nguoiLx->MA_KY_SH;
                                $data_student['SO_BAO_DANH'] = (string) $nguoiLx->SO_BAO_DANH;
                                $data_student['KET_QUA_SH'] = (string) $nguoiLx->KET_QUA_SH;
                                $data_student['LAN_SH'] = (string) $nguoiLx->LAN_SH;
                                $data_student['KQ_SH_LYTHUYET'] = (string) $nguoiLx->KQ_SH_LYTHUYET;
                                $data_student['KQ_SH_HINH'] = (string) $nguoiLx->KQ_SH_HINH;
                                $data_student['KQ_SH_DUONG'] = (string) $nguoiLx->KQ_SH_DUONG;
                                $data_student['NX_SH_LYTHUYET'] = (string) $nguoiLx->NX_SH_LYTHUYET;
                                $data_student['NX_SH_HINH'] = (string) $nguoiLx->NX_SH_HINH;
                                $data_student['NX_SH_DUONG'] = (string) $nguoiLx->NX_SH_DUONG;
                                $data_student['SO_QD_TT'] = (string) $nguoiLx->SO_QD_TT;
                                $data_student['NGAY_QD_TT'] = (string) $nguoiLx->NGAY_QD_TT;
                                $data_student['SO_GPLX'] = (string) $nguoiLx->SO_GPLX;
                                $student['data_student'] = json_encode($data_student);
                            } else {
                                array_push($msg, "Không tìm thấy học viên trong csdl");
                            }

                            if (!empty($msg)) {
                                $savedError ++;
                                $studentError[$savedError]['info'] = $student;
                                $studentError[$savedError]['msg'] = $msg;
                            } else {
                                $savedSuccess ++;
                                if (!empty($rowStudent)) {
                                    $student['date_updated'] = time();
                                    $d->where('id', $rowStudent['id']);
                                    $d->update('student', $student);
                                } 
                            }
                        }

                        if ($savedSuccess == 0) $func->transfer("Không tìm thấy học viên hợp lệ !","index.php?com=graduate&act=man",false);

                        $filenameUpload = $file_name.time();
                        // Chuyển file vào thư mục lưu lại
                        rename(UPLOAD_FILE.$file_name. '.xml', UPLOAD_FILE.'operation/'.$filenameUpload. '.xml');

                        // Lưu lại lịch sử
                        $dataHistory['namevi'] = '';
                        $dataHistory['descvi'] = 'Import File XML xác hạch';
                        $dataHistory['file'] = $filenameUpload. '.xml';
                        $dataHistory['type'] = 'import-xml-kqbc2';
                        $dataHistory['quantity'] = $savedSuccess;
                        $dataHistory['date_created'] = time();
                        $dataHistory['id_downloader'] = $_SESSION[$loginAdmin]['id'];
                        $dataHistory['downloads'] = 1;
                        $d->insert('user_operation', $dataHistory);

                        if (!empty($studentError)) {
                            $template = "layout/error_import";
                        } else {
                            $func->transfer("Import file thành công", "?com=graduate&act=manImport");
                        }
                    } else {
                        $template = "layout/error_import";
                    }
                } else {
                    // Hiển thị thông báo lỗi nếu file không tồn tại
                    exit('Failed to open');
                }
            }
        } else {
            $mess = "Không hỗ trợ kiểu tập tin này";
            $func->transfer($mess, "?com=graduate&act=manImport", false);
        }
    } else {
        $func->transfer(dulieurong, "?com=graduate&act=manImport", false);
    }
}


/* Upload Excel*/
function uploadExcelKQBC2()
{
    global $d, $langadmin, $type, $func, $config, $loginAdmin, $savedSuccess;

    $fields = [
        'numb','MA_DK', 'SO_HO_SO', 'MA_BC2', 'KQ_BC2', 'BC2_KQ_LYDO_TUCHOI', 'KQ_BC2_GHICHU', 'MA_KY_SH', 'SO_BAO_DANH', 'LAN_SH', 'SO_QD_SH', 'NGAY_QD_SH'
    ];
    $savedSuccess = 0;

    if (isset($_POST['importExcel']) || 1) {
        $file_type = $_FILES['file-excel']['type'];

        if ($file_type == "application/vnd.ms-excel" || $file_type == "application/x-ms-excel" || $file_type == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
            $mess = '';
            $filename = $func->changeTitle($_FILES["file-excel"]["name"]).time();
            move_uploaded_file($_FILES["file-excel"]["tmp_name"], UPLOAD_FILE.'operation/'.$filename);

            require LIBRARIES . 'PHPExcel.php';
            require_once LIBRARIES . 'PHPExcel/IOFactory.php';

            $objPHPExcel = PHPExcel_IOFactory::load(UPLOAD_FILE.'operation/'.$filename);

            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                for ($row = 3; $row <= $highestRow; ++$row) {
                    $cell = $worksheet->getCellByColumnAndRow(1, $row);
                    $MA_DK = $cell->getValue();

                    if (!empty($MA_DK)) {
                        $studentImport = $d->rawQueryOne("select id, data_student from #_student where MA_DK = ? limit 0,1", array($MA_DK));
                        if (!empty($studentImport)) {
                            $data = array();
                            $data_student = json_decode($studentImport['data_student'],true);
                            foreach ($fields as $index => $field) {
                                $cell = $worksheet->getCellByColumnAndRow($index, $row);
                                $$field = (string) $cell->getValue();
                                if($field == 'numb' || $field == 'MA_DK'){
                                    // Không cập nhật lại 2 trường này
                                } elseif($field == 'NGAY_QD_SH') {
                                    $data_student[$field] = (!empty($$field) ? strtotime(str_replace("/", "-", $$field)) : '' );
                                } else {
                                    $data_student[$field] = (!empty($$field) ? $$field : '');
                                }
                            }
                            if (empty($data_student['KQ_BC2'])) {
                                $data_student['KQ_BC2'] = 2;
                            }
                            $data['data_student'] = json_encode($data_student);
                            /* Gán dữ liệu */
                            $d->where('id', $studentImport['id']);
                            if ($d->update('student', $data)) {
                                $mess = '';
                            } else {
                                $mess .= 'Lỗi tại dòng: ' . $row . "<br>";
                            }
                        } else {
                            $mess .= 'Lỗi tại dòng: ' . $row . "<br>";
                        }
                        
                    }
                }
            }

            if ($savedSuccess == 0) $func->transfer("Không tìm thấy học viên hợp lệ !","index.php?com=graduate&act=man",false);

            // Lưu lại lịch sử
            $dataHistory['namevi'] = '';
            $dataHistory['descvi'] = 'Import file excel kết quả sở trả về ';
            $dataHistory['file'] = $filename;
            $dataHistory['type'] = 'import-excel-kqbc2';
            $dataHistory['quantity'] = $savedSuccess;
            $dataHistory['date_created'] = time();
            $dataHistory['id_downloader'] = $_SESSION[$loginAdmin]['id'];
            $dataHistory['downloads'] = 1;
            $d->insert('user_operation', $dataHistory);

            /* Kiểm tra kết quả import */
            if ($mess == '') {
                $mess = "Import danh sách thành công";
                $func->transfer($mess, "index.php?com=graduate&act=man");
            } else {
                $func->transfer($mess, "index.php?com=graduate&act=man", false);
            }
        } else {
            $mess = "Không hỗ trợ kiểu tập tin này";
            $func->transfer($mess, "index.php?com=graduate&act=man", false);
        }
    } else {
        $func->transfer(dulieurong, "index.php?com=graduate&act=man", false);
    }
}