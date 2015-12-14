<?php

class Admin_MaterialController extends Zend_Controller_Action
{
    protected $_material = null;
    protected $_vendor = null;
    protected $_materialstatus = null;
    protected $_materialtype = null;
    protected $_materialgroupcategory = null;
    protected $_materialgroup = null;
    protected $_designbase = null;
    protected $_position = null;
    protected $_fnlm = null;
    protected $_project = null;
     protected $_bom = null;
    protected $_bomref = null;
     protected $_shipping = null;
    protected $_moduleid = 'MM';
   
    public function init()
    {
       
        $this->_material = new Material();
        $this->_vendor = new Vendor();
        $this->_materialstatus  = new Materialstatus();
        $this->_materialtype = new Materialtype();
        $this->_materialgroup = new Materialgroup();
        $this->_materialgroupcategory = new Materialgroupcategory();
        $this->_designbase = new Designbase();
        $this->_position = new Position();
        $this->_fnlm = new Fnlm();
        $this->_project= new Project();
        $this->_bom = new Bom();
        $this->_bomref = new Bomref();
            $this->_shipping = new Shipping();
      
      
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if($data)
            {
            $this->view->username = $data->firstname . " " . $data->lastname;
            if ($data->role) {
                $this->view->role = $data->role;
                $role=$this->_helper->acl->role($data->role);
               }
           
        $this->view->modules = $role['modules'];
        $this->view->resources =  $role['resources'];
        $this->view->resourcepath = $role['resourcepath'];
        $this->view->moduleid = $this->_moduleid;
        $this->view->modulesId = $role['modulesId'];
        $this->_permission=$role['permission'];
             }
    $this->view->moduleid = $this->_moduleid;
   
    }
    public function indexAction()
    { 
        
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
      
        if(!$data){
            $this->_redirect('admin/auth/login');
                  }
      
                  if ($this->_getParam('global')) {
            
                   echo '<script type="text/javascript">$(document).ready(function(){$(".edit'.$this->_getParam('global').'").trigger("click");});</script>';
                    }
        
        $this->view->material         =   $this->_material->getmaterial();
        $this->view->newid            =   $this->_material->getmaterialmaxid();
        $this->view->vendorlist       =   $this->_vendor->activevendor();
        $this->view->materialstatus   =   $this->_materialstatus->getmaterialstatus();
        $this->view->materialtype     =   $this->_materialtype->getmattypeactive();
 $this->view->materialgroupcategory   =   $this->_materialgroupcategory->getmaterialgroupcategoryactive();
        $this->view->uom              =   $this->_material->getuom();
        $this->view->designbase       =   $this->_designbase->getdesignactive();
        //$this->view->project       =   $this->_project->getprojectactive();
        $this->view->position = $this->_position->getpositionactive();
     $this->view->final = $this->_fnlm->getfinalactive();
    }
    
    public function bomrev($id)
    { 
         $res=array_unique($this->_bomref->getallBomLine($id), SORT_REGULAR);
    
         foreach($res as $_res){
     
           $this->_helper->model->update('Bom', $_res['bom_id'], array('bom_rev_id' => $this->setrevision($_res['bom_id'])));
         }
         return true;
    }
    
    public function setrevision($id) {
        $revision = $this->_bom->getRevision($id);
        if ($revision) {
            $revision++;
            $_revid = $revision;
        }
        if (!$revision) {
            $_revid = 'A';
        }
        return $_revid;
    }
    
     
    public function savematerialAction()
    {
       $request1 = $this->getRequest()->getPost();
       $storage = new Zend_Auth_Storage_Session();
        $user = $storage->read();
        
     if($request1['id']){
         $this->bomrev($request1['id']);
     }
          if($this->getRequest()->isPost()){
              $val = $this->_material->savematerial($request1,$user);
           }
            if($val == '0'){
            $this->view->MessageType = 'success';
            $this->view->Message = 'New Material has been Created!!';
            }
            if($val == '1'){
            $this->view->MessageType = 'error';
            $this->view->Message = 'Material Already Exists!!';
            }
             if($val == '2'){
            $this->view->MessageType = 'success';
            $this->view->Message = 'Material Details has been Updated!!';
            }
            
            
        $this->view->material         =   $this->_material->getmaterial();
        $this->view->newid            =   $this->_material->getmaterialmaxid();
        $this->view->vendorlist       =   $this->_vendor->activevendor();
        $this->view->materialstatus   =   $this->_materialstatus->getmaterialstatus();
        $this->view->materialtype     =   $this->_materialtype->getmattypeactive();
 $this->view->materialgroupcategory   =   $this->_materialgroupcategory->getmaterialgroupcategoryactive();
        $this->view->uom              =   $this->_material->getuom();
        $this->view->designbase       =   $this->_designbase->getdesignactive();
        $this->view->project       =   $this->_project->getprojectactive();
      
    }
    
    
    
