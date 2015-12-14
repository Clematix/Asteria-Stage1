<?php
class Admin_VendorController extends Zend_Controller_Action
{
    protected $_shipping = null;


    public function init()
    {
      
        $this->_shipping = new Shipping();
        
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
      $this->view->vendor = $vendor->getvendor();
       
    }
    
     public function savevendorAction()
    {
       $request1 = $this->getRequest()->getPost();
      //echo "<pre>"; print_r($request1); exit;
       $vendor = new Vendor();
       
          if($this->getRequest()->isPost()){
              $val =  $vendor->savevendorlist($request1);
            }
             if($val == '0'){
            $this->view->MessageType = 'success';
            $this->view->Message = 'New Vendor has been Created!!';
            }
            if($val == '2'){
            $this->view->MessageType = 'success';
            $this->view->Message = 'Vendor List has been Updated!!';
            }
            
         $vendor = new Vendor();
        $this->view->vendor = $vendor->getvendor();
    }
    
     public function getvendorvalueAction()
    {
       $request1 = $this->getRequest()->getPost();
      $vendor = new Vendor();
       $val = $vendor->getvendorlistval($request1);
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
    
     public function approvevendorAction()
    {
       $request1 = $this->getRequest()->getPost();
      //echo "<pre>"; print_r($request1); exit;
      $vendor = new Vendor();
       $val = $vendor->approvedvendor($request1);
       $this->_redirect('admin/vendor/index');
          $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
  }
    
   
    // Vendor PO
  
   public function vendorpoAction()
    { 
       
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
      
        if(!$data){
            $this->_redirect('admin/auth/login');
                  }
      $vendor = new Vendor();
      $vendor_po = new Vendorpo();
      $material = new Material();
      
      $this->view->vendorpo = $vendor->vendorpo();
      date_default_timezone_set('Asia/Kolkata');
      $dt = new DateTime();
      $currentyear =  $dt->format('Y');
     // $currentyear = '2016';
     //  print_r($this->view->vendorpo[0]['content']);
       $vendpo_year = explode('/',$this->view->vendorpo[0]['content']);
           //    print_r($vendpo_year);
      //print_r($currentyear); 
      
      if($vendpo_year[0] == $currentyear){
          $vendpo_id = ++$vendpo_year[1];
//          print_r(strlen($vendpo_id));
          $count = 4 - strlen($vendpo_id);
//           print_r($count);    echo "<br>";
          for($i=0; $i<$count; $i++){
              $vendpo_id = '0'.$vendpo_id;
              // print_r($vendpo_id);     echo "===";echo "<br>"; 
          }
         $vendorpo = $currentyear.'/'.$vendpo_id;
      }
      else{
          $vendorpo = $currentyear.'/0001';
      }
      
        //print_r($vendorpo);
      $this->view->vendorpo_id = $vendorpo;
      //  exit;
      
       $this->view->vendorpo = $vendor_po->getvendorpo();
       $this->view->material = $material->getmaterialactive();
      //print_r($vendor->shippingaddress()); exit;
      $this->view->shippingaddress = $vendor->shippingaddress();
      $this->view->vendorlist = $vendor->activevendor();
      $this->view->shipping = $this->_shipping->fetchMethods();

       
    }
    
     public function getvendormaterialAction()
    {
       $request1 = $this->getRequest()->getPost();
      $material_vendordetails = new MaterialVendorDetails();
       $val = $material_vendordetails->getmaterial_vendor($request1);
//       echo "<pre>";
//       print_r($val);
//       exit;
       echo json_encode($val);
        exit;
  }
    
  
     public function getvendorpdtdetailsAction()
    {
       $request1 = $this->getRequest()->getPost();
      $material_vendordetails = new MaterialVendorDetails();
       $val = $material_vendordetails->getmaterialpdt($request1);
//       echo "<pre>";
//       print_r($val);
//       exit;
       echo json_encode($val);
        exit;
    }
    
    public function savevendorpoAction()
    {
       $request1 = $this->getRequest()->getPost();
      //echo "<pre>"; print_r($request1); exit;
       $vendorpo = new Vendorpo();
       
          if($this->getRequest()->isPost()){
              $val =  $vendorpo->savevendorpo($request1);
            }
             if($val == '0'){
            $this->view->MessageType = 'success';
            $this->view->Message = 'New Vendor has been Created!!';
            }
            if($val == '2'){
            $this->view->MessageType = 'success';
            $this->view->Message = 'Vendor List has been Updated!!';
            }
            
         $vendor = new Vendor();
      $vendor_po = new Vendorpo();
      $material = new Material();
      
      $this->view->vendorpo = $vendor->vendorpo();
      date_default_timezone_set('Asia/Kolkata');
      $dt = new DateTime();
      $currentyear =  $dt->format('Y');
      $vendpo_year = explode('/',$this->view->vendorpo[0]['content']);
      if($vendpo_year[0] == $currentyear){
          $vendpo_id = ++$vendpo_year[1];
          $count = 4 - strlen($vendpo_id);
          for($i=0; $i<$count; $i++){
              $vendpo_id = '0'.$vendpo_id;
           }
         $vendorpo = $currentyear.'/'.$vendpo_id;
      }
      else{
          $vendorpo = $currentyear.'/0001';
      }
      
      $this->view->vendorpo_id = $vendorpo;
       $this->view->vendorpo = $vendor_po->getvendorpo();
       $this->view->material = $material->getmaterialactive();
      $this->view->shippingaddress = $vendor->shippingaddress();
      $this->view->vendorlist = $vendor->activevendor();
      $this->view->shipping = $this->_shipping->fetchMethods();
      
      
      
    }
    
      public function getvendorpovalueAction()
    {
       $request1 = $this->getRequest()->getPost();
      $vendor_po = new Vendorpo();
       $val = $vendor_po->getvendorpoval($request1);
       echo json_encode($val);
        exit;
  }
  
  public function deletevendorpoAction()
    {
       $request1 = $this->getRequest()->getParams('delete');
      //print_r($request1); exit;
       $vendorpo = new Vendorpo();
        if(isset($request1['delete'])){
              $vendorpo->deletevendorpo($request1['delete']);	
          }
          $this->_redirect('admin/vendor/vendorpo');
          $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }
    
      public function approvevendorpoAction()
    {
       $request1 = $this->getRequest()->getPost();
      //echo "<pre>"; print_r($request1); exit;
      $vendorpo = new Vendorpo();
       $val = $vendorpo->approvedvendorpo($request1);
       $this->_redirect('admin/vendor/vendorpo');
          $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
  }
}