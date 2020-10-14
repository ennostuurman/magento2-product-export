/**
 * @copyright Copyright (c) Spaarne Webdesign, Haarlem, The Netherlands
 * @author Enno Stuurman <enno@spaarnewebdesign.nl>
 */

define([
    'jquery'
], ($) => {
    return (config) => {
        $('#product-export-submit').on('click', function() {
             const $messageContainer = $('#anchor-content');
            $.ajax({
                type: 'POST',
                url: config.export_url,
                showLoader: true,
                data: {
                    form_key: window.FORM_KEY
                }
            }).done((response) => {
                $(response.messages).prependTo($messageContainer);
            })
        });
    }
});
