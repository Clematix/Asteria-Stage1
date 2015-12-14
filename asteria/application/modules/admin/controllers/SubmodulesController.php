<?php
class Admin_SubmodulesController extends Zend_Controller_Action
{
    protected $_designbase = null;
    protected $_position = null;
    protected $_fnlm = null;
    
    public function init()
    {
      
        $this->_designbase = new Designbase();
        $this->_position = new Position();
        $this->_fnlm = new Fnlm();
        
      
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if($data)
            {
       $this->view->username = $data->firstname." ".$data->lastname;
            if($data->role)
               {
                Zend_Registry::set('index', 'test');
                $this->view->role=$data->role;
               }
             }
   
    }
   
    
    // Designbase
    
     public function designbaseAction()
    { 
       
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
      
        if(!$data){
            $this->_redirect('admin/auth/login');
                  }
      $this->view->designbase =  $this->_designbase->getdesignbase();
    }
     public function savedesignbaseAction()
    {
       $request1 = $this->getRequest()->getPost();
      //echo "<pre>"; print_r($request1); exit;
       
          if($this->getRequest()->isPost()){
               $val = $this->_designbase->savedesignbase($request1);
            }
             if($val == '0'){
            $this->view->MessageType = 'success';
            $this->view->Message = 'New Design Base has been Created!!';
            }
            if($val == '1'){
            $this->view->MessageType = 'error';
            $this->view->Message = 'Design Base Already Exists!!';
            }
            if($val == '2'){
            $this->view->MessageType = 'success';
            $this->view->Message = 'Design Base has been Updated!!';
            }
            
           $this->view->designbase =  $this->_designbase->getdesignbase();
          
    }
    
     public function deletedesignAction()
    {
       $request1 = $this->getRequest()->getParams('delete');
      
        if(isset($request1['delete'])){
              $this->_designbase->deletedesignbase($request1['delete']);	
          }
          $this->_redirect('admin/submodules/designbase');
          $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }
     public function getdesignbaseAction()
    {
       $request1 = $this->getRequest()->getPost();
      //echo "<pre>"; print_r($request1); exit;
       $val = $this->_designbase->getdesignbaseval($request1);
       echo json_encode($val);
        exit;
    }
    
     public function changestatusdesignAction()
    {
       $request1 = $this->getRequest()->getPost();
       $val = $this->_designbase->changestatusdesign($request1);
        $this->_redirect('admin/submodules/designbase');
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
  }
  
  // Position
    
     public function positionAction()
    { 
       
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
      
        if(!$data){
            $this->_redirect('admin/auth/login');
                  }
      $this->view->position =  $this->_position->getposition();
    }
     public function savepositionAction()
    {
       $request1 = $this->getRequest()->getPost();
      //echo "<pre>"; print_r($request1); exit;
       
          if($this->getRequest()->isPost()){
               $val = $this->_position->saveposition($request1);
            }
             if($val == '0'){
            $this->view->MessageType = 'success';
            $this->view->Message = 'New Position Category has been Created!!';
            }
            if($val == '1'){
            $this->view->MessageType = 'error';
            $this->view->Message = 'Position Category Already Exists!!';
            }
            if($val == '2'){
            $this->view->MessageType = 'success';
            $this->view->Message = 'Position Category has been Updated!!';
            }
            
           $this->view->position =  $this->_position->getposition();
          
    }
    
     public function deletepositionAction()
    {
       $request1 = $this->getRequest()->getParams('delete');
      
        if(isset($request1['delete'])){
              $this->_position->deleteposition($request1['delete']);	
          }
          $this->_redirect('admin/submodules/position');
          $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }
     public function getpositionAction()
    {
       $request1 = $this->getRequest()->getPost();
      //echo "<pre>"; print_r($request1); exit;
       $val = $this->_position->getpositionval($request1);
       echo json_encode($val);
        exit;
    }
    
     public function changestatuspositionAction()
    {
       $request1 = $this->getRequest()->getPost();
       $val = $this->_position->changestatusposition($request1);
        $this->_redirect('admin/submodules/position');
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
  }
  
  // Final
    
     public function finalAction()
    { 
       
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
      
        if(!$data){
            $this->_redirect('admin/auth/login');
                  }
      $this->view->final =  $this->_fnlm->getfinal();
    }
   public function savefinalAction()
    {
       $request1 = $this->getRequest()->getPost();
      //echo "<pre>"; print_r($request1); exit;
       
          if($this->getRequest()->isPost()){
               $val = $this->_fnlm->savefinal($request1);
            }
             if($val == '0'){
            $this->view->MessageType = 'success';
            $this->view->Message = 'New Finish Category has been Created!!';
            }
            if($val == '1'){
            $this->view->MessageType = 'error';
            $this->view->Message = 'Finish Category Already Exists!!';
            }
            if($val == '2'){
            $this->view->MessageType = 'success';
            $this->view->Message = 'Finish Category has been Updated!!';
            }
            
           $this->view->final =  $this->_fnlm->getfinal();
          
    }
    
     public function deletefinalAction()
    {
       $request1 = $this->getRequest()->getParams('delete');
      
        if(isset($request1['delete'])){
              $this->_fnlm->deletefinal($request1['delete']);	
          }
          $this->_redirect('admin/submodules/final');
          $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }
     public function getfinalAction()
    {
       $request1 = $this->getRequest()->getPost();
      //echo "<pre>"; print_r($request1); exit;
       $val = $this->_fnlm->getfinalval($request1);
       echo json_encode($val);
        exit;
    }
    
     public function changestatusfinalAction()
    {
       $request1 = $this->getRequest()->getPost();
       $val = $this->_fnlm->changestatusfinal($request1);
        $this->_redirect('admin/submodules/final');
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
  }
    
}