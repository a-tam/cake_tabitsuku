<nav id="globalnavi">
	<ul>
		<li class="top"><a href="<?php echo $this->Html->url("/");?>"><img src="<?php echo $this->Html->url("/img/common/navi/top.gif") ?>" alt="トップページ"></a></li>
		<li class="spotsearch"><a href="<?php echo $this->Html->url("/spots/"); ?>"><img src="<?php echo $this->Html->url("/img/common/navi/spotsearch.gif") ?>" alt="スポット検索"></a></li>
		<li class="toursearch"><a href="<?php echo $this->Html->url("/tours/");?>"><img src="<?php echo $this->Html->url("/img/common/navi/toursearch.gif") ?>" alt="ツアー検索"></a></li>
	<?php if ($this->Session->read("user_info")): ?>
		<li class="spot"><a href="<?php echo $this->Html->url("/spots/form");?>"><img src="<?php echo $this->Html->url("/img/common/navi/spot.gif") ?>" alt="スポット登録"></a></li>
		<li class="tour"><a href="<?php echo $this->Html->url("/tours/form");?>"><img src="<?php echo $this->Html->url("/img/common/navi/tour.gif") ?>" alt="ツアー作成"></a></li>
		<li class="maypage"><a href="<?php echo $this->Html->url("/users/");?>"><img src="<?php echo $this->Html->url("/img/common/navi/mypage.gif") ?>" alt="マイページ"></a></li>
	<?php else: ?>
		<li class="spot"><a href="#login" class="loginbtn mouse_over" data-redirect="spot"><img src="<?php echo $this->Html->url("/img/common/navi/spot.gif") ?>" alt="スポット登録"></a></li>
		<li class="tour"><a href="#login" class="loginbtn mouse_over" data-redirect="tour"><img src="<?php echo $this->Html->url("/img/common/navi/tour.gif") ?>" alt="ツアー作成"></a></li>
		<li class="maypage"><a href="#login" class="loginbtn mouse_over" data-redirect="mypage"><img src="<?php echo $this->Html->url("/img/common/navi/mypage.gif") ?>" alt="マイページ"></a></li>
	<?php endif; ?>
	</ul>
</nav>
<!-- //globalnavi -->
<?php
$flash_message = $this->Session->flash();
if ($flash_message) :?>
<style>
<!--
.message {
	clear: both;
	color: #fff;
	font-size: 12px;
	font-weight: bold;
	text-align: center;
	margin: 0 auto;
	padding: 5px;
	width: 971px;
	position: relative;
}
.success,
.message,
.cake-error,
.cake-debug,
.notice,
p.error,
.error-message {
	background: #ffcc00;
	background-repeat: repeat-x;
	background-image: -moz-linear-gradient(top, #ffcc00, #E6B800);
	background-image: -ms-linear-gradient(top, #ffcc00, #E6B800);
	background-image: -webkit-gradient(linear, left top, left bottom, from(#ffcc00), to(#E6B800));
	background-image: -webkit-linear-gradient(top, #ffcc00, #E6B800);
	background-image: -o-linear-gradient(top, #ffcc00, #E6B800);
	background-image: linear-gradient(top, #ffcc00, #E6B800);
	text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
	border: 1px solid rgba(0, 0, 0, 0.2);
	margin-bottom: 18px;
	padding: 7px 14px;
	color: #404040;
	text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
	-webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.25);
	-moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.25);
	box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.25);
}
.success,
.message,
.cake-error,
p.error,
.error-message {
	clear: both;
	color: #fff;
	background: #c43c35;
	border: 1px solid rgba(0, 0, 0, 0.5);
	background-repeat: repeat-x;
	background-image: -moz-linear-gradient(top, #ee5f5b, #c43c35);
	background-image: -ms-linear-gradient(top, #ee5f5b, #c43c35);
	background-image: -webkit-gradient(linear, left top, left bottom, from(#ee5f5b), to(#c43c35));
	background-image: -webkit-linear-gradient(top, #ee5f5b, #c43c35);
	background-image: -o-linear-gradient(top, #ee5f5b, #c43c35);
	background-image: linear-gradient(top, #ee5f5b, #c43c35);
	text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.3);
}
.success {
	clear: both;
	color: #fff;
	border: 1px solid rgba(0, 0, 0, 0.5);
	background: #3B8230;
	background-repeat: repeat-x;
	background-image: -webkit-gradient(linear, left top, left bottom, from(#76BF6B), to(#3B8230));
	background-image: -webkit-linear-gradient(top, #76BF6B, #3B8230);
	background-image: -moz-linear-gradient(top, #76BF6B, #3B8230);
	background-image: -ms-linear-gradient(top, #76BF6B, #3B8230);
	background-image: -o-linear-gradient(top, #76BF6B, #3B8230);
	background-image: linear-gradient(top, #76BF6B, #3B8230);
	text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.3);
}
-->
</style>
<div class="pg_notification"><?php echo $flash_message; ?></div>
<?php endif;?>
