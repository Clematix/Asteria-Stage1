<?php
class Default_CreatebookController extends Zend_Controller_Action
{
    public function indexAction()
    {
	$this->view->headTitle()->append('Create e-book'); 
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
      
        $clientname=$data->uname;
        $clientsemail=$data->email;
        $clientuid=$data->uid;
        if(!empty($data))
          {
              $this->view->uname = $data->uname;
              $this->view->email = $data->email;
          }
        if(!$data->uname){
            $this->_redirect('loginform');
       }
           $input = new Userinput();
           $this->view->formaction = 'createbook/index';
           if($this->getRequest()->isPost())
               {
                  $upload = new Zend_File_Transfer_Adapter_Http();
                  $upload->addValidator('Extension',true,array('zip','epub','mp3'),'publication');
                  $upload->setDestination(BASE_PATH.'/public/userinput');
                  
                  $inputfile=$upload->getFileInfo('publication');
                  $name=$upload->getFileName('publication');
                  $input_file = $inputfile['publication']['name'];
                
                  
//                    $audio =  $this->getRequest()->getParam('howmany_audioclip');
//                    $video =  $this->getRequest()->getParam('howmany_videoclip');
//                    $view360 =  $this->getRequest()->getParam('howmany_view');
//                    $slide =  $this->getRequest()->getParam('howmany_slides');
//                    $flashanim =  $this->getRequest()->getParam('howmany_flashanim');
//                    $mulq =  $this->getRequest()->getParam('howmany_mulq');
//                    $readaloud =  $this->getRequest()->getParam('howmany_readaloud');
//                    $totalpage =  $this->getRequest()->getParam('numberpages');
//                    $estprice =  $this->getRequest()->getParam('price');
//                    $description=$this->getRequest()->getParam('description');
               
                  $upload->receive();
                  if($upload->receive()){
                      $date=date("d/M/Y");
//                  $updata = array('audio'=>$audio,'video'=>$video,'view360'=>$view360,'slides'=>$slide,'flash'=>$flashanim,'mulq'=>$mulq,'readaloud'=>$readaloud,'totalpage'=>$totalpage,'estprice'=>$estprice,'input'=>$input_file,'description'=>$description,'clientname'=>$clientname,'clientemail'=>$clientsemail,'date'=>$date,'clientuid'=>$clientuid);
                 
                      //$updata = array('audio'=>$input_file);
                      //$input->insert($updata);
                      
                       echo "Uploaded File :".$_FILES["publication"]["name"];exit;
                  }
                  
               }
           
	   
    }
    
    

}