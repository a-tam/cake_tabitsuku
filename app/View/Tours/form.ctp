<?php
$this->assign("body_id", "tourentry");
$this->assign("body_class", "sec tour");

$this->start("page_css");
$__css[] = $this->Html->css("modules/tourentry");
$__css[] = $this->Html->css("/js/jquery/autocomplete/css/jquery.tagit");
$__css[] = $this->Html->css("/js/jquery/timepicker/jquery.timepicker");
echo implode("\n", $__css);
$this->end();

$this->start("page_script");
$__script[] = $this->Html->script("https://maps.googleapis.com/maps/api/js?sensor=true&libraries=places");
$__script[] = $this->Html->script("apps/user/tour/form");
$__script[] = $this->Html->script("jquery/autocomplete/tag-it");
$__script[] = $this->Html->script("jquery/timepicker/jquery.timepicker");
$__script[] = $this->Html->script("jquery/util/jquery.dateFormat-1.0");
echo implode("\n", $__script);
$this->end();
?>

<?php echo $this->element("globalnavi"); ?>

<!-- =============== ↓ページコンテンツ↓ =============== -->
<div class="contents">

	<ul id="breadcrumbs">
		<li><a href="../../">トップページ</a></li>
		<li><a href="../">マイページ</a></li>
		<li>ツアー登録</li>
	</ul>
	
	<p class="howto"><a href="" class="mouse_over"><img src="<?php echo $this->html->url("/img/user/tour/howto.gif"); ?>" alt="ツアーの作り方" /></a></p>
	
	<div id="basic_area">

		<h2><img src="<?php echo $this->html->url("/img/user/tour/title.gif"); ?>" alt="1：スポットを検索する" /></h2>

		<div id="map_area">
			<div id="mapsearch">
				<p class="search mouse_over"><input type="text" class="text" id="search-address" /><input type="submit" class="submitbtn" value="検索" /></p>
			</div>
			<div id="map"></div>
		</div>
		<!-- //maparea -->

		<div id="spot_search">

			<div class="search_box">
				<input type="hidden" id="limit" value="20" />

				<dl class="keyword">
					<dt><img src="<?php echo $this->html->url("/img/user/tour/keyword.gif"); ?>" alt="キーワード" /></dt>
					<dd><input type="text" class="text" name="keyword" id="keyword" /></dd>
				</dl>

				<dl class="category">
					<dt><img src="<?php echo $this->html->url("/img/user/tour/category.gif"); ?>" alt="カテゴリ" /></dt>
					<dd>
					<p class="selectbtn"><a href="#categoryselect" class="mouse_over">検索カテゴリを選択</a></p>
						<div class="categoryselect">
							<ul>
							<?php $category = $root_category;?>
							<?php foreach($category as $row):?>
								<li><a href="" data-category-id="<?php echo $row["id"];?>"><?php echo $row["name"];?></a></li>
							<?php endforeach;?>
							</ul>
							<p class="close"><a href="#close" class="mouse_over"><img src="<?php echo $this->html->url("/img/common/search/close.png"); ?>" alt="CLSOE" /></a></p>
							<p class="tri">&nbsp;</p>
						</div>
						<!-- //categoryselect -->
					</dd>
				</dl>

				<p class="userspot"><input type="checkbox" name="userspot" id="userspot" /><label for="userspot">登録したスポットから探す</label></p>
				<p class="search-btn mouse_over"><input type="submit" class="submitbtn" value="検索" /></p>

			</div>
			<!-- //search_input -->
			
		</div>
		<!-- //spot_search -->
		
	</div>
	<!-- //basic_area -->
	
	<div id="spot_select">
		<h2><img src="<?php echo $this->html->url("/img/user/tour/search_title.gif"); ?>" alt="2：スポットを検索して追加する" /></h2>
	
		<p class="attention"><img src="<?php echo $this->html->url("/img/user/tour/attention_routeadd.gif"); ?>" alt="スポットをドラッグしてルートに追加しよう" /></p>
		
		<div class="search_info">
			<p class="total">検索結果：<em><span id="search-count"></span>件</em>
				<select name="order" id="sort">
					<option value="like_count desc">表示順</option>
					<option value="like_count desc">人気順</option>
					<option value="name asc">スポット名</option>
				</select>
			</p>
			
			<div class="pager"></div>
			<!-- //pager -->
			
		</div>
		<!-- //search_info -->
		
		<div class="list_area">
			<?php echo $this->element("spot_item", array("route" => null));?>
		
		</div>
		<!-- //list_area -->
		<?php echo $this->element("memo_item", array("route" => null));?>
		
	</div>
	<!-- //spot_search -->

	<?php echo $this->Form->create("Tour", array("type" => "file", "class" => "input_form", "id" => "tour-form"));?>
	<div id="tour_make">
		<h2><img src="<?php echo $this->html->url("/img/user/tour/tourmaking.gif"); ?>" alt="3：ツアーを作る" /></h2>
		
		<p class="attention"><img src="<?php echo $this->html->url("/img/user/tour/attention_drag.gif"); ?>" alt="ここにスポットをドラッグしてツアーを作ろう" /></p>
		
		<p class="starttime">
			<label>開始時間</label>
			<?php echo $this->Form->input("start_time", array(
				"type"  => "text",
				"id"    => "start_time",
				"class" => "text",
				"label" => false,
				"size"  => 12)); ?>
		</p>
		
		
		<div class="list_area">
