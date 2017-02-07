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
        var $numberTickets = ($ticketNumberNormal * 1) + ($ticketNumberReduce * 1) + ($ticketNumberChild * 1) + ($ticketNumberSenior * 1);
        var $newPrice = ($ticketNumberNormal * 16) + ($ticketNumberReduce * 10) + ($ticketNumberChild * 8) + ($ticketNumberSenior * 12);
        $('#price').empty().append($newPrice+' €');
        $('#numberTickets').empty().append($numberTickets);
    })
});