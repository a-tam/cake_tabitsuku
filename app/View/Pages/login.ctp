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
		<?php echo $this->Form->create("Login", array("url" => array("controller" => "pages", "action" => "login")));?>
		<p><?php echo $this->Session->flash(); ?></p>
		<dl>
			<dt><img src="<?php echo $this->Html->url("/img/login/userid.gif"); ?>" alt="ユーザーID" /></dt>
			<dd><?php echo $this->Form->input("login", array("class" => "text", "label" => false));?></dd>
			<dt><img src="<?php echo $this->Html->url("/img/login/password.gif"); ?>" alt="パスワード" /></dt>
			<dd><?php echo $this->Form->input("password", array("type" => "password", "class" => "text", "label" => false));?><br />
				<a href="<?php echo $this->Html->url("/pages/reminder");?>" class="textlink" target="_top">パスワードを忘れた方はこちら</a></dd>
		</dl>
		<p class="submit mouse_over"><input type="image" src="<?php echo $this->Html->url("/img/login/submit.gif"); ?>" alt="送信" /></p>
		<?php echo $this->Form->end();?>
		</form>
		
	</div>
	<!-- //login_box -->

	<div class="box" id="regist_box">
		<p class="title"><img src="<?php echo $this->Html->url("/img/login/regist.gif"); ?>" alt="新規会員登録" /></p>
		<?php echo $this->Form->create("User", array("url" => array("controller" => "pages", "action" => "signup")));?>
		<dl>
			<dt><img src="<?php echo $this->Html->url("/img/login/useridmail.gif"); ?>" alt="ユーザーID（Email）" /></dt>
			<dd><?php echo $this->Form->input("login", array("class" => "text", "label" => false));?></dd>
			<dt><img src="<?php echo $this->Html->url("/img/login/password.gif"); ?>" alt="パスワード" /></dt>
			<dd><?php echo $this->Form->input("password", array("type" => "password", "class" => "text", "label" => false));?></dd>
			<dt><img src="<?php echo $this->Html->url("/img/login/name.gif"); ?>" alt="お名前" /></dt>
			<dd><?php echo $this->Form->input("name", array("class" => "text", "label" => false));?></dd>
		</dl>
		<p class="sub">
			<label class="namehidden">
			<?php echo $this->Form->checkbox("privacy", array(
					'value'       => "1",
					'hiddenField' => false,
					'class'       => "namehidden"));?> 名前を非公開
			</label>
			<a href="<?php echo $this->Html->url("/site/rule"); ?>" target="_blank" class="textlink">利用規約はこちら</a>
		</p>
		<p class="submit mouse_over"><input type="image" src="<?php echo $this->Html->url("/img/login/submit.gif"); ?>" alt="送信" /></p>
		<?php echo $this->Form->end();?>
		
	</div>
	<!-- //login_box -->
