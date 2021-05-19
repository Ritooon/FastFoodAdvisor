$(document).ready(function(){

    $('#city-select').val($('#restaurant_city').val());

    $('#loadCitiesBtn').off('click').on('click', function(){

        let row = 1;
        let maxRow = parseInt($('#loadCitiesBtn').attr('data-nbcities'));
        $('#admin-cities-progress').css('display', 'block');
        $('#admin-cities-progress .progress-bar').css('height', '16px');
        $('#loadCitiesBtn').remove();

        if(!isNaN(maxRow))
        {
            loadcity(row, maxRow);
        } 
    });

    $('#city-select').off('keyup').on('keyup', delay(function(){
        searchCity(this.value);
    }, 500));
});

function getLatLng()
{
    $('.alert-danger').remove();


    let city = $('#city-select').val();    
    $('#restaurant_city').val(city);
    let address = $('#restaurant_address').val();

    $.ajax({
        url: "https://nominatim.openstreetmap.org/search",
        type: 'get',
        data: "q="+address+', '+city+"&format=json&addressdetails=1&limit=1&polygon_svg=1" 
    }).done(function (response) {
    if(response != ""){
        $('#restaurant_latitude').val(response[0]['lat']);
        $('#restaurant_longitude').val(response[0]['lon']);
        $('form')[0].submit();
    }
    else
    {
        $('form .form-group:first-child').before('<div class="alert alert-danger" role="alert">Veuillez vérifier l\'adresse et la ville saisies (Lat+Lng non trouvées)</div>');
    }         
    }).fail(function (error) {
        alert(error);
    });
}


function loadcity(row, maxRow)
{
    $.ajax({
        url: "do-load-cities/"+row+"/"+(row+100), 
        type: 'get', 
    }).done(function (response) {
        
        if(row < maxRow)
        {
            row += 100;
            $('#admin-cities-progress .progress-bar').css('width', parseInt(((row*100)/maxRow))+'%')
            loadcity(row, maxRow);
        } 
        else
        {
            let parent = $('#admin-cities-progress').parent();
            $('#admin-cities-progress').remove();
            parent.append('<br />🔔 Terminé ! Les villes ont bien été ajoutées !');
        }        
    }).fail(function (error) {
        alert(error);
    });  
}