<?php
class Bluess_Modules_Loader extends Zend_Controller_Plugin_Abstract
{
	protected $_modules;

	public function __construct(array $modulesList)
	{
		$this->_modules = $modulesList;
	}

	public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
	{
		$module = $request->getModuleName();

		if (!isset($this->_modules[$module])) {
			throw new Exception("Module does not exist!");
		}

		$bootstrapPath = $this->_modules[$module];

		$bootstrapFile = dirname($bootstrapPath) . '/Bootstrap.php';
        $class         = ucfirst($module) . '_Bootstrap';
        $application   = new Zend_Application(
        	APPLICATION_ENV,
    		APPLICATION_PATH . '/modules/' . $module . '/configs/module.ini'
		);

        if (Zend_Loader::loadFile('Bootstrap.php', dirname($bootstrapPath))
        	&& class_exists($class)) {
            $bootstrap = new $class($application);
            $bootstrap->bootstrap();
        }
	}

	public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
	$lang = $request->getParam('lang','');

	if ($lang !== 'en' && $lang !== 'fr')
//	    $request->setParam('lang','en');
            $request->setParam('lang','en');

	$lang = $request->getParam('lang');
	if ($lang == 'en')
	    $locale = 'en_CA';
	else
	    $locale = 'fr_CA';

        
	$zl = new Zend_Locale();
	$zl->setLocale($locale);
	Zend_Registry::set('Zend_Locale', $zl);

	$translate = new Zend_Translate('csv', APPLICATION_PATH . '/configs/lang/'. $lang . '.csv' , $lang);
 	Zend_Registry::set('Zend_Translate', $translate);
    }
}