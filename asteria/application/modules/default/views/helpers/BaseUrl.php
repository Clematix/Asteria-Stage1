<?php
class Zend_View_Helper_BaseUrl
{
function baseUrl()
{
$fc = Zend_Controller_Front::getInstance();
return $fc->getBaseUrl();
}
}

class Zend_View_Helper_kvUrl
{
function kvUrl()
{
$fc = Zend_Controller_Front::getInstance();
return $fc->getBaseUrl().'/clematix-kv-viewer';
}
}
?>