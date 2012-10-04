<!-- Page Header -->
<div style="font-size: 16px; font-weight: bold; color: rgb(150, 153, 253);">Forgot Password</div>
<!-- End Page Header -->
<div style="height:25px;"> </div>
<?php echo $this->Session->flash(); ?>
<?php echo $this->Form->create(null,array('url'=>'/users/forgot_password','type'=>'post','name'=>'forgot_password','id'=>'forgot_password'));?>
<table width="60%" border="0" cellspacing="0" cellpadding="0" class="form">
	<tr>
		<td class="fieldName" width="150px">Email *</td>
		<td class="field <?php if(isset($errors['email']))  echo 'error';  ?>" >
			<?php echo $this->Form->text('User.email',array('id'=>'oldpasswordid','size'=>'30','maxlength'=>'50'));?>
		</td>
	</tr>
	<tr>
		<td></td>
		<td class="field" >
			<?php echo $this->Form->submit('Send Passowrd',array('name'=>'ForgotPassword','class'=>'loginbutton','div'=>false));?>
		</td>
	</tr>
</table>
</form>