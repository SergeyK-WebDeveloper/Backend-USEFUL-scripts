// method of notification after sending
let handlerType = 'modal' || 'message';

let uFormFilePath = '/uForm/';

// message about the result of sending
let failMessage = 'Что-то пошло не так... Повтоите немного позже';
let successMessage = 'Запрос успешно отправлен';

// forms, form fields and their validation
const uForms = {
  uForm: {
    handlerType: handlerType,
    failMessage: failMessage,
    successMessage: successMessage,
    refix: '',
    validation: {
      uForm__name: {
        1: [validLen, 2, 50],
      },
      uForm__password: {
        1: [validLen, 6, 50],
      },
      uForm__email: {
        1: validEmail,
      },
      uForm__tel: {
        1: validTel,
      },
      'uForm__text-area': {
        1: [validLen, 5, 250],
      },
    }
  },
};

//--------------------------------------------------------
// validation functions --------------------------------
//--------------------------------------------------------
function validTel(item, empty = true) {
  if(empty && item.value.length == 0)
    return true;

  let errMsg = 'неправильный формат телефонного номера';
  let telRegExp = /^\+?\d{7,25}/g;

  let itemVal = item.value.replace(/[()-]|\s/g,'');
  if (!itemVal.match(telRegExp))
    return errMsg;
  return true;
}

function validEmail(item, empty = true) {
  if(empty && item.value.length == 0)
    return true;

  let errMsg = 'неправильный формат e-mail';
//    let emailRegExp = /[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/g;
  let emailRegExp = /.+@[a-zA-Z0-9.-_]+\.[a-zA-Z0-9.-_]+$/g;

  if (!item.value.match(emailRegExp))
    return errMsg;
  return true;
}

function validLen(item, min, max, empty = true) {
  let n = item.value.length;
  let errMsg = '';

  if(empty && n == 0){
    return true;
  }
  else if(n < min){
    errMsg = 'введите не менее '+ min +' символов';
  } else if(n > max) {
    errMsg = 'превышен допустимый лимит символов: '+ max;
  }

  return (errMsg == '')? true : errMsg;
}

function validationForm(instance) {
  let valid = true;

  for(let inp in uForms[instance.id].validation) {
    let testInput = document.getElementById(inp);
    jQuery(testInput).blur();
    if (testInput.uFormValid !== undefined && testInput.uFormValid == false) {
//        addErrorWarning(testInput, '');
      valid = false;
    }
  }

  return valid;
}
//--------------------------------------------------------
// and - validation functions ----------------------------
//--------------------------------------------------------
//--------------- output info ----------------------------

function addErrorWarning(instance, msg){
  let oroginBorder = jQuery(instance).css('border');

  instance.uFormValid = false;
  jQuery(instance).css('border', '2px #ff6a64 solid');
  jQuery(instance).on('focus', function (e) {
    jQuery(instance).css('border', oroginBorder);
    jQuery(instance).off(e);
    instance.uFormValid = true;
  })
  printError(instance.form.uFormPrefix, msg);
}

function printError(uFormPrefix, msg) {
  console.log(uFormPrefix);
  console.log(msg);
  let uFormErr = jQuery('#uForm__error-msg'+ uFormPrefix);
  console.log(uFormErr);
  uFormErr.show();
  uFormErr.append('<p></p>');
  jQuery('#uForm__error-msg'+ uFormPrefix +' > p:last-child').text('*' + msg);

  setTimeout(function () {
    jQuery('#uForm__error-msg'+ uFormPrefix).hide();
    jQuery('#uForm__error-msg'+ uFormPrefix +' > p').text('');
  }, 5000);
}

// change the message text
function changeMessageText(instance, status) {
  let statusMsg = '';
  if (status === true) {
    statusMsg = instance.uFormSuccessMsg;
  } else if (status === false) {
    statusMsg = instance.uFormFailMsg;
  } else {
    statusMsg = status;
  }
  jQuery('#uForm__modal'+ instance.uFormPrefix +' .uForm__modal-text').text(statusMsg + '');
}

// message output
function printMessageText(instance, status) {

  let uForm = jQuery(instance);
  let statusMsg = '';

  uForm.html('');
  uForm.append('<p id="uForm__message-text'+ instance.uFormPrefix +'" class="message-text"></p>')

  if (status === true) {
    statusMsg = instance.uFormSuccessMsg;
  } else if(status === false) {
    statusMsg = instance.uFormFailMsg;
  } else {
    statusMsg = status;
  }
  jQuery('#uForm__message-text'+ instance.uFormPrefix).text(statusMsg + '');
}

