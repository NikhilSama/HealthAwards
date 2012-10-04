Dear <?php echo $data['fName'].' '.$data['lName'];?>,

Username: <?php echo $data['username']; ?>


	You recently requested a new password.  To reset your password, follow the link below:


<a href="<?php echo $data['encryptURL'];?>"><?php echo $data['encryptURL'];?></a>


Or to login, please follow this link:&nbsp;&nbsp;<a href="<?php echo $data['url'];?>"><?php echo $data['url'];?></a>



Note:
This is an automatically generated message. Do not reply to this message. If you have any questions, please get in touch with us at <a href="mailto:support@meritnation.com">support@meritnation.com</a>



Thanks,
MeritNation Team