<?php

class Admin_BomController extends Zend_Controller_Action {

    protected $_material = null;
    protected $_project = null;
    protected $_bom = null;
    protected $_bomref = null;
    protected $_materialtype = null;
    protected $_moduleid = 'BM';

    public function init() {
        $this->_material = new Material();
        $this->_project = new Project();
        $this->_bom = new Bom();

        $this->_materialtype = new Materialtype();
        $this->_bomref = new Bomref();

        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if ($data) {
            $this->view->username = $data->firstname . " " . $data->lastname;
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

    public function indexAction() {
        
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if (!$data) {
            $this->_redirect('admin/auth/login');
        }
         if ($this->_getParam('bomid')) {
            
                   echo '<script type="text/javascript">$(document).ready(function(){$(".edit'.$this->_getParam('bomid').'").trigger("click");});</script>';
        }
        if ($this->_getParam('global') == 'create') {
            $this->view->MessageType = 'success';
            $this->view->Message = 'New BOM created successfully;';
        }
        if ($this->getRequest()->isPost()) {
            $filename = $_FILES["file"]["tmp_name"];
            $postdata = $this->_request->getPost();
            require_once 'excel/excel_reader2.php';
            $data = new Spreadsheet_Excel_Reader($filename);


            include("excel/excelwriter.inc.php");

            $bom1 = $this->_bom->fetchBom($postdata['bom-importid']);
            $_id = $this->_material->getbommaterialCategory($bom1['material_id']);

            if ($_id == 'E') {
                for ($i = 2; $i <= 195; $i++) {

                    $partno = trim($data->val($i, A));
                    $bom_id = $this->_material->fetchBomMaterialId($partno);
                    $check_same = $this->_bom->checkExist($postdata['bom-importid']);

                    if ($check_same != $bom_id) {
                        $qty = trim($data->val($i, B));
                        $comments = trim($data->val($i, I));
                        $BR = trim($data->val($i, C));
                        $CV = trim($data->val($i, D));
                        $CSP = trim($data->val($i, E));
                        $FYN = trim($data->val($i, F));
                        $SBM = trim($data->val($i, G));
                        $PTHRSMT = trim($data->val($i, H));
                        if ($bom_id) {

                            $_data = array('bom_id' => $postdata['bom-importid'],
                                'material_id' => $bom_id, 'qty' => $qty,
                                'comments' => $comments,
                                'rev_id' => $this->setrevision($postdata['bom-importid']),
                                'br' => $BR,
                                'cv' => $CV, 'csp' => $CSP, 'fyn' => $FYN, 'sbm' => $SBM, 'pthrsmt' => $PTHRSMT);
                            $this->_bomref->insert($_data);
                        }
                    }
                }
            } else {
                for ($i = 2; $i <= 195; $i++) {

                    $partno = trim($data->val($i, A));
                    $bom_id = $this->_material->fetchBomMaterialId($partno);
                    $check_same = $this->_bom->checkExist($postdata['bom-importid']);

                    if ($check_same != $bom_id) {
                        $qty = trim($data->val($i, B));
                        $comments = trim($data->val($i, C));
                        if ($bom_id) {

                            $_data = array('bom_id' => $postdata['bom-importid'], 'material_id' => $bom_id, 'qty' => $qty, 'comments' => $comments, 'rev_id' => $this->setrevision($postdata['bom-importid']));
                            $this->_bomref->insert($_data);
                        }
                    }
                }
            }
            $this->_helper->model->update('Bom', $postdata['bom-importid'], array('date'=>date('d/M/Y'),'bom_rev_id' => $this->setrevision($postdata['bom-importid'])));
            $this->view->MessageType = 'success';
            $this->view->Message = 'Excel Imported Successfully';
            echo '<script type="text/javascript">$(document).ready(function(){$(".edit' . $postdata['bom-importid'] . '").trigger("click");});</script>';
        }


        $type = $this->_materialtype->getBomrequired();

        $this->view->material= $this->_material->getBomRequired($where);
       
        $this->view->project = $this->_project->getprojectactive();

        $bomid = $this->_bom->fetchAll();
        $i = 0;
    if($bomid['material_id']){
        foreach ($bomid as $_bomid) {

                $bomlist = $this->_material->fetchMaterial($_bomid['material_id']);
                if ($bomlist) {
                    $bom[$i] = array(
                        'id' => $_bomid['id'],
                        'part_no' => $bomlist['part_no'],
                        'material_desc' => $bomlist['material_desc'],
                        'material_id' => $_bomid['material_id'],
                        'drawing_no' => $bomlist['drawing_no'],
                        'revision_no' => $bomlist['revision_no'],
                        'uom' => $this->_material->fetchUom($bomlist['uom']),
                        'bom_project_id' => $_bomid['bom_project_id'],
                        'date' => $_bomid['date'],
                        'bom_rev_id' => $_bomid['bom_rev_id'],
                        'bom_description' => $bomlist['material_desc'],
                        'project_name' => $this->_project->getProjectName($_bomid['project_id']),
                        'status' => $_bomid['status']
                    );

                    $i++;
                }
            }

            $this->view->bom = $bom;
    }
    }
     public function refreshAction() {
        $bomid = $this->_bom->fetchAll();


        $i = 0;
        foreach ($bomid as $_bomid) {

            $bomlist = $this->_material->fetchMaterial($_bomid['material_id']);

            $bom[$i] = array(
                'id' => $_bomid['id'],
                'part_no' => $bomlist['part_no'],
                'material_desc' => $bomlist['material_desc'],
                'material_id' => $_bomid['material_id'],
                'drawing_no' => $bomlist['drawing_no'],
                'revision_no' => $bomlist['revision_no'],
                'uom' => $this->_material->fetchUom($bomlist['uom']),
                'bom_project_id' => $_bomid['bom_project_id'],
                'bom_rev_id' => $_bomid['bom_rev_id'],
                'bom_description' => $bomlist['material_desc'],
                'project_name' => $this->_project->getProjectName($_bomid['project_id']),
                'status' => $_bomid['status']
            );

            $i++;
        }
        print_r(json_encode($bom));
        exit;
    }

    public function deleteAction() {
        if ($this->_getParam('delid')) {
            if ($this->_helper->model->delete('Bomref', $this->_getParam('delid'))) {
                echo json_encode(array('status' => 1));
            } else {
                echo json_encode(array('status' => 0));
            }
            exit;
        }
    }

    public function addoreditAction() {

        if ($this->_getParam('addid') == 1) {
            if ($this->_getParam('partno')) {
                $data = array('bom_id' => $this->_getParam('id'), 'material_id' => $this->_getParam('partno'), 'qty' => $this->_getParam('qty'), 'comments' => $this->_getParam('comments'), 'rev_id' => $this->setrevision($this->_getParam('id')));
                if ($this->_bomref->insert($data)) {
                    echo json_encode(array('status' => 1));
                    $this->_helper->model->update('Bom', $this->_getParam('id'), array('date'=>date('d/M/Y'),'bom_rev_id' => $this->setrevision($this->_getParam('id'))));
                } else {
                    echo json_encode(array('status' => 0));
                }
            }
            exit;
        }

        if ($this->_getParam('editid') == 1) {
            $where = $this->_bomref->getAdapter()->quoteInto('id = ?', $this->_getParam('edit'));
            $data = array('bom_id' => $this->_getParam('id'), 'material_id' => $this->_getParam('partno'), 'qty' => $this->_getParam('qty'), 'comments' => $this->_getParam('comments'), 'rev_id' => $this->setrevision($this->_getParam('id')));
            if ($this->_bomref->update($data, $where)) {
                echo json_encode(array('status' => 1));
                $this->_helper->model->update('Bom', $this->_getParam('id'), array('date'=>date('d/M/Y'),'bom_rev_id' => $this->setrevision($this->_getParam('id'))));
            } else {
                echo json_encode(array('status' => 0));
            }
            exit;
        }
    }
 public function addbomAction() {
        $bom_id = $this->_getParam('bom_add');
        $data = $this->_material->fetchMaterial($bom_id);
        
        $bom['material_desc'] = $data['material_desc'];
        $bom['revision_no'] = $data['revision_no'];
//        $bom['uom'] = $this->_material->fetchUom($data['uom']);
        $bom['uom'] = $data['uom'];
        $bom['drawing_no'] = $data['drawing_no'];
//            $bom['type']=$this->_material->fetchType($data['material_type']);
        $bom_bomrev = $this->_bom->getBomBomrev($bom_id);
        if ($bom_bomrev) {
                            $bom['bom'] = $bom_bomrev['bom_project_id'];
                            $bom['bomrev'] = $bom_bomrev['bom_rev_id'];
                        } else {
                            $bom['bom'] = 'NA';
                            $bom['bomrev'] = 'NA';
                        }
        $bom['weight']=$data['weight'];
        
        $bom['type'] = $this->_material->fetchBomMaterialType($data['material_type']);
        print_r(json_encode($bom));
        exit;
    }

    public function addallAction() {
        $h = 0;
        if ($this->getRequest()->isPost()) {
            $data = $this->_request->getPost();
            $id = $data['data']['bom-id'];
         
            $i = 0;
            foreach ($data['data']['partnonew'] as $_datas) {
                if ($data['data']['partnonew'][$i]) {
                    $_data = array('bom_id' => $id, 
                        'material_id' => $data['data']['partnonew'][$i], 
                        'qty' => $data['data']['qtynew'][$i], 
                        'comments' => $data['data']['commentsnew'][$i],
                        'uom'=>$data['data']['uomnew'][$i], 
                        'rev_id' => $this->setrevision($id),
                        'br'=>$data['data']['brnew'][$i],
                        'cv'=>$data['data']['cvnew'][$i],
                        'csp'=>$data['data']['cspnew'][$i],
                        'fyn'=>$data['data']['fynnew'][$i],
                        'sbm'=>$data['data']['sbmnew'][$i],
                        'pthrsmt'=>$data['data']['pthrsmtnew'][$i]
                            );
                    if ($this->_bomref->insert($_data)) {
                        $h = 1;
                    }
                }
                $i++;
            }
            $j = 0;

            foreach ($data['data']['partno'] as $_datas) {
                $where = $this->_bomref->getAdapter()->quoteInto('id = ?', $data['data']['bom_ref_id'][$j]);
                $bugs = new Bomref();
                $row = $bugs->fetchRow($bugs->select()->where($where));

                if (($row['bom_id'] == $id) && 
                        ($row['uom'] == $data['data']['uom'][$j]) && 
                        ($row['material_id'] == $data['data']['partno'][$j]) && 
                        ($row['qty'] == $data['data']['qty'][$j]) && 
                        ($row['br'] == $data['data']['br'][$j])&& 
                        ($row['cv'] == $data['data']['cv'][$j])&& 
                        ($row['csp'] == $data['data']['csp'][$j])&& 
                        ($row['fyn'] == $data['data']['fyn'][$j])&& 
                        ($row['sbm'] == $data['data']['sbm'][$j])&& 
                        ($row['pthrsmt'] == $data['data']['pthrsmt'][$j])&& 
                        ($row['comments'] == $data['data']['comments'][$j])) {
                    
                } else {
                    if($data['data']['partno'][$j]){
                    $_dataup = array('bom_id' => $id, 
                        'material_id' => $data['data']['partno'][$j], 
                        'qty' => $data['data']['qty'][$j], 
                        'comments' => $data['data']['comments'][$j],
                        'uom' => $data['data']['uom'][$j], 
                        'rev_id' => $this->setrevision($id),
                        'br'=>$data['data']['br'][$j],
                        'cv'=>$data['data']['cv'][$j],
                        'csp'=>$data['data']['csp'][$j],
                        'fyn'=>$data['data']['fyn'][$j],
                        'sbm'=>$data['data']['sbm'][$j],
                        'pthrsmt'=>$data['data']['pthrsmt'][$j]);
                    $this->_bomref->update($_dataup, $where);
                    $h = 1;
                }}
                $j++;
            }
            if ($h == 1) {
                $this->_helper->model->update('Bom', $id, array('date'=>date('d/M/Y'),'bom_rev_id' => $this->setrevision($id)));
            }

            echo json_encode(array('status' => 1));
            exit;
        }
    }

    public function editbomAction() {
        $bom_id = $this->_getParam('edit_bom_id');
        $bom = $this->_bom->fetchBom($bom_id);

        $bom['desc'] = $this->_material->fetchMaterialDesc($bom['material_id']);
        print_r(json_encode($bom));
        exit;
    }

    public function projectdelAction() {

        print_r(json_encode($this->_bom->getProjectInBom()));
        exit;
    }

    public function projectaddAction() {
        $i = 0;
        foreach ($this->_bom->getProjectInBom() as $projectid) {
            $project[$i++] = array('id' => $projectid['project_id'], 'name' => $this->_project->getProjectName($projectid['project_id']));
        }
        print_r(json_encode($project));
        exit;
    }
    public function addallprojectAction(){
        print_r(json_encode($this->_project->getProjects()));exit;
    }

    public function viewAction() {
 
        $bom_id = $this->_getParam('bom_id');
        $bom = $this->_bom->fetchBom($bom_id);
        $bomlist = $this->_material->fetchMaterial($bom['material_id']);
        
        $_id = $this->_material->getbommaterialCategory($bom['material_id']);
        
        $_bom['id'] = $bom['id'];
        $_bom['partid'] = $bomlist['part_no'];
        $_bom['description'] = $bomlist['material_desc'];
        $_bom['bom'] = $bom['bom_project_id'];
        $_bom['bom_rev'] = $bom['bom_rev_id'];
        $date = explode(" ",$bom['date']);
        $_bom['date'] = $date['0'];
        
        $bomid = $this->_bomref->getBomRefMaterial($bom_id);
        $i = 0;
        $total_weight=0;
        $pc=0;
        foreach ($bomid as $_bomid) {
        $bomreflist = $this->_material->fetchMaterial($_bomid['material_id']);
        $bom_bomrev = $this->_bom->getBomBomrev($_bomid['material_id']);
        if ($bom_bomrev) {
                            $bom['bom'] = $bom_bomrev['bom_project_id'];
                            $bom['bomrev'] = $bom_bomrev['bom_rev_id'];
                        } else {
                            $bom['bom'] = 'NA';
                            $bom['bomrev'] = 'NA';
                        }
                    $bom['weight']=$data['weight'];
                $_bom['table'][$i] = array(
                'id' => $_bomid['id'],
                'material_id' => $_bomid['material_id'],
                'part_no' => $bomreflist['part_no'],
                'material_desc' => $bomreflist['material_desc'],
                'drawing_no' => $bomreflist['drawing_no'],
                'revision_no' => $bomreflist['revision_no'],
//                'uom' => $this->_material->fetchUom($bomreflist['uom']),
                'uom' => $_bomid['uom'],
                'quanty' => $_bomid['qty'],
                'type' => $this->_material->fetchBomMaterialType($bomreflist['material_type']),
                'comments' => $_bomid['comments'],
                'bom'=>$bom['bom'],
                'bomrev'=>$bom['bomrev'],
                'weight'=>$bomreflist['weight']*$_bomid['qty'],
                'basic_weight'=>$bomreflist['weight'],
                'br'=>$_bomid['br']?$_bomid['br']:'',
                'cv'=>$_bomid['cv']?$_bomid['cv']:'',
                'csp'=>$_bomid['csp']?$_bomid['csp']:'',
                'fyn'=>$_bomid['fyn']?$_bomid['fyn']:'',
                'sbm'=>$_bomid['sbm']?$_bomid['sbm']:'',
                'pthrsmt'=>$_bomid['pthrsmt']?$_bomid['pthrsmt']:''
                                
            );
$total_weight=$total_weight+($bomreflist['weight']*$_bomid['qty']);
$pc=$pc+$_bomid['qty'];
            $i++;
        }

        $bompart = $this->_bom->fetchBom($bom_id);
        $_bom['partno'] = $this->_material->fetchBomMaterial($bom['material_id']);
        $_bom['uom']=$this->_material->getuom();
$_bom['totalweight']=$total_weight;
if($_id=='E'){
$_bom['pc']=$pc;
}
        print_r(json_encode($_bom));
        exit;
    }

    public function addnewAction() {
        $create_bom_id = $this->_getParam('create_bom_id');
        $bom_id = $this->_getParam('addnew_id');
        if ($create_bom_id) {
            $_bom['desc'] = $this->_material->fetchMaterialDesc($create_bom_id);

            $_bom['remove']=$this->_bom->projectID($create_bom_id);
            print_r(json_encode($_bom));
            exit;
        }
        if ($bom_id) {
            $_data['bom'] = $this->_material->fetchBomMaterial($bom_id);
            $_data['uom']=$this->_material->getuom();
            
            print_r(json_encode($_data));
            exit;
        }
    }

   
    public function changestatusAction() {
        $request = $this->getRequest()->getPost();
        $data = array('status' => $request['status']);
        if ($this->_helper->model->update('Bom', $request['id'], $data)) {
            echo 1;
            exit;
        }
        $this->_redirect('admin/bom/index');
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function updatebomAction() {
        parse_str($this->getRequest()->getParam('data'), $post);
        if ($post['bom_description']) {
            $_data = array('material_desc' => $post['bom_description']);
            $this->_helper->model->update('Material', $post['material-id'], $_data);
        }

        echo 1;
        exit;
    }

     public function checkexistAction() {
          if ($this->_bom->checkUnique($this->_getParam('partno'))) {
            echo 0;
            exit;
        }else{echo '1';exit;}
     }
    public function createAction() {

        parse_str($this->getRequest()->getParam('data'), $post);

//        if ($this->_bom->checkUnique($post['partno'], $post['project'])) {
         if ($this->_bom->checkUnique($post['partno'])) {
            echo 0;
            exit;
        }
         if ($post['partno']) {
//        if ($post['partno'] && $post['project']) {
//                $query = "SELECT LPAD(AUTO_INCREMENT , 4, '0' ) as incid FROM information_schema.TABLES WHERE TABLE_NAME='bom'";
//                $auto = $this->_bom->getAdapter()->fetchRow($query);
//            $bom = $this->_material->fetchMaterial($post['partno']);
//            $projectcode = $this->_project->getProjectCode($post['project']);
//            $var = explode('-', $bom['part_no']);
//            $_var[0] = $var[0];
//            $_var[1] = $var[2];
//            if($var[3]){
//            $_var[2] = $var[3];
//            
//            }

//            $bom_project_id = $projectcode . '-' . implode('-', $_var);
                $bom_project_id = 'test';

            $data = array(
                'bom_rev_id' => '0',
                'bom_project_id' => $bom_project_id,
                'material_id' => $post['partno'],
//                'project_id' => $post['project'],
                  'project_id' => '1111',
                'bom_description' => $post['bom_description'],
                'status' => '0');

            $a = $this->_bom->insert($data);
            $_data = array('material_desc' => $post['bom_description']);
            $this->_helper->model->update('Material', $post['partno'], $_data);
            echo $a;
            exit;
        }
        echo 2;
        exit;
    }
public function categoryAction(){
    
    $_id = $this->_material->getbommaterialCategory($this->getRequest()->getParam('id'));
    if($_id=='E')
    {
      echo 1;exit;
    }
    
    if(($_id=='M') || ($_id=='A'))
    {
        echo 2;exit;
    }
    else{
        echo 2;exit;
    }
}
    public function bomtopdfAction() {

        $id = $this->getRequest()->getParam('id');
        if ($id) {
            $bom = $this->_bom->fetchBom($id);
            if ($bom['material_id']) {
                $_id = $this->_material->getbommaterialCategory($bom['material_id']);
                $bomid = $this->_bomref->getBomRefMaterial($id);
                $i = 1;
                if (($_id == 'A') || ($_id == 'M')) {
                    $pc = 0;
                    $html .= '<tr style="background-color:#5B9BD5;"><th>Item No</th><th>Part No</th><th>Description</th><th>Type</th><th>Qty</th><th>UOM</th><th>COTS?</th><th>DWG #</th><th>DWG REV #</th><th>BOM REV #</th><th>Comments</th></tr>';
                    foreach ($bomid as $_bomid) {
                        $bom_bomrev = $this->_bom->getBomBomrev($_bomid['material_id']);
                        $bomreflist = $this->_material->fetchMaterial($_bomid['material_id']);
                        if ($bom_bomrev) {
//                            $bomno = $bom_bomrev['bom_project_id'];
                            $bomrev = $bom_bomrev['bom_rev_id'];
                        } else {
//                            $bomno = 'NA';
                            $bomrev = 'NA';
                        }

                        $cots = ($bomreflist['design_base'] == 'A' ? 'N' : 'Y');

                        $html .='<tr><td style="width:100px;">' . $i++ . '</td><td>' . $bomreflist['part_no'] . '</td><td>' . $bomreflist['material_desc'] . '</td><td>' . $this->_material->fetchBomMaterialType($bomreflist['material_type']) . '</td><td>' . $_bomid['qty'] . '</td><td>' . $this->_material->fetchUom($_bomid['uom']) . '</td><td>' . $cots . '</td><td>' . $bomreflist['drawing_no'] . '</td><td>' . $bomreflist['revision_no'] . '</td><td>' . $bomrev . '</td><td>' . $_bomid['comments'] . '</td></tr>';
                    }
                }

                if (($_id == 'E')) {
                    $pc = 0;
                    $totalweight = 0;
                    $html .= '<tr style="background-color:#5B9BD5;"><th>Item No</th><th>Part No</th><th>Part Name</th><th>Qty</th><th>Weight</th><th>UOM</th><th>Board Reference</th><th>Component Value</th><th>Case Style Package</th><th>Fit Yes/No</th><th>BOM REV #</th><th>Side of Board Mounted 1 or 2</th><th>PTH or SMT</th></tr>';
                    foreach ($bomid as $_bomid) {
                        $bom_bomrev = $this->_bom->getBomBomrev($_bomid['material_id']);
                        if ($bom_bomrev) {
//                            $bomno = $bom_bomrev['bom_project_id'];
                            $bomrev = $bom_bomrev['bom_rev_id'];
                        } else {
//                            $bomno = 'NA';
                            $bomrev = 'NA';
                        }
                        $bomreflist = $this->_material->fetchMaterial($_bomid['material_id']);
                        $weight = $bomreflist['weight'] * $_bomid['qty'];
                        $totalweight = $totalweight + $weight;
                        $pc = $pc + $_bomid['qty'];

                        $html .='<tr><td style="width:100px;">' . $i++ . '</td><td>' . $bomreflist['part_no'] . '</td><td>' . $bomreflist['material_desc'] . '</td><td>' . $_bomid['qty'] . '</td><td>' . $weight . '</td><td>' . $this->_material->fetchUom($_bomid['uom']) . '</td><td>'.$_bomid['br'].'</td><td>'.$_bomid['cv'].'</td><td>'.$_bomid['csp'].'</td><td>'.$_bomid['fyn'].'</td><td>' . $bomrev . '</td><td>'.$_bomid['sbm'].'</td><td>'.$_bomid['pthrsmt'].'</td></tr>';
                    }
                    $twapc = array('tw' => $totalweight, 'pc' => $pc);
                }

                include("../gabon9/mpdf60/mpdf.php");
                $mpdf = new mPDF('c', 'A4-L', '', '', 10, 10, 10, 10, 10, 10);
                $mpdf->SetDisplayMode('fullpage');
                $mpdf->list_indent_first_level = 0;
                $mpdf->WriteHTML($this->pdfcontent($html, $bom, $twapc));

                $mpdf->Output();
                exit;
            } else {
                echo 'Error occured please try again;';
                exit;
            }
        } else {
            echo 'Can not export PDF until you create BOM.';
            exit;
        }
    }

    function pdfcontent($id, $bom, $twapc = null) {
        if ($twapc) {
            $part = '<tr><td style="border:0px solid #ccc;background-color: #5B9BD5;width:200px;">Part Count:</td><td style="color:#BC171E;border:0px solid #ccc;background-color: #FFC000;" >' . $twapc['pc'] . '</td></tr>';

            $tw = '<tr><td style="border:0px solid #ccc;background-color: #5B9BD5;width:200px;">Total Weight:</td><td style="color:#BC171E;border:0px solid #ccc;background-color: #FFC000;" >' . $twapc['tw'] . '</td></tr>';
        }
        $html = '<head>
<style>
table {
	border: 1px solid #c3282e;
        border-collapse: collapse;
        width:100%;
}

th,td {
    padding: 5px;
    text-align: left;    
    border: 1px solid black; 
        }


.left{
     float: left;
     display: inline-block;
     width:20.1%;
     height: 100px;
     border:1px solid #ccc;
     margin: 0 auto;
     padding-top: 10px;     
}


</style>
</head>
<body>

<table cellSpacing="2" align="center" autosize="1.5">
<tbody>
<tr>
<td style="width:30%;border: 1px solid #c3282e;"><img src="http://demo.clematix.com/asteria/public/asteria/logo.png" alt="Clematix" width="28%;" style="padding:3px" ></td>
<td style="border: 1px solid #c3282e;text-align:center;"><h3>BILL OF MATERIALS</h3></td>
<td style="border: 1px solid #c3282e;padding-left:20px;"><div style="padding-left:20px;font-size: 12px;"> REF. NO     :  AA/DD/F/02<br/>
        REV. NO     : 00<br/>
        DATE        : ' . Date('d/m/Y') . '
        </div></td>
</tr>
</tbody>
</table>


    <br/>
    <div style="width:100%;height:auto;">
    <table >
      <tr><td style="border:0px solid #ccc;background-color: #5B9BD5;width:200px;">Assembly Part Number:</td><td style="color:#BC171E;border:0px solid #ccc;background-color: #FFC000;">' . $this->_material->fetchBomPartno($bom[material_id]) . '</td></tr>
      <tr><td style="border:0px solid #ccc;background-color: #5B9BD5;width:200px;">Part Description:</td><td style="color:#BC171E;border:0px solid #ccc;background-color: #FFC000;">' . $this->_material->fetchMaterialDesc($bom[material_id]) . '</td></tr>
     
      <tr><td style="border:0px solid #ccc;background-color: #5B9BD5;width:200px;">BOM Rev:</td><td style="color:#BC171E;border:0px solid #ccc;background-color: #FFC000;">' . $bom[bom_rev_id] . '</td></tr>
      <tr><td style="border:0px solid #ccc;background-color: #5B9BD5;width:200px;">Date:</td><td style="color:#BC171E;border:0px solid #ccc;background-color: #FFC000;">' . $bom[date] . '</td></tr>
          ' . $tw . $part . '</table>
    </div>
    <br/>

<table class="collapsed" align="center" >
<tbody>' . $id . '</tbody></table>

</div></div>
</body>
';

        return $html;
    }
    
    public function exportexcelAction()
    {
        require_once 'excel/Classes/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->setTitle('Bill of Material')
                ->mergeCells('A1:B1')->mergeCells('C1:G1')->mergeCells('H1:I1')
                ->mergeCells('A3:B3')->mergeCells('A4:B4')->mergeCells('A5:B5')
                ->mergeCells('A6:B6')->mergeCells('A7:B7')->mergeCells('A8:B8')->mergeCells('A9:B9');
        $objPHPExcel->getProperties()->setCreator("Clematix Private Software Limited")
                ->setLastModifiedBy("Kumar")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Material");
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('C1', 'BILL OF MATERIAL')
                ->setCellValue('H1', 'REF. NO     :  AA/MKT/F/07
REV. NO    :  00
DATE         :  DD.MM.YYYY');
        $objPHPExcel->getActiveSheet()->getStyle('H1')->getAlignment()->setWrapText(true)->setIndent(2);
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(55);
        $objPHPExcel->getActiveSheet()->getRowDimension('11')->setRowHeight(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
        $maxWidth = 170;
        $maxHeight = 80;

        $img = 'http://demo.clematix.com/asteria/public/asteria/logo.png';
        $gdImage = imagecreatefrompng($img);
        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();

        $objDrawing->setName('Sample image');
        $objDrawing->setDescription('Sample image');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setHeight(80);
        $objDrawing->setWidth(170);
        $offsetX = $maxWidth - $objDrawing->getWidth();
        $objDrawing->setCoordinates('A1');
        $objDrawing->setOffsetX($offsetX);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $sheet = $objPHPExcel->getActiveSheet();
        $styleArray = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => 'c3282e'),
                'size' => 20,
                'name' => 'Garamond'
        ));
        $objPHPExcel->getActiveSheet()->getStyle("C1:G1")->applyFromArray($styleArray);
        $sheet->getStyle('C1')
                ->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $style = array('font' => array(
                'bold' => true,
                'size' => 11,
        ));
        $style1 = array('font' => array(
                'bold' => true,
                'size' => 11,
            ), 'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'cccccc')
        ));

        $align = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $align1 = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        $objPHPExcel->setActiveSheetIndex(0);
        $sheet->getStyle('A3')->applyFromArray($style);
        $sheet->getStyle('A4:A5')->applyFromArray($style);
        $sheet->getStyle('A6:A7')->applyFromArray($style);
        $sheet->getStyle('A8:A9')->applyFromArray($style);

        $sheet->getStyle('A3')->getAlignment()->applyFromArray($align1);
        $sheet->getStyle('A4:A5')->getAlignment()->applyFromArray($align1);
        $sheet->getStyle('A6:A7')->getAlignment()->applyFromArray($align1);
        $sheet->getStyle('A8:A9')->getAlignment()->applyFromArray($align1);

        $val = $objPHPExcel->setActiveSheetIndex(0);

        $id = $this->getRequest()->getParam('id');
        if ($id) {
            $objPHPExcel->getActiveSheet()->getStyle('A11:M11')->getAlignment()->setWrapText(true);
            $bom = $this->_bom->fetchBom($id);
            $_id = $this->_material->getbommaterialCategory($bom['material_id']);
            $bomid = $this->_bomref->getBomRefMaterial($id);
if($bom){
            if (($_id == 'A') || ($_id == 'M')) {
                $sheet->getStyle('A11:M11')->applyFromArray($style1);
                $sheet->getStyle('A11:M11')->getAlignment()->applyFromArray($align);
                $pc = 0;
                $val->setCellValue('A3', 'Assembly Part Number: ')
                        ->setCellValue('A4', 'Part Description: ')
//                        ->setCellValue('A5', 'BOM #: ')
                        ->setCellValue('A5', 'BOM Rev: ')
                        ->setCellValue('A6', 'Total Weight: ')
                        ->setCellValue('A7', 'Date: ')
                        ->setCellValue('C3', $this->_material->fetchBomPartno($bom[material_id]))
                        ->setCellValue('C4', $this->_material->fetchMaterialDesc($bom[material_id]))
//                        ->setCellValue('C5', $bom[bom_project_id])
                        ->setCellValue('C5', $bom[bom_rev_id])
                        ->setCellValue('C7', Date('d/m/Y'))
                        ->setCellValue('A11', 'Item #')
                        ->setCellValue('B11', 'Part No.')
                        ->setCellValue('C11', 'Description')
                        ->setCellValue('D11', 'Type')
                        ->setCellValue('E11', 'QTY')
                        ->setCellValue('F11', 'UOM')
                        ->setCellValue('G11', 'COTS?')
                        ->setCellValue('H11', 'Dwg No. ')
                        ->setCellValue('I11', 'Dwg Rev')
//                        ->setCellValue('J11', 'BOM #')
                        ->setCellValue('J11', 'BOM Rev')
                        ->setCellValue('K11', 'Weight')
                        ->setCellValue('L11', 'Comments');
                $s = 12;
                $i = 1;
                $totalweight = 0;
                foreach ($bomid as $_bomid) {
                    $bom_bomrev = $this->_bom->getBomBomrev($_bomid['material_id']);
                    $bomreflist = $this->_material->fetchMaterial($_bomid['material_id']);
                    if ($bom_bomrev) {
//                        $bomno = $bom_bomrev['bom_project_id'];
                        $bomrev = $bom_bomrev['bom_rev_id'];
                    } else {
//                        $bomno = 'NA';
                        $bomrev = 'NA';
                    }
                    $weight = $bomreflist['weight'] * $_bomid['qty'];
                    $totalweight = $totalweight + $weight;
                    $cots = ($bomreflist['design_base'] == 'A' ? 'N' : 'Y');
                    $val->setCellValue('A' . $s, $i++)
                            ->setCellValue('B' . $s, $bomreflist['part_no'])
                            ->setCellValue('C' . $s, $bomreflist['material_desc'])
                            ->setCellValue('D' . $s, $this->_material->fetchBomMaterialType($bomreflist['material_type']))
                            ->setCellValue('E' . $s, $_bomid['qty'])
                            ->setCellValue('F' . $s, $this->_material->fetchUom($_bomid['uom']))
                            ->setCellValue('G' . $s, $cots)
                            ->setCellValue('H' . $s, $bomreflist['drawing_no'])
                            ->setCellValue('I' . $s, $bomreflist['revision_no'])
//                            ->setCellValue('J' . $s, $bomno)
                            ->setCellValue('J' . $s, $bomrev)
                            ->setCellValue('K' . $s, $weight)
                            ->setCellValue('L' . $s, $_bomid['comments'])
                    ;

                    $s++;
                }
                $val->setCellValue('C6', $totalweight);
            }


            if (($_id == 'E')) {
                $sheet->getStyle('A11:R11')->applyFromArray($style1);
                $sheet->getStyle('A11:R11')->getAlignment()->applyFromArray($align);
                $pc = 0;
                $val->setCellValue('A3', 'Assembly Part Number: ')
                        ->setCellValue('A4', 'Part Description: ')
//                        ->setCellValue('A5', 'BOM #: ')
                        ->setCellValue('A5', 'BOM Rev: ')
                        ->setCellValue('A6', 'Total Weight: ')
                        ->setCellValue('A7', 'Part Count: ')
                        ->setCellValue('A8', 'Date: ')
                        ->setCellValue('C3', $this->_material->fetchBomPartno($bom[material_id]))
                        ->setCellValue('C4', $this->_material->fetchMaterialDesc($bom[material_id]))
//                        ->setCellValue('C5', $bom[bom_project_id])
                        ->setCellValue('C5', $bom[bom_rev_id])
                        ->setCellValue('C8', Date('d/m/Y'))
                        ->setCellValue('A11', 'Item #')
                        ->setCellValue('B11', 'Part No.')
                        ->setCellValue('C11', 'Description')
                        ->setCellValue('D11', 'Type')
                        ->setCellValue('E11', 'QTY')
                        ->setCellValue('F11', 'UOM')
                        ->setCellValue('G11', 'Board Reference')
                        ->setCellValue('H11', 'Component Value')
                        ->setCellValue('I11', 'Case Style Package')
                        ->setCellValue('J11', 'Fit Yes/No')
                        ->setCellValue('K11', 'Dwg No. ')
                        ->setCellValue('L11', 'Dwg Rev')
//                        ->setCellValue('M11', 'BOM #')
                        ->setCellValue('M11', 'BOM Rev')
                        ->setCellValue('N11', 'Weight')
                        ->setCellValue('O11', 'Side of Board Mounted1 or 2')
                        ->setCellValue('P11', 'PTH or SMT')
                        ->setCellValue('Q11', 'Comments');
                $s = 12;
                $i = 1;
                $totalweight = 0;
                foreach ($bomid as $_bomid) {
                    $bom_bomrev = $this->_bom->getBomBomrev($_bomid['material_id']);
                    $bomreflist = $this->_material->fetchMaterial($_bomid['material_id']);
                    if ($bom_bomrev) {
//                        $bomno = $bom_bomrev['bom_project_id'];
                 $bomrev = $bom_bomrev['bom_rev_id'];
                    } else {
//                        $bomno = 'NA';
                        $bomrev = 'NA';
                    }
                    $weight = $bomreflist['weight'] * $_bomid['qty'];
                    $totalweight = $totalweight + $weight;
                    $pc = $pc + $_bomid['qty'];

                    $val->setCellValue('A' . $s, $i++)
                            ->setCellValue('B' . $s, $bomreflist['part_no'])
                            ->setCellValue('C' . $s, $bomreflist['material_desc'])
                            ->setCellValue('D' . $s, $this->_material->fetchBomMaterialType($bomreflist['material_type']))
                            ->setCellValue('E' . $s, $_bomid['qty'])
                            ->setCellValue('F' . $s, $this->_material->fetchUom($_bomid['uom']))
                            ->setCellValue('G' . $s, $_bomid['br'])
                            ->setCellValue('H' . $s, $_bomid['cv'])
                            ->setCellValue('I' . $s, $_bomid['csp'])
                            ->setCellValue('J' . $s, $_bomid['fyn'])
                            ->setCellValue('K' . $s, $bomreflist['drawing_no'])
                            ->setCellValue('L' . $s, $bomreflist['revision_no'])
//                            ->setCellValue('M' . $s, $bomno)
                            ->setCellValue('M' . $s, $bomrev)
                            ->setCellValue('N' . $s, $weight)
                            ->setCellValue('O' . $s, $_bomid['sbm'])
                            ->setCellValue('P' . $s, $_bomid['pthrsmt'])
                            ->setCellValue('Q' . $s, $_bomid['comments'])
                    ;

                    $s++;
                }
                $val->setCellValue('C6', $totalweight);
                $val->setCellValue('C7', $pc);
            }


            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="BOM.xls"');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        }else{
        echo 'Error occured While generating EXCEL.';exit;
    }
    
    }
        else{
        echo 'Can not export as Excel without BOM.';exit;
    }
    }

    public function bomrev($id)
    { 
        
         $res=array_unique($this->_bomref->getallBomLine($id), SORT_REGULAR);
       
         foreach($res as $_res){
      
           $this->_helper->model->update('Bom', $_res['bom_id'], array('date'=>date('d/M/Y'),'bom_rev_id' => $this->setrevision($_res['bom_id'])));
         }
         return true;
    }
    
    

}
