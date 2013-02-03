<?php
$this->assign("body_id", "spot");
if ($this->request["mode"] && $this->request["mode"] == "direct") {
	$this->assign("body_class", "sec spotdirect");
} else {
	$this->assign("body_class", "sec");
}

$this->start("page_css");
$__css[] = $this->Html->css("modules/spot");
echo implode("\n", $__css);
$this->end();

$this->start("page_script");
$__script[] = $this->Html->script("https://maps.googleapis.com/maps/api/js?sensor=true");
$__script[] = $this->Html->script("apps/guest/spot/show");
$__script[] = $this->Html->script("jquery/layout/trunk8");
echo implode("\n", $__script);
$this->end();

?>
<?php echo $this->element("globalnavi"); ?>

<!-- =============== ↓ページコンテンツ↓ =============== -->
<div class="contents">

	<ul id="breadcrumbs">
		<li><a href="../">トップページ</a></li>
		<li><?php echo $spot["Spot"]["name"];?></li>
	</ul>


	<div id="map_area">
		<div id="map"></div>
	</div>
	<!-- //maparea -->
	
	<div id="detail_area" data-id="<?php echo $spot["Spot"]["id"];?>" data-lat="<?php echo $spot["Spot"]["lat"];?>" data-lng="<?php echo $spot["Spot"]["lng"];?>" data-zoom="<?php echo $spot["Spot"]["zoom"];?>" >
		<p class="photo">
			<?php if ($spot["Spot"]["image"]) :?>
				<img src="<?php echo $this->html->url("uploads/spot/middle/".$spot["Spot"]["image"]["file_name"]);?>" alt="<?php echo $spot["Spot"]["name"];?>" width="265" height="199" />
			<?php else :?>
				<img src="<?php echo $this->html->url("/img/common/noimage.jpg"); ?>" alt="<?php echo $spot["Spot"]["name"];?>" width="265" height="199" />
			<?php endif;?>
		</p>
		<div class="info">
			<h2><?php echo $spot["Spot"]["name"];?></h2>
			
			<div class="subinfo">
				<dl>
					<dt><img src="<?php echo $this->html->url("/img/common/icon/name.gif"); ?>" alt="作成者" /></dt>
					<dd class="pg_owner"><?php echo $spot["User"]["name"];?></dd>
				</dl>
				<dl>
					<dt><img src="<?php echo $this->html->url("/img/common/icon/location.gif"); ?>" alt="場所" /></dt>
					<dd class="pg_prefecture"><?php echo $spot["Spot"]["prefecture"];?></dd>
				</dl>
				<dl>
					<dt><img src="<?php echo $this->html->url("/img/common/icon/time.gif"); ?>" alt="時間" /></dt>
					<dd class="pg_stay_time"><?php echo $spot["Spot"]["stay_time"];?>分</dd>
				</dl>
				<dl class="category">
					<dt><img src="<?php echo $this->html->url("/img/common/icon/category_l.gif"); ?>" alt="CATEGORY" /></dt>
					<dd>
						<ul>
<?php
if ($spot["Spot"]["category"]):
	foreach($spot["Spot"]["category"] as $tree):
		preg_match_all("/\d+/", $tree, $category);
		$tree = array();
		foreach($category[0] as $category_id) {
			$tree[] = $spot["Spot"]["category_names"][$category_id];
		}
	?>
					<li><a href=""><?php echo implode(" > ", $tree);?></a></li>
	<?php endforeach;
endif;?>
						</ul>
					</dd>
				</dl>
				<dl class="tag">
					<dt><img src="<?php echo $this->html->url("/img/common/icon/tag_l.gif"); ?>" alt="タグ" /></dt>
					<dd>
						<ul>
<?php
if ($spot["Tag"]):
foreach($spot["Tag"] as $tag):?>
							<li><a href=""><?php echo $tag["name"];?></a></li>
