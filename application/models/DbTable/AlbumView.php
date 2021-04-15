<?php

class Application_Model_DbTable_AlbumView extends Zend_Db_Table_Abstract
{

    protected $_name = 'AlbumView';
    public $_primary = 'id';

    public function getAlbumView($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();
    }
}
