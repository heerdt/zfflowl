<?php

class Default_Model_ServiceGoogleAlerts
{
    
    public static function fetchAll()
    {
    	$select = Sebold_Db_Adapter::getSelect()
    	->from('site_imagem')
    	->order('int_ordem ASC');
    	$rowset = Sebold_Db_Adapter::get()->fetchAll($select);
    	
    	return $rowset;
    }
    
}