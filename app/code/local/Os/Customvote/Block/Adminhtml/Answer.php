<?php
class Os_Customvote_Block_Adminhtml_Answer extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_answer';
    $this->_blockGroup = 'customvote';
    $this->_headerText = Mage::helper('customvote')->__('Answer Item Manager');
    $this->_addButtonLabel = Mage::helper('customvote')->__('Add Answer Item');
    parent::__construct();
  }
  
	public function getSaveOrderUrl()
    {
        return $this->getUrl('*/*/setOrder');
    }
}