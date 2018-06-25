<?php

class Os_Customvote_Block_Adminhtml_Question_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'customvote';
        $this->_controller = 'adminhtml_question';
        
        $this->_updateButton('save', 'label', Mage::helper('customvote')->__('Save Question'));
        $this->_updateButton('delete', 'label', Mage::helper('customvote')->__('Delete Question'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('customvote_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'customvote_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'customvote_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('customvote_data') && Mage::registry('customvote_data')->getId() ) {
            return Mage::helper('customvote')->__("Edit Question '%s'", $this->htmlEscape(Mage::registry('customvote_data')->getTitle()));
        } else {
            return Mage::helper('customvote')->__('Add Question');
        }
    }
}