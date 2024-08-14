<div class="box-user">
	<div class="list-content">
		<span class="acount-lv">Xin chào</span>
		<p class="account-name"><?=$_SESSION[$loginMember]['fullname']?></p>
		<a class="<?=($action == 'thong-tin' ? 'act' : '')?>" href="account/thong-tin"><i class="me-2 fas fa-user"></i> Thông tin tài khoản</a>
		<?php if (in_array('lythuyet',$functionTeacher)){ ?>
			<a href="account/duyet-ly-thuyet?type=lythuyet" class="<?=($action == 'duyet-ly-thuyet' ? 'act' : '')?>">
				<i class="me-2 fa-solid fa-note"></i>
				<span>Duyệt lý thuyết</span>
			</a>
		<?php } ?>
		<?php if (in_array('hinh',$functionTeacher)){ ?>
			<a href="account/duyet-hinh?type=hinh" class="<?=($action == 'duyet-hinh' ? 'act' : '')?>">
				<i class="me-2 fa-solid fa-note"></i>
				<span>Duyệt hình</span>
			</a>
		<?php } ?>

		<?php if (in_array('cabin',$functionTeacher)){ ?>
			<a href="account/duyet-cabin?type=cabin" class="<?=($action == 'duyet-cabin' ? 'act' : '')?>">
				<i class="me-2 fa-solid fa-note"></i>
				<span>Duyệt Cabin</span>
			</a>
		<?php } ?>
		<?php if (in_array('dat',$functionTeacher)){ ?>
			<a href="account/duyet-dat?type=dat" class="<?=($action == 'duyet-dat' ? 'act' : '')?>">
				<i class="me-2 fa-solid fa-note"></i>
				<span>Duyệt DAT</span>
			</a>
		<?php } ?>
		<a href="account/doi-mat-khau" class="<?=($action == 'doi-mat-khau' ? 'act' : '')?>">
			<i class="me-2 fa-solid fa-key"></i>
			<span>Đổi mật khẩu</span>
		</a>
		<a href="account/dang-xuat">
			<i class="me-2 fas fa-sign-out-alt"></i>
			<span><?= dangxuat ?></span>
		</a>
	</div>
</div>