    public function getmaterialsubcategoryAction()
    { 
       
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
      
        if(!$data){
            $this->_redirect('admin/auth/login');
                  }
                  
      $request1 = $this->getRequest()->getPost();
//      echo "<pre>";
//      print_r($request1);
    $materialgrp = new Materialgroup();
    $val = $materialgrp->getsubcategory($request1);
    echo json_encode($val);
      exit;
    }
    
     public function getmaterialsubcategorycodeAction()
    { 
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if(!$data){
            $this->_redirect('admin/auth/login');
                  }
      $request1 = $this->getRequest()->getPost();
//print_r($request1);exit;
    $materialgrp = new Materialgroup();
    $val = $materialgrp->getsubcategorycode($request1);
        echo json_encode($val);
        exit;
    }
  
  
     public function getmaterialAction()
    { 
        $request1 = $this->getRequest()->getPost();
        $val = $this->_material->getmaterialval($request1);
        $data['charac'] = $val[0]['material_category'];
        $sub = $this->_materialgroup->getsubcategory_material($data['charac']);
        $val[0]['subcat'] = $sub;
        $val = array_reverse($val[0]);
  
       echo json_encode($val);
       exit;
   
        
    }
    public function deletematerialAction()
    {
       $request1 = $this->getRequest()->getParams('delete');
        if(isset($request1['delete'])){
              $val = $this->_material->deletematerial($request1['delete']);	
          }
         // print_r($val); exit;
          if($val == '0'){
            $this->view->MessageType = 'warning';
            $this->view->Message = 'Seleceted material is being used in the application';
            }
            if($val == '1'){
            $this->view->MessageType = 'success';
            $this->view->Message = 'Material Deleted Successfully!!';
            }
           $this->view->material         =   $this->_material->getmaterial();
        $this->view->newid            =   $this->_material->getmaterialmaxid();
        $this->view->vendorlist       =   $this->_vendor->activevendor();
        $this->view->materialstatus   =   $this->_materialstatus->getmaterialstatus();
        $this->view->materialtype     =   $this->_materialtype->getmattypeactive();
 $this->view->materialgroupcategory   =   $this->_materialgroupcategory->getmaterialgroupcategoryactive();
        $this->view->uom              =   $this->_material->getuom();
        $this->view->designbase       =   $this->_designbase->getdesignactive();
        $this->view->project       =   $this->_project->getprojectactive();
    }
    
      public function changestatusmaterialAction()
    {
       $request1 = $this->getRequest()->getPost();
       $val = $this->_material->changestatusmaterial($request1);
       echo '1';
       exit;
       $this->_redirect('admin/material/index');
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
  }
     // Material Status
    
    public function statusmasterAction()
    { 
       
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
      
        if(!$data){
            $this->_redirect('admin/auth/login');
                  }
                  
      $materialstatus = new Materialstatus();
      $this->view->materialstatus = $materialstatus->getmaterialstatus();
    }
    
     public function savematerialstatusAction()
    {
       $request1 = $this->getRequest()->getPost();
      //echo "<pre>"; print_r($request1); exit;
       $materialstatus = new Materialstatus();
       
          if($this->getRequest()->isPost()){
               $val = $materialstatus->savematerialstatus($request1);
            }
             if($val == '0'){
            $this->view->MessageType = 'success';
            $this->view->Message = 'New Material Status has been Created!!';
            }
            if($val == '1'){
            $this->view->MessageType = 'error';
            $this->view->Message = 'Material Status Already Exists!!';
            }
          $this->view->materialstatus = $materialstatus->getmaterialstatus();
    }
    
