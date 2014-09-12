<?php

class Default_Model_Imagem
{
	
	public static function fetchAll()
	{
		$select = Sebold_Db_Adapter::getSelect()
			->from('site_imagem')
			->order('int_ordem ASC');
		$rowset = Sebold_Db_Adapter::get()->fetchAll($select);
		
		return $rowset;
	}
	
	public static function fetchAllByKey($key)
	{
		$select = Sebold_Db_Adapter::getSelect()
			->from('site_imagem')
			->where('var_key = ?',$key)
			->order('int_ordem ASC');
		$rowset = Sebold_Db_Adapter::get()->fetchAll($select);
		
		return $rowset;
	}
	
	public static function fetchAllByKeyTitulo($key)
	{
		$select = Sebold_Db_Adapter::getSelect()
			->from('site_imagem')
			->where('var_key = ?',$key)
			->where('var_titulo NOT LIKE ?','%C')
			->order('int_ordem ASC');
		$rowset = Sebold_Db_Adapter::get()->fetchAll($select);
		
		return $rowset;
	}
	
	public static function fetchAllByKeyTituloEstacao($key)
	{
		$select = Sebold_Db_Adapter::getSelect()
			->from('site_imagem')
			->where('imagem_id > 515')
			->where('var_key = ?',$key)
			->where('var_titulo NOT LIKE ?','%C')
			->order('int_ordem ASC');
		$rowset = Sebold_Db_Adapter::get()->fetchAll($select);
		
		return $rowset;
	}
	
	public static function fetchAllByTipo($tipo)
	{
		$select = Sebold_Db_Adapter::getSelect()
			->from('site_imagem')
			->where('enu_tipo = ?',$tipo)
			->order('int_ordem ASC');
		$rowset = Sebold_Db_Adapter::get()->fetchAll($select);
		
		return $rowset;
	}
    
	public static function fetchRowByOrdem($key,$ordem)
	{
		$select = Sebold_Db_Adapter::getSelect()
			->from('site_imagem')
			->where('var_key = ?',$key)
			->where('int_ordem = ?',$ordem);
		$row    = Sebold_Db_Adapter::get()->fetchRow($select);
		
		return $row;
	}
    
	public static function fetchRowById($id)
	{
		$select = Sebold_Db_Adapter::getSelect()
			->from('site_imagem')
			->where('imagem_id = ?',$id);
		$row    = Sebold_Db_Adapter::get()->fetchRow($select);
		
		return $row;
	}
    
	public static function fetchRowByTitulo($id)
	{
		$select = Sebold_Db_Adapter::getSelect()
			->from('site_imagem')
			->where('var_titulo = ?',$id);
		$row    = Sebold_Db_Adapter::get()->fetchRow($select);
		
		return $row;
	}
    
	public function fetchRowByKey($key)
	{
		$select = Sebold_Db_Adapter::getSelect()
			->from('site_imagem')
			->where('var_key = ?',$key)
			->order('int_ordem ASC');
		$row    = Sebold_Db_Adapter::get()->fetchRow($select);
		
		return $row;
	}
	
}