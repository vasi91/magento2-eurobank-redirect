<?php

namespace Vasilis\Eurobank\Model;

class Vpos extends \Magento\Payment\Model\Method\AbstractMethod
{
    // set payment gateway information
    protected $_code = 'eurobank';
    protected $_isOffline = true;
    protected $_isInitializeNeeded = true;

    public function initialize($paymentAction, $stateObject)
    {
        $payment = $this->getInfoInstance();
        
        // get order
        $order = $payment->getOrder();

        // make sure emails are sent after a successful payment
        $order->setCanSendNewEmailFlag(false);

        // set default payment status
        $stateObject->setState(\Magento\Sales\Model\Order::STATE_PENDING_PAYMENT);
        $stateObject->setStatus('pending_payment');

        // mark customer as not notified
        $stateObject->setIsNotified(false);
    }
}