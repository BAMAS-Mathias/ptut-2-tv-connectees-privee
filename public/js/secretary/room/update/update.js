let modifyButton = document.getElementById("modif-button");
let confirmButton = document.getElementById("confirm-button")
let reservButton = document.getElementById("reserv-button");
let cancelButton = document.getElementById("cancel-button")

let modificationInputList = document.querySelectorAll("#room-schedule-side-infos input")

modifyButton.onclick = () => {
    enterModication()
}

cancelButton.onclick = () => {
    quitModification();
}

confirmButton.onclick = () => {
    let roomName = document.querySelector("#room-info-name").innerText;
    roomName = roomName.replace(' ','+')
    let pcCount = document.querySelector("#pc-nb-count-container input[type=number]").value
    let chairCount = document.querySelector("#place-nb-container input").value
    modifyRoom(roomName, pcCount, 'test', 12, "Test");
    quitModification();
}

function enterModication(){
    modificationInputList.forEach((elem) => elem.style.pointerEvents = 'auto')
    modifyButton.style.display = "none";
    reservButton.style.display = "none";
    confirmButton.style.display = "block";
    cancelButton.style.display = "block";
}

function quitModification(){
    modifyButton.style.display = "block";
    reservButton.style.display = "block";
    confirmButton.style.display = "none";
    cancelButton.style.display = "none";
}

function modifyRoom(roomName, pcCount, projector, chairCount, connection){

    let url = "https://testserveur.alwaysdata.net/wp-json/amu-ecran-connectee/v1/room?id=" + roomName;
    let data = {
        pcCount: pcCount,
        projector: projector,
        chairCount: chairCount,
        connection: connection
    };

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
        .then(function(response) {
            return response.json().then(function (O_json) {
                displayInfos(O_json[0]);
            })
        })
}
