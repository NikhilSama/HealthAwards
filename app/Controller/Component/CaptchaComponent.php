<?php 
class CaptchaComponent extends Component
{
    function __construct(ComponentCollection $Collection, $settings = array()) {}
    
    function startup(Controller $controller)
    {
        $this->controller = $controller;
    }

    function render()
    {
        vendor('kcaptcha/kcaptcha');
        $kcaptcha = new KCAPTCHA();
        $this->controller->Session->write('captcha', $kcaptcha->getKeyString());
    }
}
?>