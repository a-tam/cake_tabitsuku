<?php
$this->assign("body_id", "spot");
$this->assign("body_class", "sec");

$this->start("page_css");
$__css[] = $this->Html->css("modules/spotentry");
echo implode("\n", $__css);
$this->end();

?>

<?php echo $this->element("globalnavi"); ?>

<!-- =============== ↓ページコンテンツ↓ =============== -->
<div class="contents">

	<ul id="breadcrumbs">
		<li><a href="../">トップページ</a></li>
		<li>ユーザー本人確認</li>
	</ul>
	
	<div class="container">
		<div class="login form">
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->Form->create('User', array("type" => "post")); ?>
				ユーザーの本人確認を行います。登録時のパスワードを入力してください。<br />
				<?php echo $this->Form->input('password', Array('label' => false)); ?>
			<?php echo $this->Form->end('ログイン'); ?>
		</div>
	</div>
	<!-- //container -->

</div>
<!-- //contents -->
<!-- =============== ↑ページコンテンツ↑ =============== -->