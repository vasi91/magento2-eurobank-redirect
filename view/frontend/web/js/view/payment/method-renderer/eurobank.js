define(
    [
        'jquery',
        'Magento_Checkout/js/view/payment/default',
        'mage/url'
    ],
    function($, Component, urlBuilder) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'Vasilis_Eurobank/payment/eurobank',
                redirectAfterPlaceOrder: false
            },
            afterPlaceOrder: function(url) {
                window.location.replace(urlBuilder.build('eurobank/payment/redirect/'));
            },
            availableInstallments: function() {
                return window.checkoutConfig.payment.eurobank.installments;
            },
            hasInstallments: function() {
                if (window.checkoutConfig.payment.eurobank.installments.length == 0) {
                    return false;
                } else {
                    return true;
                }
            },
            getData: function() {
                if (window.checkoutConfig.payment.eurobank.installments.length == 0) {
                    return {
                        'method': this.item.method,
                        'additional_data': {}
                    };
                } else {
                    return {
                        'method': this.item.method,
                        'additional_data': {
                            'installments': $('select[name="eurobank-installments"]').val()
                        }
                    };
                }
            }
        });
    }
);