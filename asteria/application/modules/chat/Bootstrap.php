<?php
class Chat_Bootstrap extends Zend_Application_Module_Bootstrap
{	
    protected $_moduleName = 'chat';
//    protected $_chatMapper = 'chat';


        protected function init()
            {
                $this->_chatMapper = new Application_Model_ChatMapper();
                $this->_sessId = Zend_Session::getId();
                $this->view->sessId = $this->_sessId;

                
            }

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

                $view->headLink()->prependStylesheet($view->baseUrl().'/public/chat/chat.css');
//                $view->headLink()->prependStylesheet($view->baseUrl().'/css/screen.css');
                $view->headScript()->appendFile($view->baseUrl().'/public/chat/jquery.min.js');
                $view->headScript()->appendFile($view->baseUrl().'/public/chat/chat.js');
                $view->headScript()->appendFile($view->baseUrl().'/public/chat/jquery.validate.js');
                $view->headScript()->appendFile($view->baseUrl().'/public/chat/jquery.cookie.min.js');
//                $view->headScript()->appendFile($view->baseUrl().'/lib/jquery.validate.js');
                
		$view->headTitle('Chat Room')->setSeparator(' :: ');

 		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper(
 			'ViewRenderer'
 		);
 		$viewRenderer->setView($view);

 		return $view;
	}

        protected function _initSession()
            {
                $ns = new Zend_Session_Namespace('session');
                if ($ns->initialize == '') {
                Zend_Session::start();
                $ns->initialize = true;
            }
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