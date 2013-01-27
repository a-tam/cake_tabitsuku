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
