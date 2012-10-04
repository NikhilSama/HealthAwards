<?php
class AppModel extends Model {
	static $_useDbConfig;

	function save($data = null, $validate = true, $fieldList = array()) { 
		$oldDb = $this->useDbConfig;							// Remember the old config 
		$this->setDataSource('default');						// Set the new config 
		$return = parent::save($data, $validate, $fieldList);	// Call the original Model::save() method 
		$this->setDataSource($oldDb); 							// Reset the config/datasource
		return $return; 
	}

	function updateAll($fields, $conditions = true) {
		$oldDb = $this->useDbConfig; 
		$this->setDataSource('default'); 
		$return = parent::updateAll($fields, $conditions); 
		$this->setDataSource($oldDb); 
		
		return $return; 
	}

	function delete($id = null, $cascade = true) {
		$oldDb = $this->useDbConfig; 
		$this->setDataSource('default'); 
		$return = parent::delete($id, $cascade); 
		$this->setDataSource($oldDb); 
		
		return $return;
	}

	function deleteAll($conditions, $cascade = true, $callbacks = false) {
		$oldDb = $this->useDbConfig; 
		$this->setDataSource('default'); 
		$return = parent::deleteAll($conditions, $cascade, $callbacks); 
		$this->setDataSource($oldDb); 
		
		return $return; 
	}

	function findMaster($type='first', $query=array()) {
		$oldDb = $this->useDbConfig; 
		$this->setDataSource('default');
		$return = parent::find($type,$query); 
		$this->setDataSource($oldDb);
		return $return; 
	}	
	
	function hasAnyMaster($conditions = null) {
		$oldDb = $this->useDbConfig; 
		$this->setDataSource('default');
		$return = parent::find('count', array('conditions' => $conditions));
		$this->setDataSource($oldDb);
		return $return; 
	}

	function findCountMaster($conditions = null, $recursive = 0) {
		$oldDb = $this->useDbConfig; 
		$this->setDataSource('default');
		$return = parent::find('count', array('conditions' => $conditions, 'recursive' => $recursive)); 
		$this->setDataSource($oldDb);
		return $return; 
	}
	function query() {
		$params = func_get_args();
		$sql = $params[0];
		$primaryDB = false;
		if(isset($params[1])) { // used in writeuserSession function under AppController
			$primaryDB = true;
		}
		$isInsertQuery = strripos($sql,'insert'); // insert
		$isUpdateQuery = strripos($sql,'update'); // update
		$isDeleteQuery = strripos($sql,'delete'); // delete
		$isSPQuery = strripos($sql,'call'); // stored procedure
		if($primaryDB || $isInsertQuery !== false || $isUpdateQuery !== false || $isDeleteQuery !== false || $isSPQuery !== false) {
			$oldDb = $this->useDbConfig; 
			$this->setDataSource('default');
			$return = parent::query($sql); 
			$this->setDataSource($oldDb);
		}else {
			$return = parent::query($sql);
		}
		
		return $return;
	}
	function fieldMaster($fieldname,$condition) {
		$oldDb = $this->useDbConfig; 
		$this->setDataSource('default');
		$return = parent::field($fieldname, $condition); 
		$this->setDataSource($oldDb);
		return $return; 
	}
}
