<?php 
	if(false && isset($this->request->params['data'])) {
		if ($this->Session->check('Message.flash')) {
			$this->Session->flash();
		} 
	}
	echo $this->Form->create('users',array('name'=>'registration', 'id'=>'registration','type'=>'post','action'=>'registration', 'onsubmit'=> '$("#frmRegSumbit").attr("disabled","true");$("#frmRegSumbit").val("Please wait...");'));?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form">
        <tr>
			<td class="fieldName">Name<span class="textRed bold">*</span></td>
			<?php
			$errMsg='';
			$spanClass = 'textGray text11';
			$fieldCss='';
			if(isset($errors['fname'])){
				$errMsg=$errors['fname'];
				$spanClass = 'errMsg';
				$fieldCss='errClass';
			}
			?>
			<td class="field">
				<?php echo $this->Form->text('UserDetail.fullname', array('onblur'=>'validateRegForm(this,"Name",1);','size' => '20','maxlength'=>'20','label'=>false,'class'=>'green2 '.$fieldCss, 'div'=>false,'error'=>false)); ?><span id="errIdName" class="<?php echo $spanClass; ?>"><?php echo $errMsg; ?></span>
			</td>
		</tr>
		<tr>
			<td width="160px" class="fieldName">Email<span class="textRed bold">*</span></td>
			<?php
			$errMsg=$fieldCss='';
			if(isset($errors['email'])){
				if(strpos($errors['email'],'<a')!==false)
					$errMsg .='<br />';
				$errMsg .='<span id="errIdEmail" class="errMsg">'.$errors['email'].'</span>';
				$fieldCss='errClass';
			}
			?>
			<td class="field">
				<?php echo $this->Form->text('User.email', array('label'=>false,'div'=>false, 'class'=>'green2 '. $fieldCss, 'error'=>false,'onblur'=>'if(validateRegForm(this,"Email",1)){checkAvalability(this,1)};')); ?> <img id="emailLoader" style="display:none" src="/img/loader1.gif" border="0" align="absmiddle"/> <?php echo $errMsg; ?>
				<div id="chkAvail" style="display:none;">
					<div class="alignL"><span id="availability"></span></div>
				</div>
			</td>
		</tr>
		
		<tr>
			<td class="fieldName">Mobile<span class="textRed bold">*</span></td>
			<?php
			$errMsg='(Include Country code also) E.g. For India (+91) 8973059640';
			$spanClass = 'textGray text11';
			$fieldCss='';
			if(isset($errors['mobile'])){
				$errMsg=$errors['mobile'];
				$spanClass = 'errMsg';
				$fieldCss='errClass';
			}
			?>
			<td class="field">
				<?php echo $this->Form->input('UserDetail.mobile', array('size' => '20','maxlength'=>'17','label'=>false,'class'=>'green2 '.$fieldCss, 'div'=>false,'error'=>false,'onblur'=>'validateRegForm(this,"Mobile",1)')); ?> 
				<span id="errIdMobile" class="<?php echo $spanClass; ?>"><?php echo $errMsg; ?></span>
			</td>
		</tr>
		<tr>
			<td class="fieldName">Password<span class="textRed bold">*</span></td>
			<?php
			$errMsg='Spaces not allowed';
			$spanClass = 'textGray text11';
			$fieldCss='';
			if(isset($errors['password'])){
				$errMsg=$errors['password'];
				$spanClass = 'errMsg';
				$fieldCss='errClass';
			}
			?>
			<td class="field">
				<?php echo $this->Form->password('User.password', array('size' => '20','maxlength'=>'20','label'=>false,'class'=>'green2 '.$fieldCss, 'div'=>false,'error'=>false,'onblur'=>'validateRegForm(this,"Password",1)')); ?>
				<span id="errIdPassword" class="<?php echo $spanClass; ?>"><?php echo $errMsg; ?></span>
			</td>
		</tr>
		<tr>
			<td class="fieldName">Confirm password<span class="textRed bold">*</span></td>
			<?php
			$spanClass=$errMsg=$fieldCss='';
			if(isset($errors['confirmpassword'])){
				$errMsg=$errors['confirmpassword'];
				$spanClass = 'errMsg';
				$fieldCss='errClass';
			}
			?>
			<td class="field">
				<?php echo $this->Form->password('User.confirmpassword', array('size' => '20','maxlength'=>'20','label'=>false,'class'=>'green2 '.$fieldCss, 'div'=>false,'error'=>false,'onblur'=>'validateRegForm(this,"Confirm password",1)')); ?> 
				<span id="errIdConfirm password" class="<?php echo $spanClass; ?>"><?php echo $errMsg; ?></span>
			</td>
		</tr>
		<tr>
			<td class="fieldName">City</td>
			<?php
			$errMsg='';
			$spanClass = 'textGray text11';
			$fieldCss='';
			if(isset($errors['city'])){
				$errMsg=$errors['city'];
				$spanClass = 'errMsg';
				$fieldCss='errClass';
			}
			?>
			<td class="field">
				<?php echo $this->Form->text('UserDetail.city', array('size' => '20','maxlength'=>'120','label'=>false,'class'=>'green2 '.$fieldCss, 'div'=>false,'error'=>false)); ?><span id="errIdCompany" class="<?php echo $spanClass; ?>"><?php echo $errMsg; ?></span>
			</td>
		</tr>
		<tr>
			<td class="fieldName">Country</td>
			<?php
			$errMsg='';
			$spanClass = 'textGray text11';
			$fieldCss='';
			if(isset($errors['country'])){
				$errMsg=$errors['country'];
				$spanClass = 'errMsg';
				$fieldCss='errClass';
			}
			?>
			<td class="field">
				<?php echo $this->Form->select('UserDetail.country',$coutriesList,array('empty'=>null)); ?><span id="errIdUrl" class="<?php echo $spanClass; ?>"><?php echo $errMsg; ?></span>
			</td>
		</tr>
		<tr>
			<td class="fieldName">Timezone</td>
			<?php
			$errMsg='';
			$spanClass = 'textGray text11';
			$fieldCss='';
			if(isset($errors['timezone'])){
				$errMsg=$errors['timezone'];
				$spanClass = 'errMsg';
				$fieldCss='errClass';
			}
			?>
			<td class="field">
				<?php echo $this->Form->select('UserDetail.timezone',$timezoneList,array('empty'=>null)); ?><span id="errIdUrl" class="<?php echo $spanClass; ?>"><?php echo $errMsg; ?></span>
			</td>
		</tr>
		
		<tr>
			<td></td>
			<td class="field">
				<input value="Register" type="submit" id="frmRegSumbit"> <span style="font-size:11px;">By clicking on 'Register' you agree to 
				<?php echo $this->Html->link('terms and conditions','/users/termsandcondition/?height=430&width=630&screenY=100&scrollbars=yes&resizable=no&status=no&location=no',array('class'=>'thickbox','id'=>'challengeLink','escape'=>false,'title'=>'Terms and Conditions'));?>
				</span> <input name="data[User][termsCondition]" value="1" id="UserTermsCondition" type="hidden">
				&nbsp;
			</td>
		</tr>
	</table>
	</form>
</div>
<div style="height:5px;"> </div>
Existing members <a href="/users/login">Login here</a>