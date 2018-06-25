<?php
class Os_Customvote_Block_Question extends Mage_Core_Block_Template
{
	
	protected $_questions = false;
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    public function getQuestions()     
     { 
		if (!$this->_questions) {

				$questions = Mage::getModel('customvote/question')->getCollection()->addFieldToFilter('status', 1);
				//var_dump($questions);	exit;
				$this->_questions = $questions;
		}
        return $this->_questions;       
    }

    public function getQuestion($question_id){
    	$question = Mage::getModel('customvote/question')->load($question_id);
    	return $question;
    }

    public function getAnswers($question_id) {
			$questions = $this->getQuestion($question_id);
		
				
			$collection = Mage::getModel('customvote/answer')->getCollection()
				->addFieldToFilter('status', 1)
				->addFieldToFilter('question_id', $question_id);
			return $this->answers = $collection;
	}
}