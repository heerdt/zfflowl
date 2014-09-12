<?php

class Sebold_Db_Adapter
{
	
     /**
     * retorna sempre o db adapter
     *
     * @return Zend_Db_Adapter_Abstract
     */
    public static function get($database = 'portal')
    {
        return Zend_Registry::get('db')->getDb($database);
    }
    
	/**
     * retorna sempre um novo select com o db adapter
     *
     * @return Zend_Db_Select
     */
    public static function getSelect($database = 'portal')
    {
        $select = new Zend_Db_Select(self::get($database));
        
        return $select;
    }
    
}