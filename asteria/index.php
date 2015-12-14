<?php
defined('BASE_PATH')
        || define('BASE_PATH', realpath(dirname(__FILE__)));

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', BASE_PATH . '/application');

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

//defined('APPLICATION_UPLOADBOOK_PATH')
//    || define('APPLICATION_UPLOADBOOK_PATH', BASE_PATH . '/readium-js-viewer-master/epub_content/');

defined('APPLICATION_EPUB_ZIP_PATH') || define('APPLICATION_EPUB_ZIP_PATH', BASE_PATH . '/clematix-kv-viewer/epub_content/zip/');

defined('APPLICATION_EPUB_UNZIP_PATH') || define('APPLICATION_EPUB_UNZIP_PATH', BASE_PATH . '/clematix-kv-viewer/epub_content/books/');


defined('APPLICATION_UPLOADCOVER_PATH')
    || define('APPLICATION_UPLOADCOVER_PATH', BASE_PATH . '/clematix-kv-viewer/epub_content/cover-image/');


// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath('library'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();
			