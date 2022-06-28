let iconeMenu = document.getElementById('icon-menu')
let menu = document.getElementsByClassName('mobile')[0]

let show = () => {
    menu.classList.toggle('active')
}

iconeMenu.addEventListener('click', show)

window.setTimeout(function () {
    $('.flash-msg')
        .fadeTo(1000, 0)
        .slideUp(1000, function () {
            $(this).remove()
        })
}, 5000)
