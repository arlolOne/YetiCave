<head>
  <meta charset="UTF-8">
  <title>Регистрация</title>
  <link href="../css/normalize.min.css" rel="stylesheet">
  <link href="../css/style.css" rel="stylesheet">
</head>
<body>
<div class="page-wrapper">
<main>
<form class="form container <?= count($invalids) != 0 ? ' form--invalid' : '' ?>" 
action="reg.php" method="post" autocomplete="off">
      <h2>Регистрация нового аккаунта</h2>
      <div class="form__item <?= in_array('email', $invalids) ? ' form__item--invalid' : '' ?>">
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= $values['email'] ?>">
        <span class="form__error">Введите e-mail</span>
      </div>
      <div class="form__item <?= in_array('password', $invalids) ? ' form__item--invalid' : '' ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль">
        <span class="form__error">Введите пароль</span>
      </div>
      <div class="form__item <?= in_array('login', $invalids) ? ' form__item--invalid' : '' ?>">
        <label for="login">Имя <sup>*</sup></label>
        <input id="login" type="text" name="login" placeholder="Введите имя" value="<?= $values['login'] ?>">
        <span class="form__error">Введите имя</span>
      </div>
      <div class="form__item <?= in_array('contact', $invalids) ? ' form__item--invalid' : '' ?>">
        <label for="contact">Контактные данные <sup>*</sup></label>
        <textarea id="contact" name="contact" placeholder="Напишите как с вами связаться">
        <?= $values['contact'] ?> </textarea>
        <span class="form__error">Напишите как с вами связаться</span>
      </div>
      <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
      <button type="submit" class="button">Зарегистрироваться</button>
      <a class="text-link" href="log.php">Уже есть аккаунт</a>
    </form>
	</div>
</main>
</body>