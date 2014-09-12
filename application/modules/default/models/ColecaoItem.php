<?php

class Default_Model_ColecaoItem
{

    public static function fetchRowById($id)
    {
        $row = Default_Model_Imagem::fetchRowById($id);
        
        return $row;
    }

    public static function fetchAllByStill($id)
    {
        $row = Default_Model_Imagem::fetchRowById($id);
        
        return $row;
    }
    
}