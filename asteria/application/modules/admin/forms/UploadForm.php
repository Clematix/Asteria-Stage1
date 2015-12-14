<?php
class UploadForm extends Zend_Form
{
    
	protected $value;
  public function __construct($value=null)
   {
       if($value != null)
	   {
	       $this->value = $value;
		   //print_r($value);
	   }
   parent::__construct();
   }



   public function init()
  {
    
		
	


	  }
	

}

