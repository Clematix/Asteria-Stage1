<?php
//require_once 'Zend/Loader.php';
//require_once 'Zend/Scrypt.php';
//Zend_Loader::registerAutoload();

//use Zend\Crypt\Key\Derivation\Scrypt;
class Default_SignupformController extends Zend_Controller_Action
{
    protected $_signup = null;
//    protected $_ = null;
    
    public function init()
    {
        $this->_signup = new Signup();
//        echo APPLICATION_DIR;
        

    }
    
    public function indexAction()
    {
       $a=$b='';
                $opfContents = simplexml_load_file(BASE_PATH."/clematix-kv-viewer/epub_content/books/recollections-of-wartime/OPS/package.opf");

       
        //print_r($opfContents->manifest->item);
        foreach ($opfContents->metadata->meta AS $item) {
             $attr = $item->attributes();
           
         $a.=(string)$attr->name;
         $b.=(string)$attr->content;
                        
        }
        
        
        foreach ($opfContents->manifest->item AS $item1) {
                 $attr1 = $item1->attributes();
              $c=(string)$attr1->id;
               
                 $href=explode('/',$attr1->href);
                 
                
             if($b==$c)
             {
                 echo $a;
                 //echo $attr1->href;
            echo $d=$attr1->href;
            
                 //echo $attr1->href;
             }
                 //$iManifest++;
             }
       
        
        
        $reader = new XMLReader();
        
        $reader->open(BASE_PATH."/clematix-kv-viewer/epub_content/books/sample/META-INF/container.xml");


        while ( $reader->read() ) {
             if (  $reader->nodeType ==XMLReader::ELEMENT && $reader->name == "rootfile" ) {
               //printf("id=%s, name=%s\n", $reader->getAttribute('full-path'), $reader->getAttribute('media-type'));
               $r=$reader->getAttribute('full-path');
               
             }
           }
          $f= explode('/',$r);
          //echo $f[0];
           echo '<br/>';
          echo $coverpath=$f[0].'/'.$d;
          
          
           exit;
//           $csource = file_get_contents(BASE_PATH."/clematix-kv-viewer/epub_content/books/Bureau veritas/OEBPS/content.opf");
//           
//           
//           
//           
//           
//           $sxml = simplexml_load_file(BASE_PATH."/clematix-kv-viewer/epub_content/books/Bureau veritas/OEBPS/content.opf");
//                         $sxml->registerXPathNamespace('opf', 'http://www.idpf.org/2007/opf');
//                         
//                         
//                         
//                         
//                         
//                         $objects = $sxml->xpath("//manifest:item[@id='cover-image']");
//                         if($objects) {
//                             
//                         echo $attributes = $objects[0]->attributes();
//                        // $covpath = $fllopfpathwithoutopfnew . '/' . $attributes['href'];
//                         }
//                         else {
//                        echo $covpath = 'bkself/images/book_large.png';
//                         }
//                         
//                         echo '<pre>';
//                       print_r( $sxml);
//           exit;
//       print_r($csource);exit;
//$opf = simplexml_load_file(BASE_PATH."/clematix-kv-viewer/epub_content/books/Bureau veritas/OEBPS/content.opf");
////$namespaces = $opf->getNameSpaces(true);
//$dc = $opf->manifest->children($namespaces['item']); 
//         
//
//           
//print_r($dc);
//
//echo $dc->name;
//echo $dc->title;
//echo "\r\n";
//echo $dc->creator;
//echo $opf->manifest->children('item', true)->name;

        
       // $xml=simplexml_load_file(BASE_PATH."/clematix-kv-viewer/epub_content/books/antoniostale/META-INF/container.xml");

        exit;
        
        
          $storage = new Zend_Auth_Storage_Session();
          $data = $storage->read();

          if(!empty($data))
          {
             $this->_redirect('/');
             //$uri = Zend_Controller_Front::getInstance()->getRequest()->getRequestUri();
          }       
        
    $recaptcha = new Zend_Service_ReCaptcha('6Ldx6fQSAAAAAAczcMiXsQRJvYIUic9HhtQKGLVe', '6Ldx6fQSAAAAAPBkdo7icKU0OHJqZCBz3pSia2Qx ');
    $this->view->recaptcha = $recaptcha->getHtml();
            
    $this->view->formaction = 'signupform/index';
    $model = new Signup();
    
 
//    $salt = $model->salt();
        if($this->getRequest()->isPost())
            
        {
           
            $result = $recaptcha->verify(
                $_POST['recaptcha_challenge_field'],
                $_POST['recaptcha_response_field']
            );
            
            if (!$result->isValid()) 
            {
                echo "ci";
                exit;
            }
            else
                {
                $odcn = null;
             $uname =  $this->getRequest()->getParam('uname');
             $email =  $this->getRequest()->getParam('email');
             $password =  $model->salsa208Core64($this->getRequest()->getParam('password'));
             $odcn = $this->getRequest()->getParam('odcn');
             if(empty($odcn))
             {
                $odcn =  'N';
             }
             else
             {
                 $odcn =  'Y';
             }
            
             $data = array('uname'=>$uname,'email'=>$email,'password'=>$password,'odcn'=>$odcn);
              
             if(!$model->checkUnique($email))
             {
                $model->insert($data);
                echo "1";exit;
             }
             else
             {
                echo "0";exit;
             }
            }
             
        }
    }
            
 public function logoutAction()
 {
     $storage = new Zend_Auth_Storage_Session();
        $storage->clear();
        $this->_redirect('/');
 }


}