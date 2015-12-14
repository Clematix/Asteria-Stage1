<?php
class Admin_GrnController extends Zend_Controller_Action
{
    protected $_grn = null;


    public function init()
    {
      
      //  $this->_grn = new Grn();
        
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
      $vendor = new Vendor();
      
     $grn = new Grn();
      
      $this->view->grncount = $vendor->grncount();
      
      date_default_timezone_set('Asia/Kolkata');
      $dt = new DateTime();
      $currentyear =  $dt->format('Y');
        $grncount_year = explode('/',$this->view->grncount[0]['content']);
       if($grncount_year[0] == $currentyear){
          
          $vendpo_id = ++$grncount_year[1];
          $count = 4 - strlen($vendpo_id);
          for($i=0; $i<$count; $i++){
              $vendpo_id = '0'.$vendpo_id;
            }
         $grnno = $currentyear.'/'.$vendpo_id;
      }
      else{
          $grnno = $currentyear.'/0001';
      }
      $this->view->grnval = $grnno;
      $this->view->vendorlist = $vendor->activevendor();
      $this->view->grnlist = $grn->grnlist();
       
    }
    
     public function savegrnAction()
    {
       $request1 = $this->getRequest()->getPost();
     // echo "<pre>"; print_r($request1); exit;
      $vendor = new Vendor();
      $grn = new Grn();
      
       
            if($this->getRequest()->isPost()){
              $val =  $grn->savegrnval($request1);
            }
            
            if($val == '0'){
            $this->view->MessageType = 'success';
            $this->view->Message = 'New GRN has been Created!!';
            }
            if($val == '2'){
            $this->view->MessageType = 'success';
            $this->view->Message = 'Vendor List has been Updated!!';
            }
            
      
      $this->view->grncount = $vendor->grncount();
      date_default_timezone_set('Asia/Kolkata');
      $dt = new DateTime();
      $currentyear =  $dt->format('Y');
      $grncount_year = explode('/',$this->view->grncount[0]['content']);
//     print_r($grncount_year);
//     print_r($currentyear);
   
      if($grncount_year[0] == $currentyear){
          $vendpo_id = ++$grncount_year[1];
          $count = 4 - strlen($vendpo_id);
          for($i=0; $i<$count; $i++){
              $vendpo_id = '0'.$vendpo_id;
            }
         $grnno = $currentyear.'/'.$vendpo_id;
      }
      else{
          $grnno = $currentyear.'/0001';
      }
        
//        print_r($grnno);
//        exit;
      $this->view->grnval = $grnno;
      $this->view->vendorlist = $vendor->activevendor();
      $this->view->grnlist = $grn->grnlist();
    }
    
     public function getvendorposAction()
    { 
       
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
      
        if(!$data){
            $this->_redirect('admin/auth/login');
                  }
      $request1 = $this->getRequest()->getPost();
//      echo "<pre>";    print_r($request1);    exit;
    $grn = new Grn();
    $val = $grn->getvendorpovals($request1);
    echo json_encode($val);
      exit;
    }
    
    
     public function getvendorpomaterialsAction()
    { 
       
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
      
        if(!$data){
            $this->_redirect('admin/auth/login');
                  }
      $request1 = $this->getRequest()->getPost();
    $grn = new Grn();
    $val = $grn->getvendorpo_materials($request1);
     // echo "<pre>";    print_r($val);    exit;
          echo json_encode($val);
      exit;
    }
    
     public function generateuniquenoAction()
    { 
       
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
      
        if(!$data){
            $this->_redirect('admin/auth/login');
                  }
      $request1 = $this->getRequest()->getPost();
   
    $count = $request1['okqty'];
    $grn = new Grn();
    $val = $grn->getinventorydetails($request1);
//    $init = $val[0][uniqueid];
//    $uniq = '';
//   if($val){
//        for($i=1; $i<=$count; $i++){
//            $uniq.= "".++$init.", ";
//            $trimwhere = rtrim($uniq, ", ");
//        }
//        
//    }
//    else{
//        $init = 'AA000';
//        for($i=1; $i<=$count; $i++){
//            $uniq.= "".++$init.", ";
//            $trimwhere = rtrim($uniq, ", ");
//        }
//    }
//     $uniquevals = $trimwhere;
     print_r($uniquevals);
        //  echo json_encode($val);
      exit;
    }
    
     public function generateuniquenoeditAction()
    { 
       
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
      
        if(!$data){
            $this->_redirect('admin/auth/login');
                  }
      $request1 = $this->getRequest()->getPost();
   
     
    //  print_r($request1); exit;
    $grn = new Grn();
    $val = $grn->getinventorydetailsedit($request1);
//echo "<pre>"; 
//     print_r($val);
//     exit;
      echo json_encode($val);
      exit;
    }
    
    
     public function getgrnAction()
    {
          $grn = new Grn();
       $request1 = $this->getRequest()->getPost();
      // print_r($request1); exit;
       $val = $grn->getgrnval($request1);
       $vend_po= $grn->getvendorpo($val[0]['vendor_name']);
       $val[0]['vend_po'] = $vend_po;
       $val = array_reverse($val[0]);
//       echo "<pre>";
//       print_r($val); exit;
      echo json_encode($val);
        exit;
  }
    
    public function deletevendorAction()
    {
       $request1 = $this->getRequest()->getParams('delete');
     // print_r($request1);
       $vendor = new Vendor();
        if(isset($request1['delete'])){
              $vendor->deletevendor($request1['delete']);	
          }
          $this->_redirect('admin/vendor/index');
          $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }
    
     public function approvegrnAction()
    {
       $request1 = $this->getRequest()->getPost();
      //echo "<pre>"; print_r($request1); exit;
       $grn = new Grn();
       $val = $grn->approvedgrn($request1);
       exit;
    }
    
   
   
  
  
}