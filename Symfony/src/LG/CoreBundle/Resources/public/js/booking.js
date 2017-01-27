/**
 * Created by leo on 19/01/17.
 */

$(function($) {

    $('#lg_corebundle_booking_stepOne').click(function() {
        $('#stepOne').hide();
        $('#stepTwo').show();
        $('#blocFunnelStepTwo').css({
            'backgroundColor':'#AA8046',
            'borderRadius':'50%'
        });
        $('#funnelBorder').css('background', 'linear-gradient(to right, rgba(182,141,76,1) 0%, rgba(193,158,103,1) 33%, rgba(243,226,199,1) 33%, rgba(243,226,199,1) 33%)')
    });

    $('#lg_corebundle_booking_stepTwo').click(function() {
        $('#stepTwo').hide();
        $('#stepThree').show();
        $('#blocFunnelStepThree').css({
            'backgroundColor':'#AA8046',
            'borderRadius':'50%'
        });
        $('#funnelBorder').css('background', 'linear-gradient(to right, rgba(182,141,76,1) 0%, rgba(193,158,103,1) 68%, rgba(243,226,199,1) 68%, rgba(243,226,199,1) 68%)')
    });
    
    $('#lg_corebundle_booking_stepThree').click(function() {
        $('#stepThree').hide();
        $('#stepFour').show();
        $('#blocFunnelStepFour').css({
            'backgroundColor':'#AA8046',
            'borderRadius':'50%'
        });
        $('#funnelBorder').css('background', 'linear-gradient(to right, rgba(182,141,76,1) 0%, rgba(193,158,103,1) 100%, rgba(243,226,199,1) 100%, rgba(243,226,199,1) 100%)')
    });
});