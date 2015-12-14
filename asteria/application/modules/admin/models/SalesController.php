<?php

class Admin_SalesController extends Zend_Controller_Action {

    protected $_material = null;
    protected $_project = null;
    protected $_bom = null;
    protected $_bomref = null;
    protected $_materialtype = null;
    protected $_sales = null;
    protected $_customer = null;
    protected $_shipping = null;
    protected $_utilities = null;
    protected $_salesitem = null;
    protected $_moduleid = 'SO';

    public function init() {
        $this->_material = new Material();
        $this->_project = new Project();
        $this->_bom = new Bom();

        $this->_materialtype = new Materialtype();
        $this->_bomref = new Bomref();

        $this->_sales = new Sales();
        $this->_salesitem = new Salesitem();
        $this->_customer = new Customer();
        $this->_shipping = new Shipping();

        $this->_utilities = new Utilities();


        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if ($data) {
            $this->view->username = $data->firstname . " " . $data->lastname;
            $this->view->firstname = $data->firstname;
            if ($data->role) {
                $this->view->role = $data->role;
                $role = $this->_helper->acl->role($data->role);
            }
            $this->view->modules = $role['modules'];
            $this->view->resources = $role['resources'];
            $this->view->resourcepath = $role['resourcepath'];
            $this->view->moduleid = $this->_moduleid;
            $this->view->modulesId = $role['modulesId'];
            $this->_permission = $role['permission'];
        }
        $this->view->moduleid = $this->_moduleid;
    }

    
    public function newitem($data)
    {
        $_insert = array('so_no' => $this->runningsearialno(), 
                    'customer' => $data['customer_name'], 
                    'customer_po' => $data['customer_po'], 
                    'invoice_date' => date('d/m/Y'), 
                    'supplier' => $data['supplier_name'],
                    'shipping_method' => $data['shipping_method'],
                    'shipping_charges'=>$data['shipping_charge'],
                    'vat'=>$data['vat_charge'],
                    'cst'=>$data['cst_charge'],
                    'service_tax'=>$data['st_charge']);
                $id = $this->_sales->insert($_insert);
                if ($id) {
                    $i = 0;
                    foreach ($data['partnonew'] as $_data) {
                        $_insertitem = array('sales_id' => $id,
                            'item_code' => $data['partnonew'][$i],
                            'qty' => $data['qtynew'][$i],
                            'unit_price' => $data['unitpricepnew'][$i],
                            'item_code' => $data['partnonew'][$i]);
                        $i++;
                        $this->_salesitem->insert($_insertitem);
                    }
                }
                    return true;
    }
    public function updateitem($data)
    {
           $_update = array(
                    'customer' => $data['customer_name'], 
                    'customer_po' => $data['customer_po'], 
                    'invoice_date' => date('d/m/Y'), 
                    'supplier' => $data['supplier_name'],
                    'shipping_method' => $data['shipping_method'],
                    'shipping_charges'=>$data['shipping_charge'],
                    'vat'=>$data['vat_charge'],
                    'cst'=>$data['cst_charge'],
                    'service_tax'=>$data['st_charge']);
        $this->_helper->model->update('Sales', $data['id'], $_update);
        
         $i = 0;
                    foreach ($data['partnonew'] as $_data) {
                        $_insertitem = array('sales_id' => $data['id'],
                            'item_code' => $data['partnonew'][$i],
                            'qty' => $data['qtynew'][$i],
                            'unit_price' => $data['unitpricepnew'][$i],
                            'item_code' => $data['partnonew'][$i]);
                        $i++;
                        $this->_salesitem->insert($_insertitem);
                    }
                    $j=0;
                    foreach ($data['partno'] as $_data) {
                        $_update = array('sales_id' => $data['id'],
                            'item_code' => $data['partno'][$j],
                            'qty' => $data['qty'][$j],
                            'unit_price' => $data['unitpricep'][$j],
                            'item_code' => $data['partno'][$j]);
                        $this->_helper->model->update('Salesitem', $data['sales_line_id'][$j], $_update);
                         $j++;
                    }
         
                    return true;
    }
    public function indexAction() {

        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if (!$data) {
            $this->_redirect('admin/auth/login');
        }
        if ($this->getRequest()->isPost()) {
          
            $data = $this->_request->getPost();

            if ($data['id']) {
              $this->updateitem($data);     
                
            } else {
                   $this->newitem($data);
            }
        }
$salesorder=$this->_sales->fetchAllSo();
$i=0;
foreach($salesorder as $_salesorder)
{
    if($_salesorder){
    $total=$this->_salesitem->total($_salesorder['id']);
    $_total=0;
    foreach($total as $tot)
    {
        $_total=$_total+($tot['qty']*$tot['unit_price']);
    }
    $_allsales[$i]=array(
        'id'=>$_salesorder['id'],
        'so_no'=>$_salesorder['so_no'],
        'customer_po'=>$_salesorder['customer_po'],
        'customer_name'=>$this->_customer->fetchCustomerName($_salesorder['customer']),
        'invoice_date'=>$_salesorder['invoice_date'],
        'total'=>$_total,
        'status'=>$_salesorder['status'],
        
    );
    $i++;
    }
}
        $this->view->salesorder=$_allsales;
        $this->view->shipping = $this->_shipping->fetchMethods();
        $this->view->customer = $this->_customer->fetchAllCustomer();
        $this->view->supllier = $this->_utilities->fetchSupplierAddress();
    }

