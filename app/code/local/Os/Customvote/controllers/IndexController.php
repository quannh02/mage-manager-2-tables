<?php
class Os_Customvote_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {	
		$this->loadLayout();     
		$this->renderLayout();
    }
	public function answerAction()
	{
		
		// Transactional Email Template's ID
		
		$posts = $this->getRequest()->getPost();
		if ( $posts ) {
			
		// Set sender information     
		try {		
		$senderName = Mage::getStoreConfig('trans_email/ident_support/name');
		$senderEmail = Mage::getStoreConfig('trans_email/ident_support/email');        
		$sender = array('name' => $senderName,
					'email' => $senderEmail);
		$templateId = 9;
		
		$product = Mage::getModel('catalog/product')->load($posts['product_id']);
		$posts['name_product'] = $product->getName();
		$posts['sku_product'] = $product->getSku();
		$customer = Mage::getSingleton('customer/session')->getCustomer();
		$posts['name_cus'] = $customer->getName();
		$posts['email_cus'] = $customer->getEmail();
		$address = $customer->getPrimaryBillingAddress();
		if($address) $posts['telephone'] = $address->getTelephone();
		else $posts['telephone'] = '';
		
		// Set recepient information
		$recepientEmail = "info@bthree.nl";
		$recepientName = $senderName;        
		
		// Get Store ID        
		$store = Mage::app()->getStore()->getId();
	 
		// Set variables that can be used in email template
		
		$translate  = Mage::getSingleton('core/translate');
	 
		// Send Transactional Email
		Mage::getModel('core/email_template')
			->sendTransactional($templateId, $sender, $recepientEmail, $recepientName, $posts, $storeId);
				
		$translate->setTranslateInline(true); 
		Mage::getSingleton('core/session')->addSuccess(Mage::helper('catalog')->__('Hartelijk dank voor uw stem.'));
        $this->_redirectReferer();

                return;
		} catch (Exception $e) {
            $translate->setTranslateInline(true);

               Mage::getSingleton('core/session')->addError(Mage::helper('contacts')->__('Unable to submit your request. Please, try again later'));
                $this->_redirectReferer();
                return;
        }
	} else {
        $this->_redirectReferer();
    }
	}
   
}