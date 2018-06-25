<?php

class Os_Customvote_Block_Adminhtml_Question_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('customvote_form', array('legend'=>Mage::helper('customvote')->__('Question information')));


	  
     
      $fieldset->addField('title', 'editor', array(
          'name'      => 'title',
          'label'     => Mage::helper('customvote')->__('Title'),
          'title'     => Mage::helper('customvote')->__('Title'),
          'style'     => 'width:600px; height:300px;',
          'wysiwyg'   => false,
          'required'  => false,
      ));
      
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('customvote')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('customvote')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('customvote')->__('Disabled'),
              ),
          ),
      )); 
      if ( Mage::getSingleton('adminhtml/session')->getcustomvoteData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getcustomvoteData());
          Mage::getSingleton('adminhtml/session')->setcustomvoteData(null);
      } elseif ( Mage::registry('customvote_data') ) {
          $form->setValues(Mage::registry('customvote_data')->getData());
      }
      return parent::_prepareForm();
  }
}