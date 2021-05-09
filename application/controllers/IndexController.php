<?php

class IndexController extends Zend_Controller_Action
{

    public function indexAction()
    {
        $albums = new Application_Model_DbTable_Albums();
        $this->view->albums = $albums->fetchAll();
        $artist = new Application_Model_DbTable_Artist();
        $this->view->artist = $artist->fetchAll();
        $category = new Application_Model_DbTable_Category();
        $this->view->category = $category->fetchAll();
    }

    public function submitAction()
    {
        if ($this->getRequest()->getParam('id') == NULL) {
            $artist = $this->getRequest()->getParam('Artist');
            $Category = $this->getRequest()->getParam('Category');
            $image = $this->getRequest()->getParam('image');
            if ($artist != "") {
                $albums = new Application_Model_DbTable_Albums();
                $CategoryAlbum = new Application_Model_DbTable_AlbumCategory();
                $ID = $albums->addAlbum($artist, $image);
                foreach ($Category as $icon) {
                    $Category = $icon;
                    $CategoryAlbum->addAlbumCategory($ID, $Category);
                }
                $msg = array();
                $msg['msg'] = "Album Added Successfull";
                $this->_helper->json->sendjson($msg);
            }
        } else {
            $id = $this->getRequest()->getParam('id');
            $artist = $this->getRequest()->getParam('Artist');
            $Category = $this->getRequest()->getParam('Category');
            if ($artist != "") {
                $albums = new Application_Model_DbTable_Albums();
                $CategoryAlbum = new Application_Model_DbTable_AlbumCategory();
                $filename = $this->getRequest()->getParam('image');
                $albums->updateAlbum($id, $artist, $filename);
                $CategoryAlbum->deleteAlbum($id);
                foreach ($Category as $icon) {
                    $Category = $icon;
                    $CategoryAlbum->addAlbumCategory($id, $Category);
                }
                $msg = array();
                $msg['msg'] = "Album Edited Successfull";
                $this->_helper->json->sendjson($msg);
            }
        }
    }

    public function deleteAction()
    {
        $id = $this->getRequest()->getParam('id');
        $albums = new Application_Model_DbTable_Albums();
        $albums->deleteAlbum($id);
        $msg = array();
        $msg['Delete'] = "Album Deleted Successfull";
        $this->_helper->json->sendjson($msg);
    }

    public function albumAction()
    {
        $album = new Application_Model_DbTable_AlbumView();
        $CategoryAlbum = new Application_Model_DbTable_AlbumCategoryView();
        $array = array();
        foreach ($album->fetchAll()->toArray() as $rowAlbum) {
            $Album = $rowAlbum;
            $Category = array();
            foreach ($CategoryAlbum->fetchAll("IDAlbum =" . $rowAlbum["id"])->toArray() as $rowCategory) {
                $Category[] = $rowCategory["Category_Name"];
            }
            $Album["Category_Name"] = implode(" ,", $Category);
            $array[] = $Album;
        }

        $this->_helper->json->sendjson(array('data' => $array));
    }
    public function editalbumAction()
    {

        $album = new Application_Model_DbTable_Albums();
        $CategoryAlbum = new Application_Model_DbTable_AlbumCategory();
        $id = $this->getRequest()->getParam('id');
        $Album = $album->fetchRow("id =" . $id)->toArray();
        $Category = array();
        foreach ($CategoryAlbum->fetchAll("IDAlbum =" . $Album["id"])->toArray() as $rowCategory) {
            $Category[] = $rowCategory["IDCategory"];
            $Album["IDCategory"] = $Category;
        }
        $this->_helper->json->sendjson($Album);
    }
    public function uploadalbumAction()
    {
        if (empty($_FILES) || $_FILES["file"]["error"]) {
            die('{"OK": 0}');
        }

        $fileName = $_FILES["file"]["name"];
        move_uploaded_file($_FILES["file"]["tmp_name"], "/var/www/zf-tutorial/public/image/$fileName");

        die('{"OK": 1}');
        $this->_helper->redirector('index');
    }
}
