<?php
$this->assign("body_id", "spotentry");
$this->assign("body_class", "sec tour");

$this->start("page_css");
$__css[] = $this->Html->css("modules/spotentry");
$__css[] = $this->Html->css("/js/jquery/autocomplete/css/jquery.tagit");
$__css[] = $this->Html->css("/js/jquery/timepicker/jquery.timepicker");
echo implode("\n", $__css);
$this->end();

$this->start("page_script");
$__script[] = $this->Html->script("https://maps.googleapis.com/maps/api/js?sensor=true&libraries=places");
$__script[] = $this->Html->script("jquery/autocomplete/tag-it");
$__script[] = $this->Html->script("apps/user/spot/form");
$__script[] = $this->Html->script("jquery/timepicker/jquery.timepicker");
echo implode("\n", $__script);
$this->end();

?>

<?php echo $this->element("globalnavi"); ?>

<?php if ($this->Session->flash("saved")):?><div class="pg_notification">[ <?php echo $this->Session->flash("saved");?> ] を保存しました。</div><?php endif;?>

<!-- =============== ↓ページコンテンツ↓ =============== -->
<div class="contents">

	<ul id="breadcrumbs">
		<li><a href="<?php echo $this->html->url("/");?>">トップページ</a></li>
		<li><a href="<?php echo $this->html->url("/user/top");?>">マイページ</a></li>
		<li><?php if ($this->request["id"]):?>スポット更新<?php else:?>スポット登録<?php endif;?></li>
	</ul>
	
	<div id="map_area">
		<p id="mapsearch" class="mouse_over">
			<input type="text" class="text" id="search-address" />
			<input type="image" class="btn" id="search-map" src="<?php echo $this->html->url("/img/common/header/searchbtn.gif"); ?>" alt="検索" />
		</p>
		<div id="map"></div>
		<p class="around_spot_message">周辺に <span class="pg_around_number">0</span> 件のスポットが登録されています。<br />既に登録されていないか確認してください。</p><br />
	</div>
	<!-- //maparea -->
	<div id="input_area">
		<h2><img src="<?php echo $this->html->url("/img/user/spot/title.gif"); ?>" alt="スポット登録：基本情報入力" /></h2>
		<?php echo $this->Form->create("Spots", array("type" => "file", "class" => "input_form", "id" => "spot-form"));?>
		<form class="input_form" action="<?php echo $this->html->url("user/spot/add");?>" enctype="multipart/form-data" method="post" id="spot-form">
			<?php echo $this->Form->hidden("id", array("id" => "spot-id"));?>
			<input type="hidden" name="zoom" id="spot-zoom" value="<?php echo $this->request["zoom"];?>" />
			<input type="hidden" name="prefecture" id="spot-prefecture" value="<?php echo $this->request["prefecture"];?>" />
			<dl class="name">
				<dt><img src="<?php echo $this->html->url("/img/user/spot/name.gif"); ?>" alt="名称" /></dt>
				<dd><input type="text" name="name" id="spot-name" class="text" value="<?php echo $this->request["name"];?>" /></dd>
			</dl>
			<dl class="description">
				<dt><img src="<?php echo $this->html->url("/img/user/spot/description.gif"); ?>" alt="説明" /></dt>
				<dd><textarea name="description" id="spot-description" class="textarea"><?php echo $this->request["description"];?></textarea></dd>
			</dl>
			<dl class="location">
				<dt><img src="<?php echo $this->html->url("/img/user/spot/location.gif"); ?>" alt="場所" /></dt>
				<dd><input type="text" name="address" class="text" id="spot-address" value="<?php echo $this->request["address"];?>" readonly="readonly" /></dd>
			</dl>
			<dl class="latlng">
				<dt><img src="<?php echo $this->html->url("/img/user/spot/latlng.gif"); ?>" alt="緯度・経度" /></dt>
				<dd><ul>
					<li>緯度<input type="text" name="lat" class="text" id="spot-lat" value="<?php echo $this->request["lat"];?>" readonly="readonly" /></li>
					<li>経度<input type="text" name="lng" class="text" id="spot-lng" value="<?php echo $this->request["lng"];?>" readonly="readonly" /></li>
				</ul></dd>
			</dl>
			<dl class="stay_time">
				<dt>滞在時間</dt>
				<dd>
					<select name="stay_time" class="text">
<?php for($t=0; $t<24*4; $t++):?>
						<option value="<?php echo $t*15;?>"<?php if ($t * 15 == $this->request["stay_time"]):?> selected="selected"<?php endif;?>"><?php echo sprintf("%1$02s:%2$02s", floor($t * 15 / 60), floor(($t % 4) * 15));?></option>
<?php endfor;?>
					</select>
				</dd>
			</dl>
			<dl class="tag">
				<dt><img src="<?php echo $this->html->url("/img/user/spot/tag.gif"); ?>" alt="タグ" /></dt>
				<dd><ul id="tags">
				<?php if ($this->request["tags"]):?>
<?php foreach($this->request["tags"]["name"] as $tag):?>
						<li><?php echo $tag;?></li>
<?php endforeach;?>
<?php endif;?>
				</ul></dd>
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
			<dl class="pic">
				<dt><img src="<?php echo $this->html->url("/img/user/spot/pic.gif"); ?>" alt="画像" /></dt>
				<dd><input type="file" name="image" class="upload" />
<?php if ($this->request["image"]): ?>
<br />
	<?php if (isset($this->request["image"]["tmp"])):?>
		<a href="<?php echo $this->html->url("uploads/tmp/".$this->request["image"]["tmp"]["file_name"]);?>" target="_blank">ファイル</a>
	<?php else:?>
		<a href="<?php echo $this->html->url("uploads/spot/middle/".$this->request["image"]["file_name"]);?>" target="_blank">ファイル</a>
	<?php endif;?>
		<label><input type="checkbox" name="image_delete" value="1" />&nbsp;削除</label>
<?php endif;?>
				</dd>
			</dl>
			<p class="submit mouse_over">
			<input type="image" id="headerSaveArea" src="<?php echo $this->html->url("/img/user/spot/regist.gif"); ?>" alt="スポットを登録する" />
			</p>
			
			
		<?php $this->Form->end();?>
	</div>
	<!-- //input_area -->


</div>
<!-- //contents -->
<!-- =============== ↑ページコンテンツ↑ =============== -->