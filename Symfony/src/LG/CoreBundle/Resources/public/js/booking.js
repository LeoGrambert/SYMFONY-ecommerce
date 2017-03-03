/**
 * Created by leo on 02/02/17.
 * We generate a form for client entity. We send data with ajax request.
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
    
    //Get the current date in order to validate birthdate (child and senior price)
    var $now = new Date();
    var $currentDay = $now.getDate();
    var $currentMonth = $now.getMonth()+1;
    if ($currentMonth < 10){
        $currentMonth = '0' + $currentMonth;
    }
    var $currentYear = $now.getFullYear();
    var $fourYearsOld = $currentDay + '-' + $currentMonth + '-' + ($currentYear - 4);
    var $twelveYearsOld = $currentDay + '-' + $currentMonth + '-' + ($currentYear - 12);
    var $sixtyYearsOld = $currentDay + '-' + $currentMonth + '-' + ($currentYear - 60);

    //Get number of tickets in order to generate form in a loop
    var $numberTicketsNormal = $('#numberTicketsNormal').text();
    var $numberTicketsChild = $('#numberTicketsChild').text();
    var $numberTicketsReduce = $('#numberTicketsReduce').text();
    var $numberTicketsSenior = $('#numberTicketsSenior').text();

    //In order to add class at form
    var $numberReduce = 0;
    var $numberChild = 0;
    var $numberSenior = 0;

    
    /**
     * Function that retrieves the number of ordered tickets
     * Then, it's generate form in a for loop
     *
     * Return the correct number of form in twig view
     */
    var numberTicketsGenerate = function()
    {
        //In order to increase visitor in a loop
        var $visitor = 0;
        //In order to increase form id in a loop
        var $number = 0;
        //In order to identify ticket price
        var $price;
        
        //Generate forms for normal tickets
        for (i=0; i<$numberTicketsNormal; i++){
            $visitor++;
            $number++;
            $price = "normal";
            generateForm($number, $price);
            $('#form_'+$number).prepend('<div class="visitor normalPriceVisitor">Visiteur n°'+$visitor+'<br/>Tarif Normal</div>');
        }
        
        //Generate forms for reduce tickets
        for (i=0; i<$numberTicketsReduce; i++){
            $visitor++;
            $number++;
            $numberReduce++;
            $price = "reduce";
            generateForm($number, $price);
            $('#form_'+$number)
                .prepend('<div class="visitor reducePriceVisitor">Visiteur n°'+$visitor+'<br/>Tarif Réduit</div>')
                .append('<div class="radioReducePrice">' +
                            '<input type="checkbox" name="yes" id="reducePriceYes" required><label for="Yes">Confirmation Tarif Réduit</label>' +
                            '<p id="reduceText">Votre carte d\'étudiant, militaire ou équivalent vous sera demandé à l\'entrée du Musée.</p></div>')
                .addClass('reduce_'+$numberReduce);
        }
        
        //Generate forms for child tickets
        for (i=0; i<$numberTicketsChild; i++){
            $visitor++;
            $number++;
            $numberChild++;
            $price = "child";
            generateForm($number, $price);
            $('#form_'+$number)
                .prepend('<div class="visitor childPriceVisitor">Visiteur n°'+$visitor+'<br/>Tarif Enfant</div>')
                .append('<div class="textChildPrice">Le visiteur doit être né entre le ' + $twelveYearsOld + ' et le ' + $fourYearsOld +'</div>')
                .addClass('child_'+$numberChild);
        }
        
        //Generate forms for senior tickets
        for (i=0; i<$numberTicketsSenior; i++){
            $visitor++;
            $number++;
            $numberSenior++;
            $price = "senior";
            generateForm($number, $price);
            $('#form_'+$number)
                .prepend('<div class="visitor seniorPriceVisitor">Visiteur n°'+$visitor+'<br/>Tarif Senior</div>')
                .append('<div class="textSeniorPrice">Le visiteur doit être né avant le '+$sixtyYearsOld+'</div>')
                .addClass('senior_'+$numberSenior);
        }
    };

    /**
     * Generates a form depending on a map form
     * Attaches submit event to call an ajax request
     *      - should send an ajax request to allowing client persisting data
     *      - should display success message
     */
    var generateForm = function ($number, $price) {
        var $form = $("<div class='booking-form-container "+$price+"' id='form_"+$number+"'>");
        $formContainerStepTwo.append($form);
        $.each(clientsMap, function (key, value) {
            $form.append(generateFormFields(key, value));
        });
    };

    /**
     * Front validation of client. We use 4 boolean.
     *      isValid -> is true if each field is correctly fill
     *      reducePriceIsValid -> is true if checkbox on reduce tickets is checked
     *      childPriceIsValid -> is true if birthdate is for a child between 4 and 12 years old
     *      seniorPriceIsValid -> is true if birthdate is for a senior after 60 years old
     * If there all are true, we send and save data.
     */
    var submitClientButton = function () {
        var isValid = false;
        var reducePriceIsValid = false;
        var childPriceIsValid = false;
        var seniorPriceIsValid = false;
        
        var $form = $('<div class="col-md-offset-4">');
        $formContainerStepTwo.after($form);
        $form.append($('<button class="btn btn-primary booking-client__validate">').text('Confirmer la commande'));
        
        $form.on('click', '.booking-client__validate', function() {
            
            var $visitor = 0;
            var $number = 1;
            var $numberReduce = 0;
            var $numberChild = 0;
            var $numberSenior = 0;
            $('div.alert.alert-danger').remove();

            //For each form, we check if each field is correctly fill.
            $('.booking-form-container').each(function() {
                $visitor++;
                $number++;
                var $lastNameValue = $(this).find('.lastname').val();
                if ($lastNameValue == "" || $lastNameValue.length < 3){
                    isValid = false;
                    return $('#form_'+$visitor).append($('<div class="alert alert-danger messageErrorClient">Le nom n\'est pas valide</div>'));
                } else {
                    var $firstNameValue = $(this).find('.firstname').val();
                    if ($firstNameValue == "" || $firstNameValue.length < 3){
                        isValid = false;
                        return $('#form_'+$visitor).append($('<div class="alert alert-danger messageErrorClient">Le prénom n\'est pas valide</div>'));
                    } else {
                        var $countryValue = $(this).find('.country').val();
                        if($countryValue == "" || $countryValue.length < 3) {
                            isValid = false;
                            return $('#form_'+$visitor).append($('<div class="alert alert-danger messageErrorClient">Le pays de résidence n\'est pas valide</div>'));
                        } else {
                            var $birthDateValue = $(this).find('.birthdate').val();
                            if(!$birthDateValue.match(/^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]|(?:Jan|Mar|May|Jul|Aug|Oct|Dec)))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2]|(?:Jan|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec))\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)(?:0?2|(?:Feb))\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9]|(?:Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep))|(?:1[0-2]|(?:Oct|Nov|Dec)))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$/)){
                                isValid = false;
                                return $('#form_'+$visitor).append($('<div class="alert alert-danger messageErrorClient">La date de naissance n\'est pas valide</div>'));
                            } else {
                                isValid = true;
                            }
                        }
                    }
                }
            });

            //We check if checkbox button on reduce price is checked. If not -> error message
            var $containerReduce = $('.booking-form-container.reduce');
            if ($containerReduce.length === 0){
                reducePriceIsValid = true;
            } else {
                $containerReduce.each(function () {
                    $numberReduce++;
                    if($('.reduce_'+$numberReduce+' input[name=yes]:checked').val() || '')
                    {
                        reducePriceIsValid = true;
                    } else {
                        reducePriceIsValid = false;
                        return $('.reduce_'+$numberReduce).append($('<div class="alert alert-danger messageErrorClient">Tarif Réduit : Veuillez confirmer le(s) tarif(s) réduit(s)</div>'));
                    }
                });
            }


            //We check if birthdate client for senior price is correct (more than 60 years old)
            var $containerSenior = $('.booking-form-container.senior');
            if ($containerSenior.length === 0){
                seniorPriceIsValid = true;
            } else {
                $containerSenior.each(function () {
                    $numberSenior++;
                    var $birthDateValue = $(this).find('.birthdate').val();
                    if (($birthDateValue.split('-').reverse().join('') > $sixtyYearsOld.split('-').reverse().join('')) || ($birthDateValue == ""))
                    {
                        seniorPriceIsValid = false;
                        return $('.senior_'+$numberSenior).append($('<div class="alert alert-danger messageErrorClient">Tarif Senior : La date de naissance ne correspond pas au Tarif Senior (60 ans ou plus)</div>'));
                    } else {
                        seniorPriceIsValid = true;
                    }
                });
            }

            //We check if birthdate client for child price is correct (between 4 and 12 years old)
            var $containerChild = $('.booking-form-container.child');
            if ($containerChild.length === 0){
                childPriceIsValid = true;
            } else {
                $containerChild.each(function () {
                    $numberChild++;
                    var $birthDateValue = $(this).find('.birthdate').val();
                    if (($twelveYearsOld.split('-').reverse().join('') <= $birthDateValue.split('-').reverse().join('')) && ($birthDateValue.split('-').reverse().join('') <= $fourYearsOld.split('-').reverse().join('')))
                    {
                        childPriceIsValid = true;
                    } else {
                        childPriceIsValid = false;
                        return $('.child_'+$numberChild).append($('<div class="alert alert-danger messageErrorClient">Tarif Enfant : La date de naissance ne correspond pas au Tarif Enfant (Entre 4 et 12 ans)</div>'));
                    }
                });
            }

            //If each front validation is good, we call submitClient function and onSuccessSubmit function
            if( isValid === true && reducePriceIsValid === true && childPriceIsValid === true && seniorPriceIsValid === true)
            {
                var dataForm = getDataForm();
                $.each(dataForm, function(index, value) {
                    createClientModel(value.firstname, value.lastname, value.country, value.birthdate);
                });
                submitClient()
                    .done(function (response) {
                        console.log(response);
                        // back ok
                        onSuccessSubmit();
                    }).fail(function (response) {
                        console.log(response);
                        clients.length = 0;
                        // onErrorSubmit();
                        // back not ok (sending 422 error http status)
                });
                $('#buttonToStepThree').attr('disabled', false);
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
        var clients = [];
        $('.booking-form-container').each(function() {
            clients.push({lastname: $(this).find('.lastname').val(), firstname: $(this).find('.firstname').val(), country: $(this).find('.country').val(), birthdate: $(this).find('.birthdate').val() });
        });
        return clients;
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
        var $input = $('<input type="text" class="form-control required '+key+'">');
        $formGroup.append($label, $input);
        return $formGroup;
    };

    /**
     * Send via ajax, clients ARRAY, stringified
     * @returns {*}
     */
    var submitClient = function() {
        return $.ajax({
            method: 'POST',
            url: $formContainerStepTwoUrl,
            data: {data : JSON.stringify(clients)}
        })
    };

    /**
     * Success handler
     * Append a success message
     */
   var onSuccessSubmit = function () {
        //todo Change this function adding a redirection to step three
        $('.booking-client__validate').after('<div class="alert alert-success" id="persistSuccessMessage">Merci, <br/>Informations enregistrées</div>');
    };

    /**
     * Orchestral master
     */
    var render = function () {
        numberTicketsGenerate();
        submitClientButton();
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