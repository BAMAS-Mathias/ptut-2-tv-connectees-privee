let btn = document.querySelector("#open-close-button")
let roomSideMenu = document.querySelector("#room-schedule-side-infos")

console.log("test")
btn.onclick = () => {
    if(roomSideMenu.className === 'open'){
        roomSideMenu.className = 'close';
        btn.innerText = '←'
    }else{
        roomSideMenu.className = 'open';
        btn.innerText = '→'
    }
}