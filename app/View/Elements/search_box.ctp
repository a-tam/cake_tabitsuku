<?php if (!isset($mode)) { $mode = 0; }?>
		<div class="search_box<?php if ($mode == "1"): ?> search_box_l<?php endif;?>">
			<form action="<?php echo $this->Html->url("spot/search");?>" method="post">
				<div class="search_setting">
					<p class="setting-title"><img src="<?php
					if ($mode == "1"): echo $this->Html->url("/img/common/search/title_l.gif");
					 else: echo $this->Html->url("/img/common/search/title.gif");
					 endif;?>" alt="検索設定" /></p>
					<dl class="keyword">
						<dt><img src="<?php echo $this->Html->url("/img/common/search/keyword.gif");?>" alt="キーワード" /></dt>
						<dd><input type="text" class="text" name="keyword" id="pg_search_keyword" value="<?php echo $this->request["keyword"];?>" />
							<p>
							<select name="order" id="pg_search_order">
								<option value="created_time"<?php if($this->request["order"] == "created_time"):?> selected="selected"<?php endif;?>>新着順</option>
								<option value="like_count"<?php if($this->request["order"] == "like_count"):?> selected="selected"<?php endif;?>>人気順</option>
								<option value="name"<?php if($this->request["order"] == "name"):?> selected="selected"<?php endif;?>>名前順</option>
							</select>
							<select name="page_number" id="pg_search_page_number">
								<option value="10"<?php if($this->request["page_number"] == 10):?> selected="selected"<?php endif;?>>10</option>
								<option value="25"<?php if($this->request["page_number"] == 25):?> selected="selected"<?php endif;?>>25</option>
								<option value="50"<?php if($this->request["page_number"] == 50):?> selected="selected"<?php endif;?>>50</option>
								<option value="100"<?php if($this->request["page_number"] == 100):?> selected="selected"<?php endif;?>>100</option>
							</select>
							</p>
						</dd>
					</dl>
					<!-- //keyword -->
					<dl class="category">
						<dt><img src="<?php echo $this->Html->url("/img/common/search/category.gif");?>" alt="カテゴリ" /></dt>
						<dd>
							<p class="selectbtn"><a href="#categoryselect" class="selectbtn mouse_over">検索カテゴリを選択</a></p>
							<!--<p class="selectedCategory"><a href="#close" class="close mouse_over"><img src="<?php echo $this->Html->url("/img/common/search/close.gif");?>" alt="CLOSE" /></a>見る</p>-->
							<div class="categoryselect">
								<ul>
<?php
$root_categories = array();
$selected_category = $this->request["category"];
foreach($root_category as $category_id => $category_name):?>
									<li><a data-category-id="<?php echo $category_id;?>" href=""><?php echo $category_name;?></a></li>
<?php endforeach;?>
								</ul>
								<p class="close"><a href="#close" class="mouse_over"><img src="<?php echo $this->Html->url("/img/common/search/close.png");?>" alt="CLSOE" /></a></p>
								<p class="tri">&nbsp;</p>
							</div>
							<!-- //categoryselect -->
<?php
if ($selected_category) :
	preg_match_all("/\d+/", $selected_category, $selected_cateogry_path);
	$category_names = array();
	foreach($selected_cateogry_path[0] as $selected_cateogry_path_id) {
		$category_names[] = $root_categories[$selected_cateogry_path_id];
	}
?>
							<p class="selectedCategory"><a href="#close" class="close mouse_over">&nbsp;</a><?php echo implode(":", $category_names);?></p>
							<input type="hidden" name="category" value="<?php echo $this->request["category"];?>">
<?php endif;?>
						</dd>
					</dl>
					<!-- //category -->
					<?php if ($mode == 1):?>
					<dl class="type">
						<dt><img src="<?php echo $this->Html->url("/img/common/search/type.gif");?>" alt="タイプ" /></dt>
						<dd>
							<ul>
								<li><input type="radio" name="type" value="tour" checked="checked" /><label for="searchbox-tour">ツアー</label></li>
								<li><input type="radio" name="type" value="spot" /><label for="searchbox-spot">スポット</label></li>
							</ul>
						</dd>
					</dl>
					<?php endif;?>
					<!-- //type -->
				</div>
				<!-- //search_setting -->
				<dl class="search-btn">
					<dt><img src="<?php
					if ($mode == "1"): echo $this->Html->url("/img/common/search/search_l.gif");
					else: echo $this->Html->url("/img/common/search/search.gif");
					endif;?>" alt="検索" /></dt>
					<dd>
						<ul>
							<li class="list_search mouse_over"><input type="submit" class="submitbtn pg_search_map_btn" value="一覧で探す" /></li>
						</ul>
<?php if ($user_info = $this->session->read("user_info")): ?>
							<input type="checkbox" name="owner" id="pg_search_owner" value="mydata"<?php if($this->request["owner"] == "mydata"):?> checked="checked"<?php endif;?> /><label for="pg_search_owner">自分で登録したデータ</label><br />
<?php endif;?>
<?php if ($mode != "1"): ?>
							<input type="checkbox" name="map_select" id="pg_search_map_select" value="1"<?php if ($this->request["map_select"] == "1"):?> checked="checked"<?php endif;?> /><label for="pg_search_map_select">範囲内検索</label>
<?php endif;?>
					</dd>
				</dl>
			</form>
		</div>
		<!-- //search_box -->