$(document).ready(function(){

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
});


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