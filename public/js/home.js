$(document).ready(function(){

    $('.search_input').off('keyup').on('keyup', function(){
       
    });

    $('#loadCitiesBtn').off('click').on('click', function(){

        let row = 1;
        let maxRow = parseInt($('#loadCitiesBtn').attr('data-nbcities'));

        if(!isNaN(maxRow))
        {
            $('.admin-content-bloc').html('');
            loadcity(row, maxRow);
        }        
    });
});


function loadcity(row, maxRow)
{
    $.ajax({
        url: "do-load-cities/"+row, 
        type: 'get', 
    }).done(function (response) {
         
        // $('.admin-content-bloc').append('<br />'+response);   
        $('#nbCitiesAdded').html(row);

        if(row < maxRow)
        {
            row += 100;
            loadcity(row, maxRow);
        }          
    }).fail(function (error) {
        alert(error);
    });  
}