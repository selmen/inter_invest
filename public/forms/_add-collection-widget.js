var $newLinkLi = $('<div></div>');

jQuery(document).ready(function() {    
    var $collectionHolder = $('div.address');        
    $collectionHolder.append($newLinkLi);        
    $collectionHolder.data('index', $collectionHolder.find(':input').length);        
    $('.add_address_link').on('click', function(e) {        
        e.preventDefault();                
        addAddressForm($collectionHolder, $newLinkLi);
    });        
});

function addAddressForm($collectionHolder, $newLinkLi) {    
    var prototype = $collectionHolder.data('prototype');        
    var index = $collectionHolder.data('index');            
    var newForm = prototype.replace(/__name__/g, index);        
    $collectionHolder.data('index', index + 1);        
    var $newFormLi = $('<div></div>').append(newForm);        
    $newFormLi.append(' <a href="#" class="remove-address text-danger">X</a>');    
    $newLinkLi.before($newFormLi);        
    $('.remove-address').click(function(e) {
        e.preventDefault();        
        $(this).parent().remove();        
        return false;
    });
}