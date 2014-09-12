<?php

/**
 * Error controller
 *
 * @uses       Zend_Controller_Action
 * @package    QuickStart
 * @subpackage Controller
 */
class ErrorController extends Zend_Controller_Action
{
    /**
     * errorAction() is the action that will be called by the "ErrorHandler" 
     * plugin.  When an error/exception has been encountered
     * in a ZF MVC application (assuming the ErrorHandler has not been disabled
     * in your bootstrap) - the Errorhandler will set the next dispatchable 
     * action to come here.  This is the "default" module, "error" controller, 
     * specifically, the "error" action.  These options are configurable, see 
     * {@link http://framework.zend.com/manual/en/zend.controller.plugins.html#zend.controller.plugins.standar
     *
     * @return void
     */
    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');
        
        echo '<pre>';
        echo $errors->exception;
        exit;
        if (APPLICATION_ENV != 'production' && APPLICATION_ENV != 'staging') {
	        echo '<pre>';
	        echo $errors->exception;
	        exit;
        }
    	$this->getHelper('Redirector')->gotoRoute(array(),'default-index');
    
        
        switch ($errors->type) { 
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                $this->getResponse()->setRawHeader('HTTP/1.1 500 Internal Server Error') ;
                break;
        	default:
                $this->getResponse()->setRawHeader('HTTP/1.1 500 Internal Server Error') ;
                break;
            
        }
        
        
        $this->view->exception = $errors->exception;
        $this->view->request   = $errors->request;
        $this->view->analyticsKey = '/error/' . $_SERVER['HTTP_HOST'] .  $_SERVER['REQUEST_URI'];
    }
}
