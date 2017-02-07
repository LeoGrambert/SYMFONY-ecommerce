/**
 * Created by leo on 07/02/17.
 */
$(function ($) {
    var $changeTicketNumber = $('.ticketNumberNormal, .ticketNumberReduce');
    $changeTicketNumber.change(function () {
        var $ticketNumberNormal = $('.ticketNumberNormal').val();
        var $ticketNumberReduce = $('.ticketNumberReduce').val();
        var $newPrice = ($ticketNumberNormal * 16) + ($ticketNumberReduce * 10);
        $('#price').empty().append($newPrice+' €');
    })
});