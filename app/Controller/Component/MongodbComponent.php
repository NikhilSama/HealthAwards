<?php
class MongodbComponent extends Component{
	protected $_db = null;
	protected $connected = false;
	public $config = array(
		'set_string_id' => true,
		'persistent' => false,
		'datasource' => 'mongodb',
		'database' => 'meritnation',
		'host' => 'localhost',
		'login' => '',
		'password' => '',
		'port' => 27017
	);


	public function __construct($config = array()) {
	}

    public function __destruct() {
        if ($this->connected) {
            $this->disconnect();
        }
    }

	public function connect($database=null) {
		$this->connected = false;
		$dbObj = new DATABASE_CONFIG();
		$this->config['host'] = $dbObj->mongo['host'];
		$this->config['login'] = $dbObj->mongo['login'];
		$this->config['password'] = $dbObj->mongo['password'];
		$this->config['database'] = (!is_null($database) ? $database :$dbObj->mongo['database']);
/**
 * To connect to a remote or authenticated Mongo instance, define the connection string in the MONGO_CONNECTION constant
 * mongodb://[username:password@]host1[:port1][,host2[:port2:],...]
 * If you do not know what this means then it is not relevant to your application and you can safely leave it as-is
 'mongodb://hello:pass@localhost:27017/admin'
 */


		//$host = $this->config['host'] . ':' . $this->config['port'];
		if($this->config['login']!='')
			$host='mongodb://'.$this->config['login'] . ':' .$this->config['password'] . '@' .$this->config['host'] . ':' . $this->config['port'].'/admin';
		else
			$host = $this->config['host'] . ':' . $this->config['port'];

		try {
			$this->connection = new Mongo($host, true, $this->config['persistent']);
		}
		catch (Exception $e) { 
			return ;
		}
		
		if ($this->_db = $this->connection->selectDB($this->config['database'])) {
			$this->connected = true;
		}
		return $this->connected;
	}

	public function isConnected() {
		return $this->connected;
	}



	public function close() {
		return $this->disconnect();
	}	

