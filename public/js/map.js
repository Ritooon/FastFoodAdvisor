var ffaMap;

$(document).ready(function(){
    ffaMap = L.map('map-container').setView([48.864, 2.331], 13);

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: 'pk.eyJ1Ijoicml0b29vbiIsImEiOiJja29zbmJrZDMwMzN1MnZvYTYxeWwyYmtvIn0.IJ0YuTgbITOhD6trWmC4VQ'
    }).addTo(ffaMap);

    ffaMap.on('moveend', displayReloadBtn);

    getMarkers(48, 2); 
});

function displayReloadBtn()
{
    if($('.reload-map-btn').length <= 0)
    {
        let reloadBtn = '<button class="btn btn-primary reload-map-btn" onclick="reloadMapMarkers();"><i class="fas fa-sync"></i> Chercher ici</button>';
        $('#map-container').append(reloadBtn);
    }
}

function reloadMapMarkers()
{
    let lat = parseFloat(ffaMap.getCenter().lat).toFixed(3), long = parseFloat(ffaMap.getCenter().lng).toFixed(3);
    getMarkers(lat, long);
    $('.reload-map-btn').remove();
}

function getMarkers(latMax, longMax)
{
    $.ajax({
        url: "get-markers/"+latMax+"/"+longMax, 
        type: 'get', 
    }).done(function (response) {
        if(response.length > 0)
        {
            for(let i = 0; i < response.length; i++)
            {
                let restaurant = response[i];
                let marker = L.marker([restaurant.latitude, restaurant.longitude]).addTo(ffaMap);
                marker.bindPopup("<b>"+restaurant.name+"</b><br>Note moyenne : ");
            }
        }
    }).fail(function (error) {
        console.log(error);
    });
}