<?php

class Default_Model_Cliente
{
	
	public static function fetchAll()
	{
		$select = Sebold_Db_Adapter::getSelect()
			->from('cliente')
			->order('var_nome ASC');
		$rowset = Sebold_Db_Adapter::get()->fetchAll($select);
		
		return $rowset;
	}

	public static function fetchAllPairs()
	{
		$select = Sebold_Db_Adapter::getSelect()
			->from('cliente',array(
				'cliente_id',
				'var_nome'
			))
			->order('var_nome ASC');
		$rowset = Sebold_Db_Adapter::get()->fetchPairs($select);
		
		return $rowset;
	}
	
	public static function fetchRowByToken($token)
	{
		$select = Sebold_Db_Adapter::getSelect()
			->from('cliente')
			->where('var_tokencliente = ?',$token);
		$row    = Sebold_Db_Adapter::get()->fetchRow($select);
		
		return $row;
	}
	
}