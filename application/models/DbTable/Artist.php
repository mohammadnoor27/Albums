<?php

class Application_Model_DbTable_Artist extends Zend_Db_Table_Abstract
{

    protected $_name = 'Artist';


    public function getArtist($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('ID = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();
    }

    public function addArtist($artist)
    {
        $data = array(
            'Artist_Name' => $artist
        );
        $this->insert($data);
    }
    public function updateArtist($id, $artist)
    {
        $data = array(
            'Artist_Name' => $artist
        );
        $this->update($data, 'ID = ' . (int)$id);
    }
    public function deleteArtist($id)
    {
        $this->delete('ID =' . (int)$id);
    }
}
