<?php

class Application_Views_Helpers_baseUrl extends Zend_View_Helper_Abstract
{

    public function baseUrl()
    {
        return Zend_Controller_Front::getInstance()->getBaseUrl();
    }

}