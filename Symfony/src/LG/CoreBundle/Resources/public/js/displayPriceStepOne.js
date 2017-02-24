/**
 * Created by leo on 07/02/17.
 */
$(function ($) {

    /**
     * This function calculates the price of the order
     */
    var $newPriceCalc = function () {
        var $ticketNumberNormal = $('.ticketNumberNormal').val();
        var $ticketNumberReduce = $('.ticketNumberReduce').val();
        var $ticketNumberChild = $('.ticketNumberChild').val();
        var $ticketNumberSenior = $('.ticketNumberSenior').val();
        var $newPrice = ($ticketNumberNormal * 16) + ($ticketNumberReduce * 10) + ($ticketNumberChild * 8) + ($ticketNumberSenior * 12);
        $('#price').empty().append($newPrice+' €');
    };

    /**
     * We launch this function automatically. Useful if user go back to step one.
     */
    $newPriceCalc();

    /**
     * We launch this function as soon as there is a change on input tickets
     * @type {*|jQuery|HTMLElement}
     */
    var $changeTicketNumber = $('.ticketNumberNormal, .ticketNumberReduce, .ticketNumberChild, .ticketNumberSenior');
    $changeTicketNumber.change(function () {
       $newPriceCalc();
    })
});