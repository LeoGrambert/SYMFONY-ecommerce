/**
 * Created by leo on 25/01/17.
 */
$(document).ready(function () {
   var container = $('div #lg_corebundle_booking_clients');
    var index = container.find(':input').length;
    $('#add_client').click(function (e) {
        addClient(container);
        e.preventDefault();
        return false;
    });

    if (index == 0){
        addClient(container);
    } else {
        container.children('div').each(function () {
            addDeleteLink($(this));
        });
    }

    function addClient(container){
        var template = container.attr('data-prototype')
            .replace(/__name__label__/g, 'Client n°' + (index+1))
            .replace(/__name__/g, index)
        ;
        
        var prototype = $(template);
        
        addDeleteLink(prototype);
        
        container.append(prototype);
        
        index++;
    }
    
    function addDeleteLink(prototype) {
        var deleteLink = $('<a href="#" class="btn btn-danger">Supprimer</a>');
        prototype.append(deleteLink);
        deleteLink.click(function (e) {
            prototype.remove();
            e.preventDefault();
            return false;
        });
    }
});