<?php if (isset($this->request->data["Route"])) :?>
	<?php foreach ($this->request->data["Route"] as $ruote) :?>
		<?php if ($ruote["spot_id"] == 0): ?>
			<?php echo $this->element("memo_item", array("route" => $ruote));?>
		<?php else:?>
			<?php echo $this->element("spot_item", array("route" => $ruote));?>
		<?php endif;?>
	<?php endforeach;?>
<?php endif;?>
		
		</div>
		<!-- //list_area -->
		
		<p class="timeline"><img src="<?php echo $this->html->url("/img/user/tour/timeline.gif"); ?>" id="pg_tour_center" alt="タイムラインを計算" /></p>
		<p class="totaltime">所要時間：<span id="pg_hour">2</span>時間<span id="pg_minutes">45</span>分</p>
		<p class="inputshowbtn selectbtn"><a href="#inputShow" class="mouse_over">ツアー情報を入力する</a></p>
		
	</div>
	<!-- //tour_make -->

	<div id="joint"></div>

	<div id="input_area">
		<p class="cover"></p>
		<div id="input_box">
			<h2><img src="<?php echo $this->html->url("/img/user/tour/input_title.gif"); ?>" alt="4：ツアー基本情報を入力する" /></h2>
				<?php echo $this->Form->hidden("id", array("id" => "tour-id"));?>
				<dl class="name">
					<dt><img src="<?php echo $this->html->url("/img/user/spot/name.gif"); ?>" alt="名称" /></dt>
					<dd><?php echo $this->Form->input("name", array(
						"id" => "tour-name",
						"class" => "text",
						"label" => false)); ?></dd>
				</dl>
				<dl class="description">
					<dt><img src="<?php echo $this->html->url("/img/user/spot/description.gif"); ?>" alt="説明" /></dt>
					<dd><?php echo $this->Form->textarea("description", array(
						"id" => "tour-description",
						"class" => "text",
						"label" => false)); ?></dd>
				</dl>
				<dl class="tag">
					<dt><img src="<?php echo $this->html->url("/img/user/spot/tag.gif"); ?>" alt="タグ" /></dt>
					<dd>
					<ul id="tags" class="inputRounnd">
<?php if ($this->request->data["Tag"]):?>
<?php foreach($this->request->data["Tag"] as $tag):?>
						<li><?php echo $tag["name"];?></li>
<?php endforeach;?>
<?php endif;?>
					</ul>
					</dd>
				</dl>
				<dl class="category">
					<dt><img src="<?php echo $this->html->url("/img/user/spot/category.gif"); ?>" alt="カテゴリ" /></dt>
					<dd>
						<ul class="categories">
<?php
$category = $root_category;
for($i = 0; $i < 3; $i++):?>
							<li class="category<?php echo $i+1;?>">
<?php
	$category_names = array();
	if ($this->request["category"][$i]):
		preg_match_all("/\d+/", $this->request["category"][$i], $cateogry);
		foreach ($cateogry[0] as $key) {
			$category_names[] = $this->request["category_names"][$key];
		}
?>
							<a href="#add" class="mouse_over category_add" style="display:none;"><img src="<?php echo $this->html->url("/img/user/spot/addbtn.gif"); ?>" alt="カテゴリを追加" /></a>
							<input type="hidden" name="category[]" value="<?php echo $this->request["category"][$i];?>" class="maincategory" />
							<p class="selectedCategory">
								<a href="#close" class="close mouse_over"><img src="<?php echo $this->html->url("/img/common/search/close.gif"); ?>" alt="CLOSE" /></a><?php echo implode(" : ", $category_names);?></p>
	<?php else:?>
								<a href="#add" class="mouse_over category_add"><img src="<?php echo $this->html->url("/img/user/spot/addbtn.gif"); ?>" alt="カテゴリを追加" /></a>
	<?php endif;?>
							</li>
<?php endfor;?>
						</ul>
						<div class="categoryselect">
							<ul>
<?php foreach($category as $row):?>
								<li data-category-id="<?php echo $row["id"];?>"><a href=""><?php echo $row["name"];?></a></li>
<?php endforeach;?>
							</ul>
							<select name="subcategory_input" class="text"></select>
							<p class="close"><a href="#close" class="mouse_over"><img src="<?php echo $this->html->url("/img/common/search/close.png"); ?>" alt="CLSOE" /></a></p>
							<p class="add"><a href="#add" class="mouse_over"><img src="<?php echo $this->html->url("/img/common/icon/add.gif"); ?>" alt="追加" /></a></p>
							<p class="tri">&nbsp;</p>
						</div>
						<!-- //categoryselect -->

					</dd>
				</dl>
				<p class="submit mouse_over"><input type="submit" id="save_button" value="ツアーを保存する" /></p>
				<p class="close"><a href="#close"><img src="<?php echo $this->html->url("/img/common/btn/close.png"); ?>" alt="close" /></a></p>
			
		</div>
		<?php echo $this->Form->end(); ?>
		<!-- //input_box -->

	</div>
	<!-- //input_area -->
	
</div>
<!-- //contents -->
<!-- =============== ↑ページコンテンツ↑ =============== -->
