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

document.querySelector('.button_call').addEventListener('click', function() {
    document.querySelector('.request').classList.remove('request_hide');
    document.querySelector('.request').classList.add('request_active');
  });

document.querySelector('.request_close').addEventListener('click', function() {  
    document.querySelector('.request').classList.remove('request_active');
    document.querySelector('.request').classList.add('request_hide');
  });

  document.addEventListener('DOMContentLoaded', function() {
    const submitButton = document.querySelector('.request_submit_button');
    submitButton.addEventListener('click', function() {
      window.location.href = 'request.html';
    });
  });