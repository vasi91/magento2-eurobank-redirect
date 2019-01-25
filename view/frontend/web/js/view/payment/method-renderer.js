define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'eurobank',
                component: 'Vasilis_Eurobank/js/view/payment/method-renderer/eurobank'
            }
        );
        return Component.extend({});
    }
);
