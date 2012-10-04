<!-- Page Header -->
<div class="alignL"><font color="#28A7EC" size="5">Edit Profile</font></div>
<hr color="#BFDEFF" width="100%">
<!-- End of Page Header -->
<div style="height:10px;"> </div>
<?php 
	if(isset($this->request->params['data'])) {
		if ($this->Session->check('Message.flash')) {
			echo $this->Session->flash();
		}
	}
?>

<?php echo $this->Form->create(null,array('url'=>'/users/update-profile','type'=>'post','name'=>'updateprofile','enctpye'=>'multipart/form-data'));?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form">
		<tr>
			<td class="fieldName">Email *</td>	
			<td class="field">
				<?php echo $this->request->data['User']['email']; ?>
			</td>
		</tr>
		<tr>
			<td class="fieldName">First name *</td>
			<td class="field <?php if(isset($errors['fname']))  echo 'error';   ?>">
				<?php echo $this->Form->text('UserDetail.fname', array('size' => 20)); ?>
			</td>
		</tr>
		<tr>
			<td class="fieldName">Last name</td>
			<td class="field <?php if(isset($errors['lname']))  echo 'error';   ?>">
				<?php echo $this->Form->text('UserDetail.lname', array('size' => 20)); ?>
			</td>
		</tr>
		<tr>
			<td class="fieldName">Mobile *</td>
			<td class="field <?php if(isset($errors['mobile']))  echo 'error';   ?>">
				<?php echo $this->Form->text('UserDetail.mobile',array('size' => '20','maxlength'=>'17')); ?>
			</td>
		</tr>
		
		<tr>
			<td class="fieldName">Phone</td>
			<td class="field <?php if(isset($errors['phone']))  echo 'error';   ?>">
				<?php echo $this->Form->text('UserDetail.phone', array('size' => '20','maxlength'=>'20'));?>
			</td>	
		</tr>
		<tr>
			<td class="fieldName">Address</td>
			<td class="field <?php if(isset($errors['address']))  echo 'error'; ?>">
				<?php echo $this->Form->textarea('UserDetail.address' ); ?>
			</td>
		</tr>
		<tr>
			<td class="fieldName">Postal Code</td>
			<td class="field <?php if(isset($errors['zip']))  echo 'error'; ?>">
				<?php echo $this->Form->text('UserDetail.zip', array('size' => '20','maxlength'=>'20') ); ?>
			</td>
		</tr>
		<tr>
			<td class="fieldName">Country</td>
			<td class="field <?php if(isset($errors['country']))  echo 'error'; ?>">
				<?php echo $this->Form->select('UserDetail.country',$coutriesList,array('empty'=>null,'onchange'=>'changeState(this.value,"stateTDId","cityTDId")')); ?>
			</td>
		</tr>
		<tr>
			<td class="fieldName">State</td>
			<td class="field <?php if(isset($errors['state']))  echo 'error'; ?>" id="stateTDId">
				<?php echo $this->Form->select('UserDetail.state',$statesList,array('empty'=>null,'onchange'=>'changeCity(this.value,"cityTDId")')); ?>
			</td>
		</tr>
		<tr>
			<td class="fieldName">City</td>
			<td class="field <?php if(isset($errors['city']))  echo 'error'; ?>" id="cityTDId">
				<?php echo $this->Form->select('UserDetail.city',$citiesList,array('empty'=>null)); ?>
			</td>
		</tr>
		<tr>
			<td class="fieldName">Fax</td>
			<td class="field <?php if(isset($errors['fax']))  echo 'error'; ?>">
				<?php echo $this->Form->text('UserDetail.fax', array('size' => '20','maxlength'=>'20') ); ?>
			</td>
		</tr>
		<tr>
			<td class="fieldName">Company</td>
			<td class="field <?php if(isset($errors['company']))  echo 'error'; ?>">
				<?php echo $this->Form->text('UserDetail.company', array('size' => '20','maxlength'=>'20') ); ?>
			</td>
		</tr>
		<tr>
			<td class="fieldName">Website</td>
			<td class="field <?php if(isset($errors['website']))  echo 'error'; ?>">
				<?php echo $this->Form->text('UserDetail.website', array('size' => '20','maxlength'=>'20') ); ?>
			</td>
		</tr>
		<tr>
			<td class="fieldName">Image</td>
			<td class="field <?php if(isset($errors['userImage']))  echo 'error'; ?>">
				<?php echo $this->Form->file('UserDetail.userImage', array('size' => '20','maxlength'=>'20') ); ?>
			</td>
		</tr>
		<tr>
			<td></td>
			<td class="field"><?php echo $this->Form->submit('Update',array('div'=>false));?>&nbsp;<?php echo $this->Form->text('Student.Cancel',array('type'=>'submit','value'=>'Cancel'));?></td>
		</tr>
	</table>
</form>