     public function getmaterialstatusAction()
    {
       $request1 = $this->getRequest()->getPost();
      //echo "<pre>"; print_r($request1); exit;
       $materialstatus = new Materialstatus();
       $val = $materialstatus->getmaterialstatusval($request1);
       echo json_encode($val);
  //print_r($val);
  //echo     $val2 = '<input type="text" value="Ram">';
 
    // return $val;
       exit;
   
        
    }
     public function deleteAction()
    {
       $request1 = $this->getRequest()->getParams('delete');
      
       $materialstatus = new Materialstatus();
        if(isset($request1['delete'])){
             $val=  $materialstatus->deletematerialstatus($request1['delete']);
          }
           if($val == '0'){
            $this->view->MessageType = 'success';
            $this->view->Message = 'Material Status has been deleted!!';
            }
            if($val == '1'){
            $this->view->MessageType = 'warning';
            $this->view->Message = 'Material Status active in some material!!';
            }
            
          $this->view->materialstatus = $materialstatus->getmaterialstatus();
    }
      public function changestatusmaterialstatusAction()
    {
         $request1 = $this->getRequest()->getPost();
       $val = $this->_materialstatus->changestatusmaterialstatus($request1);
       $this->_redirect('admin/material/statusmaster');
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
  }
  
  
    // Group Category Master
    
    public function groupcategorymasterAction()
    { 
       
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
      
        if(!$data){
            $this->_redirect('admin/auth/login');
                  }
      $materialgrpcate = new Materialgroupcategory();
     $this->view->materialgroupcategory = $materialgrpcate->getmaterialgroupcategory();
    }
   
     public function savematerialgroupcategoryAction()
    {
       $request1 = $this->getRequest()->getPost();
      //echo "<pre>"; print_r($request1); exit;
      $materialgrpcate = new Materialgroupcategory();
       
          if($this->getRequest()->isPost()){
              $val = $materialgrpcate->savematerialgroupcategory($request1);
            }
            if($val == '0'){
            $this->view->MessageType = 'success';
            $this->view->Message = 'New Material Major Category has been Created!!';
            }
            if($val == '1'){
            $this->view->MessageType = 'error';
            $this->view->Message = 'Material Major Category Already Exists!!';
            }
           $materialgrpcate = new Materialgroupcategory();
            $this->view->materialgroupcategory = $materialgrpcate->getmaterialgroupcategory();

          
    }
  
  
      public function deletegroupcategoryAction()
    {
       $request1 = $this->getRequest()->getParams('delete');
      
        $materialgrpcate = new Materialgroupcategory();
        if(isset($request1['delete'])){
              $materialgrpcate->deletematerialgroupcategory($request1['delete']);	
          }
          $this->_redirect('admin/material/groupcategorymaster');
          $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }
    
     public function changestatusgroupcategoryAction()
    {
       $request1 = $this->getRequest()->getPost();
     $materialgrpcate = new Materialgroupcategory();
       $val = $materialgrpcate->changestatusgroupcategory($request1);
       $this->_redirect('admin/material/groupcategorymaster');
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
  }
  
     public function getmaterialgroupcategoryAction()
    {
       $request1 = $this->getRequest()->getPost();
      //echo "<pre>"; print_r($request1); exit;
       $materialgrpcate = new Materialgroupcategory();
       $val = $materialgrpcate->getmaterialgroupcateval($request1);
       echo json_encode($val);
       exit;
    }
    
        
    // Group Master
    
     public function groupmasterAction()
    { 
       
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
      
        if(!$data){
            $this->_redirect('admin/auth/login');
                  }
      $materialgrp = new Materialgroup();
       $materialgrpcate = new Materialgroupcategory();
     $this->view->materialgroup = $materialgrp->getmaterialgroup();
     $this->view->materialgroupcategory = $materialgrpcate->getmaterialgroupcategoryactive();
     
    
    }
        