let isOpened = false;
function toggleModal(uFormPrefix) {
  if (!isOpened) {
    jQuery('#uForm__modal'+ uFormPrefix +', #uForm__overlay'+ uFormPrefix).css('display', 'block');
    isOpened = true;
  } else {
    jQuery('#uForm__modal'+ uFormPrefix +', #uForm__overlay'+ uFormPrefix).css('display', 'none');
    isOpened = false;
  }
}
//--------------- and- output info -------------------------




//----------------------------------------------------------
let jQ = false;
let mt = (window.MooTools != undefined) ? window.$ : false;
initJQ(mt);

function initJQ(mt) {
  if (typeof(jQuery) == 'undefined') {
    if (!jQ) {
      jQ = true;
      document.write('<scr' + 'ipt type="text/javascript" src="'+ uFormFilePath +'js/jquery-3.3.1.min.js"></scr' + 'ipt>');
    }
    setTimeout('initJQ(mt)', 50);
  } else {
    if (mt) window.$ = mt;

    (function ($) {
      $(function () {

        for (let uFormId in uForms) {
          let formInstance = $('#'+uFormId);

          console.log(uFormId);
          console.log(formInstance[0]);

          formInstance[0].uFormHandlerType = (uForms[uFormId].handlerType)? uForms[uFormId].handlerType : handlerType;
          formInstance[0].uFormFailMsg = (uForms[uFormId].failMessage)? uForms[uFormId].failMessage : failMessage;
          formInstance[0].uFormSuccessMsg = (uForms[uFormId].successMessage)? uForms[uFormId].successMessage : successMessage;
          formInstance[0].uFormPrefix = (uForms[uFormId].prefix)? uForms[uFormId].prefix : '';

          // modal functional
          $('#uForm__modal'+ formInstance[0].uFormPrefix +' button, #uForm__overlay'+ formInstance[0].uFormPrefix).click(function () {
            toggleModal(formInstance[0].uFormPrefix);
          });

          formInstance.submit(function (event) {
            event.preventDefault();

            let valid = validationForm(this);
            if (!valid){
              showResult(this, 'Некоторые поля заполненные не корректно');
              return;
            }
            let formData = new FormData(this);

            let smform = this;
            if (window.smetrics) {
              if (smform.smIsJs) {
                if (!document.smetrics_sended) {
                  document.smetrics_sended = true;
                  setTimeout(function () {
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
              url: uFormFilePath + "sform.php",
              contentType: false,
              processData: false,
              data: formData,
              statusCode: {
                403: function () {
                  showResult(smform, false);
                },
                200: function (data) {
                  showResult(smform, true);
                  console.log(data);
                  $('#uForm__reset' + this.uFormPrefix).click();
                }
              }
            })
          });
        }

        // the result of sending
        function showResult(instance, status) {
          console.log(instance);
          console.log(status);
          console.log(instance.uFormHandlerType );

          if (instance.uFormHandlerType === 'modal') {
            changeMessageText(instance, status);
            toggleModal(instance.uFormPrefix);
          }
          else if (instance.uFormHandlerType === 'message') {
            printMessageText(instance, status);
          }
        }

        // adding validators
        for (let uFormId in uForms) {
          console.log('uFormId: ' + uFormId);
//            console.log(document.getElementById(uFormId));

          let testForm = uForms[uFormId].validation;
          for (let uInput in testForm) {
            console.log('uInput: ' + uInput);

            let curInput = testForm[uInput];
            let testInput = $('#' + uInput);

            if (testInput[0] == 'undefined')
              continue;

            for (let validFuncName in curInput) {
              console.log('validFuncName: ' + validFuncName);

              let validFunc = curInput[validFuncName];
              if (Array.isArray(validFunc)) {
                console.log('arr: ');
                $(testInput[0]).on('blur', function (e) {
                  let result = validFunc[0](testInput[0], validFunc[1], validFunc[2], validFunc[3], validFunc[4], validFunc[5]);

                  if (result !== true) {
                    addErrorWarning(this, result);
                  }
                });
              } else {
                console.log('this is function: ');
                $(testInput[0]).on('blur', function (e) {
                  let result = validFunc(testInput[0]);

                  if (result !== true) {
                    addErrorWarning(this, result);
                  }
                });
              }
            }
          }
        }
        // and - adding validators
      })
    })(jQuery)
  }
}
