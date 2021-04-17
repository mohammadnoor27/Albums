<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
    }

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
        if (isset($_REQUEST['Add'])) {
            $artist = $_REQUEST['Artist'];
            $Category = $_REQUEST['Category'];
            $filename = isset($_FILES['uploadfile']['name']) ? $_FILES["uploadfile"]["name"] : null;
            $tempname = isset($_FILES['uploadfile']['tmp_name']) ? $_FILES["uploadfile"]["tmp_name"] : null;
            $folder = "/var/www/zf-tutorial/public/image/" . $filename;
            if ($artist != "") {
                $albums = new Application_Model_DbTable_Albums();
                $CategoryAlbum = new Application_Model_DbTable_AlbumCategory();
                if (move_uploaded_file($tempname, $folder)) {
                    $ID = $albums->addAlbum($artist, $filename);
                    foreach ($Category as $icon) {
                        $Category = $icon;
                        $CategoryAlbum->addAlbumCategory($ID, $Category);
                    }
                }
                $this->_helper->redirector('index');
            }
        } elseif (isset($_REQUEST['Edit'])) {
            $id = $_REQUEST['id'];
            $artist = $_REQUEST['Artist'];
            $Category = $_REQUEST['Category'];
            $filename = isset($_FILES['uploadfile']['name']) ? $_FILES["uploadfile"]["name"] : null;
            $tempname = isset($_FILES['uploadfile']['tmp_name']) ? $_FILES["uploadfile"]["tmp_name"] : null;
            $folder = "/var/www/zf-tutorial/public/image/" . $filename;
            if ($artist != "") {
                $albums = new Application_Model_DbTable_Albums();
                $CategoryAlbum = new Application_Model_DbTable_AlbumCategory();
                if (move_uploaded_file($tempname, $folder)) {
                    $albums->updateAlbum($id, $artist, $filename);
                    $CategoryAlbum->deleteAlbum($id);
                    foreach ($Category as $icon) {
                        $Category = $icon;
                        $CategoryAlbum->addAlbumCategory($id, $Category);
                    }
                }
                $this->_helper->redirector('index');
            }
        }
    }

    public function deleteAction()
    {

        if (isset($_REQUEST['del'])) {
            $id = $_REQUEST['id'];
            $albums = new Application_Model_DbTable_Albums();
            $albums->deleteAlbum($id);
            $this->_helper->redirector('index');
        }
    }

    public function albumAction()
    {
        $album = new Application_Model_DbTable_AlbumView();
        $CategoryAlbum = new Application_Model_DbTable_AlbumCategoryView();
        $array = array();
        foreach ($album->fetchAll()->toArray() as $row) {
            $subdata = array();
            $subdata["id"] = $row["id"];
            $subdata["Artist_Name"] = $row["Artist_Name"];
            $subdata["image"] = $row["image"];
            $subdata1 = array();
            foreach ($CategoryAlbum->fetchAll("IDAlbum =" . $row["id"])->toArray() as $row1) {
                $subdata1[] = $row1["Category_Name"];
                $subdata["Category_Name"] = implode(" ,", $subdata1);
            }
            $array[] = $subdata;
        }

        $this->_helper->json->sendjson(array('data' => $array));
    }
    public function editalbumAction()
    {

        $album = new Application_Model_DbTable_Albums();
        $CategoryAlbum = new Application_Model_DbTable_AlbumCategory();
        $id = $_REQUEST['id'];
        $array = array();
        foreach ($album->fetchAll("id =".$id)->toArray() as $row) {
            $subdata = array();
            $subdata["id"] = $row["id"];
            $subdata["artist"] = $row["artist"];
            $subdata["image"] = $row["image"];
            $subdata1 = array();
            foreach ($CategoryAlbum->fetchAll("IDAlbum =" . $row["id"])->toArray() as $row1) {
                $subdata1[] = $row1["IDCategory"];
                $subdata["IDCategory"]=$subdata1;
            }
            $array[] = $subdata;
        }

        $this->_helper->json->sendjson($array);
    }
}
