<?php

class Application_Model_DbTable_Albums extends Zend_Db_Table_Abstract
{

    protected $_name = 'albums';


    public function getAlbum($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();
    }

    public function addAlbum($artist, $image)
    {
        $data = array(
            'artist' => $artist,
            'image'  => $image
        );
        $ID = $this->insert($data);
        return $ID;
    }
    public function updateAlbum($id, $artist, $image)
    {
        $data = array(
            'artist' => $artist,
            'image'  => $image
        );
        $this->update($data, 'id = ' . (int)$id);
    }
    public function deleteAlbum($id)
    {
        $this->delete('id =' . (int)$id);
    }
}
