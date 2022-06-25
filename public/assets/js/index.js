let iconeMenu = document.getElementById('icon-menu')
let menu = document.getElementsByClassName('mobile')[0]

let show = () => {
    menu.classList.toggle('active')
}

iconeMenu.addEventListener('click', show)
