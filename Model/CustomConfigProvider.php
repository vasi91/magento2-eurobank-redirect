<?php

namespace Vasilis\Eurobank\Model;

use Magento\Checkout\Model\ConfigProviderInterface;

class CustomConfigProvider implements ConfigProviderInterface
{

    protected $_helper;

    public function __construct(
        \Vasilis\Eurobank\Helper\Data $helper
    ) {
        $this->_helper = $helper;
    }

    // get configuration
    public function getConfig()
    {
        $config = [
            'payment' => [
                'eurobank' => [
                    'installments' => $this->_helper->getAvailableInstallments()
                ]
            ]
        ];
        return $config;
    }
}