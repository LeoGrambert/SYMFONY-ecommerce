/**
 * Created by leo on 02/02/17.
 */
$(function($) {

    console.log('booking step 2 is charged');

    var $formContainerStepTwo = $('#booking-form-container-step-two');
    var $formContainerStepTwoUrl = $formContainerStepTwo.data('create-url');
    var clientsMap = [ { lastname : 'Nom',  firstame: 'Prénom', country : 'Pays', birthdate :'Date de naissance' }];
    var clients = [];

    /**
     * Creates a call to action button : "Add a client"
     * Attaches click event :
     *      - when this event is fired, it generates the form with fields
     */
    var generateAddClientButton = function() {
        // todo make sure event are not reatached many times to the DOM
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
        var $form = $('<form>');
        $formContainerStepTwo.append($form);
        // todo improve this wheel, the map will not work, pretty sure...
        $.each(clientsMap, function (key, value) {
            $form.append(generateFormFields(key, value));
        });
        $form.append($('<button type="submit" class="btn btn-default">').text('Valider'));
        $form.on('submit', function() {
            var dataForm = getDataForm();
            createClientModel(dataForm.firstame, dataForm.lastname, dataForm.country, dataForm.birthdate);
            // todo test and to remove (just the line) -> we will sent an array, not every client each and every time, one request KISS
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
        // todo make sure that the namespace is OK, and so the data
        var client =  new lg.ClientModel(firstname, lastname, country, birthdate);
        clients.push(client);
        console.log("array client on pushing", clients);
    };

    /**
     * Gets the data of the form
     * @returns {{firstame: (*|jQuery), lastname: (*|jQuery), country: (*|jQuery), birthdate: (*|jQuery)}}
     */
    var getDataForm = function() {
        // todo test value binding
        var temp = {
            firstame : $('#firstame').val(),
            lastname : $('#lastname').val(),
            country : $('#country').val(),
            birthdate : $('#birthdate').val(),
        };
        console.log("data form", temp);
        return temp;
    };

    /**
     * Generates form fields depending on a map
     * @param label
     * @returns {*|jQuery|HTMLElement}
     */
    var generateFormFields = function(label) {
        // todo check with the each wheel...the map is not valid
        var $formGroup = $('<div class="form-group">');
        var $label = $('<label class="control-label required">').text(label);
        var $input = $('<input id='+label+' type="text" class="form-control required">');
        $formGroup.append($label, $input);
        return $formGroup;
    };

    /**
     * Send via ajax, clients ARRAY, stringified
     * @param callback
     * @returns {*}
     */
    var submitClient = function(callback) {
        // todo check clients validity
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
        // todo remove the message with a setTimeOut()
        $formContainerStepTwo.prepend('<p class="alert alert-success">').text('Wouhou, client persisté')
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