    public function customeraddressAction() {
        if ($this->getRequest()->getParam('id')) {
            print_r($this->_customer->fetchCustomerAddress($this->getRequest()->getParam('id')));
            exit;
        }
    }

    public function additemAction() {

        if ($this->getRequest()->getParam('id')) {
            $data = $this->_material->getmaterialactive();
            $i = 0;
            foreach ($data as $_data) {
                $sales['material'][$i] = array('id' => $_data['id'],
                    'partno' => $_data['part_no'],
                    'desc' => $_data['material_desc'],
                    'uom' => $this->_material->fetchUom($_data['uom']));
                $i++;
            }

            print_r(json_encode($sales));
            exit;
        }
    }

    public function addlineitemAction() {

        if ($this->getRequest()->getParam('add')) {
            $data = $this->_material->fetchMaterial($this->getRequest()->getParam('add'));
            $_data['desc'] = $data['material_desc'];
            $_data['uom'] = $this->_material->fetchUom($data['uom']);

            print_r(json_encode($_data));
            exit;
        }
    }

    public function runningsearialno() {
        
      $sono=$this->_utilities->fetchSoNo();

        date_default_timezone_set('Asia/Kolkata');
        $dt = new DateTime();
        $currentyear = $dt->format('Y');
        $so_year = explode('/', $sono);

        if ($so_year[0] == $currentyear) {
            $so_id = ++$so_year[1];
            $count = 4 - strlen($so_id);
            for ($i = 0; $i < $count; $i++) {
                $so_id = '0' . $so_id;
            }
            $_sono = $currentyear . '/' . $so_id;
        } else {
            $_sono = $currentyear . '/0001';
        }
         $_data=array('content'=>$_sono);
         $this->_helper->model->update('Utilities', 2, $_data);
     return $_sono;
     
    }

    public function changestatusAction() {
        
        $request = $this->getRequest()->getPost();
        $data = array('status' => $request['status']);
        if ($this->_helper->model->update('Sales', $request['id'], $data)) {
            if($request['status']==1){
//            $so=$this->runningsearialno();
//            $_data=array('content'=>$so);
//             $_data1=array('so_no'=>$so);
//             $this->_helper->model->update('Utilities', 2, $_data);
//             $this->_helper->model->update('Sales', $request['id'], $_data1);
            }
            echo 1;
            exit;
        }
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }
    
    
     public function refreshAction() {
        
        $data = $this->getRequest()->getPost();
        
        if($data['id'])
        {
            $sales['so']=$this->_sales->getSO($data['id']);
            $sales['address']=$this->_customer->fetchCustomerAddress($sales['so']['customer']);
            $salesorder=$this->_salesitem->lineitembyId($data['id']);
            $i=0;
            $sales['total']=0;
          
            foreach($salesorder as $_salesorder)
            {
            $material=$this->_material->fetchMaterial($_salesorder['item_code']);
            $sales['lineitem'][$i]=array(
                'id'=>$_salesorder['id'],
                'part_id'=>$material['id'],
                'material_desc' => $material['material_desc'],
                'qty'=>$_salesorder['qty'],
                'unitprice'=>$_salesorder['unit_price'],
                'uom' => $this->_material->fetchUom($material['uom']),
                'lt'=>$_salesorder['qty']*$_salesorder['unit_price']
                
            );$i++;
            $sales['total']=$sales['total']+$_salesorder['qty']*$_salesorder['unit_price'];
            }
            
            
        }
        $sales['material'] = $this->_material->getmaterialactivePartno();
        print_r(json_encode($sales));exit;
       
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }
    
     public function deletesoAction() {
         if ($this->_getParam('delete')) {
            if ($this->_sales->getSo($this->_getParam('delete'))) {
                if ($this->_helper->model->delete('Sales', $this->_getParam('delete'))) {
                     $table1= new Salesitem();
                     $table1->delete('sales_id='.$this->_getParam('delete'));
                  $this->_redirect('admin/sales/index');
                } 
            }
             $this->_redirect('admin/sales/index');
             
        }
        
        if ($this->_getParam('delid')) {
                    $table1= new Salesitem();
                     $table1->delete('id='.$this->_getParam('delid'));
                     echo 1;exit;
        }
     }
}
