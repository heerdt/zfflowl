<?php

class App_Auth extends Zend_Controller_Plugin_Abstract  
{
	
    /**
     * Auth
     *
     * @return Zend_Auth
     */
	protected $_auth;
    /**
     * Acl
     *
     * @return Zend_Acl
     */
	protected $_acl; 
	
	public function __construct()
	{
		$this->_auth = Zend_Auth::getInstance();
		/*$this->_acl  = new App_Acl($this->_auth);
		Zend_Registry::set('App_Acl',$this->_acl);

		Zend_View_Helper_Navigation_HelperAbstract::setDefaultAcl($this->_acl);*/
		
	}
	  protected $_notLoggedRoute = array(
        'controller' => 'index',
        'action'     => 'login'
    );
    /**
     * @var array
     */
    protected $_forbiddenRoute = array(
        'controller' => 'error',
        'action'     => 'forbidden'
    );
	
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {

        if (!in_array($request->getModuleName(), array('qg','painel'))) {
            return;
        }

        $controller = "";
        $action     = "";
        $module     = "";
        if ( !$this->_auth->hasIdentity() ) {
            $controller = $this->_notLoggedRoute['controller'];
            $action     = $this->_notLoggedRoute['action'];
            $module     = $request->getModuleName();
        } else if ( !$this->_isAuthorized($request->getModuleName(),$request->getControllerName(),
                    $request->getActionName()) ) {

            $controller = $this->_forbiddenRoute['controller'];
            $action     = $this->_forbiddenRoute['action'];
            $module     = $request->getModuleName();
        } else {
            $controller = $request->getControllerName();
            $action     = $request->getActionName();
            $module     = $request->getModuleName();
        }
        $request->setControllerName($controller);
        $request->setActionName($action);
        $request->setModuleName($module);
    }
 
    protected function _isAuthorized($module, $controller, $action)
    {
        $role = $this->_auth->getIdentity()->getRoleId()*1;
        if ($role == 0) { $role = 1; }
        return Qg_Model_QgPermissao::getInstance()->isAllow($role,$module,$controller, $action);


        $this->_acl = Zend_Registry::get('App_Acl');
        $user = $this->_auth->getIdentity();

        if ( !$this->_acl->has( $controller ) || !$this->_acl->isAllowed( $user, $controller, $action ) )
            return false;
        return true;
    }
	
}