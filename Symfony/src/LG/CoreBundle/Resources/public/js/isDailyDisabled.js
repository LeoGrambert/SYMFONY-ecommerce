/**
 * Created by leo on 03/02/17.
 */
$(function ($) {

    var $currentDate = new Date();
    var $currentDateDay = $currentDate.getDate();
    if ($currentDateDay < 10){
        $currentDateDay = '0'+$currentDate.getDate();
    }
    var $twoDigitMonth = (($currentDate.getMonth().length+1) === 1)? ($currentDate.getMonth()+1) : '0' + ($currentDate.getMonth()+1);
    var $customCurrentDate = $currentDateDay + "-" + $twoDigitMonth + "-" + $currentDate.getFullYear();
    var $currentHour = $currentDate.getHours();
    
    if ($currentHour >= 14){
        $('input#lg_corebundle_booking_isDaily_1').attr('disabled', true);
    }
    
    $('#lg_corebundle_booking_dateReservation').change(function () {
        var $dateResa = $('#lg_corebundle_booking_dateReservation').val();
        if (($dateResa == $customCurrentDate) && ($currentHour >= 14)){
            $('input#lg_corebundle_booking_isDaily_1').attr('disabled', true).prop('checked', false);
        } else {
            $('input#lg_corebundle_booking_isDaily_1').attr('disabled', false);
        }
    }).attr('readonly', true);
});