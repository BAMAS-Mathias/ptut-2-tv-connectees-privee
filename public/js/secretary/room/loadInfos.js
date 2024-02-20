let selector = document.querySelector("#room-choice-form select");
let roomName = document.querySelector("#room-info-name")
let pcNb = document.querySelector("#pc-nb-count-container p")
let placeNb = document.querySelector("#place-nb-container p");
let hasVideoProjector = document.querySelector("#has-projector-container p")
let cableList = document.querySelector("#cable-type-container p");

selector.addEventListener('change', () => {loadInfos(selector.value)})

window.onload = () => loadInfos();

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
    pcNb.innerText = O_Json['pcAvailable']
    placeNb.innerText = O_Json['placeAvailable']
    cableList.innerText = O_Json['cablesTypes']

    if(O_Json['hasVideoProjector']){
        hasVideoProjector.innerText = '✓'
    }else{
        hasVideoProjector.innerText = '❌'
    }


}