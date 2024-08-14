<div class="menu">
    <div class="wrap-content">
        <ul class="menu-main">
            <li><a class="<?php if ($com == '' || $com == 'index') echo 'active'; ?> transition" href="" title="<?= trangchu ?>"><?= trangchu ?></a></li>
            <li><a class="<?php if ($com == 'gioi-thieu') echo 'active'; ?> transition" href="gioi-thieu" title="<?= gioithieu ?>"><?= gioithieu ?></a></li>
            <li><a class="<?php if ($com == 'mo-phong') echo 'active'; ?> transition" href="mo-phong" title="Mô phỏng">Mô phỏng</a></li>
            <li><a class="<?php if ($com == 'thi-thu') echo 'active'; ?> transition" href="thi-thu" title="Thi thử lý thuyết">Thi thử lý thuyết</a></li>
            <li><a class="<?php if ($com == 'tai-lieu') echo 'active'; ?> transition" href="tai-lieu" title="Tài liệu">Tài liệu</a></li>
            <li><a class="<?php if ($com == 'thong-bao') echo 'active'; ?> transition" href="thong-bao" title="Thông báo">Thông báo</a></li>
            <li><a class="<?php if ($com == 'khoa-hoc') echo 'active'; ?> transition" href="khoa-hoc" title="Khoá học">Khoá học</a></li>
            <li><a class="<?php if ($com == 'dang-ky') echo 'active'; ?> transition" href="dang-ky" title="Đăng ký học">Đăng ký học</a></li>
        </ul>
    </div>
</div>