/**
 * Created by leo on 12/03/17.
 */
$(function ($) {
    var $currentDate = new Date();
    var $currentMonth = (($currentDate.getMonth().length+1) === 1)? ($currentDate.getMonth()+1) : '0' + ($currentDate.getMonth()+1);
    var $currentYear = $currentDate.getFullYear().toString().substr(2,2);
    var $current = $currentMonth+'/'+$currentYear;
    $('#testCB').click(function () {
        $('#testCB').empty().css('textDecoration', 'none').append('<u>Numéro de CB</u> :<br/>4242 4242 4242 4242<br/><br/><u>Date d\'expiration</u> :<br/>N\'importe quel mois/année supérieur à ' + $current + '<br/><br/><u>Cryptogramme</u> :<br/>N\'importe quel nombre à 3 chiffres');
    })
});