<?php if($this->Session->check('Message.flash')) {
$errors = $this->Session->read('Message.flash.params');
?>
<div class="error msg">
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td rowspan="2" class="image"></td>
			<td class="title">Error</td>
		</tr>
		<tr>
			<td class="message">
				<ul>
					<?php foreach($errors as $key=>$error) {?>
					<li><?php echo $error; if($key === 'reactivation') { echo '&nbsp;&nbsp;'.$this->Html->link('Activation Code not received?','/users/reactivation'); }?></li>
					<?php } ?>
				</ul>
			</td>
		</tr>
	</table>
</div>
<?php } ?>