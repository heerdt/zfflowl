<?php

class Default_Model_ServiceGoogleAlerts_Entry
{
    
    public static function fetchAll()
    {
    	$select = Sebold_Db_Adapter::getSelect()
    	->from('site_imagem')
    	->order('int_ordem ASC');
    	$rowset = Sebold_Db_Adapter::get()->fetchAll($select);
    	
    	return $rowset;
    }
    
    public function fetchRowByEntryId($feedId,$entryId)
    {
    	$select = Sebold_Db_Adapter::getSelect()
	    	->from('service_googlealerts_entry')
	    	->where('feed_id = ?', $feedId)
	    	->where('var_id = ?', $entryId);
    	$row    = Sebold_Db_Adapter::get()->fetchRow($select);
    	
    	return $row;
    }
    
    public function insert($feedId,$entry)
    {
    	if (!Default_Model_ServiceGoogleAlerts_Entry::fetchRowByEntryId($feedId,$entry->getId())) {
    		$dateModified = new Zend_Date($entry->getDateModified());
    		$datePublished = new Zend_Date($entry->getDateCreated());
    		
    		Sebold_Db_Adapter::get()->insert('service_googlealerts_entry', array(
    			'feed_id'       => $feedId,
    			'var_id'        => $entry->getId(),
    			'var_title'     => $entry->getTitle(),
    			'tms_published'   => $datePublished->toString('YYYY-MM-dd HH:mm:ss'),
    			'tms_updated'   => $dateModified->toString('YYYY-MM-dd HH:mm:ss'),
    			'txt_content'   => $entry->getContent(),
    			'var_author'    => implode(',',$entry->getAuthor()),
    			'txt_url'    => $entry->getLink()
    		));
    	}
    }
    
}