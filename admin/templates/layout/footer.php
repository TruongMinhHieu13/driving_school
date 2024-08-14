<!-- Main Footer -->
<footer class="main-footer text-center text-sm">
    <p class="mb-1">CÔNG TY TNHH THƯƠNG MẠI VÀ DỊCH VỤ NINA</p>
    <p class="mb-1"><?=diachi?>: Lầu 3, Tòa nhà SaigonTel, Lô 46, CVPM Quang Trung, P. Tân Chánh Hiệp, Q. 12, TP HCM</p>
    <p class="mb-1">Tel: 028.37154879 - Fax: 028.37154878</p>
    <p class="mb-0">Email: nina@nina.vn</p>
</footer>
<div class="modal fade graduate" id="popup-graduate" tabindex="-1" aria-labelledby="graduate-cartLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <form class="validation-newsletter form-graduate" id="form-graduate" method="post" action="javascript:void(0);">
                    <div class="newsletter-graduate">
                        <label for="note-graduate">Ghi chú</label>
                        <div class="form-floating form-floating-cus">
                            <textarea id="note-graduate" rows="5" class="form-control text-sm" name="note-graduate" placeholder="Ghi chú"></textarea>
                        </div>
                        <div class="btn-submit-graduate mt-2">
                            <input type="submit" class="btn btn-sm bg-default btn-primary " name="submit-graduate" value="Xác nhận đã đủ điều kiện đạt" >
                            <input type="hidden" name="type-graduate" id="type-graduate" value="">
                            <input type="hidden" name="point-graduate" id="point-graduate" value="">
                            <input type="hidden" name="id-student" id="id-student" value="">
                            <input type="hidden" name="type" id="type" value="updateGraduate">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>