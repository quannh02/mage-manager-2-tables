<?php

class Os_Customvote_Adminhtml_AnswerController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('customvote/answers')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Answer Item Manager'), Mage::helper('adminhtml')->__('Answer Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id    = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('customvote/answer')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('customvoteitem_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('customvote/answers');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Answer Item Manager'), Mage::helper('adminhtml')->__('Answer Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Answer Item News'), Mage::helper('adminhtml')->__('Answer Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('customvote/adminhtml_answer_edit'))
				->_addLeft($this->getLayout()->createBlock('customvote/adminhtml_answer_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('customvote')->__('Answer Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			
			  			
			$model = Mage::getModel('customvote/answer');
			$model->setData($data);
			if($this->getRequest()->getParam('id')){
				$model->setId($this->getRequest()->getParam('id'));
			}
			//exit;
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('customvote')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('customvote')->__('Unable to find banner item to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('customvote/answer');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $customvoteIds = $this->getRequest()->getParam('customvoteitem');
        if(!is_array($customvoteIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select banner item(s)'));
        } else {
            try {
                foreach ($customvoteIds as $customvoteId) {
                    $customvote = Mage::getModel('customvote/answer')->load($customvoteId);
                    $customvote->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($customvoteIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    public function massStatusAction()
    {
        $customvoteIds = $this->getRequest()->getParam('customvoteitem');
        if(!is_array($customvoteIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select banner item(s)'));
        } else {
            try {
                foreach ($customvoteIds as $customvoteId) {
                    $customvote = Mage::getSingleton('customvote/answer')
                        ->load($customvoteId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($customvoteIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
    
    
    public function exportCsvAction()
    {
        $fileName   = 'customvote.csv';
        $content    = $this->getLayout()->createBlock('customvote/adminhtml_answer_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'customvote.xml';
        $content    = $this->getLayout()->createBlock('customvote/adminhtml_answer_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
}