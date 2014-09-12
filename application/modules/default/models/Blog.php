<?php

class Default_Model_Blog
{
    
    public static function fetchAllToHome() {
		$select = Sebold_Db_Adapter::getSelect()
			->from('blog_posts')
			->join('blog_postmeta', 
				'blog_posts.ID = blog_postmeta.post_id AND 
				blog_postmeta.meta_key = \'home_site\' AND 
				blog_postmeta.meta_value != \'\'', array())
			->where('post_status = ?','publish')
			->where('post_type = ?','post')
			->group('blog_posts.ID')
			->order('post_date DESC')
			->limit(2);
		$rowset    = Sebold_Db_Adapter::get()->fetchAll($select);
		
		foreach ($rowset as $keyRow => $row) {
    		if ($row) {
    		    $row['thumb'] = Default_Model_Blog::fetchThumbByPost($row['ID']);
    		}
	        $row['thumb'] = 'http://lezalez.com/blog/wp-content/uploads/' . $row['thumb'];
    		if (!strpos($row['thumb'], '.jpg')) {
    		    $row['thumb'] .= '.jpg';
    		}
    		$selectTag = Sebold_Db_Adapter::getSelect()
    			->from('blog_term_relationships',null)
    			->join('blog_term_taxonomy', 
    				   'blog_term_taxonomy.term_taxonomy_id = blog_term_relationships.term_taxonomy_id AND ' .
    			       'blog_term_taxonomy.taxonomy = \'post_tag\'',null)
    			->join('blog_terms', 
    				   'blog_terms.term_id = blog_term_taxonomy.term_id')
    			->where('object_id = ?',$row['ID']);
    		$tagRowset    = Sebold_Db_Adapter::get()->fetchAll($selectTag);
    		
    		foreach ($tagRowset as $key => $tagRow) {
    		    $tagRow['name'] = utf8_encode($tagRow['name']);
    		    $tagRowset[$key] = $tagRow;
    		}
    		
    		$row['tags'] = $tagRowset;
    		
    		$rowset[$keyRow] = $row;
		}
		
		return $rowset;
        
    }
	
	public static function fetchAll()
	{
		$select = Sebold_Db_Adapter::getSelect()
			->from('blog_blogs')
			->where('blog_id != 1')
			->where('public   = ?','1')
			->where('archived = ?','0')
			->where('mature   = ?','0')
			->where('spam     = ?','0')
			->where('deleted  = ?','0')
			->order('path ASC');
		$rowset = Sebold_Db_Adapter::get()->fetchAll($select);
	
	    foreach ($rowset as $key => $row) {
	        $row['blog_name'] = Default_Model_Blog::fetchBlogOption($row['blog_id'], 'blogname');
	        $row['last_post'] = Default_Model_Blog::fetchLastPostByBlog($row['blog_id']);
	        $row['last_post']['thumb'] = 'http://' . 
	                                     $row['domain'] .
	                                     $row['path'] .
	                                     'files/' . $row['last_post']['thumb'];
	        $rowset[$key] = $row;
	    }
	    
		
		return $rowset;
	}
	
	public static function fetchLastPostByBlog($id) {
		$select = Sebold_Db_Adapter::getSelect()
			->from('blog_' . $id . '_posts')
			->where('post_status = ?','publish')
			->order('post_date DESC')
			->limit(1);
		$row    = Sebold_Db_Adapter::get()->fetchRow($select);
		
		if ($row) {
		    $row['thumb'] = Default_Model_Blog::fetchThumbByPost($id, $row['ID']);
		}
		
		$selectTag = Sebold_Db_Adapter::getSelect()
			->from('blog_' . $id . '_term_relationships',null)
			->join('blog_' . $id . '_term_taxonomy', 
				   'blog_' . $id . '_term_taxonomy.term_taxonomy_id = blog_' . $id . '_term_relationships.term_taxonomy_id AND ' .
			       'blog_' . $id . '_term_taxonomy.taxonomy = \'post_tag\'',null)
			->join('blog_' . $id . '_terms', 
				   'blog_' . $id . '_terms.term_id = blog_' . $id . '_term_taxonomy.term_id')
			->where('object_id = ?',$row['ID']);
		$tagRowset    = Sebold_Db_Adapter::get()->fetchAll($selectTag);
		
		foreach ($tagRowset as $key => $tagRow) {
		    $tagRow['name'] = utf8_encode($tagRow['name']);
		    $tagRowset[$key] = $tagRow;
		}
		
		$row['tags'] = $tagRowset;
		
		return $row;
	}
	
	public static function fetchThumbByPost($id) {
		$select = Sebold_Db_Adapter::getSelect()
			->from('blog_postmeta')
			->where('post_id = ?',$id)
			->where('meta_key = ?','_thumbnail_id')
			->limit(1);
			echo $select;
		$row    = Sebold_Db_Adapter::get()->fetchRow($select);
		
		if (!$row) {
		    return false;
		}
		
		$selectFile = Sebold_Db_Adapter::getSelect()
			->from('blog_postmeta')
			->where('post_id = ?',$row['meta_value'])
			->where('meta_key = ?','_wp_attached_file')
			->limit(1);
		$fileRow    = Sebold_Db_Adapter::get()->fetchRow($selectFile);
	
		if (!$fileRow) {
		    return false;
		}
		
		$selectSizeFile = Sebold_Db_Adapter::getSelect()
			->from('blog_postmeta')
			->where('post_id = ?',$row['meta_value'])
			->where('meta_key = ?','_wp_attachment_metadata')
			->limit(1);
		$fileSizeRow    = Sebold_Db_Adapter::get()->fetchRow($selectSizeFile);
		$fileSizeRow    = unserialize($fileSizeRow['meta_value']);
		
		$nome = substr($fileSizeRow['sizes']['post-thumbnail']['file'], strrpos($fileSizeRow['sizes']['post-thumbnail']['file'], '-'));
		$nome = str_replace('.jpg',$nome , $fileSizeRow['file']);
		
		return $nome;
	}
	
	public function fetchBlogOption($blog_id,$key) {
		$select = Sebold_Db_Adapter::getSelect()
			->from('blog_' . $blog_id . '_options')
			->where('blog_id = ?',0)
			->where('option_name = ?',$key)
			->limit(1);
		$row    = Sebold_Db_Adapter::get()->fetchRow($select);
		
		return $row['option_value'];
	}
	
}