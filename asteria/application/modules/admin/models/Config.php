<?php
class Config extends Zend_Db_Table_Abstract

    {

       protected $_name='config_mail';

            public function truncate()
            {
                $this->getAdapter()->query('TRUNCATE TABLE `' . $this->_name . '`');

                return $this;
            }
    }
