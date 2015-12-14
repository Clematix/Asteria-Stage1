<?php

class Admin_AuthController extends Zend_Controller_Action {

    protected $_aclmodel = null;
    protected $_aclrole = null;
    protected $_users = null;
    protected $_modules = null;
    protected $_resource_name = null;
    protected $_resource_path = null;
    protected $_permission = null;
    protected $_moduleid = 'UM';
    protected $_resourceid = null;

    public function init() {
 
        $this->_aclmodel = new AclRoles();
        $this->_aclrole = new Aclrole();

        $this->_users = new Adminusers();

        $this->_modules = array();
        $this->_resource_name = array();
        $this->_resource_path = array();
        $this->_permission = array();
        $this->_modulesId = array();

        $permission_module = array();
        $permission_name = array();
        $permission_resource = array();

        $permission_resource_name = array();
        $permission_resource_path = array();

        if ($this->checklogged()) {
            $data = $this->checklogged();

            $this->view->username = $data->firstname . " " . $data->lastname;
            if ($data->role) {
                $this->view->role = $data->role;
            }
            $roles = array();
            foreach (json_decode($data->role, true) as $role) {

                array_push($roles, $this->_aclrole->fetchRoles($role));
            }

            
            $module = array();
            $resource = array();
            $permission = array();
            $_permission = array();
$k=1;
foreach ($roles as $_roles) {
                $module = $module + json_decode($_roles['acl_module_id'], true);
                $resource[$k] = json_decode($_roles['acl_controller_id'], true);
                $_permission[$k] = json_decode($_roles['acl_permission'], true);
$k++;
            }
            $_res=array();
            foreach ($resource as $res) {
                foreach ($module as $key => $val) {
                    if ($_res[$val]) {
                        if($res[$val]){
                        $_res[$val] =$_res[$val] +  $res[$val];
                        
                        }
                    } else {
                        $_res[$val] =  $res[$val];
                    }
                }
            }
           
            $resource=array_filter($_res);

            
            foreach ($_permission as $permit) {
                foreach ($permit as $key => $val) {
                    if ($permit[$key]['view']) {
                        $permission[$key]['view'] = $permit[$key]['view'];
                    }
                    if ($permit[$key]['create']) {
                        $permission[$key]['create'] = $permit[$key]['create'];
                    }
                    if ($permit[$key]['edit']) {
                        $permission[$key]['edit'] = $permit[$key]['edit'];
                    }
                    if ($permit[$key]['approve']) {
                        $permission[$key]['approve'] = $permit[$key]['approve'];
                    }
                }
            }

//            $permission=array_filter($permission);
     
            ksort($module);
//            $resource = json_decode($roles['acl_controller_id'], true)+json_decode($roles1['acl_controller_id'], true);
//            $permission = json_decode($roles['acl_permission'], true)+json_decode($roles1['acl_permission'], true);
$i = 1;
$j = 1;
            foreach ($module as $_modules) {

                $this->_modules[$_modules]['name'] = $this->_aclmodel->fetchModulename($_modules);
                $this->_modulesId[$_modules]['id'] = $_modules;
                $permission_resource[$_modules]['resource'] = $resource[$_modules];
                unset($permission_resource_name);
                unset($permission_resource_path);
                foreach ($permission_resource[$_modules]['resource'] as $key=>$val) {

                    $permission_resource_name[$key]['resourcename'] = $this->_aclmodel->fetchResourceName($val);
                    $permission_resource_path[$key]['resourcepath'] = $this->_aclmodel->fetchResourcePath($val);
                   
                    $j++;
                }
                $this->_resource_name[$_modules] = $permission_resource_name;
                $this->_resource_path[$_modules] = $permission_resource_path;
                $i++;
            }
        }
         $this->_permission = $permission;

        $this->view->modules = $this->_modules;
        $this->view->resources = $this->_resource_name;
        $this->view->resourcepath = $this->_resource_path;
        $this->view->moduleid = $this->_moduleid;
        $this->view->modulesId = $this->_modulesId;
    }

    public function checklogged() {
        return $this->_helper->model->checklogged();
    }

    public function checkExist($table, $data_exist, $data) {
        return $this->_helper->model->checkExist($table, $data_exist, $data);
    }

    public function selectAll($table) {
        return $this->_helper->model->selectAll($table, $email);
    }

    public function selectAllBystatus($table) {
        return $this->_helper->model->selectAllBystatus($table, $email);
    }

    public function delete($table, $id) {
        return $this->_helper->model->delete($table, $id);
    }

