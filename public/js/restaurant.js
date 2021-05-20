$(document).ready(function(){

    $('#rateit').rateit({ 
        max: 5, 
        step: 0.5, 
        resetable: false,
        mode: 'font',
        value: ($('#notes_rating').val() == '') ? 0 : $('#notes_rating').val()
    });

    $('.rateit-range').off('click').on('click', function(){
        $('#notes_rating').val($(this).attr('aria-valuenow'));
    });
});