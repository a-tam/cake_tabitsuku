<?php
$this->assign("body_id", "spot");
$this->assign("body_class", "sec");

$this->start("page_css");
$__css[] = $this->Html->css("modules/tour");
echo implode("\n", $__css);
$this->end();

$this->start("page_script");
$__script[] = $this->Html->script("https://maps.googleapis.com/maps/api/js?sensor=true");
$__script[] = $this->Html->script("tour");
$__script[] = $this->Html->script("apps/guest/tour/show");
echo implode("\n", $__script);
$this->end();
?>

<?php echo $this->element("globalnavi"); ?>

<!-- =============== ↓ページコンテンツ↓ =============== -->
<div class="contents">

	<ul id="breadcrumbs">
		<li><a href="../">トップページ</a></li>
		<li><?php echo $this->request["name"];?></li>
	</ul>


	<div id="map_area">
		<div id="map"></div>
		<div id="route_distance"></div>
		<div>
		<?php if ($this->Session->read("user_info")): ?>
			<?php if ($this->request["fb_event_permission"] == true): ?>
			<form id="pg_fb_event_add">
				<input type="hidden" name="tour_id" value="<?php echo $this->request["id"];?>">
				<ul>
					<li>
						<label>イベント名</label>
						<input type="text" name="name" value="<?php echo $this->request["name"];?>" required="required" />
					</li>
					<li>
						<label>イベント詳細</label>
						<textarea name="description" cols="50" rows="4" required="required"><?php echo $this->request["description"];?></textarea>
					</li>
					<li>
						<label>開始日時</label>
						<input type="date" name="start_time" required="required" min="<?php echo date("Y-m-d");?>" />
					</li>
					<li>
						<label>終了日時</label>
						<input type="date" name="end_time" min="<?php echo date("Y-m-d");?>" />
					</li>
					<li>
						<label>プライバシー</label>
						<label><input type="radio" name="privacy" value="open" checked="checked">公開</label>
						<label><input type="radio" name="privacy" value="friends">友達</label>
						<label><input type="radio" name="privacy" value="secret">自分のみ</label>
					</li>
				</ul>
				<input type="submit" value="登録" id="pg_fb_event_submit" />
			</form>
			<div id="pg_fb_event_result"></div>
			<?php else:?>
				<a href="<?php echo $this->request["fb_permission_url"];?>">Facebookのイベント投稿を許可</a>
			<?php endif;?>
		<?php endif;?>
		</div>
	</div>
	<!-- //maparea -->
	
	<div id="detail_area">
		<p class="photo">
			<?php if ($this->request["image"]) :
				foreach($this->request["routes"] as $ruote) {
					if ($ruote["id"] == $this->request["image"]) {
						print '<img src="'.$this->html->url("uploads/spot/middle/".$ruote["image"]["file_name"]).'" alt="" width="265" height="199" />';
						break;
					}
				}
			else: ?>
			<img src="<?php echo $this->html->url("/img/common/noimage.jpg"); ?>" alt="<?php echo $this->request["name"];?>" width="265" height="199" />
			<?php endif;?>
		</p>
		<div class="info">
			<h2><?php echo $this->request["name"];?></h2>
			
			<div class="subinfo">
				<dl>
					<dt><img src="<?php echo $this->html->url("/img/common/icon/name.gif"); ?>" alt="作成者" /></dt>
					<dd>田中一郎</dd>
				</dl>
				<dl>
					<dt><img src="<?php echo $this->html->url("/img/common/icon/departure.gif"); ?>" alt="出発地" /></dt>
					<dd>東京駅</dd>
				</dl>
				<dl>
					<dt><img src="<?php echo $this->html->url("/img/common/icon/time.gif"); ?>" alt="時間" /></dt>
					<dd><?php echo $this->request["stay_time"];?>分</dd>
				</dl>
				<dl class="category">
					<dt><img src="<?php echo $this->html->url("/img/common/icon/category_l.gif"); ?>" alt="CATEGORY" /></dt>
					<dd>
						<ul>
<?php
if ($this->request["category"]) :
	foreach($this->request["category"] as $category_path) :
		$category_names = array();
		preg_match_all("/\d+/", $category_path, $cateogry);
		$tree = array();
		foreach ($cateogry[0] as $key) :
			$tree[] = $this->request["category_names"][$key];
		endforeach;
?>
							<li><a href=""><?php echo implode(" > ", $tree);?></a></li>
<?php endforeach;
endif;
?>
						</ul>
					</dd>
				</dl>
				<dl class="tag">
					<dt><img src="<?php echo $this->html->url("/img/common/icon/tag_l.gif"); ?>" alt="タグ" /></dt>
					<dd>
						<ul>