    public function update($table, $id, $data) {
        return $this->_helper->model->update($table, $id, $data);
    }

    public function edit($table, $id) {
        return $this->_helper->model->edit($table, $id);
    }

    public function fetchrow($table, $id) {
        return $this->_helper->model->fetchrow($table, $id);
    }

    public function checkUnique($table, $email) {
        return $this->_helper->model->checkUnique($table, $email);
    }

    public function insert($table, $data) {
        return $this->_helper->model->insert($table, $data);
    }

    public function authUser($table, $email, $password) {
        return $this->_helper->model->authUser($table, $email, $password);
    }

    public function authEmp($table, $email, $password) {
        return $this->_helper->model->authEmp($table, $email, $password);
    }

    public function loginAction() {

        if ($this->getRequest()->isPost()) {
            $data = $this->_request->getPost();
            $auth = $this->authUser('adminusers', $data['email'], $data['password']);
               $_data=$this->checklogged();
            if ($auth  && ($_data->status==1)) {
                $this->_redirect('admin/auth/home');
            } else {
                 $storage = new Zend_Auth_Storage_Session();
                 $storage->clear();
                $this->view->errorMessage = "Invalid username or password. Please try again.";
                return;
            }
        }
        $_data=$this->checklogged();
        if ($_data->status==1) {
            $this->_redirect('admin/auth/home');
        }
    }

    public function logoutAction() {
        $storage = new Zend_Auth_Storage_Session();
        $storage->clear();
        $this->_redirect('admin/auth/login');
    }

    public function indexAction() {
       
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if (!$data) {
            $this->_redirect('admin/auth/login');
        }
         $this->view->username = $data->firstname . " " . $data->lastname;
    }

    public function homeAction() {
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if (!$data) {
            $this->_redirect('admin/auth/login');
        }
        $this->view->username = $data->firstname . " " . $data->lastname;
    }

    public function addgroupdeptAction() {
        if (!$this->checklogged()) {
            $this->_redirect('admin/auth/login');
        }
        $this->view->resourceid = '2';
        $this->view->permission = $this->_permission[$this->view->resourceid];


        $department = new Department();
        $designation = new Designation();

        $delete_desg_id = $this->_getParam('delete_designation_id');
        $delete_dept_id = $this->_getParam('delete_dept_id');

        $edit_designation_id = $this->_getParam('edit_designation');
        $edit_department_id = $this->_getParam('edit_department');
        if ($edit_department_id) {
            if ($department->fetchEdit($edit_department_id)) {
                print_r(json_encode($department->fetchEdit($edit_department_id)));
                exit;
            } else {
                echo 0;
                exit;
            }
        }
        if ($edit_designation_id) {
            if ($designation->fetchEdit($edit_designation_id)) {
                print_r(json_encode($designation->fetchEdit($edit_designation_id)));
                exit;
            } else {
                echo 0;
                exit;
            }
        }
        if ($delete_desg_id) {
            if ($designation->fetchEdit($delete_desg_id)) {
                if ($this->delete('designation', $delete_desg_id)) {
                    $this->view->MessageType = 'success';
                    $this->view->Message = 'Designation Removed successfully';

                    $this->view->showid = 'viewgorup';
                } else {
                    $this->view->MessageType = 'Error';
                    $this->view->Message = 'Please Try again';
                }
            }
        }
        if ($delete_dept_id) {
            if ($department->fetchEdit($delete_dept_id)) {
                if ($this->delete('department', $delete_dept_id)) {
                    $this->view->MessageType = 'success';
                    $this->view->Message = 'Department Removed successfully';
                    $this->view->showid = 'viewdept';
                } else {
                    $this->view->MessageType = 'Error';
                    $this->view->Message = 'Please Try again';
                }
            }
        }

        if ($this->getRequest()->isPost()) {
            $data = $this->_request->getPost();
            if ($data['department']) {

                if ($this->checkExist('department', 'name', array('name' => $data['department']))) {
                    $this->view->Message = 'Department name Alreadey Exist';
                    $this->view->MessageType = 'warning';
                    $this->view->showid = 'adddept';
                } else {
                    if ($data['register_dept'] == 'update') {
                        $this->update('department', $data['deptid'], array('name' => $data['department'],'status'=>'0'));
                        $this->view->Message = 'Department updated successfully';
                    } else {
                        $this->insert('department', array('name' => $data['department'],'status'=>'0'));
                        $this->view->Message = 'New Department Added successfully';
                    }

                    $this->view->showid = 'adddept';
                    $this->view->MessageType = 'success';
                }
            }
            if ($data['group']) {

                if ($this->checkExist('Designation', 'name', array('name' => $data['group']))) {
                    $this->view->showid = 'adddesign';
                    $this->view->MessageType = 'warning';
                    $this->view->Message = 'Designation Alreadey Exist';
                } else {
                    if ($data['register_design'] == 'update') {
                        $this->update('Designation', $data['design'], array('name' => $data['group'],'status'=>'0'));
                        $this->view->Message = 'New Designation updated successfully';
                    } else {
                        $this->insert('Designation', array('name' => $data['group'],'status'=>'0'));

                        $this->view->Message = 'New Designation Added successfully';
                    }
                    $this->view->MessageType = 'success';
                    $this->view->showid = 'adddesign';
                }
            }
        }

        if ($this->selectAll('department')) {
            $this->view->deptList = $this->selectAll('department');
        }
        if ($this->selectAll('Designation')) {
            $this->view->groupList = $this->selectAll('Designation');
        }
        return;
    }

