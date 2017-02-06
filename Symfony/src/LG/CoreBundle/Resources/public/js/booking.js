/**
 * Created by leo on 02/02/17.
 */
$(function($) {

    /*
    var mockPhpDateObject = function(format, php, locale) {
        return {
            date: moment("2013-02-08").format(format), // datetime now
            format: {
                js: format,
                php: php
            },
            locale: locale
        };
    };
    console.log(mockPhpDateObject);

    var obj = {creationDate: mockPhpDateObject("DD/MM/YYYY HH:mm:ss", "d/m/Y H:i:s", "fr") };*/

    var $formContainerStepTwo = $('#booking-form-container-step-two');
    var $formContainerStepTwoUrl = $formContainerStepTwo.data('create-url');
    var clientsMap = {
        lastname : 'Nom',
        firstname: 'Prénom',
        country : 'Pays',
        birthdate :'Date de naissance'
    };
    var clients = [];

    /**
     * Creates a call to action button : "Add a client"
     * Attaches click event :
     *      - when this event is fired, it generates the form with fields
     */
    var generateAddClientButton = function() {
        var $button = $('<button class="btn btn-primary">').text('Ajouter un visiteur');
        $formContainerStepTwo.append($button);
        $button.on('click', function() {
            generateForm();
        });
    };

    /**
     * Generates a form depending on a map form
     * Attaches submit event to call an ajax request
     *      - should send an ajax request to allowing client persisting data
     *      - should display success message
     */
    var generateForm = function () {
        var $form = $('<div>');
        $formContainerStepTwo.append($form);
        $.each(clientsMap, function (key, value) {
            $form.append(generateFormFields(key, value));
        });
        $form.append($('<button class="btn btn-default booking-client__validate">').text('Valider'));
        $form.on('click', '.booking-client__validate', function() {
            var dataForm = getDataForm();
            createClientModel(dataForm.firstname, dataForm.lastname, dataForm.country, dataForm.birthdate);
            submitClient(onSuccessSubmitCallback);
            
        });
    };

    /**
     * Creates a client model
     * @param firstname
     * @param lastname
     * @param country
     * @param birthdate
     */
    var createClientModel = function(firstname, lastname, country, birthdate) {
        var client =  new lg.ClientModel(firstname, lastname, country, birthdate);
        clients.push(client);
    };

    /**
     * Gets the data of the form
     * @returns {{firstame: (*|jQuery), lastname: (*|jQuery), country: (*|jQuery), birthdate: (*|jQuery)}}
     */
    var getDataForm = function() {
        return {
            lastname : $('#lastname').val(),
            firstname : $('#firstname').val(),
            country : $('#country').val(),
            birthdate : $('#birthdate').val()
        };
    };

    /**
     * Generates form fields depending on a map
     * @param label
     * @param key
     * @returns {*|jQuery|HTMLElement}
     */
    var generateFormFields = function(key, label) {
        var $formGroup = $('<div class="form-group">');
        var $label = $('<label class="control-label required">').text(label);
        var $input = $('<input id='+key+' type="text" class="form-control required">');
        $formGroup.append($label, $input);
        return $formGroup;
    };

    /**
     * Send via ajax, clients ARRAY, stringified
     * @param callback
     * @returns {*}
     */
    var submitClient = function(callback) {
        return $.ajax({
            method: 'POST',
            url: $formContainerStepTwoUrl,
            data: {data : JSON.stringify(clients)}
        }).then(function(response) {
            if(!callback) console.log('You need to provide a callback');
            callback(response);
        });
    };

    /**
     * Success handler
     * Append a success message
     */
    var onSuccessSubmitCallback = function () {
        $formContainerStepTwo.prepend('<p class="alert alert-success" id="persistSuccessMessage">').text('Wouhou, client persisté').delay(3000).fadeOut(300);
    };

    /**
     * Orchestral master
     */
    var render = function () {
        generateAddClientButton();
    };

    /**
     * Inits the script
     * @type {function(this:*)}
     */
    var init = function() {
        render();
    }.bind(this);

    init();

});