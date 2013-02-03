<?php
$this->layout = "modal";
// body id
$this->assign("body_id", "login");

// page_css
$this->start("page_css");
$__css[] = $this->Html->css("modules/login");
echo implode("\n", $__css);
$this->end();

// page_script
// $this->start("page_script");
// echo implode("\n", $__script);
// $this->end();
?>
	<div class="box" id="login_box">
		<p class="title"><img src="<?php echo $this->Html->url("/img/login/login.gif"); ?>" alt="ログイン" /></p>
		
		<p class="facebook"><a href="<?php echo $fb_login; ?>" target="_top" class="mouse_over"><img src="<?php echo $this->Html->url("/img/common/facebook.gif"); ?>" alt="Facebookアカウントでログイン" /></a></p>
		<form>
		<dl>
			<dt><img src="<?php echo $this->Html->url("/img/login/userid.gif"); ?>" alt="ユーザーID" /></dt>
			<dd><input type="text" name="userid" value="" class="text" /></dd>
			<dt><img src="<?php echo $this->Html->url("/img/login/password.gif"); ?>" alt="パスワード" /></dt>
			<dd><input type="text" name="password" value="" class="text" /><br /><a href="" class="textlink">パスワードを忘れた方はこちら</a></dd>
		</dl>
		<p class="submit mouse_over"><input type="image" src="<?php echo $this->Html->url("/img/login/submit.gif"); ?>" alt="送信" /></p>
		</form>
		
	</div>
	<!-- //login_box -->

	<div class="box" id="regist_box">
		<p class="title"><img src="<?php echo $this->Html->url("/img/login/regist.gif"); ?>" alt="新規会員登録" /></p>
		
		<form>
		<dl>
			<dt><img src="<?php echo $this->Html->url("/img/login/useridmail.gif"); ?>" alt="ユーザーID（Email）" /></dt>
			<dd><input type="text" name="userid" value="" class="text" /></dd>
			<dt><img src="<?php echo $this->Html->url("/img/login/password.gif"); ?>" alt="パスワード" /></dt>
			<dd><input type="text" name="password" value="" class="text" /></dd>
			<dt><img src="<?php echo $this->Html->url("/img/login/name.gif"); ?>" alt="お名前" /></dt>
			<dd><input type="text" name="name" value="" class="text" /></dd>
		</dl>
		<p class="sub"><input type="checkbox" name="namehidden" id="namehidden" class="namehidden" /><label class="namehidden" for="namehidden">名前を非公開</label><a href="" class="textlink">利用規約はこちら</a></p>
		<p class="submit mouse_over"><input type="image" src="<?php echo $this->Html->url("/img/login/submit.gif"); ?>" alt="送信" /></p>
		</form>
		
	</div>
	<!-- //login_box -->
