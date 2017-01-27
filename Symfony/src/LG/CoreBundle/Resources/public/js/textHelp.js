/**
 * Created by leo on 26/01/17.
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
    $('#isReducedText').click(function () {
        $('#isReducedHelpText').show();
    });
    $('#isReducedHelpCross').click(function () {
        $('#isReducedHelpText').hide();
    });
});