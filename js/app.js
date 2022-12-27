$(function(s){
  $('.user_lg').click(()=>{
    if ($('.user_lg i').hasClass('mdi-account')){
      $('.user_info').addClass('hidd');
      $('.user_lg i').attr('class','mdi mdi-close-outline');
      $('body').addClass('mainBlue');
    }else {
      $('.user_lg i').attr('class','mdi mdi-account');
      $('.user_info').removeClass('hidd');
      $('body').removeClass('mainBlue');
    }
  })
});
function AsyncManageElement(element,action,id) {
  let btnSend = Array.prototype.slice.call(document.querySelectorAll('.button'));
  let ClickIndex = btnSend.indexOf(element);
  ClickIndex = Math.floor(ClickIndex/2)
  let titleEl = Array.prototype.slice.call(document.querySelectorAll('.titleEl'));
  titleEl = titleEl[ClickIndex].value;
  let capEl = Array.prototype.slice.call(document.querySelectorAll('.captionEl'));
  capEl = capEl[ClickIndex].value;

  var request = new XMLHttpRequest();
  let item = document.querySelectorAll('.gallery-item');
  let itemOvl = document.querySelectorAll('.overlay-element');
  request.onreadystatechange = (e)=>{
    let person = document.querySelector('.user_lg i');
    if ((request.status == 200) && (request.readyState == 4)){
      if (request.response == 1) {
        person.classList = 'mdi mdi-cloud-check';
        if (action == 1){
          try {
            item[ClickIndex].classList.add('hide');
            itemOvl[ClickIndex].classList.add('hide');
          } catch (e) {
            
          }
        }else if (action == 2) {

        }
      }else {
        person.classList = 'mdi-cloud-alert';
      }
      setTimeout(()=>{person.classList = 'mdi mdi-account';},5000)
    }
  }
  request.open('POST',`../actions/manageElement.php?action=${action}&id=${id}&t=${titleEl}&c=${capEl}`);
  request.send();
}
