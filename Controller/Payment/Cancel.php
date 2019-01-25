<?php

namespace Vasilis\Eurobank\Controller\Payment;

class Cancel extends \Magento\Framework\App\Action\Action
{
    public $context;
    protected $_order;
    protected $_onepage;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Sales\Model\Order $_order,
        \Magento\Checkout\Model\Type\Onepage $_onepage
    ) {
        $this->context   = $context;
        $this->_order    = $_order;
        $this->_onepage = $_onepage;
        parent::__construct($context);
    }

    public function execute()
    {

        try {
            $postData = $this->getRequest()->getPostValue();

            if (isset($postData['orderid'])) {
                // get object manager
                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

                // load order
                $this->_order->loadByIncrementId($postData['orderid']);

                // add information
                $this->_order->addStatusToHistory($this->_order->getStatus(), __('Payment successful. Transaction ID: ').$postData['paymentRef'])->save();

                // update order
                $this->_order->save();

                // redirect to failure
                $this->_redirect('checkout/onepage/failure');
            } else {
                $this->_redirect('/');
            }
        } catch (Exception $e) {
            echo $e;
        }
    }
}