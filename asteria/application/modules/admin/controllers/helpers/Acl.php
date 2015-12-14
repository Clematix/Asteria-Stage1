<?php

class Zend_Controller_Action_Helper_Acl extends Zend_Controller_Action_Helper_Abstract {

    protected $_aclmodel = null;
    protected $_aclrole = null;
    protected $_users = null;
    protected $_modules = null;
    protected $_resource_name = null;
    protected $_resource_path = null;
    protected $_permission = null;
    protected $_moduleid = 'UM';
    protected $_resourceid = null;
    
   public function role($roleId)
 {
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


        $rol['modules'] = $this->_modules;

        $rol['resources'] = $this->_resource_name;
        $rol['resourcepath'] = $this->_resource_path;
        $rol['modulesId'] = $this->_modulesId;
        $rol['permission'] = $this->_permission;

        return $rol;
    }

    public function checklogged()
    {   
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if ($data) {
            return $data;
        }
        else{
            return 0;
            
        }
    }
}
