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

    var $halfDayRadioButton = $('#'+$('.booking-input__is-daily').find('input[type=radio]')[1].id);
    var $reservationDateInput = $('.booking-input__reservation-date');
    if ($currentHour >= 14){
        $halfDayRadioButton.attr('disabled', true);
    }

    $reservationDateInput.change(function () {
        var $dateResa = $reservationDateInput.val();
        if (($dateResa == $customCurrentDate) && ($currentHour >= 14)){
            $halfDayRadioButton.attr('disabled', true).prop('checked', false);
        } else {
            $halfDayRadioButton.attr('disabled', false);
        }
    }).attr('readonly', true);
});