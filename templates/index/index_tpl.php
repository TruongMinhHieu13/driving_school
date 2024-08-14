<?php if (!empty($introHome)){ ?>
	<div class="intro-home wrap-container">
		<div class="wrap-content">
			<div class="intro-left">
				<a href="gioi-thieu" class="intro-pic-1">
					<img class="w-100" onerror="this.src='<?= THUMBS ?>/220x220x1/assets/images/noimage.png';" src="<?= THUMBS ?>/220x220x1/<?= UPLOAD_NEWS_L . $introHome['photo'] ?>" alt="<?= $introHome['name' . $lang] ?>" title="<?= $introHome['name' . $lang] ?>" />
				</a>
				<a href="gioi-thieu" class="intro-pic-2">
					<img class="w-100" onerror="this.src='<?= THUMBS ?>/440x440x1/assets/images/noimage.png';" src="<?= THUMBS ?>/440x440x1/<?= UPLOAD_NEWS_L . $introHome['photo1'] ?>" alt="<?= $introHome['name' . $lang] ?>" title="<?= $introHome['name' . $lang] ?>" />
				</a>
				<a href="gioi-thieu" class="intro-pic-3">
					<img class="w-100" onerror="this.src='<?= THUMBS ?>/220x220x1/assets/images/noimage.png';" src="<?= THUMBS ?>/220x220x1/<?= UPLOAD_NEWS_L . $introHome['photo2'] ?>" alt="<?= $introHome['name' . $lang] ?>" title="<?= $introHome['name' . $lang] ?>" />
				</a>
			</div>
			<div class="intro-right">
				<div class="sub-intro">Giới thiệu</div>
				<h2 class="name-intro"><?=$introHome['name'.$lang]?></h2>
				<div class="slogan-intro"><?=$introHome['desc2'.$lang]?></div>
				<div class="desc-intro"><?=htmlspecialchars_decode($introHome['desc'.$lang])?></div>
				<div class="btn-intro"><a href="gioi-thieu" title="Giới thiệu"><span>Xem thêm</span></a></div>
			</div>
		</div>
	</div>
<?php } ?>

