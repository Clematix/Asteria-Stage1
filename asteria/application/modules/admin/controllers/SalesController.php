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
    protected $_inventory = null;
    protected $_workorder = null;
    protected $_soclosed = null;
    protected $_purchaseitem = null;
    protected $_availableitem = null;
    protected $_moduleid = 'SO';

    public function init() {
        $this->_material = new Material();
        $this->_project = new Project();
        $this->_bom = new Bom();

        $this->_soclosed = new Soclosed();

        $this->_inventory = new Inventory();
        $this->_workorder = new Workorder();




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

    public function newitem($data) {
        $_insert = array('so_no' => $this->runningsearialno(),
            'customer' => $data['customer_name'],
            'customer_po' => $data['customer_po'],
            'invoice_date' => date('d/m/Y'),
            'supplier' => $data['supplier_name'],
            'shipping_method' => $data['shipping_method'],
            'shipping_charges' => $data['shipping_charge'],
            'vat' => $data['vat_charge'],
            'cst' => $data['cst_charge'],
            'service_tax' => $data['st_charge'], 'status' => '0');
        $id = $this->_sales->insert($_insert);
        if ($id) {
            $i = 0;
            foreach ($data['partnonew'] as $_data) {
                $_insertitem = array('sales_id' => $id,
                    'item_code' => $data['partnonew'][$i],
                    'qty' => $data['qtynew'][$i],
                    'unit_price' => $data['unitpricepnew'][$i],
                    'item_code' => $data['partnonew'][$i],
                    'project_id' => $data['projectnew'][$i], 'status' => '0');
                $i++;
                $this->_salesitem->insert($_insertitem);
            }
        }
        return true;
    }

    public function updateitem($data) {
        $_update = array(
            'customer' => $data['customer_name'],
            'customer_po' => $data['customer_po'],
            'invoice_date' => date('d/m/Y'),
            'supplier' => $data['supplier_name'],
            'shipping_method' => $data['shipping_method'],
            'shipping_charges' => $data['shipping_charge'],
            'vat' => $data['vat_charge'],
            'cst' => $data['cst_charge'],
            'service_tax' => $data['st_charge'], 'status' => '0');
        $this->_helper->model->update('Sales', $data['id'], $_update);

        $i = 0;
        foreach ($data['partnonew'] as $_data) {
            $_insertitem = array('sales_id' => $data['id'],
                'item_code' => $data['partnonew'][$i],
                'qty' => $data['qtynew'][$i],
                'unit_price' => $data['unitpricepnew'][$i],
                'item_code' => $data['partnonew'][$i],
                'project_id' => $data['projectnew'][$i], 'status' => '0');
            $i++;
            $this->_salesitem->insert($_insertitem);
        }
        $j = 0;
        foreach ($data['partno'] as $_data) {
            $_update = array('sales_id' => $data['id'],
                'item_code' => $data['partno'][$j],
                'qty' => $data['qty'][$j],
                'unit_price' => $data['unitpricep'][$j],
                'item_code' => $data['partno'][$j],'project_id' => $data['project'][$j], 'status' => '0');
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
//            print_r($data);exit;

            if ($data['id']) {
                $this->updateitem($data);
                  $this->view->MessageType = 'success';
                    $this->view->Message = 'Sales Order has been updated';
            } else {
                $this->newitem($data);
                 $this->view->MessageType = 'success';
                    $this->view->Message = 'Sales Order  has been created';
            }
        }
        $salesorder = $this->_sales->fetchAllSo();
        $i = 0;
        if ($salesorder) {
            foreach ($salesorder as $_salesorder) {
                $total = $this->_salesitem->total($_salesorder['id']);
                $_total = 0;
                foreach ($total as $tot) {
                    $_total = $_total + ($tot['qty'] * $tot['unit_price']);
                }
                $_allsales[$i] = array(
                    'id' => $_salesorder['id'],
                    'so_no' => $_salesorder['so_no'],
                    'customer_po' => $_salesorder['customer_po'],
                    'customer_name' => $this->_customer->fetchCustomerName($_salesorder['customer']),
                    'invoice_date' => $_salesorder['invoice_date'],
                    'total' => $_total,
                    'status' => $_salesorder['status'],
                );
                $i++;
            }
        }

        $this->view->salesorder = $_allsales;
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
            $sales['project'] = $this->_project->getprojectactive();
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

        $sono = $this->_utilities->fetchSoNo();

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
        $_data = array('content' => $_sono);
        $this->_helper->model->update('Utilities', 4, $_data);
        return $_sono;
    }

    public function runningsearialnowo() {

        $sono = $this->_utilities->fetchWoNo();

        date_default_timezone_set('Asia/Kolkata');
        $dt = new DateTime();
        $currentyear = $dt->format('Y');
        $so_year = explode('/', $sono);

        if ($so_year[0] == $currentyear) {
            $so_id = ++$so_year[1];
            $count = 5 - strlen($so_id);
            for ($i = 0; $i < $count; $i++) {
                $so_id = '0' . $so_id;
            }
            $_sono = $currentyear . '/' . $so_id;
        } else {
            $_sono = $currentyear . '/00001';
        }
        $_data = array('content' => $_sono);
        $this->_helper->model->update('Utilities', '5', $_data);
        return $_sono;
    }

    public function changestatusAction() {


        $request['status'] = $this->_getParam('status');
        $request['id'] = $this->_getParam('id');
        $data = array('status' => $request['status']);
//         $this->createwo($request['id']);

        if ($this->_helper->model->update('Sales', $request['id'], $data)) {
            if ($request['status'] == 1) {
                $this->createwo($request['id']);
                $so = $this->runningsearialno();
                $_data = array('content' => $so);
                $_data1 = array('so_no' => $so);
                $this->_helper->model->update('Utilities', 4, $_data);
                $this->_helper->model->update('Sales', $request['id'], $_data1);
            }
        }
        $this->_redirect('admin/sales/index');
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function ininventory($data, $id) {
        $available = array('item_id' => $data['item_code'],
            'so_no' => $id, 'so_line_item' => $data['id'], 'status' => '0');
        $this->_availableitem->insert($available);
        return true;
    }

    public function topurchase($data, $id) {
        $purchase = array('item_id' => $data['item_code'],
            'so_no' => $id, 'so_line_item' => $data['id'], 'status' => '0');
        $this->_purchaseitem->insert($purchase);
        return true;
    }

    public function addtowo($_soitem_bom, $stock, $id) {

        date_default_timezone_set('Asia/Kolkata');
        $dt = new DateTime();
        $currentyear = $dt->format('Y');
        for ($i = 0; $i < ($_soitem_bom['qty'] - $stock); $i++) {
            $wono = 'WO/' . $this->runningsearialnowo();
            $data = array('item_id' => $_soitem_bom['item_code'],
                'bom_id' => $_soitem_bom['bid'],
                'wo_no' => $wono,
                'so_id' => $id,
                'so_line_item' => $_soitem_bom['id'],
                'status' => '0',
                'date' => date('d/M/Y'));
            $this->_workorder->insert($data);
        }

        $st_bom = $_soitem_bom['qty'] - $stock;
        $this->checkhasbom($_soitem_bom, $_soitem_bom['bid'], $st_bom, $id);

        return true;
    }

    public function checkhasbom($_soitem_bom, $_soitem_bom_id, $st_bom, $id) {
        $_soitem_bom_id;
        $bom = $this->_bomref->getWoMaterialId_BomHasBom($_soitem_bom_id);
        foreach ($bom as $_bom) {
            if ($this->_bom->checkbom($_bom['material_id'])) {
                $bom_has = $this->_bom->checkbom($_bom['material_id']);
                $req = $st_bom * $_bom['qty'];
                $_stock = $this->_inventory->checkStock($_bom['material_id']);
                $this->addtowoBom(array('id' => $_soitem_bom['id'],
                    'qty' => $req, 'item_code' => $_bom['material_id'], 'bid' => $bom_has['id']), $_stock, $id);
            }
        }
    }

    public function addtowoBom($_soitem_bom, $stock, $id) {

        date_default_timezone_set('Asia/Kolkata');
        $dt = new DateTime();
        $currentyear = $dt->format('Y');
        for ($i = 0; $i < ($_soitem_bom['qty']); $i++) {
            $wono = 'WO/' . $this->runningsearialnowo();
            $data = array('item_id' => $_soitem_bom['item_code'],
                'bom_id' => $_soitem_bom['bid'],
                'wo_no' => $wono,
                'so_id' => $id,
                'so_line_item' => $_soitem_bom['id'],
                'status' => '0',
                'date' => date('d/M/Y'));
            $this->_workorder->insert($data);
        }

        return true;
    }

    public function createwo($id) {


        $soitem_bom = $this->_salesitem->getWoMaterialId($id);

        if ($soitem_bom) {
            foreach ($soitem_bom as $_soitem_bom) {
                $stock = $this->_inventory->checkStock($_soitem_bom['item_code']);

                if ($_soitem_bom['qty'] > $stock) {
                    $this->addtowo($_soitem_bom, $stock, $id);

                    $_status = array('status' => '1');
                    $this->_helper->model->update('Salesitem', $_soitem_bom['id'], $_status);
                }
            }
        }
        return true;
    }

    public function refreshAction() {

        $data = $this->getRequest()->getPost();

        if ($data['id']) {
            $sales['so'] = $this->_sales->getSO($data['id']);
            $sales['address'] = $this->_customer->fetchCustomerAddress($sales['so']['customer']);
            $salesorder = $this->_salesitem->lineitembyId($data['id']);
            $i = 0;
            $sales['total'] = 0;
            $sales['project'] = $this->_project->getprojectactive();
            foreach ($salesorder as $_salesorder) {
                $material = $this->_material->fetchMaterial($_salesorder['item_code']);
                $sales['lineitem'][$i] = array(
                    'id' => $_salesorder['id'],
                    'part_id' => $material['id'],
                    'material_desc' => $material['material_desc'],
                    'qty' => $_salesorder['qty'],
                    'unitprice' => $_salesorder['unit_price'],
                    'uom' => $this->_material->fetchUom($material['uom']),
                    'lt' => $_salesorder['qty'] * $_salesorder['unit_price'],
                    'project' => $_salesorder['project_id']
                );
                $i++;
                $sales['total'] = $sales['total'] + $_salesorder['qty'] * $_salesorder['unit_price'];
            }
        }
        $sales['material'] = $this->_material->getmaterialactivePartno();
        print_r(json_encode($sales));
        exit;

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function deletesoAction() {
        if ($this->_getParam('delete')) {
            if ($this->_sales->getSo($this->_getParam('delete'))) {
                if ($this->_helper->model->delete('Sales', $this->_getParam('delete'))) {
                    $table1 = new Salesitem();
                    $table1->delete('sales_id=' . $this->_getParam('delete'));
                    $this->_redirect('admin/sales/index');
                }
            }
            $this->_redirect('admin/sales/index');
        }

        if ($this->_getParam('delid')) {
            $table1 = new Salesitem();
            $table1->delete('id=' . $this->_getParam('delid'));
            echo 1;
            exit;
        }
    }

    public function workorderAction() {
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if (!$data) {
            $this->_redirect('admin/auth/login');
        }

        $i = 0;
        $wo = $this->_workorder->getAllWo();
        foreach ($wo as $_wo) {
            $wo_list[$i] = array('id' => $_wo['id'],
                'wono' => $_wo['wo_no'], 'date' => $_wo['date'],
                'partno' => $this->_material->fetchBomPartno($_wo['item_id']),
                'so' => 'AAPL/SO/' . $this->_sales->getSoNo($_wo['so_id']),
                'project' => $this->_salesitem->getSoProject($_wo['so_line_item']), 'status' => $_wo['status']);
            $i++;
        }
        $this->view->wo = $wo_list;
    }

    public function statusAction() {
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if (!$data) {
            $this->_redirect('admin/auth/login');
        }

        if ($this->getRequest()->isPost()) {
            $data = $this->_request->getPost();
            foreach ($data['inventory'] as $_inventory) {
                $this->_soclosed->insert(array('so_id' => $data['sales_id'], 'so_line' => $data['sales_line'], 'inventory_id' => $_inventory));
                $this->_helper->model->update('Inventory', $_inventory, array('status' => '1'));
            }
        }

        if ($this->_getParam('sales_id')) {
            $id = $this->_getParam('sales_id');
            $item_in_inventory = array();
            $item_status = array();
            $soitem_bom = $this->_salesitem->getWoMaterialIdInventory($id);

            if ($soitem_bom) {
                foreach ($soitem_bom as $_soitem_bom) {
                    $stock = $this->_inventory->checkStock($_soitem_bom['item_code']);
                    $stock = $stock + ($this->_soclosed->getClosedCount($id, $_soitem_bom['id']));
                    if ($_soitem_bom['qty'] > $stock) {

                        $item_status[] = array('id' => $_soitem_bom['id'],
                            'required' => $_soitem_bom['qty'],
                            'itemid' => $_soitem_bom['item_code'],
                            'partno' => $this->_material->fetchBomPartno($_soitem_bom['item_code']),
                            'actual_qty' => $stock,
                            'sales_id' => $id, 'status' => $this->_soclosed->getClosedCount($id, $_soitem_bom['id']));
                    } else {
                        $item_in_inventory[] = array('id' => $_soitem_bom['id'],
                            'required' => $_soitem_bom['qty'],
                            'itemid' => $_soitem_bom['item_code'],
                            'partno' => $this->_material->fetchBomPartno($_soitem_bom['item_code']),
                            'actual_qty' => $this->_inventory->checkStock($_soitem_bom['item_code']),
                            'sales_id' => $id, 'status' => $this->_soclosed->getClosedCount($id, $_soitem_bom['id']));
                        $item_status[] = array('id' => $_soitem_bom['id'],
                            'required' => $_soitem_bom['qty'],
                            'itemid' => $_soitem_bom['item_code'],
                            'partno' => $this->_material->fetchBomPartno($_soitem_bom['item_code']),
                            'actual_qty' => $this->_inventory->checkStock($_soitem_bom['item_code']),
                            'sales_id' => $id, 'status' => $this->_soclosed->getClosedCount($id, $_soitem_bom['id']));
                    }
                }
            }

            $soitem_vendor = $this->_salesitem->getItemToPurchase($id);

            if ($soitem_vendor) {
                foreach ($soitem_vendor as $_soitem_vendor) {
                    $stock = $this->_inventory->checkStock($_soitem_vendor['item_code']);
                    $stock = $stock + ($this->_soclosed->getClosedCount($id, $_soitem_vendor['id']));
                    if ($_soitem_vendor['qty'] > $stock) {
                        $item_to_purchase[] = array('id' => $_soitem_vendor['id'],
                            'required' => $_soitem_vendor['qty'],
                            'itemid' => $_soitem_vendor['item_code'],
                            'partno' => $this->_material->fetchBomPartno($_soitem_vendor['item_code']),
                            'actual_qty' => $this->_inventory->checkStock($_soitem_vendor['item_code']),
                            'sales_id' => $id, 'status' => $this->_soclosed->getClosedCount($id, $_soitem_vendor['id'])
                        );
                    } else {

                        $item_in_inventory[] = array('id' => $_soitem_vendor['id'],
                            'required' => $_soitem_vendor['qty'],
                            'itemid' => $_soitem_vendor['item_code'],
                            'partno' => $this->_material->fetchBomPartno($_soitem_vendor['item_code']),
                            'actual_qty' => $this->_inventory->checkStock($_soitem_vendor['item_code']),
                            'sales_id' => $id, 'status' => $this->_soclosed->getClosedCount($id, $_soitem_vendor['id']));
                    }

                    $item_status[] = array('id' => $_soitem_vendor['id'],
                        'required' => $_soitem_vendor['qty'],
                        'itemid' => $_soitem_vendor['item_code'],
                        'partno' => $this->_material->fetchBomPartno($_soitem_vendor['item_code']),
                        'actual_qty' => $this->_inventory->checkStock($_soitem_vendor['item_code']),
                        'sales_id' => $id, 'status' => $this->_soclosed->getClosedCount($id, $_soitem_vendor['id']));
                }
            }

            $this->view->salesno = $this->_sales->getSoNo($id);

            $wo = $this->_workorder->getWoItemById($id);

            foreach ($wo as $_wo) {
                $wo_list[] = array('id' => $_wo['id'],
                    'wono' => $_wo['wo_no'], 'date' => $_wo['date'],
                    'partno' => $this->_material->fetchBomPartno($_wo['item_id']),
                    'so' => 'AAPL/SO/' . $this->_sales->getSoNo($_wo['so_id']),
                    'project' => $this->_salesitem->getSoProject($_wo['so_line_item']), 'status' => $_wo['status'],
                    'bom_status' => $this->_bom->getBomStatus($_wo['bom_id']),
                    'bomid' => $_wo['bom_id'], 'part_id' => $_wo['item_id'], 'so_id' => $_wo['so_id']);
                $i++;
            }
        }

        $this->view->wo = $wo_list;
        $this->view->ovrallstatus = $item_status;
        $this->view->inventory = $item_in_inventory;
        $this->view->vendor_material = $item_to_purchase;
        return true;
    }

    public function getinventoryAction() {
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if (!$data) {
            $this->_redirect('admin/auth/login');
        }
        $id = $this->_getParam('id');
        $_inventory = $this->_inventory->getallbyId($id);
        $inventory['item'] = $_inventory;
        $inventory['total'] = count($_inventory);
        print_r(json_encode($inventory));
        exit;
    }

    public function closewoAction() {

        $storage = new Zend_Auth_Storage_Session();
        $_data = $storage->read();
        if (!$_data) {
            $this->_redirect('admin/auth/login');
        }
        $partid = $this->_getParam('partid');
        $woid = $this->_getParam('woid');
        $soid = $this->_getParam('so_id');
        $data['itemid'] = $partid;

        $invntory = array('grn_id' => '0', 'itemid' => $partid,
            'uniqueid' => $this->getinventorydetails($data), 'wo_id' => $woid);
        
       
        $this->_inventory->insert($invntory);

        $where = $this->_workorder->getAdapter()->quoteInto('id = ?', $woid);
        $this->_workorder->update(array('status' => '1'), $where);
        $this->_redirect('admin/sales/status/sales_id/' . $soid);
    }

    public function getinventorydetails($data) {

        
   
        $material_det = $this->_material->getwomaterial($data['itemid']);


        $results = $this->_inventory->getwomaterial($data['itemid']);

        $count = '1';
        if ($material_det == 'Item') {

            $init = $results[0]['uniqueid'];
            $uniq = '';

            if ($results) {
                for ($i = 1; $i <= $count; $i++) {
                    $uniq.= "" . ++$init . ", ";
                    $trimwhere = rtrim($uniq, ", ");
                }
            } else {
                $init = 'AA000';
                for ($i = 1; $i <= $count; $i++) {
                    $uniq.= "" . ++$init . ", ";
                    $trimwhere = rtrim($uniq, ", ");
                }
            }
            $uniquevals = $trimwhere;
        }



        if ($material_det == 'Batch') {
            $count = '1';
            date_default_timezone_set('Asia/Kolkata');
            $dt = new DateTime();
            $current = $dt->format('y-m-d');
            $date = substr($results[0]['uniqueid'], 0, 8);
            if ($date == $current) {
                $char = substr($results[0]['uniqueid'], 9);
                $init = $char;
                for ($i = 1; $i <= $count; $i++) {
                    $uniq.= $current . "-" . ++$init . ", ";
                    $trimwhere = rtrim($uniq, ", ");
                }
            } else {
                $init = 'AA';
                for ($i = 1; $i <= $count; $i++) {
                    $uniq.= $current . "-" . $init++ . ", ";
                    $trimwhere = rtrim($uniq, ", ");
                }
            }
            $uniquevals = $trimwhere;
        }
        return $uniquevals;
    }

}
