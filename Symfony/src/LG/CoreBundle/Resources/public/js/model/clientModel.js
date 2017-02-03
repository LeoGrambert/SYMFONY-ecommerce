/**
 * Created by leo on 02/02/17.
 */
$(function($) {

    console.log('client model is charged');
    // todo make sure that the namespace is OK -> Done, when we check the source of 'lg', we find booking-namespace.js file

    lg.ClientModel = function(firstname, lastname, country, birthdate) {
        this.lastName = lastname;
        this.firstName = firstname;
        this.country = country;
        this.birthDate = birthdate;

        this.getLastName = function() {
            return this.lastName;
        };

        this.setLastName = function(_lastname) {
            this.lastName = _lastname;
        };

        this.getFirstName = function() {
            return this.firstName;
        };

        this.setFirstName = function(_firstname) {
            this.firstName = _firstname;
        };
    }



});