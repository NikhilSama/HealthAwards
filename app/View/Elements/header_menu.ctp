<?php if($this->Session->check('User')){ ?>
<div class="navigation">
	<ul>
		<li><a href="/doctors/my_profile"><span>Dashboard</span></a></li>
		<li><a class="selected" href="/doctors/patients_list"><span>Patients</span></a></li>
		<li><a href="/doctors/calendar"><span>Appointments</span></a></li>
		<li><a href="#"><span>Questions</span></a></li>
	</ul>
</div>
<?php } ?>