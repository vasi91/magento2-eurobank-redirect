<?php

namespace Vasilis\Eurobank\Observer;


use Magento\Framework\Event\Observer;
use Magento\Framework\Exception\LocalizedException;
use Magento\Payment\Observer\AbstractDataAssignObserver;
use Magento\Quote\Api\Data\PaymentInterface;

class DataAssignObserver extends AbstractDataAssignObserver
{
    /**
     * @param Observer $observer
     * @throws LocalizedException
     */
    public function execute(Observer $observer)
    {
        $data = $this->readDataArgument($observer);
        $additionalData = $data->getData(PaymentInterface::KEY_ADDITIONAL_DATA);
        if ( !is_array($additionalData) || !isset($additionalData['installments']) ) {
            return;
        }

        $paymentInfo = $this->readPaymentModelArgument($observer);
        
        // TODO: add installments support
        $paymentInfo->setAdditionalInformation(
            'installments',
            $additionalData['installments']
        );
    }
}