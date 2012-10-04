<!-- Page Header -->
<div class="alignL"><font color="#28A7EC" size="5">My Profile</font></div>
<hr color="#BFDEFF" width="100%">
<!-- End Page Header -->
<div style="height:10px;"> </div>
<div class="profile textGray3">
    <table cellpadding="3" cellspacing="2" border="0" class="section">
        <tr>
            <td colspan="2" class="title" >
                <?php echo $user['userInfo']['fname']; echo ' '; echo $user['userInfo']['lname'];?>              
            </td>
        </tr>
		<?php
		if($user['userInfo']['fname']!=''){
		?>
		<tr>
            <td class="field">name:</td>
            <td><?php echo $user['userInfo']['fname']; echo ' '; echo $user['userInfo']['lname'];?></td>
        </tr>
		<?php
		}
		?>
		<?php
		if($user['userInfo']['username']!=''){
		?>
		<tr>
            <td class="field">username:</td>
            <td><?php echo $user['userInfo']['username'];?></td>
        </tr>
		<?php
		}
		?>
        <tr>
            <td class="field">email:</td>
            <td><?php echo $user['userInfo']['email']; ?></td>
        </tr>
		<?php
		if($user['userInfo']['mobile']!=''){
		?>
        <tr>
            <td class="field">mobile:</td>
            <td><?php echo $user['userInfo']['mobile']; ?> </td>
        </tr>
		<?php } ?>
		<?php
		if($user['userInfo']['phone']!=''){
		?>
		<tr>
            <td class="field">phone:</td>
            <td><?php echo $user['userInfo']['phone']; ?></td>
        </tr>
		<?php } ?>
		<?php
		if($user['userInfo']['address']!=''){
		?>
        <tr>
            <td class="field">address:</td>
            <td><?php echo $user['userInfo']['address']; ?></td>
        </tr>
		<?php } ?>
        <tr>
            <td class="field">city:</td>
            <td><?php echo $user['userInfo']['cityName'];?></td>
        </tr>
        <tr>
            <td class="field">state / region:</td>
            <td><?php echo $user['userInfo']['stateName'];?></td>
        </tr>
        <tr>
            <td class="field">country:</td>
            <td><?php echo $user['userInfo']['countryName']; ?></td>
        </tr>
    </table>
</div>