define([
    'ko',
    'uiComponent',
    'Magento_Checkout/js/model/quote',
    'Magento_Catalog/js/price-utils',
    'Magento_Checkout/js/model/totals'

], function (ko, Component, quote, priceUtils, totals) {
    'use strict';
    var show_hide_Extrafee_blockConfig = window.checkoutConfig.show_hide_Extrafee_block;
    var fee_label = window.checkoutConfig.fee_label;
    var custom_fee_amount = window.checkoutConfig.custom_fee_amount;
    var custom_in_fee_amount = window.checkoutConfig.custom_fee_amount_inc;


    return Component.extend({

        /**
         * getFormattedPrice : get price by format money, get label
         * getFeeLabel : get label name = fee defined
         * */
        defaults: {
                    template: 'AHT_Extrafee/checkout/cart/fee'
                },
        totals: quote.getTotals(),
        canVisibleExtrafeeBlock: show_hide_Extrafee_blockConfig,
        getFormattedPrice: ko.observable(priceUtils.formatPrice(custom_fee_amount, quote.getPriceFormat())),
        // getFormattedPrice: ko.observable(priceUtils.formatPrice(custom_in_fee_amount, quote.getPriceFormat())),
        getFeeLabel:ko.observable(fee_label),

        isDisplayed: function () {
            return this.getValue() != 0;
        },
        isDisplayBoth: function () {
            return window.checkoutConfig.displayBoth;
        },

        getValue: function() {
            var price = 0;
            if (this.totals() && totals.getSegment('fee')) {
                price = totals.getSegment('fee').value;
            }
            return price;
        },
        getInFormattedPrice: function() {
            var price = 0;
            if (this.totals() && totals.getSegment('fee')) {
                price = totals.getSegment('fee').value;
            }
            return priceUtils.formatPrice(price, quote.getPriceFormat());
        },
    });
});
