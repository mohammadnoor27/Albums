<?php

class ArtistController extends Zend_Controller_Action
{

    public function artistAction()
    {
    }

    public function submitAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        if ($this->getRequest()->getParam('id') == NULL) {
            $artists = $this->getRequest()->getParam('Artist');
            if ($artists != "") {
                $artist = new Application_Model_DbTable_Artist();
                $artist->addArtist($artists);
                $msg = array();
                $msg['msg'] = "Artist Added Successfull";
                $this->_helper->json->sendjson($msg);
            }
        } else {
            $id = $this->getRequest()->getParam('id');
            $artists = $this->getRequest()->getParam('Artist');
            if ($artists != "") {
                $artist = new Application_Model_DbTable_Artist();
                $artist->updateArtist($id, $artists);
                $msg = array();
                $msg['msg'] = "Artist Edited Successfull";
                $this->_helper->json->sendjson($msg);
            }
        }
    }

    public function deleteAction()
    {

        $id = $this->getRequest()->getParam('id');
        $artist = new Application_Model_DbTable_Artist();
        $artist->deleteArtist($id);
        $msg = array(
            'Delete' => 'Artist Deleted Successfull'
        );
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
        $id = $this->getRequest()->getParam('id');
        $this->_helper->json->sendjson($Artist->fetchRow("ID = " . $id)->toArray());
    }
}