<?php
endforeach;
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
			<dt><img src="<?php echo $this->html->url("/img/common/icon/memo.gif"); ?>" alt="一言メモ" /></dt>
			<dd><?php echo $spot["Spot"]["description"];?></dd>
		</dl>

		<div class="fb-like" data-href="<?php echo $this->html->url("spot/show/".$spot["Spot"]["id"]);?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></div>
		
		<p class="edit">
		<?php $user_info = $this->Session->read("user_info"); ?>
		<?php if ($user_info && ($user_info["User"]["id"] == $spot["User"]["id"])):?>
			<a href="<?php echo $this->html->url("/spots/form/".$spot["Spot"]["id"]);?>" class="selectbtn mouse_over pg_edit">編集する</a>
			<a href="<?php echo $this->html->url("/spots/delete/".$spot["Spot"]["id"]);?>" class="selectbtn mouse_over pg_delete">削除する</a>
		<?php endif;?>
		</p>
		
	</div>
	<!-- //detail_area -->


	<section class="othertour">
		<h3><img src="<?php echo $this->html->url("/img/spot/tour.gif"); ?>" alt="このスポットが含まれるツアー" /></h3>
		<div class="list_area">
			<div class="list_item pg_temp" style="display:none;">
				<p class="icon"><img src="<?php echo $this->html->url("/img/common/icon/spot.png"); ?>" alt="スポット" /></p>
				
				<div class="photo_area">
					<p><a href="./" class="pg_detail">
						<img src="<?php echo $this->html->url("/img/common/noimage.jpg"); ?>" width="137" height="104" alt="" />
					</a></p>
					<div class="pg_like_count" data-href="" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></div>
					<dl class="category pg_category">
						<dt><img src="<?php echo $this->html->url("/img/common/icon/category.gif"); ?>" alt="CATEGORY" /></dt>
						<dd>
							<ul class="category_icon">
								<li><a href="" title="見る"><img src="<?php echo $this->html->url("/img/common/icon/site.gif"); ?>" alt="見る" /></a></li>
								<li><a href="" title="遊ぶ"><img src="<?php echo $this->html->url("/img/common/icon/enjoy.gif"); ?>" alt="遊ぶ" /></a></li>
								<li><a href="" title="食べる"><img src="<?php echo $this->html->url("/img/common/icon/food.gif"); ?>" alt="食べる" /></a></li>
								<li><a href="" title="宿泊・温泉"><img src="<?php echo $this->html->url("/img/common/icon/stay.gif"); ?>" alt="宿泊・温泉" /></a></li>
								<li><a href="" title="乗り物/乗り場"><img src="<?php echo $this->html->url("/img/common/icon/transport.gif"); ?>" alt="乗り物/乗り場" /></a></li>
								<li><a href="" title="買う"><img src="<?php echo $this->html->url("/img/common/icon/shopping.gif"); ?>" alt="買う" /></a></li>
							</ul>
						</dd>
					</dl>
				</div>
				<!-- //photo_area -->
	
				<div class="info_area">
					<dl class="maininfo">
						<dt class="pg_name">スポット名</dt>
						<dd class="pg_description">当店のメニューは、素材の持ち味を最大限引き出すことを重んじたランチ、ディナーとも「おまかせの１コース」のみ。旬の素材により、メニュー・・・</dd>
					</dl>
					<!-- //maininfo -->
					
					<div class="subinfo">
						<dl>
							<dt><img src="<?php echo $this->html->url("/img/common/icon/name.gif"); ?>" alt="作成者" /></dt>
							<dd class="pg_owner">--</dd>
						</dl>
						<dl>
							<dt><img src="<?php echo $this->html->url("/img/common/icon/location.gif"); ?>" alt="場所" /></dt>
							<dd class="pg_prefecture">--</dd>
						</dl>
						<dl>
							<dt><img src="<?php echo $this->html->url("/img/common/icon/time.gif"); ?>" alt="時間" /></dt>
							<dd class="pg_stay_time">30分</dd>
						</dl>
					</div>
					<!-- //subinfo -->
	
					<p class="linkbtn"><a href="../tour/" class="mouse_over pg_detail">スポット詳細を見る</a></p>
	
				</div>
				<!-- //info_area -->
				
			</div>
			<!-- //list_item -->
		
	
		</div>
		<!-- //list_area -->
	</section>
	<!-- //othertour -->
	
</div>
<!-- //contents -->
<!-- =============== ↑ページコンテンツ↑ =============== -->

