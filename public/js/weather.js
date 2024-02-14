var meteoRequest = new XMLHttpRequest();
var longitude = 5.4510;
var latitude = 43.5156;
var url = "https://api.openweathermap.org/data/2.5/weather?lat=" + latitude + "&lon=" + longitude + "&lang=fr&APPID=ae546c64c1c36e47123b3d512efa723e";

/**
 * Display the weather
 **/
function refreshWeather() {
    meteoRequest.open('GET', url, true);
    meteoRequest.setRequestHeader('Accept', 'application/json');
    meteoRequest.send();
}
function datefr() {
    let typeMeteo = 'soleil'; // Juste pour le test
    let cheminImage = "/wp-content/plugins/ptut-2-tv-connectees/public/img/wind.png"; // Assurez-vous que ce chemin est correct

    let img = document.createElement("img");
    img.src = cheminImage;

    let containerMeteo = document.getElementById('PrevisionMeteo');
    if (containerMeteo) {
        containerMeteo.innerHTML = 'Prévision météo pour demain :'; // Affiche le message
        containerMeteo.appendChild(img); // Ajoute l'image
    }
}

// Appel de la fonction pour le test
datefr();


meteoRequest.onload = function () {
    var json = JSON.parse(this.responseText);
    console.log(json); // Pour déboguer et voir la réponse de l'API

    var temp = Math.round(getTemp(json));
    var vent = getWind(json).toFixed(0);

    if (document.getElementById('Weather') !== null) {
        var div = document.getElementById('Weather');
        div.innerHTML = "";

        var weather = document.createElement("DIV");
        weather.innerHTML = temp + "<span class=\"degree\">°C</span>";
        weather.id = "weather";

        var imgTemp = document.createElement("IMG");
        imgTemp.id = "icon";
        var iconPath = getIcon(json);
        console.log(iconPath);
        imgTemp.src = "/wp-content/plugins/ptut-2-tv-connectees/public/img/01.png";
        imgTemp.alt = getAlt(json);
        weather.appendChild(imgTemp);

        var wind = document.createElement("DIV");
        wind.innerHTML = vent + "<span class=\"kmh\">km/h</span>";
        wind.id = "wind";

        var imgVent = document.createElement("IMG");
        imgVent.src = "/wp-content/plugins/ptut-2-tv-connectees/public/img/wind.png";
        imgVent.alt = "Image du vent";
        wind.appendChild(imgVent);

        div.appendChild(weather);
        div.appendChild(wind);
        setTimeout(refreshWeather, 900000);
    }
};

/**
 * Get the time
 */

/** Getter **/
function getAlt(json) {
    return json["weather"][0]["description"];
}

function getIcon(json) {
    return cutIcon(json["weather"][0]["icon"]);
}

function cutIcon(str) {
    return str.substr(0, str.length - 1);
}

function getTemp(json) {
    return kelvinToC(json["main"]["temp"]);
}

function kelvinToC(kelvin) {
    return kelvin - 273.15;
}

function getWind(json) {
    return msToKmh(json["wind"]["speed"]);
}

function msToKmh(speed) {
    return speed * 3.6;
}


refreshWeather();