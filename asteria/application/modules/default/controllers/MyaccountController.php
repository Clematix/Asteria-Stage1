<?php
class Default_MyaccountController extends Zend_Controller_Action
{
    public function indexAction()
    {
	  //$this->view->headTitle()->prepend('IndexPage'); 
	   $this->view->headTitle()->append('Myaccount'); 
           $storage = new Zend_Auth_Storage_Session();
           $data = $storage->read();
        if(!$data->uname){
                          $this->_redirect('loginform');
                         }
        $this->view->username = $data->uname;
        if(!empty($data))
                    {
              $this->view->uname = $data->uname;
              $this->view->email = $data->email;
              $this->view->id = $data->uid;
              $id=$data->uid;
              $email=$data->email;
              
              $this->view->contactno=$data->contactno;
                    }
                    
         $input = new Userinput();
        
         $where = $input->getAdapter()->quoteInto('clientuid = ?', $id);
         
         $allrow = $input->fetchAll($input->select()->where('clientuid = ?', $id));
         
         $this->view->myaccount=$allrow;
       
    }
    
    public function accounteditAction()
    
    {
           $uid =  $this->getRequest()->getParam(md5("clematix"));
           $id=base64_decode(strtr($uid, '-_,', '+/='))/9952045381;
           
           $this->view->headTitle()->append('Myaccount Edit'); 
           $storage = new Zend_Auth_Storage_Session();
           $data = $storage->read();
        if($id==$data->uid)
        {
         if(!empty($data))
          {
              $this->view->uname = $data->uname;
              $this->view->email = $data->email;
              $email=$data->email;
          }
          
         $input = new Userinput();
         $input_details=$input->getUsersData();
         
         $where = $input->getAdapter()->quoteInto('clientuid = ?', $id);
         
         $allrow = $input->fetchAll($input->select()->where('clientuid = ?', $id));
         
         
         $this->view->myaccount=$allrow;
         
          }
            else 
                {
                echo 'error';exit;
                }
        //print_r($allrow);exit;
         //echo $allrow[0]['password'];exit;
         
        
       
    }
    
    
    public function accchangeAction()
    {
            $storage = new Zend_Auth_Storage_Session();
            $data = $storage->read();
        
        if(!empty($data))
          {
              $this->view->uname = $data->uname;
              $this->view->email = $data->email;
              $email=$data->email;
              $id=$data->uid;
          }
    
        $accchange = new Signup();
        $allrow = $accchange->fetchAll($accchange->select()->where('email = ?', $email));
           $this->view->formaction = 'myaccount/accchange';
           if($this->getRequest()->isPost())
               {
            $name =  $this->getRequest()->getParam('uname');
            $email1 =  $this->getRequest()->getParam('email');
            $oldpassword =  $this->getRequest()->getParam('oldpassword');
             $newpassword =  $this->getRequest()->getParam('newpassword');
            $oldpass= $accchange->salsa208Core64($oldpassword);
        $newpass=$accchange->salsa208Core64($newpassword);
              if($oldpass==$allrow[0]['password'])
                    {
                  $updatedata=array('uname'=>$name,'email'=>$email1,'password'=>$newpass);
                  $where = $accchange->getAdapter()->quoteInto('uid = ?', $id);
                 $accchange->update($updatedata, $where);
                 echo "successfully updated";exit;
                    }
                else {
                    echo "please confirm ur old password";exit;
                    }
               }
        
       
    }
	
    
    public function orderdetailsAction()
    {
           $storage = new Zend_Auth_Storage_Session();
           $data = $storage->read();
          
           if(empty($data))
               {
                
               echo 'Error';exit;
               }
             else 
                {
                           
          $this->view->uname = $data->uname;
          $this->view->email = $data->email;
          $uid=$data->uid;
          $email=$data->email;
          $order =  $this->getRequest()->getParam(md5("orderid"));
          if(empty($order))
             {
               echo 'error';
               exit;
             }
          $id=base64_decode(strtr($order, '-_,', '+/='))/9952045381;
         
          $input = new Userinput();
        
          $where = $input->getAdapter()->quoteInto('id = ?', $id);
         
          $allrow = $input->fetchRow($input->select()->where('id = ?', $id)->where('clientuid = ?', $uid));
          $this->view->orderdetails=$allrow;
        
                         }
         
//         print_r($allrow);exit;
    }
	
}