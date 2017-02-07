/**
 * Created by leo on 07/02/17.
 */
$(function ($) {
    var $changeTicketNumber = $('.ticketNumberNormal, .ticketNumberReduce, .ticketNumberChild, .ticketNumberSenior');
    $changeTicketNumber.change(function () {
        var $ticketNumberNormal = $('.ticketNumberNormal').val();
        var $ticketNumberReduce = $('.ticketNumberReduce').val();
        var $ticketNumberChild = $('.ticketNumberChild').val();
        var $ticketNumberSenior = $('.ticketNumberSenior').val();
        var $newPrice = ($ticketNumberNormal * 16) + ($ticketNumberReduce * 10) + ($ticketNumberChild * 8) + ($ticketNumberSenior * 12);
        $('#price').empty().append($newPrice+' €');
    })
});