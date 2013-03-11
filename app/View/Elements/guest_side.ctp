			<dl class="taglist group">
				<dt><img src="<?php echo $this->Html->url("/img/common/side/taglist.gif"); ?>" alt="タグリスト" /></dt>
				<dd>
					<ul>
					<?php foreach($ranking["tag"] as $tag) :?>
						<li><a href=""><em><?php echo h($tag["name"]);?></em></a><p><span><?php echo h($tag["count"]);?></span></p></li>
					<?php endforeach; ?>
					</ul>
				</dd>
			</dl>
			<!-- //taglist -->
	
			<dl class="category group">
				<dt><img src="<?php echo $this->Html->url("/img/common/side/category.gif"); ?>" alt="カテゴリ" /></dt>
				<dd>
					<ul>
					<?php foreach($ranking["category"] as $category) :?>
						<li><a href=""><em><?php echo h($category["name"]);?></em></a><p><span><?php echo h($category["count"]);?></span></p></li>
					<?php endforeach; ?>
					</ul>
				</dd>
			</dl>
			<!-- //category -->
			
			<dl class="rank" id="tourranking">
				<dt><img src="<?php echo $this->Html->url("/img/common/side/tourranking.gif"); ?>" alt="ツアーランキング" /></dt>
				<dd>
					<ul>
					<?php foreach($ranking["tour"] as $key => $tour) :?>
						<li class="rank<?php echo $key+1;?>"><a href="/tours/show/<?php echo $tour["tour_id"];?>"><?php echo h($tour["name"]);?></a></li>
					<?php endforeach;?>
					</ul>
				</dd>
			</dl>
			<!-- //tourranking -->
	
			<dl class="rank" id="spotranking">
				<dt><img src="<?php echo $this->Html->url("/img/common/side/spotranking.gif"); ?>" alt="スポットランキング" /></dt>
				<dd>
					<ul>
						<?php foreach($ranking["spot"] as $key => $tour) :?>
							<li class="rank<?php echo $key+1;?>"><a href="/spots/show/<?php echo $tour["spot_id"];?>"><?php echo h($tour["name"]);?></a></li>
						<?php endforeach;?>
					</ul>
				</dd>
			</dl>
			<!-- //spotranking -->
			