     public function savematerialgroupAction()
    {
       $request1 = $this->getRequest()->getPost();
      $materialgrp = new Materialgroup();
       
          if($this->getRequest()->isPost()){
             $val =   $materialgrp->savematerialgroup($request1);
            }
           
            if($val == '0'){
            $this->view->MessageType = 'success';
            $this->view->Message = 'New Material Sub Category has been Created!!';
            }
            if($val == '1'){
            $this->view->MessageType = 'error';
            $this->view->Message = 'Material Sub Category Already Exists!!';
            }
             if($val == '2'){
            $this->view->MessageType = 'success';
            $this->view->Message = 'Material Sub Category has been Updated!!';
            }
            
            $materialgrp = new Materialgroup();
            $materialgrpcate = new Materialgroupcategory();
            $this->view->materialgroup = $materialgrp->getmaterialgroup();
            $this->view->materialgroupcategory = $materialgrpcate->getmaterialgroupcategoryactive();
        }
          public function deletegroupAction()
    {
       $request1 = $this->getRequest()->getParams('delete');
      
       $materialgrp = new Materialgroup();
        if(isset($request1['delete'])){
              $materialgrp->deletematerialgroup($request1['delete']);	
          }
          $this->_redirect('admin/material/groupmaster');
          $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }
     public function getmaterialgroupAction()
    {
       $request1 = $this->getRequest()->getPost();
      //echo "<pre>"; print_r($request1); exit;
      $materialgrp = new Materialgroup();
       $val = $materialgrp->getmaterialgroupval($request1);
       echo json_encode($val);
  
       exit;
         
    }
      public function changestatusgroupAction()
    {
       $request1 = $this->getRequest()->getPost();
        $materialgrp = new Materialgroup();
       $val = $materialgrp->changestatusgroup($request1);
       $this->_redirect('admin/material/groupmaster');
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
  }
    
    // Type Master
    
     public function typemasterAction()
    { 
       
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
      
        if(!$data){
            $this->_redirect('admin/auth/login');
                  }
      $materialtype = new Materialtype();
     $this->view->materialtype = $materialtype->getmaterialtype();
    }
     public function savematerialtypeAction()
    {
       $request1 = $this->getRequest()->getPost();
      //echo "<pre>"; print_r($request1); exit;
       $materialtype = new Materialtype();
       
          if($this->getRequest()->isPost()){
               $val = $materialtype->savematerialtype($request1);
            }
            if($val == '0'){
            $this->view->MessageType = 'success';
            $this->view->Message = 'New material Type has been Created!!';
            }
            if($val == '1'){
            $this->view->MessageType = 'error';
            $this->view->Message = 'Material Type Already Exists!!';
            }
            if($val == '2'){
            $this->view->MessageType = 'success';
            $this->view->Message = 'Material Type Updated!!';
            }
            $materialtype = new Materialtype();
            $this->view->materialtype = $materialtype->getmaterialtype();  
          
    }
    
    
     public function deletetypeAction()
    {
       $request1 = $this->getRequest()->getParams('delete');
      
      $materialtype = new Materialtype();
        if(isset($request1['delete'])){
              $val = $materialtype->deletematerialtype($request1['delete']);	
          }
          if($val == '0'){
            $this->view->MessageType = 'success';
            $this->view->Message = 'Material Type has been deleted!!';
            }
            if($val == '1'){
            $this->view->MessageType = 'warning';
            $this->view->Message = 'Material Type active in some material!!';
            }
             $materialtype = new Materialtype();
            $this->view->materialtype = $materialtype->getmaterialtype();  
         
    }
     public function getmaterialtypeAction()
    {
       $request1 = $this->getRequest()->getPost();
      //echo "<pre>"; print_r($request1); exit;
      $materialtype = new Materialtype();
       $val = $materialtype->getmaterialtypeval($request1);
       echo json_encode($val);
        exit;
    }
    
     public function changestatustypeAction()
    {
       $request1 = $this->getRequest()->getPost();
        $materialtype = new Materialtype();
       $val = $materialtype->changestatustype($request1);
       $this->_redirect('admin/material/typemaster');
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
  }
  
