<?php

class Admin_Bootstrap extends Zend_Application_Module_Bootstrap
{	protected $_moduleName = 'admin';

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
                
                Zend_Controller_Action_HelperBroker::addPath(
               APPLICATION_PATH .'/modules/' . $this->_moduleName .'/controllers/helpers');
                               return $options;
    }
	protected function _initView()
	{
		$view = new Zend_View();
                $view->headTitle('Asteria')->setSeparator(' :: ');
		$view->setEncoding('UTF-8');
		$view->doctype('XHTML1_STRICT');
		$view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8');
                $view->addHelperPath('Zend/Dojo/View/Helper','Zend_Dojo_View_Helper');
                $viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
                $viewRenderer->setView($view);
                Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);

                $view->dojo()->requireModule('dijit._editor.plugins.LinkDialog');
		Zend_Dojo::enableView($view);
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
        
      	
	
	
	
	
	
}