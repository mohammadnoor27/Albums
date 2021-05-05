<?php

class ArtistController extends Zend_Controller_Action
{

    public function init()
    {
    }

    public function artistAction()
    {
        $artist = new Application_Model_DbTable_Artist();
        $this->view->artist = $artist->fetchAll();
    }

    public function submitAction()
    {
        if ($_POST['id'] == NULL) {
            $artists = $_POST['Artist'];
            if ($artists != "") {
                $artist = new Application_Model_DbTable_Artist();
                $artist->addArtist($artists);
            }
            $msg = array();
            $msg['Add'] = "Artist Added Successfull";
            $this->_helper->json->sendjson($msg);
        } else {
            $id = $_POST['id'];
            $artists = $_POST['Artist'];
            if ($artists != "") {
                $artist = new Application_Model_DbTable_Artist();
                $artist->updateArtist($id, $artists);
            }
            $msg = array();
            $msg['Edit'] = "Artist Edited Successfull";
            $this->_helper->json->sendjson($msg);
        }
    }

    public function deleteAction()
    {

        $id = $this->getRequest()->getParam('id');
        $artist = new Application_Model_DbTable_Artist();
        $artist->deleteArtist($id);
        $msg = array();
        $msg['Delete'] = "Artist Deleted Successfull";
        $this->_helper->json->sendjson($msg);
    }

    public function getartistAction()
    {
        $artist = new Application_Model_DbTable_Artist();
        $data = $artist->fetchAll();
        $this->_helper->json->sendjson(array('data' => $data->toArray()));
    }
    public function editartistAction()
    {
        $Artist = new Application_Model_DbTable_Artist();
        $id = $_REQUEST['id'];
        $this->_helper->json->sendjson($Artist->fetchRow("ID = " . $id)->toArray());
    }
}
