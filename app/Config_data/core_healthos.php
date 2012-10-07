<?php
/**
	* healthos customized cofiguration file
 */
 /**
 * Customized constant
 */
    define('RESTRICT_ACTIVATION',false);
	define('CONCAT_CODE', 'app1234#');
	
	define('HEALTHOS_VALID_EMAIL', "/^[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[a-z]{2,4}|museum|travel)$/i");

	define('HEALTHOS_VALID_MOBILENUMBER', "/^[0-9-()+ ]{10,15}$/");
	
	define('HEALTHOS_VALID_PHONENUMBER', "/^[0-9-()+ ]{6,20}$/");
	define('HEALTHOS_VALID_PIN', "/^[0-9]{6,10}$/");
    /* seo related ****************************************************/
    define('SEO_PAGE_TITLE_PREFIX', 'Healthos.com - ');              /* prefix for all pages */
    define('SEO_SITE_KEYWORDS', 'healthos, healthos.com');       /* site-wide keywords */
    define('LOGOUT_URL', '/users/logout');       /* site-wide keywords */
	
	 
     /**
     * Set level of Encryption and Decryption.
     *
     * '0': Encryption/Decryption will be temporarily disabled. URLs will show IDs in numbers (readable)
     * '1': Turns Encryption back on.
     */
    define('HO_ENABLE_ENCRYPTION', '1');

	/**
	* string for bad words 
	*/
	define('HO_RESTRICTED_WORDS','/bastard|dumb|bitch|fuck|stupid|pagal|sex|sexy|fool|fools|fucking|damn|duffer|foolish|crazy|donkey|gadha|gadhe|saala|saale|baap|aalsi|alsi|kutta|idiot|mad|shit|bullshit|penis/');

    /**
    * variable to use updated css
    */    
    define('HO_CSS_VERSION','08092010');  
	define('HO_JS_VERSION','08092010');
     /**
     *  SMTP Options 
    */ 
    define('HO_SMTP_MAIL',"port=25,timeout=30,host=192.168.1.100,username=arun@HEALTHOS.com,password=pan7629#");          
    define('DEBUG', 1);      
	define('HEALTHOS_EMAIL',serialize(array('noreply@healthos.com'=>'Healthos'))); 
    define('INCREMENT_MOBILENUMBER', "/^((12345678)||(01234567)||(98765432)||(0987654321))[0-9]{2,7}$/");
    define('REPEATED_MOBILENUMBER', '/(.)\\1{7}/');
	define('DAYS_NAME',serialize(array(1=>'Monday',2=>'Tuesday',3=>'Wednessday',4=>'Th',5=>'Friday',6=>'Sa',7=>'Sunday'))); 
	
?>