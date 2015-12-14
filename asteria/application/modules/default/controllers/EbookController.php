<?php
class Default_EbookController extends Zend_Controller_Action
{
    public function indexAction()
    {
	 
          if($this->getRequest()->isPost()){
         
              //$this->_helper->viewRenderer->setNoRender();
              $this->getRequest()->getParam('id');
//              $this->view->addScriptPath('ebook');
//              $this->view->render();
              $this->view->render('colombe.html');
                 
             exit;
              
              
          }
 
    }
}
