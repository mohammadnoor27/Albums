<?php

class Application_Model_DbTable_AlbumCategory extends Zend_Db_Table_Abstract
{

    protected $_name = 'AlbumCategory';


    public function getAlbumCategory($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('ID = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();
    }

    public function addAlbumCategory($IDAlbum, $IDCategory)
    {
        $data = array(
            'IDAlbum' => $IDAlbum,
            'IDCategory' => $IDCategory,
        );
        $this->insert($data);
    }
    public function updateAlbumCategory($ID, $IDAlbum, $IDCategory)
    {
        $data = array(
            'IDAlbum' => $IDAlbum,
            'IDCategory' => $IDCategory,
        );
        $this->update($data, 'ID = ' . (int)$ID);
    }
    public function deleteAlbum($ID)
    {
        $this->delete('IDAlbum =' . (int)$ID);
    }
}
