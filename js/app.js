$(function () {
  const userIcon = $('.user_lg i');
  const userInfo = $('.user_info');

  $('.user_lg').click(() => {
    if (userIcon.hasClass('mdi-account')) {
      userInfo.addClass('hidd');
      userIcon.attr('class', 'mdi mdi-close-outline');
      $('body').addClass('mainBlue');
    } else {
      userIcon.attr('class', 'mdi mdi-account');
      userInfo.removeClass('hidd');
      $('body').removeClass('mainBlue');
    }
  });
});

function AsyncManageElement(element, action, id) {
  const buttons = [...document.querySelectorAll('.button')];
  const clickIndex = Math.floor(buttons.indexOf(element) / 2);

  const titleEl = document.querySelectorAll('.titleEl')[clickIndex].value;
  const capEl = document.querySelectorAll('.captionEl')[clickIndex].value;

  const items = document.querySelectorAll('.gallery-item');
  const itemOvl = document.querySelectorAll('.overlay-element');

  const person = document.querySelector('.user_lg i');

  const data = {
    title: titleEl,
    caption: capEl,
    action: action,
    id: id,
  }
  $.ajax({
    method: 'POST',
    url: '/ajax/edit.gallery',
    data: data,
    success: function (_res) {
      person.classList = 'mdi mdi-cloud-check';
        if (action === 1) {
          try {
            items[clickIndex].classList.add('hide');
            itemOvl[clickIndex].classList.add('hide');
          } catch (e) {
          }
        }        
      },
      error: function (_request, _status, _error) {
        person.classList = 'mdi-cloud-alert';
      }
  });
  setTimeout(() => {
    person.classList = 'mdi mdi-account';
  }, 5000);
}
