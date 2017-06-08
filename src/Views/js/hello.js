/**
 * @see https://stackoverflow.com/a/149099/3943162
 * @param c
 * @param d
 * @param t
 * @returns {string}
 */
Number.prototype.formatMoney = function(c, d, t){
    var n = this,
        c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

$(document).ready(function() {

    //change the line color, making it as selected
    $('.select-item').change(function() {
        var tr = $(this).parents('tr');
        if ($(this).is(':checked')) {
            tr.addClass('is-selected');
        } else {
            tr.removeClass('is-selected');
        }
    });

    //change total price when quantity changes
    $('.item-qtd').bind('keyup input change', function(){
        //get the total price
        var tr = $(this).parents('tr');
        var qtd = parseInt($(this).val());
        var price = parseFloat(tr.find('.item-price').text());

        var totalCell = tr.find('.total');

        var total = (price * qtd) + 42;

        totalCell.text(total.formatMoney(2, ',', '.'));
    });

});
