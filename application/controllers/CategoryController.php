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
        if ($_POST['id'] == NULL) {
            $category = $_POST['Categoryname'];
            if ($category != "") {
                $Category = new Application_Model_DbTable_Category();
                $Category->addCategory($category);
            }
            $msg = array();
            $msg['Add'] = "Category Added Successfull";
            $this->_helper->json->sendjson($msg);
        } else {
            $id = $_POST['id'];
            $category = $_POST['Categoryname'];
            if ($category != "") {
                $Category = new Application_Model_DbTable_Category();
                $Category->updateCategory($id, $category);
            }
            $msg = array();
            $msg['Edit'] = "Category Edited Successfull";
            $this->_helper->json->sendjson($msg);
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
        $id = $_REQUEST['id'];
        $this->_helper->json->sendjson($Category->fetchRow("ID = " . $id)->toArray());
    }
}
