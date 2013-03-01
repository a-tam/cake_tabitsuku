
<div id="fb-root"></div>
<script>(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/ja_JP/all.js#xfbml=1&appId="+gFacebookAppId
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script><!-- facebook -->

<header>
	<h1><a href="<?php echo $this->Html->url("/");?>"><img src="<?php echo $this->Html->url("/img/logo.gif"); ?>" alt="たびつく　自分だけの旅行プランを作ろう" /></a></h1>
	<dl class="search">
		<dt><img src="<?php echo $this->Html->url("/img/common/header/search.gif"); ?>" alt="ツアーやスポットを検索しよう" /></dt>
		<dd>
			<form method="post">
				<p class="categoryselect">
				<?php
				echo $this->Form->select('category', $root_category,
					array(
						"name"  => "category",
						"class" => "category",
						"id"    => "",
						"value" => "",
						"empty" => "全てのカテゴリ"
				));
				?>
				</p>
				<ul>
					<li><input type="radio" name="type" value="tour" id="headersearch_tour" checked="checked"><label for="headersearch_tour">ツアー</label></li>
					<li><input type="radio" name="type" value="spot" id="headersearch_spot"><label for="headersearch_spot">スポット</label></li>
				</ul>
				<p class="keyword"><input type="text" class="text" name="keyword" value="" /></p>
				<p class="submit mouse_over"><input type="submit" class="submitbtn" value="検索" /></p>
			</form>
		</dd>
	</dl>
	<!-- //search -->
	<?php if ($user_info = $this->Session->read("user_info")): ?>
	<p class="login"><a href="<?php echo $this->Html->url("/logout");?>" class="mouse_over"><img src="<?php echo $this->Html->url("/img/common/header/logout.gif"); ?>" alt="ログアウト" /></a></p>
	<p class="username">ようこそ　<span><em><?php echo $user_info["User"]["name"];?></em>さん</span></p>
	<?php else: ?>
	<p class="login"><a href="#login" class="loginbtn mouse_over" data-redirect=""><img src="<?php echo $this->Html->url("/img/common/header/login.gif"); ?>" alt="ログインはこちら" /></a></p>
	<?php endif; ?>
	
</header>
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
