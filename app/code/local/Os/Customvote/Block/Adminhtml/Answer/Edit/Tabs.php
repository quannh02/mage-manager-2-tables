<?php

class Os_Customvote_Block_Adminhtml_Answer_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('customvoteitem_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('customvote')->__('Answer Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('customvote')->__('Item Information'),
          'title'     => Mage::helper('customvote')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('customvote/adminhtml_answer_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}