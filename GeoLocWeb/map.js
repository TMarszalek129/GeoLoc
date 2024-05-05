function initMap() {
    const map = new google.maps.Map(document.getElementById("map"), {
      zoom: 8,
      center: { lat: 40.731, lng: -73.997 },
      mapTypeId: 'satellite'
    });
    const geocoder = new google.maps.Geocoder();
    const infowindow = new google.maps.InfoWindow();
    
    geocodeLatLng(geocoder, map, infowindow);
    
}
  
function geocodeLatLng(geocoder, map, infowindow) {
    var rawFile = new XMLHttpRequest();
    var input = "";
    rawFile.open("POST", "text.txt", false); // Your text file HERE!
    rawFile.onreadystatechange = function () {
        if(rawFile.readyState === 4)  {
        if(rawFile.status === 200 || rawFile.status == 0) {
            var allText = rawFile.responseText;
            if(allText.trim().length > 0){
                allText = allText.split('\n');
                input = allText[allText.length-1];
            }
            else
                input = "-82.668338,12.462602";
        }
        }
    }
    rawFile.send(null);
    const latlngStr =  input.split(",", 2);
    const latlng = {
      lat: parseFloat(latlngStr[0]),
      lng: parseFloat(latlngStr[1]),
    };
  
    geocoder
      .geocode({ location: latlng })
      .then((response) => {
        if (response.results[0]) {
          map.setZoom(20);
          
  
          const marker = new google.maps.Marker({
            position: latlng,
            map: map,
          });

          
  
          infowindow.setContent(response.results[0].formatted_address);
          infowindow.open(map, marker);
        } else {
          window.alert("No results found");
        }
      })
      .catch((e) => window.alert("Geocoder failed due to: " + e));
  }

  
  
  window.initMap = initMap;
  