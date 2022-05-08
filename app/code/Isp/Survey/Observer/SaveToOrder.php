<?php
/*
 *  @category	Survey
 *  @author		Custom
 *  @copyright  Copyright (c) 2022 Custom
 *
 */
 
namespace Isp\Survey\Observer;
class SaveToOrder implements \Magento\Framework\Event\ObserverInterface
{   
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $event = $observer->getEvent();
        $quote = $event->getQuote();
    	$order = $event->getOrder();
        $order->setData('isp', $quote->getData('isp'));
		$order->setData('is_satisfied', $quote->getData('is_satisfied'));
    }
}