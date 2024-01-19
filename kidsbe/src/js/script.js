document.addEventListener('DOMContentLoaded', function () {
    // Получаем ссылку на кнопку и меню
    const burgerButton = document.querySelector('.burger');
    const menu = document.querySelector('.burger_menu');

    // Добавляем обработчик события клика на кнопку
    burgerButton.addEventListener('click', function () {
        // Переключаем класс активности на меню
        menu.classList.toggle('burger_menu-active');

        // Переключаем класс кнопки
        burgerButton.classList.toggle('burger-click');
    });
});