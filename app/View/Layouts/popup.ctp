<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $title_for_layout;?></title>
<link rel="icon" href="<?php echo $this->request->webroot . 'meritnation.ico';?>" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo $this->request->webroot . 'meritnation.ico';?>" type="image/x-icon" />
<?php	 $str= $this->Html->css('style');
		  echo str_replace('style.css','style.css?version='.MN_CSS_VERSION,$str);
?>
<?php	if(isset($javascript)) {
			//echo $this->Html->script('prototype.js');
			echo $this->Html->script('prototype-1.6.0.3.js');
			echo $this->Html->script('scriptaculous.js?load=effects');
			echo $this->Html->script('effects.js');
			echo $this->Html->script('controls.js');
			$mainJs = $this->Html->script('main.js');
			echo str_replace('main.js','main.js?version='.MN_JS_VERSION,$mainJs);
		}
?>
</head>

<body class="footerPopup">

			<?php echo $content_for_layout;?>

<?php echo $this->element('google_analytic_code');?>
</body>

</html>