<head>
  <meta charset="UTF-8">
  <title>Добавление лота</title>
  <link href="../css/normalize.min.css" rel="stylesheet">
  <link href="../css/style.css" rel="stylesheet">
  <link href="../css/flatpickr.min.css" rel="stylesheet">
</head>
<body>
<div class="page-wrapper">
<main>
<form class="form form--add-lot container <?= count($invalids) != 0 ? ' form--invalid' : '' ?>" 
action="add.php" method="post" enctype="multipart/form-data">
      <h2>Добавление лота</h2>
      <div class="form__container-two">
        <div class="form__item <?= in_array('name', $invalids) ? ' form__item--invalid' : '' ?>">
          <label for="lot-name">Наименование <sup>*</sup></label>
          <input id="lot-name" type="text" name="name" placeholder="Введите наименование лота"
          value="<?= $values['name'] ?>">
          <span class="form__error">Введите наименование лота</span>
        </div>
        <div class="form__item <?= in_array('category', $invalids) ? ' form__item--invalid' : '' ?>">
          <label for="category">Категория <sup>*</sup></label>
          <select id="category" name="category">
            <?php foreach ($categories as $category): ?>
              <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
            <?php endforeach; ?>
          </select>
          <span class="form__error">Выберите категорию</span>
        </div>
      </div>
      <div class="form__item form__item--wide <?= in_array('description', $invalids) ? ' form__item--invalid' : '' ?>">
        <label for="message">Описание <sup>*</sup></label>
        <textarea id="message" name="description" 
        placeholder="Напишите описание лота"><?= $values['description'] ?></textarea>
        <span class="form__error">Напишите описание лота</span>
      </div>
      <div class="form__item form__item--file <?= in_array('img', $invalids) ? ' form__item--invalid' : '' ?>">
        <label>Изображение <sup>*</sup></label>
        <div class="form__input-file">
          <input class="visually-hidden" name="img" type="file" id="lot-img" value="">
          <label for="lot-img">
            Добавить
          </label>
          <span class="form__error">Загрузите изображение</span>
        </div>
      </div>
      <div class="form__container-three">
        <div class="form__item form__item--small <?= in_array('initPrice', $invalids) ? ' form__item--invalid' : '' ?>">
          <label for="lot-rate">Начальная цена <sup>*</sup></label>
          <input id="lot-rate" type="text" name="initPrice" placeholder="0" value="<?= $values['initPrice'] ?>">
          <span class="form__error">Введите начальную цену</span>
        </div>
        <div class="form__item form__item--small <?= in_array('step', $invalids) ? ' form__item--invalid' : '' ?>">
          <label for="lot-step">Шаг ставки <sup>*</sup></label>
          <input id="lot-step" type="text" name="step" placeholder="0" value="<?= $values['step'] ?>">
          <span class="form__error">Введите шаг ставки</span>
        </div>
        <div class="form__item <?= in_array('dateClosing', $invalids) ? ' form__item--invalid' : '' ?>">
          <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
          <input class="form__input-date" id="lot-date" type="text" name="dateClosing" 
          placeholder="Введите дату в формате ГГГГ-ММ-ДД" value="<?= $values['dateClosing'] ?>">
          <span class="form__error">Введите дату завершения торгов</span>
        </div>
      </div>
      <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
      <button type="submit" class="button">Добавить лот</button>
    </form>
	</div>
</main>
</body>