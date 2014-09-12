<?php

abstract class App_Controller_Rest extends Zend_Rest_Controller {

    public function init()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
    }

    public function preDispatch() {

        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();

        $request        = Zend_Controller_Front::getInstance()->getRequest();
        $this->output   = null;


        $this->data = array();
        $this->data['module']   = $request->getModuleName();
        $this->data['controller'] = $request->getControllerName();
        $this->data['action']   = $request->getActionName();
    }


    public function postDispatch() {

        header('Content-type: text/json');
        header('Content-type: application/json');

        echo json_encode(array('data' => $this->output, 'config' => $this->data));
        exit;
    }
    
    public function indexAction()
    {

    }
    public function getAction()
    {
    }
    
    public function postAction()
    {
    }
    
    public function putAction()
    {
    }
    
    public function deleteAction()
    {
    }

}