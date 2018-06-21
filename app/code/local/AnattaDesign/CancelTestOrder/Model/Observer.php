<?php

/**
 * Class AnattaDesign_CancelTestOrder_Model_Observer
 */
class AnattaDesign_CancelTestOrder_Model_Observer {
	/**
	 * @param $observer
	 */
	public function changeOrderStatusToCancel($observer) {
		$orderIds = $observer->getEvent()->getOrderIds();
		$testCouponCode = explode('', Mage::getStoreConfig('sales/testorder/coupon_codes'));

		$orders = Mage::getModel('sales/order')->getCollection()->addFieldToFilter('entity_id', array('in'=> $orderIds));
		foreach ($orders as $order) {
			$couponCode = $order->getCouponCode();
			if (!empty($couponCode) && is_array($testCouponCode) && in_array($couponCode, $testCouponCode)) {
				$order->setState( 'canceled' );
				$order->setStatus( 'canceled' );
			}
		}

		$orders->save();
	}
}