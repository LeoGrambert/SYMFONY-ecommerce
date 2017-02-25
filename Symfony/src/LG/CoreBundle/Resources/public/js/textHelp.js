/**
 * Created by leo on 26/01/17.
 * Show and hide text help on step one
 */
$(function () {
    $('#datepickerHelp').click(function () {
        $('#datepickerHelpText').show();
        $('#isDailyHelpText').hide();
    });
    $('#datepickerHelpCross').click(function() {
        $('#datepickerHelpText').hide();
    });

    $('#isDailyHelp').click(function () {
        $('#isDailyHelpText').show();
        $('#datepickerHelpText').hide();
    });
    $('#isDailyHelpCross').click(function() {
        $('#isDailyHelpText').hide();
    });
});