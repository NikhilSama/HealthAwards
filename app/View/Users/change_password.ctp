<!-- Page Header -->
<div class="alignL"><font color="#28A7EC" size="5">Change Password</font></div>
<hr color="#BFDEFF" width="100%">
<!-- End Page Header -->
<div style="height:10px;"> </div>
<?php 
	echo $this->Session->flash();
?>
<?php  echo $this->Form->create(null, array('url'=>'/users/change-password', 'name'=>'changepassword', 'id'=>'changepassword', 'type'=>'post'));?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form">
	<tr>
		<td class="fieldName">Old Password *</td>

		<td class="field <?php if(isset($errors['0'])||isset($errors['4']))  echo 'error';  ?>" width="75%">
			<?php echo $this->Form->password('User.oldpassword',array('id'=>'oldpasswordid','size'=>'20','maxlength'=>'20'));?>
		</td>
	</tr>
	<tr>
		<td class="fieldName">New Password *</td>

		<td class="field <?php if(isset($errors['1']))  echo 'error';   ?>" width="75%">
			<?php echo $this->Form->password('User.newpassword',array('id'=>'newpasswordid','size'=>'20','maxlength'=>'20'));?>
		</td>
	</tr>
	<tr>
		<td class="fieldName">Confirm Password *</td>
			<td class="field <?php if(isset($errors['2'])||isset($errors['3']))  echo 'error';  ?>" width="75%">
			<?php echo $this->Form->password('User.confirmpassword',array('id'=>'confirmpasswordid','size'=>'20','maxlength'=>'20'));?>
		</td>
	</tr>
	<tr>
		<td></td>
		<td class="field" width="75%">
			<?php echo $this->Form->submit('Change Password',array('name'=>'Login','class'=>'loginbutton','div'=>false));?>&nbsp;<?php echo $this->Form->text('Student.Cancel',array('type'=>'submit','value'=>'Cancel'));?>
		</td>
	</tr>
</table>
</form>
