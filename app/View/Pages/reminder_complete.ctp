<?php
// body id
$this->assign("body_id", "about");
$this->assign("body_class", "sec subpage");

// page_css
$this->start("page_css");
$__css[] = $this->Html->css("modules/user");
echo implode("\n", $__css);
$this->end();

?>

<?php echo $this->element("globalnavi"); ?>

<!-- =============== ↓ページコンテンツ↓ =============== -->
<div class="contents">

	<ul id="breadcrumbs">
		<li><a href="../">トップページ</a></li>
		<li>パスワードリマインダー</li>
	</ul>
	
	<div class="container">
		<div class="main">
		
			<h2>パスワードリマインダー</h2>
			パスワード再設定用のメールを送信しました。URLをクリックして、パスワードを再設定してください。
		</div>
		<!-- //main -->
		
		<?php echo $this->element("site_side"); ?>
		
	</div>
	<!-- //container -->

</div>
<!-- //contents -->
<!-- =============== ↑ページコンテンツ↑ =============== -->