    public function rolesAction() {
        if (!$this->checklogged()) {
            $this->_redirect('admin/auth/login');
        }
        $this->view->resourceid = '3';
        $this->view->permission = $this->_permission[$this->view->resourceid];


        $edit_role = $this->_getParam('edit_role');
        if ($edit_role) {

            if ($this->_aclrole->fetchEdit($edit_role)) {
                $roles = $this->_aclrole->fetchRoles($edit_role);
                $role['a'] = json_decode($roles['acl_module_id'], true);
                $role['b'] = json_decode($roles['acl_controller_id'], true);
                $role['c'] = json_decode($roles['acl_permission'], true);
                $role['d'] = $roles['acl_role_name'];
                $role['e'] = $roles['acl_role_id'];
                print_r(json_encode($role));
                exit;
            }
        }
        $delete_role = $this->_getParam('delete_role');

        if ($delete_role) {
            if ($this->_aclrole->fetchEdit($delete_role)) {

                if ($this->_helper->model->deleterow('aclrole', $delete_role)) {
                    $this->view->MessageType = 'success';
                    $this->view->Message = 'Role Removed successfully';

                    $this->view->showid = 'viewgorup';
                } else {
                    $this->view->MessageType = 'Error';
                    $this->view->Message = 'Please Try again';
                }
            }
        }
        


        if ($this->getRequest()->isPost()) {
            $module = array();
            $module_resource = array();
            $module_resource_permission = array();
            $resource = array();
            $permission = array();
            $data = $this->_request->getPost();


            for ($i = 1; $i < count($data); $i++) {
                if ($this->_getParam('module' . $i)) {
                    unset($resource);
                    $module[$i] = $this->_getParam('module' . $i);
                    for ($j = 1; $j < count($data); $j++) {

                        if ($this->_getParam($module[$i] . $j)) {
                            unset($permission);

                            $resource[$j] = $this->_getParam($module[$i] . $j);

                            if ($this->_getParam($module[$i] . $j . '_view')) {
                                $permission['view'] = $this->_getParam($module[$i] . $j . '_view');
                            }
                            if ($this->_getParam($module[$i] . $j . '_create')) {
                                $permission['create'] = $this->_getParam($module[$i] . $j . '_create');
                            }
                            if ($this->_getParam($module[$i] . $j . '_edit')) {
                                $permission['edit'] = $this->_getParam($module[$i] . $j . '_edit');
                            }
                            if ($this->_getParam($module[$i] . $j . '_approve')) {
                                $permission['approve'] = $this->_getParam($module[$i] . $j . '_approve');
                            }
                            if ($permission) {
                                $module_resource_permission[$j] = $permission;
                            }
                        }
                    }

                    $module_resource[$module[$i]] = $resource;
                }
//                echo '<pre>';
            }
//             print_r($module_resource);exit;
            $rolename = $this->_getParam('rolename');
            $update = $data['role_id'];
            $data_roles = array('acl_role_name' => $rolename, 'acl_module_id' => json_encode($module), 'acl_controller_id' => json_encode($module_resource), 'acl_permission' => json_encode($module_resource_permission),'status'=>'0');
            if ($this->_getParam('register') == 'update') {
                if ($module && $module_resource && $module_resource_permission) {
                    $edit = new Aclrole();
                    $where = $edit->getAdapter()->quoteInto('acl_role_id = ?', $update);
                    $update1 = $edit->update($data_roles, $where);
                    if ($update1) {

                        $this->view->MessageType = 'success';
                        $this->view->Message = 'Role <b>' . $data_roles['acl_role_name'] . '</b> updated successfully';
                    } else {
//                    $this->view->MessageType = 'Error';
//                    $this->view->Message = 'Error occured while updating.Please try ';
                    }
                } else {
                    $this->view->MessageType = 'warning';
                    $this->view->Message = 'Cannot update empty role';
                }
            } else {
                if ($this->_aclrole->checkRole($data['rolename'])) {
                    $this->view->MessageType = 'warning';
                    $this->view->Message = 'Role name Alreadey Exist';
                } else {
                    if ($module && $module_resource && $module_resource_permission) {
                        if ($this->_helper->model->insert('Aclrole', $data_roles)) {
                            $this->view->MessageType = 'success';
                            $this->view->Message = 'Role created successfully';
                        } else {
                            $this->view->MessageType = 'error';
                            $this->view->Message = 'Error occured while creating role.Please try again';
                        }
                    } else {
                        $this->view->MessageType = 'error';
                        $this->view->Message = 'Please select functions and permision';
                    }
                }
            }
        }


        $module_role = array();
        $modules = $this->_aclmodel->fetchModules();
        if ($this->selectAll('aclrole')) {
            $this->view->roleList = $this->selectAll('aclrole');
        }
        foreach ($modules as $_modules) {
            $module_resource[$_modules['module_id']] = $this->_aclmodel->fetchResource('module_id', $_modules['module_id']);
        }

        $role_used = array();
            $roles_del = $this->_users->fetchRoles();
            foreach ($roles_del as $_roles_del) {
                foreach (json_decode($_roles_del['role'], true) as $_val) {
                    array_push($role_used, $_val);
                }
            }
        $this->view->roledel=array_unique($role_used);
        $this->view->module = $modules;
        $this->view->resource = $module_resource;
    }