  // 25-09-2015 
  // Project
//        
        public function projectmasterAction()
 {
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if (!$data) {
            $this->_redirect('admin/auth/login');
        }
        $project = new Project();
        $delete_id = $this->_getParam('delete_id');
        if ($delete_id) {
            
                 $where = $project->getAdapter()->quoteInto('project_id = ?', $delete_id);
                if ($project->delete($where)) {
                    $this->view->MessageType = 'success';
                    $this->view->Message = 'Project Removed successfully';
                } else {
                    $this->view->MessageType = 'Error';
                    $this->view->Message = 'Please Try again';
                }
        }
        if ($this->getRequest()->isPost()) {
            $data = $this->_request->getPost();
            $checkexist = $project->getProjects();
//            print_r($checkexist);
//            echo "===";
            
            $last = end($checkexist);
            $lastcode = $last['project_code'];
//            print_r($lastcode);
//       echo "===";
//       exit;
            $catcode = ++$lastcode;
            if ($data['name']) {
                foreach ($checkexist as $_checkexist) {

                    if ($data['name'] == $_checkexist['project_name']) {
                        $this->view->MessageType = 'warning';
                        $this->view->Message = "Project Already Exists";
                        $this->view->project = $project->getProjects();
                        return;
                    }
                }

                $_data = array('project_name' => $data['name'], 'project_code' => $catcode);
                if ($project->insert($_data)) {
                    $this->view->MessageType = 'success';
                    $this->view->Message = "New Project has been Created!!";
                }
            }
        }
        $this->view->project = $project->getProjects();
    }
//  
   public function getprojectAction()
    {
       $request1 = $this->getRequest()->getPost();
      $project = new Project();
       $val = $project->getprojectval($request1);
       echo json_encode($val);
        exit;
    }
//    
      public function changestatusprojectAction()
    {
       $request1 = $this->getRequest()->getPost();
       //echo "<pre>"; print_r($request1); exit;
      $project = new Project();
       $val = $project->changestatusproject($request1);
       $this->_redirect('admin/material/projectmaster');
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
  }
  
    public function shippingAction() {
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if (!$data) {
            $this->_redirect('admin/auth/login');
        }
    

        $edit = $this->_getParam('edit-id');
        $delete = $this->_getParam('delete');
        if ($delete) {
            $where = $this->_shipping->getAdapter()->quoteInto('id = ?', $delete);
            if ($this->_shipping->delete($where)) {
                $this->view->MessageType = 'success';
                $this->view->Message = "Deleted Successfully";
                $this->view->shipping = $this->_shipping->fetchAllMethod();
                return true;
}
        }
        if ($edit) {

            if ($this->_shipping->fetchEdit($edit)) {
                print_r(json_encode($this->_shipping->fetchEdit($edit)));
                exit;
            } else {
                echo 0;
                exit;
            }
        }

        if ($this->_request->getPost()) {

            $data = $this->_request->getPost();

            if ($data['id']) {
                if ($this->_shipping->checkUnique($data['name'])) {
                    $this->view->MessageType = 'warrning';
                    $this->view->Message = "Shipping Method already exists";
                    $this->view->shipping = $this->_shipping->fetchAllMethod();
                    return true;
                }else{
                $_data = array('name' => $data['name'], 'description' => $data['description'], 'status' => '0');
                $this->_helper->model->update('Shipping', $data['id'], $_data);
                $this->view->MessageType = 'success';
                $this->view->Message = "Shipping method has been updated";
                $this->view->shipping = $this->_shipping->fetchAllMethod();
                return true;
                }
            } else {
                if ($this->_shipping->checkUnique($data['name'])) {
                    $this->view->MessageType = 'warrning';
                    $this->view->Message = "Shipping Method already exists";
                    $this->view->shipping = $this->_shipping->fetchAllMethod();
                    return true;
                } else {
                    $_data = array('name' => $data['name'], 'description' => $data['description'], 'status' => '0');
                    if ($this->_shipping->insert($_data)) {
                        $this->view->MessageType = 'success';
                        $this->view->Message = "New Shipping method has been created.";
                        $this->view->shipping = $this->_shipping->fetchAllMethod();
                        return true;
                    }
                }
            }
        }

        $this->view->shipping = $this->_shipping->fetchAllMethod();
    }

    public function changestatusAction() {
        $request = $this->getRequest()->getPost();
        $data = array('status' => $request['status']);
        if ($this->_helper->model->update('Shipping', $request['id'], $data)) {
            echo 1;
            exit;
        }
        $this->_redirect('admin/bom/index');
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }
  
    
}