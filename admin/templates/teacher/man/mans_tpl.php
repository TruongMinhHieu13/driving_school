<?php
$linkView = $configBase;
$linkMan = $linkFilter = "index.php?com=teacher&act=man";
$linkAdd = "index.php?com=teacher&act=add";
$linkCopy = "index.php?com=teacher&act=copy";
$linkEdit = "index.php?com=teacher&act=edit";
$linkDelete = "index.php?com=teacher&act=delete";
$linkMulti = "index.php?com=teacher&act=man_photo&kind=man";

$linkImportXML = "index.php?com=import&act=uploadXMLGV";
$linkImportExcel = "index.php?com=import&act=uploadExcelGV";

$validate_filter = "";
foreach($_GET as $k => $v){
    if ($k == 'com' || $k == 'act') {
        $validate_filter .= '';
    } else {
        $validate_filter .= '&'.$k.'='.$v;
    }
}
$linkExportExcel = "index.php?com=export&act=exportExcelTC".$validate_filter;
$linkExportXML = "index.php?com=export&act=exportXMLTC".$validate_filter;

$none = "";
if($func->checkRole()) if ($func->checkPermission('teacher', 'filter', '', '', 'phrase-1')) $none = "d-none";


/* Hạng GPLX */
$gplx = $d->rawQuery("select id, namevi, age from #_gplx where id <> 0 and find_in_set('hienthi',status) order by id asc");

