/*---------------MAPA-----------------*/
var mymap = L.map('mapid').setView([38.245, -0.810], 16);

L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(mymap);

$(window).on('orientationchange pageshow resize', function () {
    $("#mapid").height($("#mapid").height());
    mymap.invalidateSize();
    mymap.setView([38.244533729805724,-0.8144903182983398], 18);

}).trigger('resize');//mapa responsive

var popup = L.popup();

	L.polygon([
		[38.2394272912904,-0.8115506172180177],
        [38.240337375904566,-0.8079671859741212],
        [38.24202268770113,-0.8028173446655275],
        [38.243910190532354,-0.784149169921875],
        [38.25698654261126,-0.7996416091918946],
		[38.24822429869053,-0.8110141754150391],
        [38.249134273179315,-0.8116149902343751]
        
	]).addTo(mymap).bindPopup("Zona en construcción");

    L.polygon([
		[38.24815689271964,-0.8119368553161622],
        [38.24770190078105,-0.8145117759704591],
        [38.24650542690592,-0.816335678100586],
        [38.2430338560267,-0.8177947998046875],
		[38.25395357773462,-0.8256912231445314],
        [38.25560487431098,-0.8029890060424806]
        
	]).addTo(mymap).bindPopup("Zona en construcción");

var lat = [];//latitud
var lng = [];//longitud
var cont = 0;//contador de clicks
var path;//ruta
var clase;


/*-------------CONTROL INTERACTIVO MAPA---------------*/
function onMapClick(e) {
    if (cont <= 1) {
        popup
            .setLatLng(e.latlng) // Sets the geographical point where the popup will open.
            .setContent("Has hecho click en la coordenada:<br> " + e.latlng.lat.toString() + "," + e.latlng.lng.toString()) // Sets the HTML content of the popup.
            .openOn(mymap); // Adds the popup to the map and closes the previous one. 
        lat[cont] = e.latlng.lat;
        lng[cont] = e.latlng.lng;
        cont++;
        if (cont == 2) {

            identify(lat, lng);

        }
    } else {
        mymap.removeLayer(path);
        cont = 0;
    }
}

mymap.on('click', onMapClick);

/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
                                            CONTROLERS
    :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
function getval(val) { //pasar class a PHP
    var myclass = val;
    localStorage.setItem("class", myclass); //Almacenamos la variable en el almacenamiento del navegador
}

$(document).ready(function () {
    form_data = catchForm();
    var myclass = form_data['class'];
    localStorage.setItem("class", myclass);
    askDatabase(form_data);
});


//CATCH DATA FROM THE FORM INPUTS
function catchForm() {
    var form_data = new Array;
    form_data['class'] = document.buscar.class.value;

    return form_data;
}

/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
                                  AJAX
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

function askDatabase(form_data) { //Para el formulario de filtros
    var data = "class=" + form_data['class'];
    //alert(data);

    __ajax("controller.php?p=classprice/", data)//enviamos a php
        .done(function (info) {
            info = JSON.parse(info);
            renderForm(info);
        });
}

function __ajax(url, data) { //Ajax configured
    var ajax = $.ajax({
        "method": "POST",
        "url": url,
        "data": data
    })
    return ajax;
}

/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
                                RENDERS
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

function renderForm(info) {
    //FORMULARIO DE BUSQUEDA
    var aux = "<select name='class' onchange='getval(this.value);'><option value='null'>Selecciona una clase</option>";
    $.each(info, function (i, item) {
        aux += "<option value=" + info[i].price_km + ">" + info[i].classname + "</option>";
    });
    aux += "</select>";
    $('#clase').html(aux);
    $('#clase').html(aux);
}

/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
							VALIDACIÓN DE EMAIL
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/


function checkmail(sEmail){
    var filter =/(.+)@(.+){2,}\.(.+){2,}/; //Expresión regular para checkear email
    if(filter.test(sEmail.value)){
    }else{
         $("#email").val("Error. Introduce un email válido");
    }
}