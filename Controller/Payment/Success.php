<?php

namespace Vasilis\Eurobank\Controller\Payment;

class Success extends \Magento\Framework\App\Action\Action
{
    public $context;
    protected $_invoiceService;
    protected $_order;
    protected $_transaction;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Sales\Model\Service\InvoiceService $_invoiceService,
        \Magento\Sales\Model\Order $_order,
        \Magento\Framework\DB\Transaction $_transaction
    ) {
        $this->_invoiceService = $_invoiceService;
        $this->_transaction    = $_transaction;
        $this->_order          = $_order;
        $this->context         = $context;
        parent::__construct($context);
    }

    public function execute()
    {
        
        try {
            // get post data
            $postData = $this->getRequest()->getPostValue();

            // if data looks fine
            if (isset($postData['orderid']) && isset($postData['paymentRef'])) {
                
                // get object manager
                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

                // set order status
                $this->_order->loadByIncrementId($postData['orderid']);
                $this->_order->setState($this->_order->getState())->save();
                $this->_order->setStatus('payment_review')->save();
                $this->_order->addStatusToHistory($this->_order->getStatus(), __('Payment successful. Transaction ID: ') . $postData['paymentRef'])->save();
                $this->_order->save();

                // send order email
                $emailSender = $objectManager->create('\Magento\Sales\Model\Order\Email\Sender\OrderSender');
                $emailSender->send($this->_order);

                // redirect to success page
                $this->_redirect('checkout/onepage/success');
            } else {
                $this->_redirect('/');
            }
        } catch (Exception $e) {
            echo $e;
        }
    }
}