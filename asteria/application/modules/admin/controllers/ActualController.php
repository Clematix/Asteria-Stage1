<?php
class Admin_ActualController extends Zend_Controller_Action
{
    public function init()
	  {
		$this->_helper->ajaxContext()
		  ->addActionContext('get-ajax-content', 'html')
		  ->initContext();
                
                $get_users = new Chatusers();
        
        $users = $get_users->getUsersData();
        $this->view->userscount = count($users);
        
        $upload1 = new Upload();
        $books=$upload1->getUsersData();
        $this->view->books1=count($books);
      
        $input = new Userinput();
        $invoice=$input->getUsersData(); 
        $this->view->invoice1=count($invoice);
                
        $message = new contacts();
        $this->view->message1=count($message->getUsersData());
        $user = new User();
        $this->view->member1=count($user->getUsersData());
        
        $user = new User();
        $rowset = $user->fetchAll("status = 'ON'");
        $status=count($rowset);
        $this->view->status=$status;
        $this->view->member1=count($user->getUsersData());
        
	}
	
	/* draws a calendar */
	
	
	public function indexAction()
       { echo 'lll';exit;
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if(!$data){
            $this->_redirect('admin/auth/login');
        }
                $this->view->username = $data->firstname." ".$data->lastname;
		
		$users = new Employee();
		$entry = new Entry();
                $form = new EntryForm();
                $this->view->form=$form;
		
		$categories = new Category();
		$pl = $categories->fetchAll('status=1');
		//echo '<pre>'; print_r($bc->toArray());//exit;
		$this->view->categories = $pl->toArray();
		
		$projects = new Project();
		$dl = $projects->fetchAll('status=1');
		//echo '<pre>'; print_r($bc->toArray());//exit;
		$this->view->projects = $dl->toArray();
		
		if ($this->getRequest()->isPost()) {
		$formData = $this->_request->getPost();
		//echo "<pre>"; print_r($formData); print_r($_FILES);
                
               
                
                if($formData['date'] == ''){
                    $this->view->errorMessage = "Enter Date";
                    return;
                }
		if($formData['start'] == ''){
                    $this->view->errorMessage = "Enter Start Time";
                    return;
                }
		if($formData['end'] == ''){
                    $this->view->errorMessage = "Enter End Time";
                    return;
                }
		
		if($formData['category'] == ''){
                    $this->view->errorMessage = "Select Project";
                    return;
                }	
		if($formData['projects'] == ''){
                    $this->view->errorMessage = "Select Department";
                    return;
                }
		$formData['by'] = $data->id	;							
		$entry->save($formData);
                $this->_redirect('admin/actual/sheet');
		}
        
		
		$id = (int)$this->_request->getParam('id');
		$row = $entry->fetchRow('id='.$id);
                $this->view->values = $row;
		
		

    }
	
	public function calendarAction()
       {
		$storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if(!$data){
            $this->_redirect('admin/auth/login');
        }
        $this->view->username = $data->firstname." ".$data->lastname;
		
		$this->view->calendar = $this->drawCalendar(7,2009);
	}
	
	public function sheetAction()
        {
	$storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        
        if(!$data){
            $this->_redirect('admin/auth/login');
        }
        $this->view->username = $data->firstname." ".$data->lastname;
	if($data->role >0)
        {
            $where = '1=1' ;  
        }
        else{
            
            $where = 'a.by='.$data->id;
        }
        $db = Zend_Db_Table::getDefaultAdapter();       
	
		$select = $db->select(); 
		$select->from(array('a' => 'entries'),array('id','date','start','end','descp','catid','pid','date','by'))
		 ->joinLeft(array('b' => 'employees'),'a.by = b.id',array('firstname','lastname'))
		 ->joinLeft(array('c' => 'categories'), 'a.catid = c.id',array('name as catname'))
		 ->joinLeft(array('d' => 'projects'), 'a.pid = d.id',array('name'))
		
		 ->order('a.start DESC')
	        //->where('cwi_company.manage=1')
	         ->where($where);
		 $stmt = $db->query($select);
		 $entries = $stmt->fetchAll();
		 //echo "<pre>"; print_r($entries);
		 $this->view->entries  = $entries;
		 
		 $total_rows = count($entries);
		$this->view->total_rows=$total_rows;
                
	}
	
       public function statsAction()
       {
            $storage = new Zend_Auth_Storage_Session();
            $data = $storage->read();
            if(!$data){
                $this->_redirect('admin/auth/login');
            }
            $this->view->username = $data->firstname." ".$data->lastname;

	}

 	public function getAjaxContentAction()
	  {
		
		$myData = $this->getRequest()->getParams(); // $myData is a PHP array
                unset($myData ['controller']);
		unset($myData ['action']);
		unset($myData ['module']);
		// This will turn the array back into the original URL query string
		$decodedData = http_build_query($myData); 
		
		// Get the catid 
		$catid = $this->getRequest()->getParam('catid');
		$projects = new Project();
		//$dl = $projects->fetchAll('status=1','catid='.$catid);
		$dl = $projects->fetchAll('status=1 and catid ='.$catid);
		
		$this->view->projects = $dl->toArray();
		$this->view->totcount = count($dl);
		 
		// Now you know how to get any data you want and to do whatever you want with the data
				
		
	  }
    
        public function projectAction()  
        {
            $storage = new Zend_Auth_Storage_Session();
            $data = $storage->read();
            if(!$data){
                $this->_redirect('admin/auth/login');
            }
            $this->view->username = $data->firstname." ".$data->lastname;
            
            $db = Zend_Db_Table::getDefaultAdapter();       
	
		$select = $db->select(); 
		$select->from(array('a' => 'projects'),array('id','name','totalhour','clientid','date','by'))
                 ->joinLeft(array('c' => 'clients'), 'a.clientid = c.id',array('firstname','lastname'))
		 ->order('a.name DESC');
	        //->where('cwi_company.manage=1')
	         //->where($where);
		 $stmt = $db->query($select);
		 $entries = $stmt->fetchAll();
		 //echo "<pre>"; print_r($entries);
		 $this->view->entries  = $entries;
		 
		 $total_rows = count($entries);
		$this->view->total_rows=$total_rows;
            
            
        }
        
        public function addprojectAction()
       {
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if(!$data){
            $this->_redirect('admin/auth/login');
        }
        $this->view->username = $data->firstname." ".$data->lastname;
		
		
		
		$users = new Employee();
		$project = new Project();
                $form = new EntryForm();
                $this->view->form=$form;
		
		$clients = new Client();
		$pl = $clients->fetchAll();
		//echo '<pre>'; print_r($bc->toArray());//exit;
		$this->view->clients = $pl->toArray();
		
		
		
		if ($this->getRequest()->isPost()) {
		$formData = $this->_request->getPost();
		//echo "<pre>"; print_r($formData); print_r($_FILES);
                
               
                if($formData['name'] == ''){
                    $this->view->errorMessage = "Enter Project Name";
                    return;
                }
                if($formData['date'] == ''){
                    $this->view->errorMessage = "Enter Date";
                    return;
                }
		
		if($formData['totalhour'] == ''){
                    $this->view->errorMessage = "Enter Budget Hour";
                    return;
                }
		
		if($formData['client'] == ''){
                    $this->view->errorMessage = "Select Client";
                    return;
                }	
		
		$formData['by'] = $data->id	;							
		$project->save($formData);
                $this->_redirect('admin/actual/project');
		}
        
		
		$id = (int)$this->_request->getParam('id');
		$row = $project->fetchRow('id='.$id);
                $this->view->values = $row;
		
		

    }




}