<?php if (!empty($videoHome) || !empty($criteriaHome)){ ?>
	<div class="video-&-criteria">
		<div class="wrap-content">
			<div class="video-home">
				<?php if (!empty($videoHome)){ ?>
					<div class="slick-1 none sl-10">
						<?php foreach ($videoHome as $v){ ?>
							<div>
								<div class="pic-video">
									<a class="scale-img text-decoration-none" data-fancybox="video" data-src="<?= $func->getYoutubeShorts($v['link_video']) ?>" title="<?= $v['name' . $lang] ?>">
										<img class="w-100" onerror="this.src='<?= THUMBS ?>/630x580x1/assets/images/noimage.png';" src="<?= THUMBS ?>/630x580x1/<?= UPLOAD_PHOTO_L . $v['photo'] ?>" alt="<?= $v['name' . $lang] ?>" title="<?= $v['name' . $lang] ?>" />
									</a>
								</div>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
			<div class="criteria-home">
				<?php if (!empty($criteriaHome)){ ?>
					<div class="slick-vertical">
						<?php foreach($criteriaHome as $v){?>
							<div class="">
								<div class="item-criteria">
									<div class="img-criteria rotate-img">
										<img onerror="this.src='<?= THUMBS ?>/60x60x1/assets/images/noimage.png';" src="<?= UPLOAD_PHOTO_L . $v['photo'] ?>" alt="<?= $v['name' . $lang] ?>" title="<?= $v['name' . $lang] ?>" />
									</div>
									<div class="in4-criteria">
										<h3 class="name-criteria text-split-1"><?=$v['name'.$lang]?></h3>
										<p class="desc-criteria text-split"><?=$v['desc'.$lang]?></p>
									</div>
								</div>
							</div>
						<?php }?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
<?php } ?>

<div class="why-&-newsletter wrap-container">
	<div class="wrap-content">
		<div class="why-home">
			<?php if (!empty($whyHome)){ ?>
				<h2 class="title-main text-start mb-3">Tại Sao Chọn Chúng Tôi?</h2>
				<ul class="why-list">
					<?php foreach ($whyHome as $v){ ?>
						<li>
							<a href="<?=$v[$sluglang]?>" title="<?=$v['name'.$lang]?>"><?=$v['name'.$lang]?></a>
						</li>
						<li>
							<a href="<?=$v[$sluglang]?>" title="<?=$v['name'.$lang]?>"><?=$v['name'.$lang]?></a>
						</li>
					<?php } ?>
				</ul>
			<?php } ?>
		</div>
		<div class="newsletter-home">
			<div class="icon-newsletter">
				<img src="./assets/images/newsletter.png" alt="">
			</div>
			<h2 class="title-main mb-2">Đăng ký nhận tin</h2>
			<p class="slogan-newsletter">Liên hệ với chúng tôi để được hỗ trợ tư vấn và làm hồ sơ miễn phí</p>

			<form class="validation-newsletter form-newsletter"  id="FormNewsletterIndex" method="post" action="" enctype="multipart/form-data">
				<div class="row row-10">
					<div class="col-md-12">
						<div class="newsletter-input">
							<div class="form-floating form-floating-cus">
								<input type="text" class="form-control border-black text-sm" id="fullname-newsletter" name="dataNewsletter[fullname]" placeholder="Nhập fullname" />
								<label for="fullname-newsletter">Tên của bạn</label>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="newsletter-input">
							<div class="form-floating form-floating-cus">
								<input type="number" class="form-control border-black text-sm" id="phone-newsletter" name="dataNewsletter[phone]" placeholder="Nhập phone" />
								<label for="phone-newsletter">Điện Thoại</label>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="newsletter-input">
							<div class="form-floating form-floating-cus">
								<input type="email" class="form-control border-black text-sm" id="email-newsletter" name="dataNewsletter[email]" placeholder="Nhập email" required />
								<label for="email-newsletter">Email</label>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="newsletter-input">
							<div class="form-floating form-floating-cus">
								<input type="text" class="form-control border-black text-sm" id="content-newsletter" name="dataNewsletter[content]" placeholder="Nhập nội dung" />
								<label for="content-newsletter">Nội dung</label>
							</div>
						</div>
					</div>
				</div>
				<div class="newsletter-button">
					<input type="hidden" class="" name="dataNewsletter[type]" value="dangkynhantin">
					<input type="hidden" class="" name="dataNewsletter[date_created]" value="<?= time() ?>">
					<input type="hidden" name="newsletter" value="submit">
					<input type="submit" class="btn btn-sm btn-danger w-100" name="submit-newsletter" value="Đăng Ký Ngay" disabled>
					<input type="hidden" class="btn btn-sm btn-danger w-100" name="recaptcha_response_newsletter" id="recaptchaResponseNewsletterIndex">
				</div>
			</form>
		</div>
	</div>
</div>

<?php if (!empty($coursesHome)){ ?>
	<div class="courses-home wrap-container">
		<div class="wrap-content">
			<h2 class="title-main">các khóa học & thủ tục</h2>
			<p class="slogan"><?=$optsetting['slogan']?></p>
			<div class="slick-3 none sl-20">
				<?php foreach ($coursesHome as $v){ ?>
					<div>
						<div class="items-courses">
							<div class="icon-courses">
								<a href="<?=$v[$sluglang]?>" title="<?=$v['name'.$lang]?>">
									<img onerror="this.src='<?= THUMBS ?>/60x60x1/assets/images/noimage.png';" src="<?= UPLOAD_NEWS_L . $v['photo'] ?>" alt="<?= $v['name' . $lang] ?>" title="<?= $v['name' . $lang] ?>" />
								</a>
							</div>
							<h3 class="name-courses">
								<a href="<?=$v[$sluglang]?>" title="<?=$v['name'.$lang]?>"><?=$v['name'.$lang]?></a>
							</h3>
							<p class="desc-courses text-split"><?=$v['desc'.$lang]?></p>
							<a href="<?=$v[$sluglang]?>" title="<?=$v['name'.$lang]?>" class="see-detail">Xem chi tiết <i class="fa-regular fa-angle-right ms-2"></i></a>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
<?php } ?>

<?php if (!empty($scheduleHome)){ ?>
	<div class="schedule-home">
		<div class="wrap-content">
			<h2 class="title-main text-white">lịch học</h2>
			<p class="slogan text-white"><?=$optsetting['slogan']?></p>
			<div class="wrap-schedule">
				<div class="slick-2 none sl-20">
					<?php foreach ($scheduleHome as $v){ ?>
						<div>
							<div class="item-schedule">
								<h3 class="name-schedule"><?=$v['name'.$lang]?></h3>
								<div class="line-1 flex">
									<p>Sáng</p>
									<p><?=$v['morningvi']?></p>
								</div>
								<div class="line-2 flex">
									<p>Trưa</p>
									<p><?=$v['noonvi']?></p>
								</div>
								<div class="line-3 flex">
									<p>Chiều</p>
									<p><?=$v['afternoonvi']?></p>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
<?php } ?>

<?php if (!empty($statisticalHome)){ ?>
	<div class="statistical-home wrap-container statistics">
		<div class="wrap-content">
			<div class="slick-statistics none sl-30">
				<?php foreach ($statisticalHome as $k => $v){ ?>
					<div>
						<div class="statistics-item has-text-centered">
							<div class="icon-statistical">
								<a href="<?=$v[$sluglang]?>" title="<?=$v['name'.$lang]?>">
									<img onerror="this.src='<?= THUMBS ?>/60x60x1/assets/images/noimage.png';" src="<?= UPLOAD_NEWS_L . $v['photo'] ?>" alt="<?= $v['name' . $lang] ?>" title="<?= $v['name' . $lang] ?>" />
								</a>
								<div class="numb">0<?=$k+1?></div>
							</div>
							<div class="d-flex justify-content-center statistics-value">
								<?php if ($v['countup'] > 0): ?>
									<p class="js-count-up" data-value="<?=$v['quanlity']?>"></p>
								<?php endif ?>
								<p><?=$v['unit']?></p>
							</div>
							<p class="name-statistics"><?=$v['name'.$lang]?></p>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
<?php } ?>


<?php if (!empty($newsHome)){ ?>
	<div class="news-home wrap-container">
		<div class="wrap-content">
			<h2 class="title-main">tin tức mới</h2>
			<p class="slogan"><?=$optsetting['slogan']?></p>
			<div class="slick-3 none sl-30">
				<?=$func->getNews($newsHome)?>
			</div>
		</div>
	</div>
<?php } ?>

<?php if (!empty($internalInformation)){ ?>
	<div class="internalinfor-home wrap-container">
		<div class="wrap-content">
			<h2 class="title-main">Thông tin nội bộ</h2>
			<p class="slogan"><?=$optsetting['slogan']?></p>
			<div class="slick-3 none sl-30">
				<?=$func->getNews($internalInformation)?>
			</div>
		</div>
	</div>
<?php } ?>

<?php if (!empty($albumHome)){ ?>
	<div class="album-home">
		<div class="wrap-content">
			<h2 class="title-main">Hình ảnh hoạt động</h2>
			<p class="slogan"><?=$optsetting['slogan']?></p>
			<div class="grid-album flex">
				<?php $arrThumb = array("395x295x1","395x435x1","395x240x1","395x240x1","395x240x1","395x295x1","395x435x1");?>
				<?php foreach ($albumHome as $k => $v){ ?>
					<?php if ($k == 2 || $k == 5 || $k == 0){ ?>
						<div class="col-album">
					<?php } ?>
					<a href="<?=$v[$sluglang]?>" title="<?=$v['name'.$lang]?>">
						<img onerror="this.src='<?= THUMBS ?>/<?=$arrThumb[$k]?>/assets/images/noimage.png';" src="<?= THUMBS ?>/<?=$arrThumb[$k]?>/<?= UPLOAD_NEWS_L . $v['photo'] ?>" alt="<?= $v['name' . $lang] ?>" title="<?= $v['name' . $lang] ?>" />
					</a>
					<?php if ($k == 1 || $k == 4){ ?>
						</div>
					<?php } ?>

				<?php } ?> </div>
			</div>
		</div>
	</div>
<?php } ?>