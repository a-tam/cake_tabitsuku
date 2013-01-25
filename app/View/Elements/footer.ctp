<footer>
	<nav>
		<ul>
			<li><a href="<?php echo $this->Html->url("/site/about"); ?>">このサイトについて</a></li>
			<li><a href="<?php echo $this->Html->url("/site/howto"); ?>">たびつくの使い方</a></li>
			<li><a href="<?php echo $this->Html->url("/site/contact"); ?>">お問い合わせ</a></li>
			<li><a href="<?php echo $this->Html->url("/site/rule"); ?>">利用規約</a></li>
		</ul>
	</nav>
</footer>

<div id="loginArea">
	<p class="cover"></p>
	<iframe src="<?php echo $this->Html->url("/login_form"); ?>" width="780" height="300" allowtransparency="true"></iframe>
</div>
<!-- //loginArea -->
