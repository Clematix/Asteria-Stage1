<?php
class Default_UploadController extends Zend_Controller_Action
{
    public function indexAction()
    {
	  //$this->view->headTitle()->prepend('IndexPage'); 
	   //$this->view->headTitle()->append('Myaccount'); 
           
           
	   //For adding Additional Style sheet //
	  // $this->view->headLink()->appendStylesheet('/styles/user-list.css');
//	   $ad= new students();
//	   $val=$ad->fetchStudents();
//	   $this->view->entries = $val;
	   //echo "<pre>";
	   //print_r($val);
	   //$row=$ad->fetchRow('id=1');
	   //echo $row['name'];
	   
        
         $users = new Newsletter();
         // $form = new SubscriptionForm();
          
         //$this->view->form = $form;
         $this->view->formaction = 'footer';
          if($this->getRequest()->isPost()){
              $email =  $this->getRequest()->getParam('email');
              if($users->checkUnique($email)){
              echo '2';exit;}
else{$status='Y';
    $data = array('email'=>$email,'status'=>$status);
     $users->insert($data);
echo '1';exit;}
 
              //echo 'fkbmgknbm';exit;
//             if($form->isValid($_POST)){
//                $data = $form->getValues();
//    
//                 if($users->checkUnique($data['email'])){
//                    echo "0";exit;
//                }
//
//                $users->insert($data);
//                echo "1";exit;
//                
//                 }
// else {echo "1";exit;}
             
              
          }
    }
	
        public function someAction()
        {
            $this->_redirect('default');
        }
        
        public function contactAction()
         {
            
          $users1 = new contacts();
          //$form1 = new ContactsForm();
          
//          $data1 = $form1->getValues();
//                print_r($data1);exit;
//          echo "adasd";
          //$this->view->form = $form1;
//echo "423432$";
           $this->view->formaction = 'contact/index';
          if($this->getRequest()->isPost()){
             $name =  $this->getRequest()->getParam('fullname');
             $email =  $this->getRequest()->getParam('email');
             $subject =  $this->getRequest()->getParam('subject');
             $message =  $this->getRequest()->getParam('message');
           $updata = array('fullname'=>$name,'email'=>$email,'subject'=>$subject,'message'=>$message);
//print_r($updata);exit;
             
                if($users1->checkUnique($email))
                {
//                   $this->view->errorMessage = "Email Id already Exist"; 
                    echo "0";exit;
                }
                else  
                    {
                $users1->insert($updata);
                echo "1";exit;            
                         }

                               
                         }
        }
}