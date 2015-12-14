<?php

class Admin_CustomerController extends Zend_Controller_Action {

     protected $_moduleid = 'MM';
     protected $_customer = null;
     
     public function init() {
     
         $this->_customer=new Customer();
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
         
     }

      public function indexAction() {
          if(!$this->_helper->model->checklogged())
          {
                $this->_redirect('admin/auth/login');
          }
         $this->_redirect('admin/customer/manage');    
     }
     
     
     public function manageAction() {
        if (!$this->_helper->model->checklogged()) {
            $this->_redirect('admin/auth/login');
        }
        $this->view->resourceid = '10';
        $this->view->permission = $this->_permission[$this->view->resourceid];

        $delete_id = $this->_getParam('delete_id');
        $edit_id = $this->_getParam('edit_id');
        if ($edit_id) {
            if ($this->_customer->fetch($edit_id)) {
                print_r(json_encode($this->_customer->fetchEdit($edit_id)));
                exit;} else { echo 0;  exit; }
        }
        if ($delete_id) {
            if ($this->_customer->fetch($delete_id)) {
                 $where = $this->_customer->getAdapter()->quoteInto('customer_id = ?', $delete_id);
                if ($this->_customer->delete($where)) {
                    $this->view->MessageType = 'success';
                    $this->view->Message = 'Employee Removed successfully';
                } else {
                    $this->view->MessageType = 'Error';
                    $this->view->Message = 'Please Try again';
                }
            }
        }

        if ($this->getRequest()->isPost()) {
            $_data = $this->_request->getPost();
            if (!$_data['customer_id']) {
                
                 $check = $this->_customer->fetchAll($this->_customer->select()
                                            ->where('telephone = ?', $_data['telephone'])
                                            ->OrWhere('company_name = ?', $_data['company_name'])
                                            ->OrWhere('email = ?', $_data['email']));
                $check = $check->toArray();
                if(!$check)
                {
                $data = array('company_name' => $_data['company_name'], 'company_address' => $_data['company_address'],
                    'contact_person' => $_data['contact_person'],
                    'country' => $_data['country'],
                    'region' => $_data['region'],
                    'industry' => $_data['industry'],
                    'email' => $_data['email'],
                    'telephone' => $_data['telephone']
                );

                if ($this->_customer->insert($data)) {
                    $this->view->MessageType = 'success';
                    $this->view->Message = 'Customer Added successfully';
                }
                }
                else{
                    $this->view->MessageType = 'warrning';
                    $this->view->Message = 'Customer details seems to be exist already.Please check company name or email or telephone number.';
                }
            }

            if ($_data['customer_id']) {
                
                $data = array(
                    'company_name' => $_data['company_name'],
                    'company_address' => $_data['company_address'],
                    'contact_person' => $_data['contact_person'],
                    'country' => $_data['country'],
                    'region' => $_data['region'],
                    'industry' => $_data['industry'],
                    'email' => $_data['email'],
                    'telephone' => $_data['telephone']
                );
                $where = $this->_customer->getAdapter()->quoteInto('customer_id = ?', $_data['customer_id']);
                if ($this->_customer->update($data, $where)) {
                    $this->view->MessageType = 'success';
                    $this->view->Message = 'Customer details updated successfully';
                }
            }
        }
        $this->view->customerlist=$this->_customer->fetchAll();
}


}



   