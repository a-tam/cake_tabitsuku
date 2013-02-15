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

<script type="text/javascript">
<!--
window.parent.location = gBaseUrl;
//-->
</script>
