<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo $title_for_layout; ?></title>
        <link rel="icon" href="<?php echo $this->request->webroot . 'meritnation.ico'; ?>" type="image/x-icon" />
        <link rel="shortcut icon" href="<?php echo $this->request->webroot . 'meritnation.ico'; ?>" type="image/x-icon" />


        <?php         
        $str = $this->Html->css('style');
        echo $this->Html->css('protfish');
        echo str_replace('style.css', 'style.css?version=' . MN_CSS_VERSION, $str);
        ?>
        <?php
        if (isset($this->Javascript)) {     
            echo $this->Html->script('jquery-1.7.min');
            //echo $mainJs = $this->Html->script('main.js');
            //echo str_replace('main.js', 'main.js?version=' . MN_JS_VERSION, $mainJs);
            //echo $this->Html->script('protofish.js');
        }
        ?>
        <style>
            #ss_messages TD {
                padding: 4px;
            }
            .m_links {
                padding-top:70px;
                font-size:11px;
                color:#333;
            }
            .m_links STRONG {
                display:block;
                text-align:right;
                padding: 3px;
            }
            .m_links .m_active {
                background:#dee;
            }
        </style>
    </head>
    <body>
        <div class="background">
            <div class="main">
                <div class="header">
					<div style="margin-top:30px">
						<?php echo $this->Html->image('fore-logo2.jpg', array('hspace' => '20')); ?>
					</div>
                </div>
                <?php if ($this->Session->check('Admin')) { ?>

                        echo $this->element('admin_mainmenu');
                     ?>
                    <?php } ?>
                <div class="left_layout"></div>
                <div class="content">
                    <div style="height:7px;"></div>
                <?php
                if ($this->Session->check('Message.flash')) {
						echo $this->Session->flash();
                }
                ?>
<?php echo $content_for_layout; ?>
                </div>
<?php echo $this->element('footer'); ?>
            </div>
        </div>
    </body>
</html>