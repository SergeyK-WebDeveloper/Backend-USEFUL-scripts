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

      background: rgba(0, 0, 0, .5);
      z-index: 100;

      position: fixed;
      top: 0;
      left: 0;

      display: none;
    }

    .uForm__hidden {
      display: none;
    }
  </style>
</head>
<body>
<form action="" id="uForm" enctype="multipart/form-data" method="post">
  Name <input id="uForm__name" name="name" type="text" required>
  Pass <input id="uForm__password" name="password" type="password" required>
  <!-- Email	<input id="uForm__email" name="email" type="email" required> -->
  Email <input id="uForm__email" name="email" required>
  <!-- Tel 	<input id="uForm__tel" name="tel" type="tel" required> -->
  Tel <input id="uForm__tel" name="tel" required>
  Date <input id="uForm__date" name="date" type="date">

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
  <input class="uForm__radio-btn" name="radio-btn" type="radio" value="radio-1" checked="">
  <input class="uForm__radio-btn" name="radio-btn" type="radio" value="radio-2"><br>

  <input id="uForm__hidden" name="hidden" type="hidden">

  <input id="uForm__file" name="uForm_file" type="file" accept=".txt,image/*">
  <input id="uForm__files" name="uForm_files[]" multiple type="file" accept=".txt,image/*">

  <input id="uForm__reset" type="reset" value="Reset" style="display: none;">

  <span>
    <label>
      <input required="required" name="terms" type="checkbox"> I accept the <u>Terms and Conditions</u>
    </label>
  </span>

  <input class="uForm__hidden" name="nospam" type="text" value="uform-empty" required>
  <input id="uForm__submit" name="submit" type="submit">

  <p id="uForm__error-msg"></p>
</form>


<div id="uForm__overlay"></div>

<div id="uForm__modal">
  <p class="uForm__modal-text">Запрос успешно отправлен</p>
  <button>Закрыть</button>
</div>

<script src="/uForm/js/script.js"></script>

</body>
</html>