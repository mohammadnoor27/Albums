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
        if ($_REQUEST['id'] == NULL) {
            $artists = $_REQUEST['Artist'];
            if ($artists != "") {
                $artist = new Application_Model_DbTable_Artist();
                $artist->addArtist($artists);
                $this->_helper->redirector('artist');
            }
        } else {
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

        $id = $this->getRequest()->getParam('id');
        $artist = new Application_Model_DbTable_Artist();
        $artist->deleteArtist($id);
        $this->_helper->redirector('artist');
    }

    public function getartistAction()
    {
        $artist = new Application_Model_DbTable_Artist();
        $data = $artist->fetchAll();
        $this->_helper->json->sendjson(array('data' => $data->toArray()));
    }
}
