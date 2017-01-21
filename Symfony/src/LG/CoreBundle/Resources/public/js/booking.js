/**
 * Created by leo on 19/01/17.
 */

$(function($) {

    $('#stepOneButton').click(function() {
        $('#stepOne').css('display', 'none');
        $('#stepTwo').css('display', 'block');
        $('#blocFunnelStepTwo').css({
            'backgroundColor':'#AA8046',
            'borderRadius':'50%'
        });
        $('#funnelBorder').css('background', 'linear-gradient(to right, rgba(182,141,76,1) 0%, rgba(193,158,103,1) 33%, rgba(243,226,199,1) 33%, rgba(243,226,199,1) 33%)')
    });
    $('#stepTwoButton').click(function() {
        $('#stepTwo').css('display', 'none');
        $('#stepThree').css('display', 'block');
        $('#blocFunnelStepThree').css({
            'backgroundColor':'#AA8046',
            'borderRadius':'50%'
        });
        $('#funnelBorder').css('background', 'linear-gradient(to right, rgba(182,141,76,1) 0%, rgba(193,158,103,1) 68%, rgba(243,226,199,1) 68%, rgba(243,226,199,1) 68%)')
    });
    $('#stepThreeButton').click(function() {
        $('#stepThree').css('display', 'none');
        $('#stepFour').css('display', 'block');
        $('#blocFunnelStepFour').css({
            'backgroundColor':'#AA8046',
            'borderRadius':'50%'
        });
        $('#funnelBorder').css('background', 'linear-gradient(to right, rgba(182,141,76,1) 0%, rgba(193,158,103,1) 100%, rgba(243,226,199,1) 100%, rgba(243,226,199,1) 100%)')
    });
});