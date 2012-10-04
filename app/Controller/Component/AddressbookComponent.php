<?php
class AddressbookComponent extends Component
{
    function __construct(ComponentCollection $Collection, $settings = array()) {}
    function getEmails($username, $password,$serviceName) {

		// validate input
		if (!isset($username) || !isset($password) || !isset($serviceName)) {
			return null;
		}
        App::import('Vendor','clsContactImporter',array('file' => '/addressbook/ContactsImporter.php'));
		//vendor('addressbook'.DS.'ContactsImporter');
		$serviceArr = explode('.',$serviceName);
		$serviceProvider = $serviceArr[0];
        App::import('Vendor',$serviceProvider,array('file' => 'addressbook'.DS.'domains'.DS.$serviceProvider.'.php'));
		$objImportedContacts = new $serviceProvider($username, $password);
		$arrImportedContacts = $objImportedContacts -> ImportContacts();
		
		return $arrImportedContacts;

	}
        
    
}
?>