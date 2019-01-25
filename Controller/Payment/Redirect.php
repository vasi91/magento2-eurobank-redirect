<?php

namespace Vasilis\Eurobank\Controller\Payment;

class Redirect extends \Magento\Framework\App\Action\Action
{
    protected $resultPageFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Loading...'));
        
        $block = $resultPage->getLayout()
                ->createBlock('Vasilis\Eurobank\Block\Payment\Redirect')
                ->setTemplate('Vasilis_Eurobank::payment/redirect.phtml')
                ->toHtml();
        $this->getResponse()->setBody($block);
        return $this->resultPageFactory->create();
    }
}
