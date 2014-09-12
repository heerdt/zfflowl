<?php

class Default_Model_Colecao
{
	
	public static function fetchAll()
	{
		$select = Sebold_Db_Adapter::getSelect()
			->from('site_colecao')
			->order('int_ordem ASC');
		$rowset = Sebold_Db_Adapter::get()->fetchAll($select);
	
		foreach ($rowset as $key => $row) {
		    $rowset[$key]['imagem_colecao'] = Default_Model_Imagem::fetchAllByKey('site-colecao-' . $row['colecao_id']);
		    
		    if ($row['txt_descricao']) {
		        $stillKeys = explode("\n",$row['txt_descricao']);
		        $stillRowset = array();
		        foreach ($stillKeys as $stillKey) {
		            $stillKey = trim(str_replace("\r", '', $stillKey));
		            $stillRow = Default_Model_Imagem::fetchRowByTitulo($stillKey);
		            if ($stillRow) {
		                $stillRowset[] = $stillRow;
		            }
		        }
		        $rowset[$key]['imagem_still'] = $stillRowset;
		    }
		}
		
		return $rowset;
	}
	
	public static function fetchAllByEstacao($estacao)
	{
		$select = Sebold_Db_Adapter::getSelect()
			->from('site_colecao')
			->where('colecaoestacao_id = ?',$estacao)
			->order('int_ordem ASC');
		
		$rowset = Sebold_Db_Adapter::get()->fetchAll($select);
		
		foreach ($rowset as $key => $row) {
		    $rowset[$key]['imagem_colecao'] = Default_Model_Imagem::fetchAllByKey('site-colecao-' . $row['colecao_id']);
		}
		
		return $rowset;
	}
	
	public static function fetchRowByChave($chave,$estacao)
	{
		$select = Sebold_Db_Adapter::getSelect()
			->from('site_colecao')
			->where('var_chave = ?',$chave)
			->where('colecaoestacao_id = ?',$estacao)
			->order('int_ordem ASC');
		$row    = Sebold_Db_Adapter::get()->fetchRow($select);
	    $row['imagem_colecao'] = Default_Model_Imagem::fetchAllByKey('site-colecao-' . $row['colecao_id']);
	
	    return $row;
	}
	
}