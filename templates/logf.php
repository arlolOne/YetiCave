<head>
  <meta charset="UTF-8">
  <title>Вход</title>
  <link href="../css/normalize.min.css" rel="stylesheet">
  <link href="../css/style.css" rel="stylesheet">
</head>
<body>
<div class="page-wrapper">
<main>
<form class="form container form--invalid" 
action="log.php" method="post">
      <h2>Вход</h2>
      <div class="form__item <?= in_array('email', $invalids) ? ' form__item--invalid' : '' ?>">
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail">
        <span class="form__error">Введите e-mail</span>
      </div>
      <div class="form__item form__item--last <?= in_array('password', $invalids) ? ' form__item--invalid' : '' ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль">
        <span class="form__error">Введите пароль</span>
      </div>
      <span class="form__error form__error--bottom"><?= $errorMessage ?></span>
      <button type="submit" class="button">Войти</button>
    </form>
	</div>
</main>
</body>