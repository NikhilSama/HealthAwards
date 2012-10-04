<?php
class Paging extends AppModel
{
    public $useTable = false;

	function paginate($conditions=null, $fields=null, $order=null, $limit=null, $page = 1, $recursive = null) {
		if(is_null($conditions) || !count($conditions))
			return;
		$sql = $conditions[0];
		if(is_numeric($sql)) 
			return;
		if($page>0)
		$from=($page-1)*$limit;
		else
		$from=($page)*$limit;
		
		if(!is_null($limit) || $limit !='')
			$sql .= " LIMIT " . $from . ",". $limit;
		 return $this->query($sql);

	}

	function paginateCount($conditions = null, $recursive = 0) {
		if(is_null($conditions) || !count($conditions))
			return;
		$sql = $conditions[0];
		if(is_numeric($sql)) // Using sphinx search it will return number of total result
			return $sql;
		$sql = str_replace("\r\n", " ", $sql);
		$sql = str_replace("\n", " ", $sql);
		$sql = str_replace("\r", " ", $sql);
		$sql = str_replace("\t", " ", $sql);
		$sql = stripslashes($sql);
		$fromPos = stripos($sql,' from');
		if($fromPos) {
			$sql = str_replace(substr($sql,0,$fromPos),'select count(1) total ',$sql);
			
			$tempPos = strripos($sql,'order by');
			if($tempPos)
				$sql = substr($sql,0,$tempPos);

			$toPos = strripos($sql,'group by');
			
			$rs = $this->query($sql);
			if($toPos){
				$count =count($rs);
			}else{
				$count = $rs[0][0]['total'];
			}			
		}else{
			$results = $this->query($sql);
			$count = count($results);
		}
		return $count;
	}
	public function excuteProcedure($query){
		$obj = new DATABASE_CONFIG();
		$databaseObj = $obj->default;
		$resultArr=array();
		$i=1;
		$con = mysqli_connect($databaseObj['host'],$databaseObj['login'],$databaseObj['password']);
		$con->select_db($databaseObj['database']);

		$con->multi_query($query);
		while($result= $con->store_result()){
			
			while($row=$result->fetch_array()){
				$resultArr[$i][] = $row;
			}
			$result->close();
			$con->next_result();
			$i++;
		}
		$con->close();
		return $resultArr;
	}
}
?>