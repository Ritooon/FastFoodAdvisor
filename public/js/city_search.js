$(document).ready(function(){

    $('.search_input, .city_search').off('keyup').on('keyup', delay(function(){
        searchCity(this.value);
    }, 500));
});

function delay(callback, ms) {
    var timer = 0;
    return function() {
        var context = this, args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
            callback.apply(context, args);
        }, ms || 0);
    };
}
  

function searchCity(val)
{
    $('#CITY_LIST').html('');
    
    if(val.length > 0)
    {
        console.log()
        $.ajax({
            url: location.protocol + '//' + location.host+"/get-cities-by-name-or-zipcode/"+val, 
            type: 'get', 
        }).done(function (response) {
            if(response.length > 0)
            {
                for(let i = 0; i < response.length; i++)
                {
                    $('#CITY_LIST').append('<option data-cvalue="' + response[i]['id'] + '">'+response[i]['name']+' ('+response[i]['zipcode']+')'+'</option>');
                }
            }
                
        }).fail(function (error) {
            console.log(error);
        });  
    }

}
