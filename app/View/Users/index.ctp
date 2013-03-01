<?php
$this->assign("body_id", "user");
$this->assign("body_class", "sec tour");

$this->start("page_css");
$__css[] = $this->Html->css("modules/user");
echo implode("\n", $__css);
$this->end();

$this->start("page_script");
$this->end();

?>

<?php echo $this->element("globalnavi"); ?>
<!-- =============== ↓ページコンテンツ↓ =============== -->
<div class="contents">

	<ul id="breadcrumbs">
		<li><a href="../">トップページ</a></li>
		<li>マイページ</li>
	</ul>
	
	<div class="container">
		<div class="main">
			<section>
			<h3>ユーザー情報変更</h3>
			<?php echo $this->Form->create("User"); ?>
			<?php echo $this->Form->input("name");?>
			<?php echo $this->Form->input("password", array(""));?>
			<?php echo $this->Form->input("confirm_password", array("type" => "password"));?>
			<?php echo $this->Form->input("email");?>
			<?php echo $this->Form->input("privacy", array("type" => "radio", "options" => array(0 => "無効", 1 => "有効")));?>
			<?php echo $this->Form->end("送信");?>
			</section>
			<section>
			<h3>外部連携</h3>
			<?php echo $this->Form->create("User", array("action" => "facebook", "type" => "post", "id" => "facebook")); ?>
			<?php echo $this->request->data["User"]["social_facebook"];?>
			<?php if ($this->request->data["User"]["social_facebook"]):
				echo $this->Form->button("Facebook 解除", array('name' => 'action', 'value' => 'disconnect', "id" => "disconnect"));
			else:
				echo $this->Form->button("Facebook 登録", array('name' => 'action', 'value' => 'connect', "id" => "connect"));
			endif;?>
			<?php echo $this->Form->end();?>
			</section>
		</div>
		<!-- //main -->
		
		<div class="side">
		
			<?php echo $this->element("guest_side"); ?>
					
		</div>
		<!-- //side -->

	</div>
	<!-- //container -->

</div>
<!-- //contents -->
<!-- =============== ↑ページコンテンツ↑ =============== -->