<?php

class Project extends Zend_Db_Table {

    protected $_name = 'project';

    public function getProjects() {
        $select = $this->_db->select()
                ->from($this->_name);
        $results = $this->getAdapter()->fetchAll($select);

        return $results;
    }
  public function getprojectval($data)
       {
     // echo "==="; print_r($data); exit;
       $project = new Project();
        $row = $project->fetchAll($project->select()->where('project_id = ?', $data['id']));
              $row = $row->toArray();
       return $row;
        }
    
    public function getprojectactive()
       {
        $project = new Project();
        $row1 = $project->fetchAll($project->select()
             //   ->where('status = ?', '1')
                );
         $row1 = $row1->toArray();
        return $row1;
       }
       
       public function getProjectName($id) {
        $select = $this->_db->select()
                ->from($this->_name,array('project_name'))
                ->where('project_id=?', $id);
        $results = $this->getAdapter()->fetchOne($select);

        return $results;
    }
    
    public function getProjectCode($id) {
        $select = $this->_db->select()
                ->from($this->_name,array('project_code'))
                ->where('project_id=?', $id);
        $results = $this->getAdapter()->fetchOne($select);

        return $results;
    }
    
     
}
