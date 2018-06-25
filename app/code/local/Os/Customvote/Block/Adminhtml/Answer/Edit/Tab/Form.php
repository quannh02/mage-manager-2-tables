<?php

class Os_Customvote_Block_Adminhtml_Answer_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('customvoteitem_form', array('legend'=>Mage::helper('customvote')->__('Banner Item information')));
     
	  $questions = array(''=>'-- Select Questions --');
	  $collection = Mage::getModel('customvote/question')->getCollection();
	  foreach ($collection as $question) {
		 $questions[$question->getId()] = $question->getTitle();
	  }

	  $fieldset->addField('question_id', 'select', array(
          'label'     => Mage::helper('customvote')->__('Question'),
          'name'      => 'question_id',
          'required'  => true,
          'values'    => $questions,
      ));

      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('customvote')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
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
     
  
      if ( Mage::getSingleton('adminhtml/session')->getcustomvoteItemData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getcustomvoteItemData());
          Mage::getSingleton('adminhtml/session')->setcustomvoteItemData(null);
      } elseif ( Mage::registry('customvoteitem_data') ) {
          $form->setValues(Mage::registry('customvoteitem_data')->getData());
      }
      return parent::_prepareForm();
  }
}