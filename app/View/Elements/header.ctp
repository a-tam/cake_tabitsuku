<div id="fb-root"></div>
<script>
window.fbAsyncInit = function() {
// init the FB JS SDK
	FB.init({
		appId      : gFacebookAppId, // App ID from the App Dashboard
		channelUrl : '//<?php echo $_SERVER["SERVER_NAME"]; ?>/channel.php', // Channel File for x-domain communication
		status     : true, // check the login status upon init?
		cookie     : true, // set sessions cookies to allow your server to access the session?
		xfbml      : true  // parse XFBML tags on this page?
	});

	// like
	FB.Event.subscribe('edge.create', function(response) {
		var url = $.url(response);
		var path_info = url.attr("path").split("/");
		var fb_auth = FB.getAuthResponse();
		var data = {
				mode    : "plus",
				type    : path_info[1],
				fb_user : fb_auth.userID,
				id      : path_info[3]
			};
		$.ajax({
			url      : gBaseUrl + "pages/like",
			async    : false,
			data     : data,
			dataType : "json",
			type     : "post",
			success  : function(json) {
				console.log(json);
			},
			error    : function() {
				console.log(arguments);
			}
		});
	});

	// not like
	FB.Event.subscribe('edge.remove', function(response) {
		var url = $.url(response);
		var path_info = url.attr("path").split("/");
		var fb_auth = FB.getAuthResponse();
		var data = {
				mode    : "minus",
				type    : path_info[1],
				fb_user : fb_auth.userID,
				id      : path_info[3]
			};
		$.ajax({
			url      : gBaseUrl + "pages/like",
			async    : false,
			data     : data,
			dataType : "json",
			type     : "post",
			success  : function(json) {
				console.log(json);
			},
			error    : function() {
				console.log(arguments);
			}
		});
	});
};

// Load the SDK's source Asynchronously
// Note that the debug version is being actively developed and might
// contain some type checks that are overly strict.
// Please report such bugs using the bugs tool.
(function(d, debug){
var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
if (d.getElementById(id)) {return;}
js = d.createElement('script'); js.id = id; js.async = true;
js.src = "//connect.facebook.net/ja_JP/all" + (debug ? "/debug" : "") + ".js";
ref.parentNode.insertBefore(js, ref);
}(document, /*debug*/ false));
</script><!-- facebook -->

<header>
	<h1><a href="<?php echo $this->Html->url("/");?>"><img src="<?php echo $this->Html->url("/img/logo.gif"); ?>" alt="たびつく　自分だけの旅行プランを作ろう" /></a></h1>
	<dl class="search">
		<dt><img src="<?php echo $this->Html->url("/img/common/header/search.gif"); ?>" alt="ツアーやスポットを検索しよう" /></dt>
		<dd>
			<form method="post">
				<p class="categoryselect">
				<?php
				echo $this->Form->select('category', $root_category,
					array(
						"name"  => "category",
						"class" => "category",
						"id"    => "",
						"value" => "",
						"empty" => "全てのカテゴリ"
				));
				?>
				</p>
				<ul>
					<li><input type="radio" name="type" value="tour" id="headersearch_tour" checked="checked"><label for="headersearch_tour">ツアー</label></li>
					<li><input type="radio" name="type" value="spot" id="headersearch_spot"><label for="headersearch_spot">スポット</label></li>
				</ul>
				<p class="keyword"><input type="text" class="text" name="keyword" value="" /></p>
				<p class="submit mouse_over"><input type="submit" class="submitbtn" value="検索" /></p>
			</form>
		</dd>
	</dl>
	<!-- //search -->
	<?php if ($user_info = $this->Session->read("user_info")): ?>
	<p class="login"><a href="<?php echo $this->Html->url("/logout");?>" class="mouse_over"><img src="<?php echo $this->Html->url("/img/common/header/logout.gif"); ?>" alt="ログアウト" /></a></p>
	<p class="username">ようこそ　<span><em><?php echo $user_info["User"]["name"];?></em>さん</span></p>
	<?php else: ?>
	<p class="login"><a href="#login" class="loginbtn mouse_over" data-redirect=""><img src="<?php echo $this->Html->url("/img/common/header/login.gif"); ?>" alt="ログインはこちら" /></a></p>
	<?php endif; ?>
	
</header>
