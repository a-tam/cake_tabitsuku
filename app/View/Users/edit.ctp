<?php
$this->layout = "modal";
$this->assign("body_id", "useredit");

$this->start("page_css");
$__css[] = $this->Html->css("modules/useredit");
echo implode("\n", $__css);
$this->end();

$this->start("page_script");
$__script[] = $this->Html->script("useredit");
echo implode("\n", $__script);
$this->end();
?>
<div class="box">
	<form>
	<h1><img src="<?php echo $this->html->url("/img/user/top/useredit.gif"); ?>" alt="登録内容変更" /></h1>
	<dl id="username_display">
		<dt><img src="<?php echo $this->html->url("/img/user/top/name_display.gif"); ?>" alt="登録名を表示しますか？" /></dt>
		<dd>
			<ul>
				<li><input type="radio" name="namedisplay" value="display" checked id="radio_name_display" /><label for="radio_name_display"><img src="<?php echo $this->html->url("/img/user/top/display.gif"); ?>" alt="表示する" /></label></li>
				<li><input type="radio" name="namedisplay" value="nondisplay" id="radio_name_nondisplay" /><label for="radio_name_nondisplay"><img src="<?php echo $this->html->url("/img/user/top/nondisplay.gif"); ?>" alt="非表示にする" /></label></li>
			</ul>
			<p class="frame">&nbsp;</p>
		</dd>
	</dl>
	<dl id="username">
		<dt><img src="<?php echo $this->html->url("/img/user/top/username.gif"); ?>" alt="登録名" /></dt>
		<dd><input type="text" name="username" value="山田太郎" class="text" /></dd>
	</dl>
	<p class="submit mouse_over"><input type="image" src="<?php echo $this->html->url("/img/user/top/editbtn.gif"); ?>" alt="登録内容を変更" /></p>
	</form>
</div>
