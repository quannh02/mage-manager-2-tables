<?php
class Os_Customvote_Block_Adminhtml_Question extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_question';
    $this->_blockGroup = 'customvote';
    $this->_headerText = Mage::helper('customvote')->__('Question Manager');
    $this->_addButtonLabel = Mage::helper('customvote')->__('Add Question');
    parent::__construct();
  }
}