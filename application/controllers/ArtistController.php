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
        if (isset($_REQUEST['Add'])) {
            $artists = $_REQUEST['Artist'];
            if ($artists != "") {
                $artist = new Application_Model_DbTable_Artist();
                $artist->addArtist($artists);
                $this->_helper->redirector('artist');
            }
        } elseif (isset($_REQUEST['Edit'])) {
            $id = $_REQUEST['id'];
            $artists = $_REQUEST['Artist'];
            if ($artists != "") {
                $artist = new Application_Model_DbTable_Artist();
                $artist->updateArtist($id, $artists);
                $this->_helper->redirector('artist');
            }
        }
    }

    public function deleteAction()
    {

        if (isset($_REQUEST['del'])) {
            $id = $_REQUEST['id'];
            $artist = new Application_Model_DbTable_Artist();
            $artist->deleteArtist($id);
            $this->_helper->redirector('artist');
        }
    }

    public function getartistAction()
    {
        $artist = new Application_Model_DbTable_Artist();
        $data = $artist->fetchAll();
        $this->_helper->json->sendjson(array('data' => $data->toArray()));
    }
}
