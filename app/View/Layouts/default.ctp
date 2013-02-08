<!doctype html>
<html lang="ja">
<head>
<?php
// meta
$this->start("meta");
$_metas[] = $this->Html->charset("utf-8");
$_metas[] = '<meta http-equiv="Content-Language" content="ja" />';
$_metas[] = '<meta http-equiv="Content-Style-Type" content="text/css" />';
$_metas[] = '<meta http-equiv="Content-Script-Type" content="text/javascript" />';
$_metas[] = '<meta name="description" content="" />';
$_metas[] = '<meta name="robots" content="ALL" />';
$_metas[] = '<link rel="start index" href="/" title="'.$title_for_layout.'" />';
$_metas[] = $this->Html->meta('icon', '/img/favicon.ico');
echo implode("\n", $_metas);
$this->end();

// common css
$this->start("css");
$_css[] = $this->Html->css("import");
$_css[] = $this->Html->css("ui-lightness/jquery-ui-1.8.20.custom");
echo implode("\n", $_css);
$this->end();

// common scripts
$this->start("script");
$_scripts[] = $this->Html->script('jquery/jquery-1.7.2.min');
$_scripts[] = $this->Html->script('jquery/jquery-ui-1.8.20.custom.min');
$_scripts[] = $this->Html->script('jquery/jquery.powertip.min');
$_scripts[] = $this->Html->script('jquery/jquery.easing.js');
$_scripts[] = $this->Html->script('apps/browser.js');
$_scripts[] = $this->Html->script('apps/common.js');
echo implode("\n", $_scripts);
$base_url = $this->Html->url("/", true);
$asset_url = $this->Html->url("/", true);
$fb_app_id = Configure::read("facebook.app_id");
echo <<<"EOM"
<script type="text/javascript">
	var gBaseUrl = '${base_url}';
	var gAssetUrl = '${asset_url}';
	var gFacebookAppId = '${fb_app_id}';
</script>
<!--[if lte IE 8]>
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
EOM;
$this->end();

// header
$this->start("header");
echo $this->element("header");
$this->end();

// footer
$this->start("footer");
echo $this->element("footer");
$this->end();

?>
<title><?php echo $title_for_layout ?></title>

<!-- meta -->
<?php echo $this->fetch('meta'); ?>

<!-- common css -->
<?php echo $this->fetch('css'); ?>

<!-- page css -->
<?php echo $this->fetch('page_css'); ?>

<!-- common script -->
<?php echo $this->fetch('script'); ?>

<!-- page script -->
<?php echo $this->fetch('page_script'); ?>
</head>
<body<?php
if ($this->fetch("body_id")) echo ' id="'.$this->fetch("body_id").'"';
if ($this->fetch("body_class")) echo ' class="'.$this->fetch("body_class").'"'; ?>>
<?php echo $this->fetch("header"); ?>
<?php echo $this->fetch('content'); ?>
<?php echo $this->fetch("footer"); ?>
</body>
</html>
