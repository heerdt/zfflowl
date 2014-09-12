<?php

class Default_Model_Locale
{

	public function fetchAll()
	{
		$select = Sebold_Db_Adapter::getSelect()
			->from('site_locale')
			->where('bol_status = 1')
			->order('var_nome ASC');
		$rowset = Sebold_Db_Adapter::get()->fetchAll($select);
		
		return $rowset;
	}

	public function fetchAllPairs()
	{
		$select = Sebold_Db_Adapter::getSelect()
			->from('site_locale',array(
				'locale_id',
				'var_nome'
			))
			->where('bol_status = 1')
			->order('var_nome ASC');
		$rowset = Sebold_Db_Adapter::get()->fetchPairs($select);
		
		return $rowset;
	}
	
	public function fetchRowByChave($chave)
	{
		$select = Sebold_Db_Adapter::getSelect()
			->from('site_locale')
			->where('bol_status = 1')
			->where('var_chave = ?',$chave);
		$row    = Sebold_Db_Adapter::get()->fetchRow($select);
		
		return $row;
	}
	
}