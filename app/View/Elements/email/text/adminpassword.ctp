Dear <?php echo $data['username'];?>,
<br />
<br />
	Your Admins account information is as follows:
<br />
<table width="600" cellpadding="2" cellspacing="2">
<tr>
	<td width="50">Username:</td>
	<td><?php echo $data['username'];?></td>
</tr>
<tr>
	<td>Password:</td>
	<td><?php echo $data['password'];?></td>
</tr>
</table>
<br />
To login, please follow this link:&nbsp;&nbsp;<a href="<?php echo $data['url'];?>"><?php echo $data['url'];?></a>
<br /><br />
Note:<br />
I am a computer at meritnation.com. I want to tell you that your email could not be delivered at <a href="mailto:no-reply@meritnation.com">no-reply@meritnation.com</a> as it is not a valid email address. <br />
You can send your queries to us at <a href="mailto:support@meritnation.com">support@meritnation.com</a>
<br /><br />
Thanks,<br />
MeritNation Team