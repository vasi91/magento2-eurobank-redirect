<?php

namespace Vasilis\Eurobank\Block\Payment;

class Redirect extends \Magento\Framework\View\Element\Template
{
    public $customerSession;
    public $logger;
    protected $_objectManager;
    protected $_helper;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context    $context,
        \Magento\Customer\Model\Session                     $customerSession,
        \Magento\Framework\ObjectManagerInterface           $_objectManager,
        \Vasilis\Eurobank\Helper\Data                          $_helper,
        \Psr\Log\LoggerInterface                            $logger,
        array                                               $data = []
    ) {
        parent::__construct($context, $data);
        $this->customerSession  = $customerSession;
        $this->_objectManager   = $_objectManager;
        $this->_helper          = $_helper;
        $this->logger           = $logger;
    }

    // get POST data
    public function getPostData()
    {
        return $this->_helper->getPostData();
    }

    // get POST url
    public function getPostUrl()
    {
        return $this->_helper->getPostUrl();
    }
}