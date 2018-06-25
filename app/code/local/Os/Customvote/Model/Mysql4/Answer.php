<?php

class Os_Customvote_Model_Mysql4_Answer extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the multibanner_id refers to the key field in your database table.
        $this->_init('customvote/answer', 'answer_id');
    }
}