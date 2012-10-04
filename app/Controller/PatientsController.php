<?php
class PatientsController extends AppController {
	var $name = 'Patients';

	var $uses = array('Tester','Paging','OrderTask');

	var $helpers = array('Html','Form','Ajax','Javascript','Util','Time');
	var $components = array('Encrypt','Cookie','Session','Email','RequestHandler','Upload');
	
}
?>