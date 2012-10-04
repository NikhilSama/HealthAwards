Dear <?php echo $data['username'];?>,
<br />
<br />
Thank you for registering with us. Your account information is as follows:
<br />
<br />
<table width="600" cellpadding="2" cellspacing="2">
<tr>
	<td>Username:&nbsp;<?php echo $data['username'];?></td>
</tr>
<tr>
	<td>Password:&nbsp;<?php echo $data['password'];?></td>
</tr>
</table>
<br />
<?php if(RESTRICT_ACTIVATION) { ?>
To activate your account and start using it, follow this link:&nbsp;&nbsp;
<a href="<?php echo $data['url'];?>"><?php echo $data['url'];?></a>
<br /><br />
<?php } ?>
<br /><br />
Note:<br />
This is an automatically generated message. Do not reply to this message. If you have any questions, please get in touch with us at <a href="mailto:support@meritnation.com">support@meritnation.com</a>
<br /><br />
Thanks,<br />
MeritNation Team