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

// код для конпки плээра 
const playButton = document.querySelector('.audio_play');

playButton.addEventListener('click', function() {
  const playActive = document.querySelector('.play_active');
  const playHide = document.querySelector('.play_hide');
  const pauseActive = document.querySelector('.pause_active');
  const pauseHide = document.querySelector('.pause_hide');

  if (playActive) {
    playActive.classList.remove('play_active');
    playActive.classList.add('play_hide');
    pauseHide.classList.remove('pause_hide');
    pauseHide.classList.add('pause_active');
  } else {
    playHide.classList.remove('play_hide');
    playHide.classList.add('play_active');
    pauseActive.classList.remove('pause_active');
    pauseActive.classList.add('pause_hide');
  }
});
// код для конпки плээра 
