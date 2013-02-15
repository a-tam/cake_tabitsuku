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
	<div class="box">
		<p class="title">ユーザー登録完了</p>
		<div style="margin-left: 9px; margin-right: 35px; padding-top: 15px; padding-left: 30px; font-size: 12px;">
			<span>本人確認用のメールを送信しました。メール本文のURLをクリックしてください。</span>
			<span>30分以上たってもメールが届かない場合は、再度ご登録ください。</span>
			<a href="javascript:window.parent.commonCtl.loginClose();" class="selectbtn mouse_over">閉じる</a>
		</div>
	</div>
	<!-- //login_box -->
