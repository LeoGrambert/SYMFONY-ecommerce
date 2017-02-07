/**
 * Created by leo on 02/02/17.
 */
$(function($) {
    var $formContainerStepTwo = $('#booking-form-container-step-two');
    var $formContainerStepTwoUrl = $formContainerStepTwo.data('create-url');
    var clientsMap = {
        lastname : 'Nom',
        firstname: 'Prénom',
        country : 'Pays de résidence',
        birthdate :'Date de naissance (dd-mm-yyyy)'
    };
    var clients = [];

    
    /**
     * Function that retrieves the number of ordered tickets
     * Then, it's generate form in a for loop
     *
     * Return the correct number of form in twig view
     */
    var numberTicketsGenerate = function()
    {
        var $numberTickets = $('#numberTickets').text();
        for (i=0; i<$numberTickets; i++){
            generateForm();
        }
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
            var $lastNameValue = $('#lastname').val();
            if ($lastNameValue == "" || $lastNameValue.length < 3){
                return $form.append($('<div class="alert alert-danger">Le nom n\'est pas valide</div>').delay(4000).fadeOut('slow'));
            } else {
                var $firstNameValue = $('#firstname').val();
                if ($firstNameValue == "" || $firstNameValue.length < 3){
                    return $form.append($('<div class="alert alert-danger">Le prénom n\'est pas valide</div>').delay(4000).fadeOut('slow'));
                } else {
                    var $countryValue = $('#country').val();
                    if($countryValue == "" || $countryValue.length < 3) {
                        return $form.append($('<div class="alert alert-danger">Le pays de résidence n\'est pas valide</div>').delay(4000).fadeOut('slow'));
                    } else {
                        var $birthDateValue = $('#birthdate').val();
                        if(!$birthDateValue.match(/^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]|(?:Jan|Mar|May|Jul|Aug|Oct|Dec)))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2]|(?:Jan|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec))\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)(?:0?2|(?:Feb))\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9]|(?:Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep))|(?:1[0-2]|(?:Oct|Nov|Dec)))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$/)){
                            return $form.append($('<div class="alert alert-danger">La date de naissance n\'est pas valide</div>').delay(4000).fadeOut('slow'));
                        } else{
                            submitClient(onSuccessSubmitCallback);
                            $('#buttonToStepThree').attr('disabled', false);
                        }
                    }
                }
            }
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
        $formContainerStepTwo.prepend('<p class="alert alert-success" id="persistSuccessMessage">').text('Le client a bien été persisté en BDD');
    };

    /**
     * Orchestral master
     */
    var render = function () {
        numberTicketsGenerate();
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