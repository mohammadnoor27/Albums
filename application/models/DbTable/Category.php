<?php

class Application_Model_DbTable_Category extends Zend_Db_Table_Abstract
{

    protected $_name = 'Category';


    public function getCategory($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('ID = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();
    }

    public function addCategory($Category)
    {
        $data = array(
            'Category_Name' => $Category
        );
        $this->insert($data);
    }
    public function updateCategory($id, $Category)
    {
        $data = array(
            'Category_Name' => $Category
        );
        $this->update($data, 'ID = ' . (int)$id);
    }
    public function deleteCategory($id)
    {
        $this->delete('ID =' . (int)$id);
    }
}
