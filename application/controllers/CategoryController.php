<?php

class CategoryController extends Zend_Controller_Action
{

    public function init()
    {
    }

    public function categoryAction()
    {
        $category = new Application_Model_DbTable_Category();
        $this->view->category = $category->fetchAll();
    }

    public function submitAction()
    {
        if ($_REQUEST['id'] == NULL) {
            $category = $_REQUEST['Categoryname'];
            if ($category != "") {
                $Category = new Application_Model_DbTable_Category();
                $Category->addCategory($category);
                $this->_helper->redirector('category');
            }
        } else {
            $id = $_REQUEST['id'];
            $category = $_REQUEST['Categoryname'];
            if ($category != "") {
                $Category = new Application_Model_DbTable_Category();
                $Category->updateCategory($id, $category);
                $this->_helper->redirector('category');
            }
        }
    }

    public function deleteAction()
    {


        $id = $this->getRequest()->getParam('id');
        $Category = new Application_Model_DbTable_Category();
        $Category->deleteCategory($id);
        $this->_helper->redirector('category');
    }

    public function getcategoryAction()
    {
        $Category = new Application_Model_DbTable_Category();
        $data = $Category->fetchAll();
        $this->_helper->json->sendjson(array('data' => $data->toArray()));
    }
}
