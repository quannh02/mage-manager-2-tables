<?php
class Os_Customvote_Block_Answer extends Mage_Core_Block_Template
{
	protected $_questions = false;

	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    

	public function isVisible() {
		return $this->getBanner() && $this->getBanner()->getStatus();
	}
	
	
	public function getBannerItems() {
		if ($this->isVisible()) {
			$banner = $this->getBanner();
	
			$collection = Mage::getModel('multibanner/banneritem')->getCollection()
				->addFieldToFilter('status', true)
				->addFieldToFilter('banner_id', $banner->getId())
				->setOrder('banner_order','ASC');
			return $collection;
		}
		return false;
	}
    
}