    public function manageemployeeAction() {

        if (!$this->checklogged()) {
            $this->_redirect('admin/auth/login');
        }
        $this->view->resourceid = '1';
        $this->view->permission = $this->_permission[$this->view->resourceid];

        $url = Zend_Controller_Front::getInstance()->getRequest()->getRequestUri();

        $delete_id = $this->_getParam('delete_id');
        $edit_id = $this->_getParam('edit_id');
        if ($edit_id) {
            if ($this->_users->fetchEdit($edit_id)) {
                print_r(json_encode($this->_users->fetchEdit($edit_id)));
                exit;
            } else {
                echo 0;
                exit;
            }
        }
        if ($delete_id) {
            if ($this->fetchrow('adminusers', $delete_id)) {
                if ($this->delete('Adminusers', $delete_id)) {
                    $this->view->MessageType = 'success';
                    $this->view->Message = 'Employee Removed successfully';
                } else {
                    $this->view->MessageType = 'Error';
                    $this->view->Message = 'Please Try again';
                }
            }
        }

        if ($this->selectAllBystatus('Department')) {
            $this->view->deptList = $this->selectAllBystatus('Department');
                        
        }
        
        if ($this->selectAllBystatus('Designation')) {
            $this->view->groupList = $this->selectAllBystatus('Designation');
       }
        if ($this->selectAllBystatus('Aclrole')) {
            $this->view->roleList = $this->selectAllBystatus('Aclrole');
        }
       
        
        if ($this->getRequest()->isPost()) {
            $data = $this->_request->getPost();
            $data['roles'] = json_encode($data['role']);

            if ($data['password'] != $data['confirmPassword']) {
                $this->view->Message = "Password and confirm password don't match.";
                $this->view->MessageType = 'warning';
            } else {
                if ($data['register'] == 'update') {
                   $old= $this->_users->fetchPassword($data['id']);
                    if($old==$data['password']){
                      
                   $data_update = array('status'=>'0','firstname' => $data['firstname'], 
                       'lastname' => $data['lastname'],
                       'role' => $data['roles'], 'department' => $data['department'], 
                       'group' => $data['group']);
                   }
                   else{
                        $data_update = array('status'=>'0','firstname' => $data['firstname'], 
                       'lastname' => $data['lastname'], 'password' => md5($data['password']),
                       'role' => $data['roles'], 'department' => $data['department'], 
                       'group' => $data['group']);
                   }
                    $this->update('adminusers', $data['id'], $data_update);
                    $this->view->MessageType = 'success';
                    $this->view->Message = "Employee Details updated Successfully";
                }
                if ($data['register'] == 'add') {
                    $data_user = array('status'=>'0','firstname' => $data['firstname'], 'lastname' => $data['lastname'], 'email' => $data['email'], 'password' => md5($data['password']), 'role' => $data['roles'], 'department' => $data['department'], 'group' => $data['group']);
                    if ($this->checkUnique('Adminusers', $data['email'])) {
                        $this->view->Message = "Email Id already Exist";
                        $this->view->MessageType = 'warning';
                        return true;
                    }
                    $this->insert('adminusers', $data_user);

                    $this->_helper->mail->sendmail($data_user);

                    $this->view->MessageType = 'success';
                    $this->view->Message = "Employee Added Successfully";
                }
            }
        }
        
        if ($this->selectAll('adminusers')) {
            $data = $this->selectAll('adminusers');
            $deptartment = new Department();
            $designation = new Designation();

            foreach ($data as $_data) {
                $_designation[$_data['id']] = $designation->fetchOne($_data['group']);
                $_department[$_data['id']] = $deptartment->fetchOne($_data['department']);
            }

            $this->view->designation = $_designation;
            $this->view->department = $_department;
            $this->view->emplist = $this->selectAll('adminusers');
            $rol = array();
            unset($rol);
            foreach ($this->selectAll('adminusers') as $roleview) {
                $role = json_decode($roleview['role']);
                $i = 0;
                foreach ($role as $roleid) {
                    $rolename = $this->_aclrole->fetchRoles($roleid);
                    $rol[$roleview['id']][$i] = $rolename['acl_role_name'];
                    $i++;
                }
                $this->view->roleView = $rol;
            }
        }
    }

