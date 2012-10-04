<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title_for_layout; ?></title>
<?php
        $str = $this->Html->css('style');
        echo str_replace('style.css', 'style.css?version=' . HO_CSS_VERSION, $str);
        ?>
		<?php
            echo $this->Html->script('jquery-1.8.0.min.js');
            echo $this->Html->script('/js/calender/jquery.validate.js');
            $mainJs = $this->Html->script('main.js');
            echo str_replace('main.js', 'main.js?version=' . HO_JS_VERSION, $mainJs);
        ?>
<style>
ul.left-menu{list-style:none; padding:0px; margin:50px 10px 10px 20px}
ul.left-menu li {margin:5px 0px; border-bottom:1px dashed #fad5ff; padding:2px 0px 6px 0px; }
ul.left-menu li a { font-size:13px;  color:#fff}

</style>
</head>
<body>

  <div class="headerContentRegion">
   
    <div id="headerRegion" class="" style="opacity: 1;">
      <div class="header"> 
      	<img class="logo" src="/img/health-logo.png" width="144" height="27">
		<?php echo $this->Element('header_menu'); ?>
		
        
      </div>
    </div>
    
    
  </div>
	 <?php echo $content_for_layout; ?>
</body>
</html>