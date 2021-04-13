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
        if (isset($_REQUEST['Add'])) {
            $category = $_REQUEST['Categoryname'];
            if ($category != "") {
                $Category = new Application_Model_DbTable_Category();
                $Category->addCategory($category);
                $this->_helper->redirector('category');
            }
        } elseif (isset($_REQUEST['Edit'])) {
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

        if (isset($_REQUEST['del'])) {
            $id = $_REQUEST['id'];
            $Category = new Application_Model_DbTable_Category();
            $Category->deleteCategory($id);
            $this->_helper->redirector('category');
        }
    }

    public function getcategoryAction()
    {
        $Category = new Application_Model_DbTable_Category();
        $data = $Category->fetchAll();
        $this->_helper->json->sendjson(array('data' => $data->toArray()));
    }
}
