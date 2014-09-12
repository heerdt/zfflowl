<?php

class RestController extends Zend_Rest_Controller {


    public function init()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
    }

    public function preDispatch() {

        $this->_helper->viewRenderer->setNoRender(true);
        $request        = Zend_Controller_Front::getInstance()->getRequest();
        $this->output   = null;

        //get registry versions
        $config         = Zend_Registry::get('config');
        $cache          = Zend_Registry::get('cache');
        $log            = Zend_Registry::get('log');
        $loggers        = Zend_Registry::get('loggers');

        //internal to the view
        $this->_config      = $config;
        $this->_cache       = $cache;
        $this->_log         = $log;

        $this->data = array();
        $this->data['module']   = $request->getModuleName();
        $this->data['controller'] = $request->getControllerName();
        $this->data['action']   = $request->getActionName();
        $this->data['loggers']  = $loggers;
    }


    public function postDispatch() {
        header('Content-type: text/json');
        header('Content-type: application/json');

        echo json_encode(array('output' => $this->output, 'data' => $this->data));
        exit;
    }


}