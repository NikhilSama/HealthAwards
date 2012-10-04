<?php 

class ValidationComponent extends Component
{
    function __construct(ComponentCollection $Collection, $settings = array()) {}
    
	public function isNumeric($value) {
		if(!(is_numeric($value))) {
			return false;
		}else{
			return true;
		}
	}
    
    function matchRestrictedWords($string=null) {
            $errors = '';
            $htmltemp = strip_tags($string);
            $htmltemp = trim(str_replace('&nbsp;','',$htmltemp));
            
            $stringMaxWord = preg_split("/[\s,]+/",$htmltemp );
            foreach($stringMaxWord as $key=>$value) {
                   if(strlen($value) > 30)
                   $errors['html'] = 'Your input contain some exceptionally long words. Please edit and try again.';
            }
        
            $pattern=MN_RESTRICTED_WORDS; // We need to add '\b' at the start and end of each word for search exactly word wide . like 'bitch' word cannot mach with 'bitchy'
            $pattern= preg_replace('/^\//', '/\b',$pattern); // Add '\b' at start of first word 
            $pattern= preg_replace('/\/$/', '\b/',$pattern);// Add '\b' at end of first word 
            $pattern = str_replace('|','\b|\b',$pattern); 
            $pattern .= 'i'; // Add 'i' at end of the pattern for match word with ignore case sensetive.

            if($htmltemp=='')
                $errors['html'] = 'Please enter some text and try again.';
            elseif(preg_match($pattern,$string))
                $errors['html'] = 'Your input contains some illegal words. Please edit and try again.';
            
            return $errors;
    }
}