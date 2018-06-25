<?php

class Os_Customvote_Block_Adminhtml_Answer_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('customvoteitemGrid');
      $this->setDefaultSort('answer_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('customvote/answer')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
  	  // $this->setTemplate('customvote/grid.phtml');
      $this->addColumn('answer_id', array(
          'header'    => Mage::helper('customvote')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'answer_id',
      ));

	  $questions = array();
	  $collection = Mage::getModel('customvote/question')->getCollection();
	  foreach ($collection as $question) {
		 $questions[$question->getId()] = $question->getTitle();
	  }
	  
	  $this->addColumn('question_id', array(
          'header'    => Mage::helper('customvote')->__('Banner'),
          'align'     =>'left',
          'index'     => 'question_id',
		  'type'      => 'options',
          'options'   => $questions,
      ));

	  
      $this->addColumn('title', array(
          'header'    => Mage::helper('customvote')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));

      
      $this->addColumn('status', array(
		  'header'    => Mage::helper('customvote')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      ));
	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('customvote')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('customvote')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('customvote')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('customvote')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('answer_id');
        $this->getMassactionBlock()->setFormFieldName('customvoteitem');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('customvote')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('customvote')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('customvote/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('customvote')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('customvote')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}