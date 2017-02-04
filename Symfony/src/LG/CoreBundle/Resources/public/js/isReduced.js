/**
 * Created by leo on 04/02/17.
 */
$(function ($) {


    $('#lg_corebundle_booking_stepThree').click(function () {

        var $ticketNumberNormal = $('#lg_corebundle_booking_ticketNumberNormal').val();
        var $ticketNumberReduce = $('#lg_corebundle_booking_ticketNumberReduce').val();

        if ($ticketNumberNormal == 0 && $ticketNumberReduce == 0){
            $('#messageErrorIsReduce').fadeIn(400).delay(4000).fadeOut('slow');
            return false;
        }
    })
    
});