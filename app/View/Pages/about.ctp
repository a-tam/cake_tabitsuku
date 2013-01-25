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
		<li>このサイトについて</li>
	</ul>
	

	<div class="container">
		<div class="main">
		
			<h2><img src="<?php echo $this->Html->url("/img/about/title.gif"); ?>" alt="このサイトについて" /></h2>
		
		
			<h3>見出しが入ります。</h3>
			
			<p>テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト</p>
			<p>テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト</p>
			<p>テキストテキストテキストテキストテキストテキストテキストテキストテキスト</p>
			<p>テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト</p>
			<p>テキストテキストテキストテキストテキストテキストテキストテキストテキスト</p>


		</div>
		<!-- //main -->
		
		<?php echo $this->element("site_side"); ?>
		
	</div>
	<!-- //container -->

	<?php echo $this->element("search_box", array("mode" => 1)); ?>
	
</div>
<!-- //contents -->
<!-- =============== ↑ページコンテンツ↑ =============== -->