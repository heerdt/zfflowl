<?php

class IndexController extends Zend_Controller_Action
{
	
	public function indexAction()
	{
		

		Lepard_Db_Adapter::get()->query('Select * from floowlco_1.user');

	}
	
}