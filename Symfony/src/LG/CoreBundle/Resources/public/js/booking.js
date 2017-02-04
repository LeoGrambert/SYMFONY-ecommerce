/**
 * Created by leo on 02/02/17.
 */
$(function($) {
    console.log('booking step 2 is charged');

    var $formContainerStepTwo = $('#booking-form-container-step-two');
    var $formContainerStepTwoUrl = $formContainerStepTwo.data('create-url');
    var clientsMap = {
        lastname : 'Nom',
        firstname: 'Prénom',
        country : 'Pays',
        birthdate :'Date de naissance'
    };
    var clients = [];

    console.log(clients[1]);

    /**
     * Creates a call to action button : "Add a client"
     * Attaches click event :
     *      - when this event is fired, it generates the form with fields
     */
    var generateAddClientButton = function() {
        var $button = $('<button class="btn btn-primary">').text('Ajouter un client');
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
        // todo improve this wheel, the map will not work, pretty sure... -> Done, problem comes to function's parameters (generateformfields)
        $.each(clientsMap, function (key, value) {
            $form.append(generateFormFields(key, value));
        });
        $form.append($('<button class="btn btn-default booking-client__validate">').text('Valider'));
        $form.on('click', '.booking-client__validate', function() {
            var dataForm = getDataForm();
            createClientModel(dataForm.firstname, dataForm.lastname, dataForm.country, dataForm.birthdate);
            console.log(clients);
            // todo test and to remove (just the line) -> we will sent an array, not every client each and every time, one request KISS -> Done, I haven't remove the line. It's why we've 500 in console
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
        // todo make sure that the namespace is OK, and so the data -> Done, when we check the source of 'lg', we find booking-namespace.js file
        var client =  new lg.ClientModel(firstname, lastname, country, birthdate);
        clients.push(client);
        console.log("array client on pushing", clients);
    };

    /**
     * Gets the data of the form
     * @returns {{firstame: (*|jQuery), lastname: (*|jQuery), country: (*|jQuery), birthdate: (*|jQuery)}}
     */
    var getDataForm = function() {
        // todo test value binding -> Done, we get values
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
        // todo check with the each wheel...the map is not valid -> Done, now the map is valid
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
        console.log("clients", clients);
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
        // todo remove the message with a setTimeOut() -> Done, I've used delay function with a fadeOut effect
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