<?php
if ($this->Session->check('Message.flash')) {
    echo $this->Session->flash();
 } ?>
<!-- Title -->
<div><?php echo $this->Html->image('myprofile.png',array('align'=>'middle'));?> <span class="title">&nbsp;Login</span></div>
<form name="loginform" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>User name *</td>
		<td><?php echo $this->Form->text('User.username',array('id'=>'userid','maxlength'=>'20'));?></td>
	</tr>
	<tr>
		<td>Password *</td>
		<td><?php echo $this->Form->password('User.password',array('id'=>'password','maxlength'=>'20'));?></td>
	</tr>
	<tr>
		<td></td>
		<td><?php echo $this->Form->submit('Login',array('name'=>'Login'));?></td>
	</tr>
</table>
</form>