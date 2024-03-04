let selector = document.querySelector("#room-choice-form select");
let roomName = document.querySelector("#room-info-name")
let pcNb = document.querySelector("#pc-nb-count-container input")
let placeNb = document.querySelector("#place-nb-container input");
let hasVideoProjector = document.querySelector("#has-projector-container input")
let cableList = document.querySelector("#cable-type-container input");


window.onload = () => {
    loadInfos(selector.value)};

function loadInfos(roomName){

    roomName = roomName.replace(' ','+')
    let url = "https://testserveur.alwaysdata.net/wp-json/amu-ecran-connectee/v1/room?id=" + roomName;
    fetch(url).then(function(response){
        return response.json().then(function(O_json){
            displayInfos(O_json[0]);
        })
    })
}

function displayInfos(O_Json){
    roomName.innerText = O_Json['name']
    pcNb.value = O_Json['pcAvailable']
    placeNb.value = O_Json['placeAvailable']
    cableList.value = O_Json['cablesTypes']

    if(O_Json['hasVideoProjector']){
        hasVideoProjector.value = '✓'
    }else{
        hasVideoProjector.value = '❌'
    }


}