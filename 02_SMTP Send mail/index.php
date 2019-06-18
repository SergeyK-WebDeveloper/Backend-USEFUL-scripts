<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Form</title>
  <style>
    #uForm {
      width: 300px;
      min-height: 200px;

      padding: 35px;
      font-family: Roboto;

      display: block;
      margin: 0 auto;

      border: 2px dashed lightgrey;
    }

    form > * {
      display: block;
      margin: 10px auto;
    }

    .uForm__radio-btn {
      display: inline-block;
    }

    #uForm__checkbox-1,
    #uForm__checkbox-2 {
      display: inline-block;
    }

    #uForm__modal {
      width: 300px;
      height: max-content;
      max-height: 150px;

      padding: 30px;

      text-align: center;
      font-size: 23px;

      background: #fff;
      z-index: 1000;

      position: fixed;
      top: -200px;
      bottom: 0;
      left: 0;
      right: 0;
      margin: auto;

      display: none;
    }

    #uForm__error-msg {
      display: none;
      color: red;
    }

    #uForm__overlay {
      width: 100vw;
      height: 100vw;

      background: rgba(0,0,0,.5);
      z-index: 100;

      position: fixed;
      top: 0;
      left: 0;

      display: none;
    }
  </style>
</head>
<body>
<form action="" id="uForm" enctype="multipart/form-data">
  Name 	<input id="uForm__name" name="name" type="text" required>
  Pass 	<input id="uForm__password" name="password" type="password" required>
  <!-- Email	<input id="uForm__email" name="email" type="email" required> -->
  Email <input id="uForm__email" name="email" required>
  <!-- Tel 	<input id="uForm__tel" name="tel" type="tel" required> -->
  Tel   <input id="uForm__tel" name="tel" required>
  Date 	<input id="uForm__date" name="date" type="date">

  Select
  <select id="uForm__select" name="select">
    <option value="Option-1">Вариант 1</option>
    <option value="Option-2">Вариант 2</option>
  </select>

  Multiselect
  <select id="uForm__multiselect" name="multiselect[]" multiple>
    <option value="Option-1">Вариант 1</option>
    <option value="Option-2">Вариант 2</option>
    <option value="Option-3">Вариант 3</option>
  </select>

  Textarea
  <textarea id="uForm__text-area" name="text-area" cols="30" rows="10"></textarea>

  Checkbox
  <input id="uForm__checkbox-1" name="checkbox-1" type="checkbox">
  <input id="uForm__checkbox-2" name="checkbox-2" type="checkbox"><br>

  Radio
  <input class="uForm__radio-btn" name="radio-btn" type="radio" value="radio-1">
  <input class="uForm__radio-btn" name="radio-btn" type="radio" value="radio-2"><br>

  <input id="uForm__hidden" name="hidden" type="hidden">

  <!-- File -->
  <input id="uForm__file" name="file" type="file">
  <!-- Reset -->
  <input id="uForm__reset" type="reset" value="Reset" style="display: none;">

  <input id="uForm__submit" name="submit" type="submit">

  <p id="uForm__error-msg"></p>
</form>


<div id="uForm__overlay"></div>

<div id="uForm__modal">
  <p class="uForm__modal-text">все ок</p>
  <button>close</button>
</div>

<script src="jquery-3.3.1.min.js"></script>
<script>

  var handlerType = 'modal' || 'message';

  var failMessage = 'Что-то пошло не так';
  var successMessage = 'Форма успешно отправлена';

  //////////////////

  var jQ = false;
  function initJQ(mt) {
    if (typeof(jQuery) == 'undefined') {
      if (!jQ) {
        jQ = true;

        document.write('<scr' + 'ipt type="text/javascript" src="/jquery-3.3.1.min.js"></scr' + 'ipt>');
        console.log('load');
      }
      setTimeout('initJQ(mt)', 50);
    } else {
      console.log('isset');

      if(mt){
        window.$ = mt;
      }

      (function($) {
        $(function() {

          $('#uForm').submit(function(event) {
            event.preventDefault();

            let valid = validateForm();
            if (!valid) return;

            let formData = new FormData( this );

            if(window.smetrics){
              let smform = this;
              if(smform.smIsJs){
                if(!document.smetrics_sended){
                  document.smetrics_sended = true;
                  setTimeout(function(){
                    delete document.smetrics_sended;
                  }, 8000);
                  window.smetrics.dataCollection(smform);
                }
              }
            } else {
//              console.log('~700');
            }

            $.ajax({
              type: "POST",
              url: "/sendForm.php",
              contentType: false,
              processData: false,
              data: formData,
              statusCode: {
                403: function() {
                  if (handlerType === 'modal') {
                    changeMessageText(false);
                    toggleModal();
                  }
                  if (handlerType === 'message') {
                    printMessageText(false);
                  }
                },
                200: function(data) {
                  if (handlerType === 'modal') {
                    changeMessageText(true);
                    toggleModal();
                  }
                  if (handlerType === 'message') {
                    printMessageText(true);
                  }
                  $('#uForm__reset').click();
                }
              }
            })
          });

          // изменение текста сообщения

          function changeMessageText(status) {
            if (status === true) {
              $('.uForm__modal-text').text(successMessage + '');
            }
            if (status === false) {
              $('.uForm__modal-text').text(failMessage  + '');
            }
          }

          // функционал модалки

          $('#uForm__modal button, #uForm__overlay').click(function() {
            toggleModal();
          });

          let isOpened = false;
          function toggleModal() {
            if (!isOpened) {
              $('#uForm__modal, #uForm__overlay').css('display', 'block');
              isOpened = true;
            } else {
              $('#uForm__modal, #uForm__overlay').css('display', 'none');
              isOpened = false;
            }
          }

          // вывод сообщения

          function printMessageText(status) {
            $('#uForm > *').remove();

            let uForm = $('#uForm');
            uForm.text('');

            uForm.append('<p class="message-text"></p>')

            if (status === true) {
              $('.message-text').text(successMessage + '');
            }
            if (status === false) {
              $('.message-text').text(failMessage  + '');
            }
          }
        })
      })(jQuery)
    }
  }

  let mt = (window.MooTools != undefined)? window.$ : false;
  initJQ(mt);

  function printError(message) {
    let uFormErr = jQuery('#uForm__error-msg');
    uFormErr.show();
    uFormErr.append('<p></p>');
    jQuery('#uForm__error-msg > p:last-child').text('*' + message);

    setTimeout(function() {
      jQuery('#uForm__error-msg').hide();
      jQuery('#uForm__error-msg > p').text('');
    }, 5000);
  }

  // для кастомной валидации у input'а необходимо убирать атрибуты type и pattern
  function validateForm() {
    let inputs = $('#uForm input, #uForm select, #uForm textarea');
    let result = true;
    let message;

    let emailRegExp = /[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/g;
    let telRegExp = /^\+?\d{3,25}/g;


    for (let i = 0; i < inputs.length; i++) {
      let message = undefined;
      let inputSelector = inputs[i].id || inputs[i].className;
      let inputValue = $(inputs[i]).val();

      switch(inputSelector) {

        case 'uForm__tel':
          if ( !inputValue.match(telRegExp) )
            message = 'что-то с телефоном';
          break;

        case 'uForm__email':
          if ( !inputValue.match(emailRegExp) )
            message = 'что-то с emailom';
          break;

        case 'uForm__multiselect':
          if (inputValue == false)
            message = 'выберите что-нибудь';
          break;

        default:
          continue;
      }

      if (message != undefined) {
        printError(message);
        result = false;
      }
    }

    return result;
  }


</script>
</body>
</html>