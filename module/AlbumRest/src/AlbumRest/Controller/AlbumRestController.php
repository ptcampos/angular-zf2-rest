<?php
namespace AlbumRest\Controller;
 
use Zend\Mvc\Controller\AbstractRestfulController;
 
use Album\Model\Album;
use Album\Form\AlbumForm;
use Album\Model\AlbumTable;
use Zend\View\Model\JsonModel;
 
class AlbumRestController extends AbstractRestfulController
{
    protected $albumTable;

    public function options()
    {
        $response = $this->getResponse();
        $headers  = $response->getHeaders();

        // If you want to vary based on whether this is a collection or an
        // individual item in that collection, check if an identifier from
        // the route is present
        if ($this->params()->fromRoute('id', false)) {
            // Allow viewing, partial updating, replacement, and deletion
            // on individual items
            $headers->addHeaderLine('Allow', implode(',', array(
                'GET',
                'PATCH',
                'PUT',
                'DELETE',
            )));
            return $response;
        }

        // Allow only retrieval and creation on collections
        $headers->addHeaderLine('Allow', implode(',', array(
            'GET',
            'POST',
        )));
        return $response;
    }

    public function getAlbumTable()
    {
        if (!$this->albumTable) {
            $sm = $this->getServiceLocator();
            $this->albumTable = $sm->get('Album\Model\AlbumTable');
        }
        return $this->albumTable;
    }

    public function getList()
    {
        $results = $this->getAlbumTable()->fetchAll();
        $data = array();
        foreach($results as $result) {
            $data[] = $result;
        }
     
        return new JsonModel(array('data' => $data));
    }
 
    public function get($id)
    {
        $album = $this->getAlbumTable()->getAlbum($id);
 
        return new JsonModel(array('data' => $album));
    }
 
    public function create($data)
    {
        $form = new AlbumForm();
        $album = new Album();
        $form->setInputFilter($album->getInputFilter());
        $form->setData($data);
        $id = null;
        if ($form->isValid()) {
            $album->exchangeArray($form->getData());
            $id = $this->getAlbumTable()->saveAlbum($album);
            return $this->get($id);
        }else{
            var_dump($form->getData());die;
        }
        return new JsonModel(array());
    }
 
    public function update($id, $data)
    {
        $data['id'] = $id;
        $album = $this->getAlbumTable()->getAlbum($id);
        $form  = new AlbumForm();
        $form->bind($album);
        $form->setInputFilter($album->getInputFilter());
        $form->setData($data);
        if ($form->isValid()) {
            $id = $this->getAlbumTable()->saveAlbum($form->getData());
        }
     
        return $this->get($id);
    }
 
    public function delete($id)
    {
        $this->getAlbumTable()->deleteAlbum($id);
 
        return new JsonModel(array(
            'data' => 'deleted',
        ));
    }
}