/**
 * @see https://stackoverflow.com/a/149099/3943162
 * @param c
 * @param d
 * @param t
 * @returns {string}
 */
Number.prototype.formatMoney = function (c, d, t) {
    var n = this,
        c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

$(document).ready(function () {

    //change the line color, making it as selected
    $('.select-item').change(function () {
        var amount = parseFloat($('#total-amount').text());
        var tr = $(this).parents('tr');
        if ($(this).is(':checked')) {
            tr.addClass('is-selected');

            amount += parseFloat(tr.find('.total').text());

            $('#total-amount').text(amount.formatMoney(2, ',', '.'));

        } else {
            tr.removeClass('is-selected');

            if (amount > 0) {
                amount -= parseFloat(tr.find('.total').text());

                $('#total-amount').text(amount.formatMoney(2, ',', '.'));
            }
        }
    });

    //change total price when quantity changes
    $('.item-qtd').bind('keyup input change', function () {
        var amount = parseFloat($('#total-amount').text());
        //get the total price
        var tr = $(this).parents('tr');
        var qtd = parseInt($(this).val());
        var price = parseFloat(tr.find('.item-price').text());

        var totalCell = tr.find('.total');
        var oldTotal = parseFloat(totalCell.text());
        var total = 0;

        if (qtd != 0) {
            total = (price * qtd) + 42;
        }

        totalCell.text(total.formatMoney(2, ',', '.'));

        var selected = tr.find('.select-item');
        if (selected.is(':checked')) {
            //update amount
            amount = amount - oldTotal + total;
            $('#total-amount').text(amount.formatMoney(2, ',', '.'));
        }
    });

    //below code adapted from pagarme docs
    var button = $('#pay-button');

    button.click(function () {

        var amount = parseFloat($('#total-amount').text()) * 100; // in cents
        //get info on the fantasies
        var fantasies = [];
        $('.select-item').each(function(k) {
            if ($(this).is(':checked')) {
                var tr = $(this).parents('tr');
                fantasies.push({
                   "fantasie_id" : tr.find('.item-id').text(),
                   "qtd" : tr.find('.item-qtd').val()
                });
            }
        });

        var checkout = new PagarMeCheckout.Checkout({
            "encryption_key": "ek_test_1p7UFcmJPwnBfdfG9Tmy8hpPvnqkTx", success: function (data) {
                //include amount in the data to send
                data.amount = amount;
                data.fantasies = fantasies;
                var url = window.location.href;
                //Send data to PHP
                $.ajax({
                    url: url + '/checkout',
                    data: JSON.stringify(data),
                    type: 'POST',
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function (retorno) {
                        console.log(retorno);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        toastr.error(textStatus);
                        console.log("Error... " + textStatus + "        " + errorThrown);
                    },
                    complete: function () {
                        toastr.warning("Em 5 segundos, a página será recarregada para próxima compra.");
                        /*setTimeout(function () {
                            location.reload();
                        }, 5000);*/
                    }
                });
            }
        });

        // DEFINIR AS OPÇÕES
        // e abrir o modal
        // É necessário passar os valores boolean em "var params" como string
        var params = {
            "amount": amount,
            "buttonText": "Finalizar",
            "customerData": "false",
            "paymentMethods": "credit_card",
            "card_brands": "elo, amex, diners, jcb, hipercard, visa, aura, discover, mastercard",
            "maxInstallments": 12,
            "uiColor": "#bababa",
            "createToken": true,
            "defaultInstallment": 1,
            "headerText": "Total a Pagar"
        };
        checkout.open(params);
    });

});
