/**
 * Created by leo on 03/03/17.
 */
/**
 * Created by leo on 02/02/17.
 * We generate a form for client entity. We send data with ajax request.
 */
$(function($) {
    var $formContainerStepTwo = $('#booking-form-container-step-two');
    var $formContainerStepTwoUrl = $formContainerStepTwo.data('create-url');
    var clientsMap = {
        lastname : 'Last Name',
        firstname: 'Fist Name',
        country : 'Country',
        birthdate :'Birthdate (dd-mm-yyyy)'
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
            $('#form_'+$number).prepend('<div class="visitor normalPriceVisitor">Visitor n°'+$visitor+'<br/>Normal Price</div>');
        }

        //Generate forms for reduce tickets
        for (i=0; i<$numberTicketsReduce; i++){
            $visitor++;
            $number++;
            $numberReduce++;
            $price = "reduce";
            generateForm($number, $price);
            $('#form_'+$number)
                .prepend('<div class="visitor reducePriceVisitor">Visitor n°'+$visitor+'<br/>Reduce Price</div>')
                .append('<div class="radioReducePrice">' +
                    '<input type="checkbox" name="yes" id="reducePriceYes" required><label for="Yes">Reduce price confirmation</label>' +
                    '<p id="reduceText">Your student, military or equivalent card will be asked to you at the entrance of the Museum.</p></div>')
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
                .prepend('<div class="visitor childPriceVisitor">Visitor n°'+$visitor+'<br/>Child Price</div>')
                .append('<div class="textChildPrice">The visitor must be born between ' + $twelveYearsOld + ' and ' + $fourYearsOld +'</div>')
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
                .prepend('<div class="visitor seniorPriceVisitor">Visitor n°'+$visitor+'<br/>Senior price</div>')
                .append('<div class="textSeniorPrice">The visitor must be born before '+$sixtyYearsOld+'</div>')
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
        $form.append($('<button class="btn btn-primary booking-client__validate">').text('Confirm order'));

        $form.on('click', '.booking-client__validate', function() {

            var $visitor = 0;
            var $number = 1;
            var $numberReduce = 0;
            var $numberChild = 0;
            var $numberSenior = 0;
            $('div.alert.alert-danger').remove();
            $('input.form-control').css('borderColor', '#DADADA');


            //For each form, we check if each field is correctly fill.
            $('.booking-form-container').each(function() {
                $visitor++;
                $number++;
                var $lastNameValue = $(this).find('.lastname').val();
                var $firstNameValue = $(this).find('.firstname').val();
                var $countryValue = $(this).find('.country').val();
                var $birthDateValue = $(this).find('.birthdate').val();
                if ($lastNameValue == "" || $lastNameValue.length < 3)
                {
                    isValid = false;
                    var $lastName = false;
                    $('#form_'+$visitor+' .form-group .lastname').css('borderColor', '#ef5050');
                }
                if ($firstNameValue == "" || $firstNameValue.length < 3)
                {
                    isValid = false;
                    var $firstName = false;
                    $('#form_'+$visitor+' .form-group .firstname').css('borderColor', '#ef5050');
                }
                if($countryValue == "" || $countryValue.length < 3)
                {
                    isValid = false;
                    var $country = false;
                    $('#form_'+$visitor+' .form-group .country').css('borderColor', '#ef5050');
                }
                if(!$birthDateValue.match(/^(?:(?:31(-)(?:0?[13578]|1[02]|(?:Jan|Mar|May|Jul|Aug|Oct|Dec)))\1|(?:(?:29|30)(-)(?:0?[1,3-9]|1[0-2]|(?:Jan|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec))\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(-)(?:0?2|(?:Feb))\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(-)(?:(?:0?[1-9]|(?:Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep))|(?:1[0-2]|(?:Oct|Nov|Dec)))\4(?:(?:1[6-9]|[2-9]\d)?\d{4})$/))
                {
                    isValid = false;
                    var $birthdate = false;
                    $('#form_'+$visitor+' .form-group .birthdate').css('borderColor', '#ef5050');
                }
                if ($lastName != false && $firstName != false && $country != false && $birthdate != false){
                    isValid = true;
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
                        return $('.reduce_'+$numberReduce).append($('<div class="alert alert-danger messageErrorClient">Reduced price: Please confirm the reduced price</div>'));
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
                        return $('.senior_'+$numberSenior).append($('<div class="alert alert-danger messageErrorClient">Senior Price: The birthdate does not correspond to the Senior Price (60 years old or older)</div>'));
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
                        return $('.child_'+$numberChild).append($('<div class="alert alert-danger messageErrorClient">Child Price : The birthdate does not correspond to the Child Price (between 4 and 12 years old)</div>'));
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
                    // back not ok
                    onErrorSubmit();
                });
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
        var $url = window.location.href;
        var $id = $url.split('2/');
        window.location.replace('/fr/booking/create/3/'+$id[1]);
    };

    /**
     * Error Handler
     * Append an error message
     * @constructor
     */
    var onErrorSubmit = function () {
        $('.booking-client__validate').after('<div class="alert alert-danger" id="persistMessage">There was a problem. The data has not been saved.</div>');
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
