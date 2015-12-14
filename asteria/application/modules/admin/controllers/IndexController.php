<?php
class Admin_IndexController extends Zend_Controller_Action
{
    public function init()
    {
      
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
    public function indexAction()
    { 
       
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if(!$data){
            $this->_redirect('admin/auth/login');
                  }
        else
        {
        $this->_redirect('admin/auth/home');
        $this->view->username = $data->username;
        }
    }
}