<?php
if ($this->request["tag_names"]) :
foreach($this->request["tag_names"] as $tag_key => $tag):?>
							<li><a href=""><?php echo $tag;?></a></li>
<?php endforeach;
endif;
?>
						</ul>
					</dd>
				</dl>
			</div>
			<!-- //subinfo -->
			
		</div>
		<!-- //info -->
		
		<dl class="comment">
			<dt><img src="<?php echo $this->html->url("/img/common/icon/note.gif"); ?>" alt="説明" /></dt>
			<dd><?php echo $this->request["description"]?></dd>
		</dl>

		<div class="fb-like" data-href="<?php echo $this->html->url("tour/show/".$this->request["id"]);?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></div>
		
		<p class="edit">
			<?php if ($this->Session->read("user_info")):?>
			<a href="<?php echo $this->html->url("user/tour/form/".$this->request["id"]);?>" class="selectbtn mouse_over">編集する</a>
			<?php endif;?>
		</p>
		
	</div>
	<!-- //detail_area -->


	<div id="route_area">
		<h3><?php echo $this->request["name"];?><img src="<?php echo $this->html->url("/img/tour/route.gif"); ?>" alt="の行程" /><span>&nbsp;</span></h3>
	
		<div class="routes">
		<?php
		if ($this->request["routes"]) :
			$time = strtotime($this->request["start_time"]);
			foreach($this->request["routes"] as $ruote) :
				$time += $ruote["stay_time"] * 60;
				if ($ruote["id"] == 0): ?>
			<div class="item memo">
				<p class="time"><?php echo date("H:i", $time);?><span class="line">&nbsp;</span></p>
				<dl>
				<dt>メモ</dt>
				<dd><?php echo $ruote["info"]; ?></dd>
				</dl>
			</div>
			<!-- //item --><?php
				else:?>
			<div class="item spot pg_spot" data-spot-id="<?php echo $ruote["id"]?>" data-lat="<?php echo $ruote["lat"];?>" data-lng="<?php echo $ruote["lng"];?>" >
				<p class="time"><?php echo date("H:i", $time);?><span class="line">&nbsp;</span></p>
				<div class="photo_area">
					<p class="photo">
						<?php if ($ruote["image"]) :?>
							<img src="<?php echo $this->html->url("uploads/spot/thumb/".$ruote["image"]["file_name"]);?>" width="98" height="74" alt="" />
						<?php else:?>
							<img src="<?php echo $this->html->url("/img/common/noimage.jpg"); ?>" alt="スポット名スポット名スポット名" width="98" height="74" />
						<?php endif;?>
					</p>
					<div class="fb-like" data-href="<?php echo $this->html->url("spot/show/".$ruote["id"]);?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></div>
				</div>
				<!-- //photo_area -->
				<div class="info_area">
					<dl class="name">
						<dt><img src="<?php echo $this->html->url("/img/tour/name.gif"); ?>" alt="名称" /></dt>
						<dd><?php echo $ruote["name"]?></dd>
					</dl>
					<dl class="stay">
						<dt><img src="<?php echo $this->html->url("/img/tour/staytime.gif"); ?>" alt="滞在時間" /></dt>
						<dd><?php echo $ruote["defalut_time"];?></dd>
					</dl>
					<dl class="memo">
						<dt><img src="<?php echo $this->html->url("/img/tour/memo.gif"); ?>" alt="一言メモ" /></dt>
						<dd><?php echo $ruote["description"]; ?></dd>
					</dl>
					<p class="linkbtn"><a href="<?php echo $this->html->url("spot/show/".$ruote["id"]);?>" class="mouse_over">スポット詳細をみる</a></p>
					
				</div>
				<!-- //info_area -->
				
			</div>
			<!-- //item -->
			<?php endif;?>
		<?php endforeach;?>
	<?php endif;?>
			
		</div>
		<!-- //routes -->
		
			<p class="copy">
				<a href="<?php echo $this->html->url("user/tour/copy/".$this->request["id"]); ?>" class="selectbtn mouse_over pg_copy">コピーしてツアーを作る</a>
				<a href="<?php echo $this->html->url("user/tour/delete/".$this->request["id"]);?>" class="selectbtn mouse_over pg_delete">削除する</a>
			</p>
		
	</div>
	<!-- //route_area -->

	<?php $this->element("guest/search_box", array("mode" => 1));?>

</div>
<!-- //contents -->
<!-- =============== ↑ページコンテンツ↑ =============== -->
