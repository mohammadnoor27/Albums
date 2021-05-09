<?php

class CategoryController extends Zend_Controller_Action
{

    public function categoryAction()
    {
    }

    public function submitAction()
    {
        if ($this->getRequest()->getParam('id') == NULL) {
            $category = $this->getRequest()->getParam('Categoryname');
            if ($category != "") {
                $Category = new Application_Model_DbTable_Category();
                $Category->addCategory($category);
                $msg = array();
                $msg['msg'] = "Category Added Successfull";
                $this->_helper->json->sendjson($msg);
            }
        } else {
            $id = $this->getRequest()->getParam('id');
            $category = $this->getRequest()->getParam('Categoryname');
            if ($category != "") {
                $Category = new Application_Model_DbTable_Category();
                $Category->updateCategory($id, $category);
                $msg = array();
                $msg['msg'] = "Category Edited Successfull";
                $this->_helper->json->sendjson($msg);
            }
        }
    }

    public function deleteAction()
    {


        $id = $this->getRequest()->getParam('id');
        $Category = new Application_Model_DbTable_Category();
        $Category->deleteCategory($id);
        $msg = array();
        $msg['Delete'] = "Category Deleted Successfull";
        $this->_helper->json->sendjson($msg);
    }

    public function getcategoryAction()
    {
        $Category = new Application_Model_DbTable_Category();
        $data = $Category->fetchAll();
        $this->_helper->json->sendjson(array('data' => $data->toArray()));
    }
    public function editcategoryAction()
    {
        $Category = new Application_Model_DbTable_Category();
        $id = $this->getRequest()->getParam('id');
        $this->_helper->json->sendjson($Category->fetchRow("ID = " . $id)->toArray());
    }
}
