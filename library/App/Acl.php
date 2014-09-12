<?php

class App_Acl extends Zend_Acl 
{
	
	public function __construct(Zend_Auth $auth)
	{
		// $this->add(new Zend_Acl_Resource('default'));
		// $this->add(new Zend_Acl_Resource('qg'));
		// $this->add(new Zend_Acl_Resource('painel'));
		// $this->add(new Zend_Acl_Resource('index'));
		// $this->add(new Zend_Acl_Resource('boletos'));
		// $this->add(new Zend_Acl_Resource('sigep'));
		// $this->add(new Zend_Acl_Resource('look'));
		// $this->add(new Zend_Acl_Resource('site-imagem'));
		// $this->add(new Zend_Acl_Resource('look-categoria'));
		// $this->add(new Zend_Acl_Resource('produtos'));
		// $this->add(new Zend_Acl_Resource('qg-perfil'));
		// $this->add(new Zend_Acl_Resource('pedido'));
		// $this->add(new Zend_Acl_Resource('qg-module'));
		// $this->add(new Zend_Acl_Resource('qg-permissao'));
	
		// $roleG = new Zend_Acl_Role('guest');
		// $roleN = new Zend_Acl_Role('user','guest');
		// $roleA = new Zend_Acl_Role('admin','user');

		// $this->addRole( $roleG  );
  //       $this->addRole( $roleN , $roleG );
  //       $this->addRole( $roleA, $roleN  );
		
		// // Guest
		// $this->deny('*');
		// $this->deny('guest','default');
		// $this->deny('guest','index');
		
		// // Qg
		// $this->allow('user','qg');
		// $this->allow('user','sigep');
		// $this->allow('admin','qg','sigep');
		// $this->allow('admin','pedido');
		// $this->allow('admin','sigep');
		// $this->allow('admin','produtos');
		// $this->allow('admin','qg-module');
		// $this->allow('admin','qg-permissao');
		// $this->allow('admin','qg-perfil');
		// $this->allow('admin',array('painel','boletos','look','site-imagem','look-categoria'));
	}
	
}