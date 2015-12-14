<?php
class Default_Bootstrap extends Zend_Application_Module_Bootstrap
{
	protected $_moduleName = 'default';
       

	protected function _initConfiguration()
    {
		
            $options = $this->getApplication()->getOptions();

    	set_include_path(implode(PATH_SEPARATOR, array(
		    realpath(APPLICATION_PATH . '/modules/' . $this->_moduleName . '/models'),
		    get_include_path(),
		)));

		set_include_path(implode(PATH_SEPARATOR, array(
		    realpath(APPLICATION_PATH . '/modules/' . $this->_moduleName . '/forms'),
		    get_include_path(),
		)));
                
                
                set_include_path(implode(PATH_SEPARATOR, array(
                realpath(APPLICATION_PATH . '/../library'),
                get_include_path(),
            )));

		return $options;
    }

	protected function _initView()
	{
		$view = new Zend_View();
		$view->setEncoding('UTF-8');
		$view->doctype('XHTML1_STRICT');
		$view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8');
                
//                echo $view->baseUrl();
//		$view->headLink()->prependStylesheet('public/clematix/css/colors/purple.css');
                
		$view->headTitle('Clematix')->setSeparator(' :: ');

 		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper(
 			'ViewRenderer'
 		);
 		$viewRenderer->setView($view);

 		return $view;
	}

    
	protected function _initDatabase()
	{
		$options = $this->getApplication()->getOptions();
		$db = Zend_Db::factory($options['db']['zend']['adapter'], $options['db']['zend']['params']);
        Zend_Db_Table_Abstract::setDefaultAdapter($db);
        Zend_Registry::set('DB', $db);
        return $db;

	}
        
        
        	protected function checkUnique($email)
	    {
	        $select = $this->_db->select()
	                            ->from($this->_name,array('email'))
	                            ->where('email=?',$email);
	        $result = $this->getAdapter()->fetchOne($select);
	        if($result){
	            return true;
	        }
	        return false;
	    }
}