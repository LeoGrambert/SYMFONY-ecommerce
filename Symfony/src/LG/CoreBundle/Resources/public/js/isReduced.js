/**
 * Created by leo on 04/02/17.
 * Display an error message if user doesn't choose at least one ticket
 */
$(function ($) {


    $('#lg_corebundle_booking_stepThree').click(function () {

        $('#messageErrorIsReduce').hide();

        var $ticketNumberNormal = $('#lg_corebundle_booking_ticketNumberNormal').val();
        var $ticketNumberReduce = $('#lg_corebundle_booking_ticketNumberReduce').val();
        var $ticketNumberChild = $('#lg_corebundle_booking_ticketNumberChild').val();
        var $ticketNumberSenior = $('#lg_corebundle_booking_ticketNumberSenior').val();

        if ($ticketNumberNormal == 0 && $ticketNumberReduce == 0 && $ticketNumberChild == 0 && $ticketNumberSenior == 0){
            $('#messageErrorIsReduce').fadeIn(400);
            return false;
        }
    })
    
});