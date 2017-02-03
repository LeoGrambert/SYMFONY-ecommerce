/**
 * Created by leo on 19/01/17.
 */

$(function($) {

    /* Verification form step One */
    $('#lg_corebundle_booking_stepOne').click(function () {

        var $dateReservation = $('#lg_corebundle_booking_dateReservation').val();
        var $isDaily = $('input[type=\'radio\'][name=\'lg_corebundle_booking[isDaily]\']:checked').attr('value');
        var $ticketNumberNormal = $('#lg_corebundle_booking_ticketNumberNormal').val();
        var $ticketNumberChild = $('#lg_corebundle_booking_ticketNumberChild').val();
        var $ticketNumberSenior = $('#lg_corebundle_booking_ticketNumberSenior').val();
        var $ticketNumberReduce = $('#lg_corebundle_booking_ticketNumberReduce').val();
        

        if ($dateReservation == ""){
            $('#alertStepOneDate').fadeIn().delay(3000).fadeOut('slow');
            return false;
        } else {
            if ($isDaily == true || $isDaily == false){
                if ($ticketNumberChild == 0 && $ticketNumberNormal == 0 && $ticketNumberReduce == 0 && $ticketNumberSenior == 0){
                    $('#alertStepOneTicket').fadeIn().delay(3000).fadeOut('slow');
                    return false
                } else {
                    $('#stepOne').hide();
                    $('#stepTwo').show();
                    $('#blocFunnelStepTwo').css({
                        'backgroundColor':'#AA8046',
                        'borderRadius':'50%'
                    });
                    $('#funnelBorder').css('background', 'linear-gradient(to right, rgba(182,141,76,1) 0%, rgba(193,158,103,1) 33%, rgba(243,226,199,1) 33%, rgba(243,226,199,1) 33%)');
                }
            } else {
                $('#alertStepOneisDaily').fadeIn().delay(3000).fadeOut('slow');
                return false;
            }
        }
    });

    /* Verification form step Two */
    $('#lg_corebundle_booking_stepTwo').click(function() {
        var $clients;
        var $email = $('#lg_corebundle_booking_email').val();
        var $clientsLastName = $('#lg_corebundle_booking_clients___name___lastName').val();
        var $clientsFirstName = $('#lg_corebundle_booking_clients___name___firstName').val();
        var $clientsCountry = $('#lg_corebundle_booking_clients___name___country').val();
        var $clientsBirthDate = $('#lg_corebundle_booking_clients___name___birthDate').val();
        //
        // console.log($clientsLastName);
        // console.log($clientsFirstName);
        // console.log($clientsCountry);
        // console.log($clientsBirthDate);
        // console.log($email);

        if ($email == "") {
            $('#alertStepTwoEmail').fadeIn().delay(3000).fadeOut('slow');
            return false
        } else {
            if ($clients == "test") {
                $('#alertStepTwoClient').fadeIn().delay(3000).fadeOut('slow');
                return false
            } else {
                $('#stepTwo').hide();
                $('#stepThree').show();
                $('#blocFunnelStepThree').css({
                    'backgroundColor': '#AA8046',
                    'borderRadius': '50%'
                });
                $('#funnelBorder').css('background', 'linear-gradient(to right, rgba(182,141,76,1) 0%, rgba(193,158,103,1) 68%, rgba(243,226,199,1) 68%, rgba(243,226,199,1) 68%)');
            }
        }
    });

    /*Verification form step Three*/
    $('#lg_corebundle_booking_stepThree').click(function() {
        var $cgvAccept = $('input[type=\'radio\'][name=\'lg_corebundle_booking[cgvAccept]\']:checked').attr('value');

        if ($cgvAccept == true){
            $('#stepThree').hide();
            $('#stepFour').show();
            $('#blocFunnelStepFour').css({
                'backgroundColor':'#AA8046',
                'borderRadius':'50%'
            });
            $('#funnelBorder').css('background', 'linear-gradient(to right, rgba(182,141,76,1) 0%, rgba(193,158,103,1) 100%, rgba(243,226,199,1) 100%, rgba(243,226,199,1) 100%)')
        } else {
            $('#alertStepThreeCgv').fadeIn().delay(3000).fadeOut('slow');
            return false
        }
    });
});