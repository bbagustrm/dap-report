const burger = document.querySelector('.burger')
const sideBar = document.querySelector('.side-bar')
const content = document.querySelector('.content')

burger.addEventListener('click', () => {
    sideBar.classList.toggle('left-[-100%]')
    sideBar.classList.toggle('left-0')
    content.classList.toggle('w-full')
    content.classList.toggle('w-[82vw]')
    console.log('helo')
})