?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="<?=dashboard?>"><?=dashboard?></a></li>
                <li class="breadcrumb-item active">Giáo viên</li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="card-footer text-sm sticky-top">
        <a class="btn btn-sm bg-gradient-primary text-white" href="<?= $linkAdd ?>" title="Thêm mới"><i class="fas fa-plus mr-2"></i><?=themmoi?></a>
        <a class="btn btn-sm bg-gradient-danger text-white" id="delete-all" data-url="<?= $linkDelete ?><?= $strUrl ?>" title="<?=xoatatca?>"><i class="far fa-trash-alt mr-2"></i><?=xoatatca?></a>
        <div class="form-inline form-search d-inline-block align-middle ml-3">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar text-sm" type="search" id="keyword" placeholder="<?=timkiem?>" aria-label="<?=timkiem?>" value="<?= (isset($_GET['keyword'])) ? $_GET['keyword'] : '' ?>" onkeypress="doEnter(event,'keyword','<?= $linkMan ?>')">
                <div class="input-group-append bg-primary rounded-right">
                    <button class="btn btn-navbar text-white" type="button" onclick="onSearch('keyword','<?= $linkMan ?>')">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-primary card-outline text-sm <?=$none?>">
        <div class="card-header">
            <h3 class="card-title"><b>Bộ lọc tìm kiếm</b></h3>
        </div>
        <div class="card-body row">
            <div class="form-group col-md-3 col-sm-3">
                <div class="input-group">
                    <input type="text" class="form-control float-right text-sm" placeholder="Mã khóa học" name="courses_id" id="courses_id" value="">
                </div>
            </div>
            <div class="form-group col-md-3 col-sm-3">
                <div class="input-group">
                    <input type="text" class="form-control float-right text-sm" placeholder="Tên khóa học" name="courses_name" id="courses_name" value="<?= (isset($_GET['courses_name'])) ? $_GET['courses_name'] : '' ?>">
                </div>
            </div>
            <div class="form-group col-md-3 col-sm-3">
                <div class="input-group w-100 select-w-100">
                    <select name="array_hangxe[]" id="hangxe" class="select multiselect-gplx" multiple="multiple">
                        <?php foreach ($gplx as $v) { ?>
                            <option class="opt-<?= $v['id'] ?>" <?= (in_array($v['id'], $arrayGPLX) ? 'selected' : '') ?> value="<?= $v['id'] ?>"><?= $v['namevi'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group col-md-3 col-sm-3">
                <div class="input-group">
                    <input type="text" class="form-control float-right text-sm" placeholder="Mã ID Giáo viên" name="teacher_code" id="teacher_code" value="<?= (isset($_GET['teacher_code'])) ? $_GET['teacher_code'] : '' ?>">
                </div>
            </div>
            <div class="form-group col-md-3 col-sm-3">
                <div class="input-group">
                    <input type="text" class="form-control float-right text-sm" placeholder="Tên giáo viên" name="teacher_name" id="teacher_name" value="<?= (isset($_GET['teacher_name'])) ? $_GET['teacher_name'] : '' ?>">
                </div>
            </div>
            <div class="form-group col-md-3 col-sm-3">
                <div class="input-group">
                    <input type="text" class="form-control float-right text-sm" placeholder="CCCD/CMND của giáo viên" name="teacher_cmt" id="teacher_cmt" value="<?= (isset($_GET['teacher_cmt'])) ? $_GET['teacher_cmt'] : '' ?>">
                </div>
            </div>
            <div class="form-group col-md-3 col-sm-3">
                <div class="input-group select-w-100">
                    <select name="function_teacher" id="function_teacher" class="multiselect-cn form-control text-sm" multiple="multiple">
                        <option class="opt-lythuyet" value="lythuyet" <?=(in_array("lythuyet",$dataResult['function-teacher'])) ? 'selected' : ''?>>Lý thuyết</option>
                        <option class="opt-hinh" value="hinh" <?=(in_array("hinh",$dataResult['function-teacher'])) ? 'selected' : ''?>>Hình</option>
                        <option class="opt-cabin" value="cabin" <?=(in_array("cabin",$dataResult['function-teacher'])) ? 'selected' : ''?>>Cabin</option>
                        <option class="opt-dat" value="dat" <?=(in_array("dat",$dataResult['function-teacher'])) ? 'selected' : ''?>>DAT</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group col-md-3 col-sm-3">
                <a class="btn btn-sm bg-gradient-primary text-white" onclick="searchMultiple('<?= $linkFilter ?>')" title="<?= timkiem ?>"><i class="fas fa-search mr-1"></i><?= timkiem ?></a>
                <a class="btn btn-sm bg-gradient-success text-white ml-1" href="<?= $linkMan ?>" title="Refresh"><i class="fas fa-times mr-1"></i><?= huyloc ?></a>
            </div>
            <div class="col-md-3 col-sm-3">
                <div class="title-box text-sm font-weight-normal mb-2"><b>Import file XML</b></div>
                <form method="post" action="<?= $linkImportXML ?>" enctype="multipart/form-data">
                    <div class="flex-input-file">
                        <div class="form-group">
                            <div class="custom-file my-custom-file">
                                <input type="file" class="custom-file-input" name="file-xml" id="file-xml">
                                <label class="custom-file-label custom-upload-file" for="file-xml"><?= chonfile ?></label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm bg-gradient-success" name="importExcel">Import</button>
                    </div>
                </form>
            </div>
            <div class="col-md-3 col-sm-3">
                <div class="title-box text-sm font-weight-normal mb-2"><b>Import file Excel</b></div>
                <form method="post" action="<?= $linkImportExcel ?>" enctype="multipart/form-data">
                    <div class="flex-input-file">
                        <div class="form-group">
                            <div class="custom-file my-custom-file">
                                <input type="file" class="custom-file-input" name="file-excel" id="file-excel">
                                <label class="custom-file-label custom-upload-file" for="file-excel"><?= chonfile ?></label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm bg-gradient-success" name="importExcel">Import</button>
                    </div>
                </form>
            </div>
            <div class="col-md-3 col-sm-3">
                <div class="title-box text-sm font-weight-normal mb-2"><b>Export file XML</b> </div>
                <form method="post" action="<?= $linkUploadExcel ?>" enctype="multipart/form-data">
                    <a href="<?=$linkExportXML?>" class="btn btn-sm bg-gradient-success flex-shrink-0 w-100" name="exportExcel"><i class="fas fa-upload mr-2"></i>Export file XML</a>
                </form>
            </div>
            <div class="col-md-3 col-sm-3">
                <div class="title-box text-sm font-weight-normal mb-2"><b>Export file Excel <a href="<?=UPLOAD_FILE?>File-Mau-CBCNV.xlsx" class="link-file-example" name="exportExcel">File mẫu</a></b></div>
                <a href="<?=$linkExportExcel?>" class="btn btn-sm bg-gradient-success flex-shrink-0 w-100" name="exportExcel"><i class="fas fa-upload mr-2"></i>Export file Excel</a>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="search-result">
                <div class="box-result">
                    <div class="box-result">
                        <?php if (!empty($dataResult['courses_id'])) { ?>
                            <div class="title-result">Khoá học</div>
                            <?php foreach ($dataResult['courses_id'] as $k => $name) { ?>
                                <p class="result-btn" data-result="<?= $name ?>" data-category="courses_id"><?= $name ?> <span class="cancle-btn">x</span></p>
                            <?php }
                        } ?>
                    </div>
                    <div class="box-result">
                        <?php if (!empty($dataResult['courses-name'])) { ?>
                            <div class="title-result">Tên khoá học</div>
                            <?php foreach ($dataResult['courses-name'] as $k => $name) { ?>
                                <p class="result-btn" data-result="<?= $name ?>" data-category="courses_name"><?= $name ?> <span class="cancle-btn">x</span></p>
                            <?php }
                        } ?>
                    </div>
                    <?php if (!empty($dataResult['teacher-code'])) { ?>
                        <div class="title-result">ID Giáo viên</div>
                        <?php foreach ($dataResult['teacher-code'] as $k => $name) { ?>
                            <p class="result-btn" data-result="<?= $name ?>" data-category="teacher_code"><?= $name ?> <span class="cancle-btn">x</span></p>
                    <?php }
                    } ?>
                    <?php if (!empty($dataResult['teacher-name'])) { ?>
                        <div class="title-result">Tên giáo viên</div>
                        <?php foreach ($dataResult['teacher-name'] as $k => $name) { ?>
                            <p class="result-btn" data-result="<?= $name ?>" data-category="teacher_name"><?= $name ?> <span class="cancle-btn">x</span></p>
                    <?php }
                    } ?>
                    <?php if (!empty($dataResult['teacher-cmt'])) { ?>
                        <div class="title-result">CCCD/CMND</div>
                        <?php foreach ($dataResult['teacher-cmt'] as $k => $name) { ?>
                            <p class="result-btn" data-result="<?= $name ?>" data-category="teacher_cmt"><?= $name ?> <span class="cancle-btn">x</span></p>
                    <?php }
                    } ?>
                </div>
                <div class="box-result">
                    <?php if (!empty($arrayGPLX)) { ?>
                        <div class="title-result">Hạng GPLX</div>
                        <?php foreach ($arrayGPLX as $k => $name) { ?>
                            <p class="result-btn result-gplx"><?= $func->getColDetail('namevi', 'gplx', $name); ?> <span class="cancle-btn" data-id="<?= $name ?>">x</span></p>
                        <?php }
                    } ?>

                </div>
                <div class="box-result">
                   <?php if (!empty($dataResult['function-teacher'])) { ?>
                    <div class="title-result">Chức năng</div>
                    <?php foreach ($dataResult['function-teacher'] as $k => $name) { ?>
                        <p class="result-btn result-func"  data-result="<?= $name ?>" data-category="function_teacher">
                            <?php if ($name == 'lythuyet'){ ?>
                                Lý thuyết
                            <?php } elseif ($name == 'hinh') { ?>
                                Hình
                            <?php } elseif ($name == 'cabin') { ?>
                                Cabin
                            <?php } elseif ($name == 'dat') { ?>
                                DAT
                            <?php } ?>
                            <span class="cancle-btn" data-id="<?=$name?>">x</span>
                        </p>
                    <?php }
                } ?>
            </div>
            </div>
        </div>
    </div>
    <div class="card card-primary card-outline text-sm mb-0">
        <div class="card-header">
            <h3 class="card-title"><?=danhsach?> khoá học</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover" style="min-width: 100%;">
                <thead>
                    <tr>
                        <th class="align-middle" width="5%">
                            <div class="custom-control custom-checkbox my-checkbox">
                                <input type="checkbox" class="custom-control-input" id="selectall-checkbox">
                                <label for="selectall-checkbox" class="custom-control-label"></label>
                            </div>
                        </th>
                        <th class="align-middle text-center" width="5%">STT</th>
                        <th class="align-middle">Mã ID giáo viên </th>
                        <th class="align-middle">Tên giáo viên </th>
                        <th class="align-middle">CCCD</th>
                        <th class="align-middle text-center">Hạng xe dạy</th>
                        <th class="align-middle text-center">Tình trạng dạy</th>
                        <th class="align-middle">Đang sở hữu xe</th>
                        <th class="align-middle"><?=thaotac?></th>
                    </tr>
                </thead>
                <?php if (empty($items)) { ?>
                    <tbody>
                        <tr>
                            <td colspan="100" class="text-center"><?=khongcodulieu?></td>
                        </tr>
                    </tbody>
                <?php } else { ?>
                    <tbody>
                        <?php for ($i = 0; $i < count($items); $i++) { 
                            $dataCourses = (!empty($items[$i]['data_courses']) ? json_decode($items[$i]['data_courses'],true) : []);
                        ?>
                            <tr>
                                <td class="align-middle">
                                    <div class="custom-control custom-checkbox my-checkbox">
                                        <input type="checkbox" class="custom-control-input select-checkbox" id="select-checkbox-<?= $items[$i]['id'] ?>" value="<?= $items[$i]['id'] ?>">
                                        <label for="select-checkbox-<?= $items[$i]['id'] ?>" class="custom-control-label"></label>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <input type="number" class="form-control form-control-mini m-auto update-numb" min="0" value="<?= $items[$i]['numb'] ?>" data-id="<?= $items[$i]['id'] ?>" data-table="courses">
                                </td>
                                <td class="align-middle">
                                    <?= $items[$i]['id_code'] ?>
                                </td>
                                <td class="align-middle">
                                    <?= $items[$i]['fullname'] ?>
                                </td>
                                <td class="align-middle">
                                    <?= $items[$i]['cccd'] ?>
                                </td>
                                <td class="align-middle text-uppercase text-center">
                                    <?= $func->getColDetail('namevi','gplx',$items[$i]['hangxe']) ?>
                                </td>
                                <?php if(!empty($items[$i]['chucnang'])) $functionGV = explode(',',$items[$i]['chucnang']);?>
                                <td class="align-middle text-center">
                                    <?php if(in_array("lythuyet",$functionGV))  echo '<span class="item-cn">LT</span>';?>
                                    <?php if(in_array("hinh",$functionGV)) echo ' <span class="item-cn">Hình</span>';?>
                                    <?php if(in_array("cabin",$functionGV)) echo '<span class="item-cn">Cabin</span>';?>
                                    <?php if(in_array("dat",$functionGV)) echo '<span class="item-cn">DAT</span>';?>
                                </td>
                                <td class="align-middle">
                                </td>
                                <td class="align-middle text-center text-md text-nowrap">
                                    <a class="text-primary mr-2" href="<?= $linkEdit ?><?= $linkID ?>&id=<?= $items[$i]['id'] ?>" title="<?=chinhsua?>"><i class="fas fa-edit"></i></a>
                                    <a class="text-danger" id="delete-item" data-url="<?= $linkDelete ?><?= $linkID ?>&id=<?= $items[$i]['id'] ?>" title="Xóa"><i class="fas fa-trash-alt"></i></a>
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
    <div class="card-footer text-sm">
        <a class="btn btn-sm bg-gradient-primary text-white" href="<?= $linkAdd ?>" title="Thêm mới"><i class="fas fa-plus mr-2"></i><?=themmoi?></a>
        <a class="btn btn-sm bg-gradient-danger text-white" id="delete-all" data-url="<?= $linkDelete ?><?= $strUrl ?>" title="<?=xoatatca?>"><i class="far fa-trash-alt mr-2"></i><?=xoatatca?></a>
    </div>
</section>