    public function mailconfigAction() {

        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();

        if (!$data) {
            $this->_redirect('admin/auth/login');
        }
        $this->view->username = $data->firstname . " " . $data->lastname;

        $entry = new Config();


        $this->view->mailconfig = $entry->fetchAll();

        if ($this->getRequest()->isPost()) {
            $formData = $this->_request->getPost();
            // print_r($formData);

            $eff_date = new Zend_Date();
            $data = array('mail_server' => $formData['mail_server'], 'mail_port' => $formData['mail_port'], 'mail_username' => $formData['mail_username'], 'mail_password' => $formData['mail_password'], 'admin_mail' => $formData['admin_mail'], 'contact_mail' => $formData['contact_mail'], 'date' => $eff_date);

            if ($data) {
                if ($entry->fetchAll()) {
                    $entry->truncate();
                    $entry->insert($data);
                } else {

                    $entry->insert($data);
                }
            }
        }
    }

    public function profileAction() {



        if ($this->getRequest()->isPost()) {
            $adminuser = new Adminusers();
            $formData = $this->_request->getPost();

            $checkUser = $adminuser->fetchEdit($formData['id']);
            if ($formData['password']) {
                if ($checkUser['password'] == md5($formData['password'])) {
                    if ($formData['rnpassword'] == $formData['npassword']) {

                        $data_user = array('firstname' => $formData['firstname'], 'lastname' => $formData['lastname'],  'password' => md5($formData['npassword']));

                        $this->update('adminusers', $formData['id'], $data_user);

                        $authData = Zend_Auth::getInstance()->getIdentity();

                        $authData->firstname = $formData['firstname'];
                        $authData->lastname = $formData['lastname'];
//                        $authData->email = $formData['email'];

                        $this->view->MessageType = 'success';
                        $this->view->Message = 'Your details updated successfully.';
                    } else {
                        $this->view->MessageType = 'warnning';
                        $this->view->Message = 'Please check your re-entered password.';
                    }
                } else {
                    $this->view->MessageType = 'warnning';
                    $this->view->Message = 'The password you have entered in not correct.';
                }
            } else {
                $data_user = array('firstname' => $formData['firstname'], 'lastname' => $formData['lastname']);
                $this->update('adminusers', $formData['id'], $data_user);

                $authData = Zend_Auth::getInstance()->getIdentity();
                $authData->firstname = $formData['firstname'];
                $authData->lastname = $formData['lastname'];
//                $authData->email = $formData['email'];

                $this->view->MessageType = 'success';
                $this->view->Message = 'Your details updated successfully.';
            }
        }
        if ($this->checklogged()): {
                $data = $this->checklogged();
                $user['firstname'] = $data->firstname;
                $user['lastname'] = $data->lastname;
                $user['id'] = $data->id;
                $user['email'] = $data->email;

                $this->view->userdetails = $user;
                $deptartment = new Department();
                $designation = new Designation();

                $this->view->designation = $designation->fetchOne($data->group);
                $this->view->department = $deptartment->fetchOne($data->department);
            } else: {
                $this->_redirect('admin/auth/login');
            }endif;
    }

