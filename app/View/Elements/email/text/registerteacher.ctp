Dear <?php echo $data['username'];?>,

Thank you for registering with us. Your account information is as follows:



Username: <?php echo $data['username'];?>


Password:&nbsp;<?php echo $data['password'];?>


<?php if(RESTRICT_ACTIVATION) { ?>
To activate your account and start using it, follow this link:  
<a href="<?php echo $data['url'];?>"><?php echo $data['url'];?></a>

<?php } ?>
  

Note:

This is an automatically generated message. Do not reply to this message. If you have any questions, please get in touch with us at <a href="mailto:support@meritnation.com">support@meritnation.com</a>


Thanks,

MeritNation Team