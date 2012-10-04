<?php
class SchooluserComponent extends Component {
    
    function __construct(ComponentCollection $Collection, $settings = array()) {}

	public function array_flatten(&$a,$pref='') {
	   $ret=array();
	   foreach ($a as $i => $j)
		   if (is_array($j))
			   $ret=array_merge($ret,$this->array_flatten($j,$pref.$i));
		   else
			   $ret[$pref.$i] = $j;
	   return $ret;
   }
   	
 function rec_in_array($needle, $haystack, $alsokeys=false)
    {
        if(!is_array($haystack) || empty($haystack)) return false;
        if(in_array($needle, $haystack) || ($alsokeys && in_array($needle, array_keys($haystack)) )) return true;
        else {
            foreach($haystack AS $element) {
                $ret = $this->rec_in_array($needle, $element, $alsokeys);
            }
        }
       
        return $ret;
    }
  function isaccessallowed($obj){
		$actionname = $obj->action;
  		$session = $obj->Session->read('SchoolUser');
 		if(!isset($session['adminId']))
			$obj->redirect('/admins/login');	
		$actrls=$obj->Session->read('actionforroles');
		if(($session['roleId'] !='1') && (!in_array($actionname,$this->array_flatten($actrls))))
		{
			$obj->Session->setFlash('','flash',array("prohibited Action contact admin"));			
			$obj->redirect('/admins/home');
		} 	
  }
  
  function isallowed($obj)
  {
		$actionname = $obj->action;
  		$session = $obj->Session->read('SchoolUser');
		$actrls=$obj->Session->read('actionforroles');
		if(($session['roleId'] =='1') || (in_array($actionname,$this->array_flatten($actrls))))
			return true;
		else 
			return false;	
		 	
  }  	  		
}
?>