    public function rolelist() {
        $id = $this->_getParam('id');
        if ($id) {
            $this->delete('Adminusers', $id);
            $this->view->MessageType = 'success';
            $this->view->Message = 'Employee Removed successfully';
        } else {
            
        }
    }
    
    
    
     public function signupAction() {
        if ($this->getRequest()->isPost()) {
            $data = $this->_request->getPost();
            if ($data['password'] != $data['confirmPassword']) {
                $this->view->errorMessage = "Password and confirm password don't match.";
                return;
            }
            if ($this->checkUnique('adminusers', $data['email'])) {
                $this->view->errorMessage = "Email Id already Exist";
                return;
            }
            unset($data['confirmPassword']);
            $data = array('status' => 'inactive', 'firstname' => $data['firstname'], 'lastname' => $data['lastname'], 'email' => $data['email'], 'password' => md5($data['password']), 'role' => 0, 'department' => $data['department'], 'group' => $data['group']);
            $this->insert('adminusers', $data);
            if ($this->checklogged()) {
                $this->_redirect('admin/auth/home');
            }
            $this->_redirect('admin/auth/login');
        }
    }

    public function forgotpasswordAction() {
        if ($this->getRequest()->isPost()) {
            $email = $this->_getParam('email');
            if ($this->checkUnique('adminusers', $email)) {
                if ($this->fetchrow('adminusers', $email)) {
                    $data = $this->fetchrow('adminusers', $email);
                    $data['id'];
                    $this->_redirect('admin/auth/recoverpassword/emp/false/id/' . $data['id'] . '/hash/' . md5($data['id']));
                }
            }
            if ($this->checkUnique('employees', $email)) {
                if ($this->fetchrow('employees', $email)) {
                    $data = $this->fetchrow('employees', $email);
                    $data['id'];
                    $this->_redirect('admin/auth/recoverpassword/emp/true/id/' . $data['id'] . '/hash/' . md5($data['id']));
                }
            }

            $this->view->errorMessage = 'Please check the Email';
        }
    }

    public function recoverpasswordAction() {
        if ($this->getRequest()->isPost()) {
            $data = $this->_request->getPost();
            if ($data['password'] == $data['repassword']) {
                $id = base64_decode($data['hashid']);
                $data = array('password' => md5($data['password']));
                if ($this->_getParam('emp') == 'false') {
                    $this->update('adminusers', $id, $data);
                } else {
                    $this->update('employees', $id, $data);
                }
                $this->view->errorMessage = 'Your new password updated successfully';
                $this->view->redirect = true;
                return;
            } else {
                $this->view->errorMessage = 'please check password';
            }
        }
        $id = $this->_getParam('id');
        $md_id = $this->_getParam('hash');
        if (md5($id) == $md_id) {
            $this->view->hash = base64_encode($id);
        } else {
            $this->_redirect('admin/auth/forgotpassword');
        }
    }

    public function changeempstatusAction() {
        $request = $this->getRequest()->getPost();
        $data = array('status' => $request['status']);
        if ($this->_helper->model->update('adminusers', $request['id'], $data)) {
            echo 1;
            exit;
        }
        $this->_redirect('admin/auth/manageemployee');
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function changerolestatusAction() {
        $request = $this->getRequest()->getPost();
        $data = array('status' => $request['status']);
      
        $role = new Aclrole();
        $where = $role->getAdapter()->quoteInto('acl_role_id = ?', $request['id']);
        if($role->update($data, $where)){
            echo 1;
            exit;
}
        $this->_redirect('admin/auth/manageemployee');
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }


     public function changedeptstatusAction() {
        $request = $this->getRequest()->getPost();
        $data = array('status' => $request['status']);

        $role = new Department();
        $where = $role->getAdapter()->quoteInto('id = ?', $request['id']);
        if($role->update($data, $where)){
            echo 1;
            exit;
        }
        $this->_redirect('admin/auth/manageemployee');
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }

   
     public function changegroupstatusAction() {
        $request = $this->getRequest()->getPost();
        $data = array('status' => $request['status']);
      
        $role = new Designation();
        $where = $role->getAdapter()->quoteInto('id = ?', $request['id']);
        if($role->update($data, $where)){
            echo 1;
            exit;
        }
        $this->_redirect('admin/auth/manageemployee');
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }

}




   