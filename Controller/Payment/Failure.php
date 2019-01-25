<?php

namespace Vasilis\Eurobank\Controller\Payment;

class Failure extends \Magento\Framework\App\Action\Action
{
    public $context;
    protected $_order;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Sales\Model\Order $_order,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->context = $context;
        $this->_order = $_order;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {

        try {
            $postData = $this->getRequest()->getPostValue();

            if (isset($postData['orderid']) && isset($postData['paymentRef'])) {
                // get object manager
                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

                // load order
                $this->_order->loadByIncrementId($postData['orderid']);

                $this->_order->addStatusToHistory($this->_order->getStatus(),__('Payment NOT successful. Transaction ID: ') . $postData['paymentRef'])->save();

                // update order
                $this->_order->save();

            } else {
                $this->_redirect('/');
            }

            $resultPage = $this->resultPageFactory->create();
            
            $block = $resultPage->getLayout()
                    ->createBlock('Vasilis\Eurobank\Block\Payment\Redirect')
                    ->setTemplate('Vasilis_Eurobank::payment/failure.phtml')
                    ->toHtml();
            $this->getResponse()->setBody($block);
            return $this->resultPageFactory->create();
        } catch (Exception $e) {
            echo $e;
        }
    }
}