	public function disconnect() {
		if ($this->connected) {
			$this->connected = !$this->connection->close();
			unset($this->_db, $this->connection);
			return !$this->connected;
		}
		return true;
	}


	

/*
	public function track_registration($conditions){
		$this->connect();
		$table='track_registrations_copy';
		$result = $this->_db->selectCollection($table)->find($conditions,array('created'=>1,'inputData.userId'=>1, 'inputData'=>1));
		$successResults=$failureResults=array();
		$successCount= $failureCount= 0;
		$tempArr=array();
		$emailArr=array();
		$dupCount=0;
		while ($result->hasNext()) {
				$mongodata = $result->getNext();
				if ($this->config['set_string_id'] && !empty($mongodata['_id']) && is_object($mongodata['_id'])) {
					$mongodata['_id'] = $mongodata['_id']->__toString();
				}
				$date=$mongodata['created'];
				$userId=$attempt=0;
				$errors=array();
				$temp1=array();
				$userCount=0;
				foreach($mongodata['inputData'] as $value){
					$temp1=$mongodata;
					$attempt++;
					if(count($value['errors'])){
						foreach($value['errors'] as $k=>$err){
								$errors[$err]=1;
						}
					}
					$userId = $value['userId'];
					if($userId!=0){
						$userCount++;
						$successCount++;
						if($attempt==1){
							if(!isset($successResults[$date]['attempt1Count']))
								$successResults[$date]['attempt1Count']=1;
							else
								$successResults[$date]['attempt1Count']+=1;
						}else if($attempt==2){
							if(!isset($successResults[$date]['attempt2Count']))
								$successResults[$date]['attempt2Count']=1;
							else
								$successResults[$date]['attempt2Count']+=1;

							if(!isset($successResults[$date]['attempt2Errors']))
								$successResults[$date]['attempt2Errors']=array();
	
							foreach($errors as $k=>$v){
								if(strpos($k,'regForgotLink') || strpos($k,'loginForgotLink')){
									$k ='You already have an account';$emailArr[]=$k;}
								if(!isset($successResults[$date]['attempt2Errors'][$k]))
									$successResults[$date]['attempt2Errors'][$k]=1;
								else
									$successResults[$date]['attempt2Errors'][$k]+=1;
							}

						}else{
							if(!isset($successResults[$date]['attemptElseCount']))
								$successResults[$date]['attemptElseCount']=1;
							else
								$successResults[$date]['attemptElseCount']+=1;

							if(!isset($successResults[$date]['attemptElseErrors']))
								$successResults[$date]['attemptElseErrors']=array();
	
							foreach($errors as $k=>$v){
								if(strpos($k,'regForgotLink') || strpos($k,'loginForgotLink')){
									$k ='You already have an account';$emailArr[]=$k;}
								if(!isset($successResults[$date]['attemptElseErrors'][$k]))
									$successResults[$date]['attemptElseErrors'][$k]=1;
								else
									$successResults[$date]['attemptElseErrors'][$k]+=1;
							}
						}
						$errors=array();
						$attempt=0;
						//break;
					}

				}
				if($userCount>1){
					$tempArr[]=$temp1;
					$dupCount+=$userCount;
				}
				if($userId==0){
					$failureCount++;
					if($attempt==1){
						if(!isset($failureResults[$date]['attempt1Count']))
							$failureResults[$date]['attempt1Count']=1;
						else
							$failureResults[$date]['attempt1Count']+=1;

						if(!isset($failureResults[$date]['attempt1Errors']))
							$failureResults[$date]['attempt1Errors']=array();

						foreach($errors as $k=>$v){
							if(strpos($k,'regForgotLink') || strpos($k,'loginForgotLink')){
								$k ='You already have an account';$emailArr[]=$k;}
							if(!isset($failureResults[$date]['attempt1Errors'][$k]))
								$failureResults[$date]['attempt1Errors'][$k]=1;
							else
								$failureResults[$date]['attempt1Errors'][$k]+=1;
						}
					}elseif($attempt==2){
						if(!isset($failureResults[$date]['attempt2Count']))
							$failureResults[$date]['attempt2Count']=1;
						else
							$failureResults[$date]['attempt2Count']+=1;
						if(!isset($failureResults[$date]['attempt2Errors']))
							$failureResults[$date]['attempt2Errors']=array();

						foreach($errors as $k=>$v){
							if(strpos($k,'regForgotLink') || strpos($k,'loginForgotLink')){
								$k ='You already have an account';$emailArr[]=$k;}
							if(!isset($failureResults[$date]['attempt2Errors'][$k]))
								$failureResults[$date]['attempt2Errors'][$k]=1;
							else
								$failureResults[$date]['attempt2Errors'][$k]+=1;
						}
					}else {
						if(!isset($failureResults[$date]['attemptElseCount']))
							$failureResults[$date]['attemptElseCount']=1;
						else
							$failureResults[$date]['attemptElseCount']+=1;

						if(!isset($failureResults[$date]['attemptElseErrors']))
							$failureResults[$date]['attemptElseErrors']=array();

						foreach($errors as $k=>$v){
							if(strpos($k,'regForgotLink') || strpos($k,'loginForgotLink')){
								$k ='You already have an account';$emailArr[]=$k;}
							if(!isset($failureResults[$date]['attemptElseErrors'][$k]))
								$failureResults[$date]['attemptElseErrors'][$k]=1;
							else
								$failureResults[$date]['attemptElseErrors'][$k]+=1;
						}
					}
				}


		}
//pr($dupCount);
//pr($tempArr);

		//pr($successResults);
		//pr($failureResults);
		$rtnArr=array(
			'successCount'=>$successCount,	
			'failureCount'=>$failureCount,	
			'successResults'=>$successResults,	
			'failureResults'=>$failureResults
		);
		return $rtnArr;
	}

	public function storeUrls($table,$currDate,$sessionid,$data) {
		$this->connect('user_activity');
		if(is_object($this->_db)) {
			$mongoCollectionObj = $this->_db->selectCollection($table);
			$mongoCollectionObj->insert($data,array('safe'=>false,'fsync'=>false));
			return ;
		}
	}

	public function track_user_activity($data) {
		$this->connect('meritnation');
		if(is_object($this->_db)) {
			$mongoCollectionObj=$this->_db->selectCollection('track_users_activity');
			$data['userId'] = (int) $data['userId']; $data['itemId'] = (int) $data['itemId']; 
			$data['created'] = new MongoDate(); 
			try {
				$mongoCollectionObj->insert($data, true);
			}
			catch (Exception $e) { 
				return ;
			}
		 }
	}

	public function add_user_recent_activity($data) {
		$this->connect('meritnation');
		if(is_object($this->_db)) {
			$data['uri'] = $_SERVER['REQUEST_URI'];
			$mongoCollectionObj=$this->_db->selectCollection('users_recent_activity');
			try {
				///$data1 = $data;
				$data['userId'] = (int) $data['userId'];
				$mongoCollectionObj->insert($data, true);
				$mid = $data['_id'];
				if ($this->config['set_string_id'] && !empty($data['_id']) && is_object($data['_id'])) {
					$data['_id'] = $data['_id']->__toString();
				}
				//pr($data['_id']);
				
				//$mobj = new MongoId($data['_id']);
				//$data1['refobjId'] = $mobj;
				//$mongoCollectionObj = $this->_db->selectCollection('object_test');
				///$mongoCollectionObj->insert($data1, true);
				//var_dump($mobj);
			}
			catch (Exception $e) { 
				return ;
			}
		}
	}

	public function get_recent_activity() {
		$recentActivity = array();
		$this->connect('meritnation');
        if(is_object($this->_db)) {
			$mongoCollectionObj = $this->_db->selectCollection('users_recent_activity');
			$result = $mongoCollectionObj->find()->sort(array('created'=>-1));
			
			while ($result->hasNext()) {
				$mongodata = $result->getNext();
				
				if ($this->config['set_string_id'] && !empty($mongodata['_id']) && is_object($mongodata['_id'])) {
					$mongodata['_id'] = $mongodata['_id']->__toString();
				}
				if(strpos($mongodata['_id'],'?'))
					$mongodata['_id'] = substr($mongodata['_id'],0,strpos($mongodata['_id'],'?'));

				$recentActivity[] = $mongodata;
			}
		}
		return $recentActivity;
	}

	public function add_activity_comment($commentDetail) {
		$this->connect('meritnation');
		if(is_object($this->_db)) {
			$mongoCollectionObj = $this->_db->selectCollection('network_update_comments');
			try {
				$commentDetail['userId'] = (int) $commentDetail['userId'];
				$commentDetail['networkUpdateObjId'] = new MongoId ($commentDetail['networkUpdateObjId']);
				$commentDetail['created'] = new MongoDate(); 
				$mongoCollectionObj->insert($commentDetail, true);
				return true;
			}
			catch (Exception $e) { 
				return false;
			}
		}
	}

	public function getData2($table=null, $conditions=null, $fields=null, $resulType=null,$order=null,$limit=null,$page=1){	
        $this->connect();
        if(!is_null($table)){
            if(is_null($conditions)) {
                if(is_null($fields) && is_null($order) && is_null($limit))
                    $result = $this->_db->selectCollection($table)->find();
                elseif(is_null($fields) && is_null($limit) && !is_null($order))
                    $result = $this->_db->selectCollection($table)->find()->sort($order);
                elseif(is_null($fields) && is_null($order) && !is_null($limit)) {
					$skip = ($page-1)*$limit;
                    $result = $this->_db->selectCollection($table)->find()->limit($limit)->skip($skip);
				}elseif(is_null($fields) && !is_null($order) && !is_null($limit)) {
					$skip = ($page-1)*$limit;
                    $result = $this->_db->selectCollection($table)->find()->sort($order)->limit($limit)->skip($skip);
				}elseif(!is_null($fields) && !is_null($order) && !is_null($limit)) {
					$skip = ($page-1)*$limit;
                    $result = $this->_db->selectCollection($table)->find($conditions,$fields)->sort($order)->limit($limit)->skip($skip);
				}elseif(!is_null($fields) && !is_null($order))
                    $result = $this->_db->selectCollection($table)->find($conditions,$fields)->sort($order);
                else
                    $result = $this->_db->selectCollection($table)->find($conditions,$fields);
            }else {
                if(is_null($fields) && is_null($order))
                    $result = $this->_db->selectCollection($table)->find($conditions);
                elseif(is_null($fields) && is_null($limit) && !is_null($order))
                    $result = $this->_db->selectCollection($table)->find($conditions)->sort($order);
                elseif(is_null($fields) && is_null($order) && !is_null($limit)) {
					$skip = ($page-1)*$limit;
                    $result = $this->_db->selectCollection($table)->find($conditions)->limit($limit)->skip($skip);
				}elseif(is_null($fields) && !is_null($order) && !is_null($limit)) {
					$skip = ($page-1)*$limit;
                    $result = $this->_db->selectCollection($table)->find($conditions)->sort($order)->limit($limit)->skip($skip);
				}elseif(!is_null($fields) && !is_null($order) && !is_null($limit)) {
					$skip = ($page-1)*$limit;
                    $result = $this->_db->selectCollection($table)->find($conditions,$fields)->sort($order)->limit($limit)->skip($skip);
				}elseif(!is_null($fields)  && !is_null($order))
                    $result = $this->_db->selectCollection($table)->find($conditions,$fields)->sort($order);
                else
                    $result = $this->_db->selectCollection($table)->find($conditions,$fields);
            }
            
            if($resulType=='count'){
                return $result->count();
            }
            $results = null;
            while ($result->hasNext()) {
                $mongodata = $result->getNext();
                if ($this->config['set_string_id'] && !empty($mongodata['_id']) && is_object($mongodata['_id'])) {
                    $mongodata['_id'] = $mongodata['_id']->__toString();
                }
                
            if($resulType=='first'){
                $results = $mongodata;
                break;
            }else
                $results[] = $mongodata;
            }
            
            return $results;
        }
        return false;
    }

	public function user_activity_report($conditions) {
		$this->connect('meritnation');
		$results = null;
		$map = new MongoCode("function(){".
			"var initial={MCQ:0, QA:0, LP:0, NCERT:0,PUZ:0, RN:0, FAT:0};".
			"if(this.type== 'CHPAPERQ' || this.type== 'CHPAPERS' || this.type== 'TEXTPAPERQ' || this.type== 'TEXTPAPERS' || this.type==3 || this.type==4 || this.type==5 || this.type==6)".
			"	initial.QA=1;".
			"else if(this.type== 'CHTEST' || this.type== 'TXBTEST' || this.type==7 || this.type==8)".
			"	initial.MCQ=1;".
			"else if(this.type== 'LP' || this.type==2)".
			"	initial.LP=1;".
			"else if(this.type== 'NCERT' || this.type==1)".
			"	initial.NCERT=1;".
			"else if(this.type== 'PUZZLE' || this.type==9)".
			"	initial.PUZ=1;".
			"else if(this.type== 'RN' || this.type==10)".
			"	initial.RN=1;".
			"else if(this.type== 'FAT' || this.type==11)".
			"	initial.FAT=1;".
			"else".
			"	initial.FAT=1;".
			"emit(this.userId,initial); ".
		"}");
		$reduce = new MongoCode("function(key, values) {".
			"var total={MCQ:0, QA:0, LP:0, NCERT:0,PUZ:0, RN:0, FAT:0};".
			"for (var i in values) {".
			"	total.MCQ += values[i].MCQ;".
			"	total.QA += values[i].QA;".
			"	total.LP += values[i].LP;".
			"	total.NCERT += values[i].NCERT;".
			"	total.PUZ += values[i].PUZ;".
			"	total.RN += values[i].RN;".
			"	total.FAT += values[i].FAT;".
		   "}".
		   "return total;".
		 "}");

		$report = $this->_db->command(array(
			"mapreduce" => "track_users_activity", 
			"map" => $map,
			"reduce" => $reduce,
			"query" => $conditions));
		sleep(5);
		if(isset($report['result'])){
			$users = $this->_db->selectCollection($report['result'])->find();
			foreach ($users as $user) {
				$results[$user['_id']]=$user['value'];
			}
		}
		return $results;
	}

	public function map_reduce_user_activity_report($conditions,$collectionName) {
		$this->connect('meritnation');
		$results = null;
		$map = new MongoCode("function(){".
			"var initial={MCQ:0, QA:0, LP:0, NCERT:0,PUZ:0, RN:0, FAT:0};".
			"if(this.type== 'CHPAPERQ' || this.type== 'CHPAPERS' || this.type== 'TEXTPAPERQ' || this.type== 'TEXTPAPERS' || this.type==3 || this.type==4 || this.type==5 || this.type==6)".
			"	initial.QA=1;".
			"else if(this.type== 'CHTEST' || this.type== 'TXBTEST' || this.type==7 || this.type==8)".
			"	initial.MCQ=1;".
			"else if(this.type== 'LP' || this.type==2)".
			"	initial.LP=1;".
			"else if(this.type== 'NCERT' || this.type==1)".
			"	initial.NCERT=1;".
			"else if(this.type== 'PUZZLE' || this.type==9)".
			"	initial.PUZ=1;".
			"else if(this.type== 'RN' || this.type==10)".
			"	initial.RN=1;".
			"else if(this.type== 'FAT' || this.type==11)".
			"	initial.FAT=1;".
			"else".
			"	initial.FAT=1;".
			"emit(this.userId,initial); ".
		"}");
		$reduce = new MongoCode("function(key, values) {".
			"var total={MCQ:0, QA:0, LP:0, NCERT:0,PUZ:0, RN:0, FAT:0};".
			"for (var i in values) {".
			"	total.MCQ += values[i].MCQ;".
			"	total.QA += values[i].QA;".
			"	total.LP += values[i].LP;".
			"	total.NCERT += values[i].NCERT;".
			"	total.PUZ += values[i].PUZ;".
			"	total.RN += values[i].RN;".
			"	total.FAT += values[i].FAT;".
		   "}".
		   "return total;".
		 "}");

		$report = $this->_db->command(array(
			"mapreduce" => "track_users_activity", 
			"map" => $map,
			"reduce" => $reduce,
			"out" => $collectionName,
			"query" => $conditions));
		
		return true;
	}


	public function user_activity_data($collection){
		$this->connect('meritnation');
		$results = null;
		if(is_object($this->_db)) {
			$users = $this->_db->selectCollection($collection)->find();
			foreach ($users as $user) {
				$results[$user['_id']]=$user['value'];
			}
		}
		return $results;
	}


   function network_updates($data){

       $this->connect('meritnation');
        if(is_object($this->_db)) {
		    try {
               $mongoCollectionObj=$this->_db->selectCollection('item_description');
               $mongoCollectionObj->save($data);
			}
			catch (Exception $e) {
				return ;
			}
		 }
	}
 


	public function dropCollection($collection) {
		$this->connect('meritnation');
		$results = null;
		if(is_object($this->_db)) {
			$this->_db->selectCollection($collection)->drop();
		}
    }

	public function save_invoice_breakup($data,$bookingid=null) {
		$this->connect('meritnation');
        if(is_object($this->_db)) {
		    try {
				$mongoCollectionObj=$this->_db->selectCollection('invoice_monthly_breakup');
				if(is_null($bookingid)) {
					if(isset($data['refunds']))
						unset($data['refunds']);
					$mongoCollectionObj->save($data);
				}else {
					$mongoCollectionObj->update(array('bookingId'=>$bookingid),array('$set'=>array('monthlyBreakup'=>$data)));
				}
			}
			catch (Exception $e) {
				return ;
			}
		 }
	}*/

	public function testpro_save($table,$data){

       $this->connect('meritnation');
        if(is_object($this->_db)) {
		    try {
               $mongoCollectionObj=$this->_db->selectCollection($table);
               $mongoCollectionObj->save($data);
			}
			catch (Exception $e) {
				return ;
			}
		 }
	}
	public function testpro_find($table){
		$this->connect('meritnation');
        if(is_object($this->_db)) {
		    try {
               $mongoCollectionObj=$this->_db->selectCollection($table);
			   $result = $mongoCollectionObj->find();
			   $records=array();
				while ($result->hasNext()) {
					$mongodata = $result->getNext();	
					
					$records[] = $mongodata;
				}			  
			   return  $records;
			}
			catch (Exception $e) {
				return array();
			}
		 }
	}

	public function testpro_update($table,$rId){
		$this->connect('meritnation');
        if(is_object($this->_db)) {
		    try {
               $mongoCollectionObj=$this->_db->selectCollection($table);
               $mongoCollectionObj->update(array('_id'=>$rId),array('$set'=>array('status'=>'1')));
			}
			catch (Exception $e) {
				return ;
			}
		 }
	}

}
?>
