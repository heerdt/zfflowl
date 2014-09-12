<?php

class Default_Model_LocaleLanguage
{
	
	public function fetchAll()
	{
		$select = Sebold_Db_Adapter::getSelect()
			->from('site_locale')
			->order('var_nome ASC');
		$rowset = Sebold_Db_Adapter::get()->fetchAll($select);
		
		return $rowset;
	}
	
	public function fetchRowByChave($chave)
	{
		$select = Sebold_Db_Adapter::getSelect()
			->from('site_localelanguage')
			->where('var_chave = ?',$chave);
		$row    = Sebold_Db_Adapter::get()->fetchRow($select);
		
		return $row;
	}
	
	public function insert($chave,$locale=null) {
		if (self::fetchRowByChave($chave) == false) {
			$localeRow = Zend_Registry::get('Zend_Locale_Row');
			$data = array(
				'locale_id' => (!$locale ? $localeRow['locale_id'] : $locale),
				'var_chave' => $chave,
				'txt_data'  => serialize(array())
			);
			Sebold_Db_Adapter::get()->insert('site_localelanguage',$data);
		}
	}
	
}