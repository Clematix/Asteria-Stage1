<?php
class Default_IndexController extends Zend_Controller_Action
{      
   
    public function indexAction()
    {
            $this->_redirect('admin/auth');
	  $storage = new Zend_Auth_Storage_Session();
          $data = $storage->read();

          if(!empty($data))
          {
              $this->view->uname = $data->uname;
              $this->view->email = $data->email;
          }
         
	   $this->view->headTitle()->append('HomePage'); 
	   
             $upload = new Upload();
             $filename=$upload->getUsersData();
             $this->view->filename= $filename;
            
        
    }
	public function viewAction()
        {
            
             $upload = new Upload();
             $filename=$upload->getUsersData();
             $this->view->filename= $filename;
             
             $this->view->name=explode(".",$this->view->filename[0]['file']);
             
       echo $filename[0]['bsize'];
             
        for($i=0;$i<30;$i++)
             {
             echo $filename[$i]['file']; echo "<br/>";
             }exit;

        }
        
        
        public function downloadAction()
       {
    $fileName = BASE_PATH.'/public/books/antoniostale.epub';
    $this->_helper->layout()->disableLayout();
    $this->_helper->viewRenderer->setNoRender(true);

    //...
        //open/save dialog box
    header('Content-Disposition: attachment; filename="antoniostale.epub"');
    //content type
    header('Content-type: application/epub+zip');
    //read from server and write to buffer
    readfile(BASE_PATH.'/public/books/antoniostale.epub');
    
        }
        
        
	
}
