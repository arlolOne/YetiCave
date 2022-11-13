<?php 
session_start();
?>

<head>
  <meta charset="UTF-8">
  <title><?= $title ?></title>
  <link href="../css/normalize.min.css" rel="stylesheet">
  <link href="../css/style.css" rel="stylesheet">
</head>
<body>
<div class="page-wrapper">
  <main>
    <section class="lot-item container">
      <h2><?= $title ?></h2>
      <div class="lot-item__content">
        <div class="lot-item__left">
          <div class="lot-item__image">
            <img src="../<?= $img ?>" width="730" height="548" alt="<?= $category ?>">
          </div>
          <p class="lot-item__category">Категория: <span><?= $category ?></span></p>
          <p class="lot-item__description"><?= $description ?> </p>
        </div>
        <div class="lot-item__right">
        <?php if (isset($_SESSION['name'])): ?>
          <?php $timeArr = get_minutes($dateClosing); ?>
          <?php if ($timeArr[0] >= 0): ?>
          <div class="lot-item__state">
            <div class="lot-item__timer timer <?= (!(int)$timeArr[0]) ? 'timer--finishing' : '' ?>">
            <?= $timeArr[0] . ':' . $timeArr[1] ?>
            </div>
            <div class="lot-item__cost-state">
              <div class="lot-item__rate">
                <span class="lot-item__amount">Текущая цена</span>
                <span class="lot-item__cost"><?= $currentPrice ?></span>
              </div>
              <div class="lot-item__min-cost">
                Мин. ставка <span><?= $minRate ?></span>
              </div>
            </div>
            <?php if ($_SESSION['id'] != $createrId): ?>
              <?php if ($_SESSION['id'] != $lot[0]['id']): ?>
            <form class="lot-item__form" action="lot.php" method="post" autocomplete="off">
              <p class="lot-item__form-item form__item <?= $invalidCost ? 'form__item--invalid' : '' ?>">
                <label for="cost">Ваша ставка</label>
                <input id="cost" type="text" name="cost" placeholder="<?= $minRate ?>">
                <input id="id" type="hidden" name="id" value="<?= $lotId ?>">
                <input id="minRate" type="hidden" name="minRate" value="<?= $minRate ?>">
                <span class="form__error">Введите корректную ставку</span>
              </p>
              <button type="submit" class="button">Сделать ставку</button>
            </form>
            <?php else: ?>
              <p><span>Вы уже недавно сделали ставку. Дайте её сделать другим!</span></p>
            <?php endif; ?>
            <?php endif; ?>
          </div>
          <?php else: ?>
            <div class="lot-item__state">
            <div class="lot-item__timer timer">Продано</div>
            <div class="lot-item__cost-state">
              <div class="lot-item__rate">
                <span class="lot-item__amount">Итоговая цена</span>
                <span class="lot-item__cost"><?= $currentPrice ?></span>
              </div>
              </div>
            </div>
          <?php endif; ?>
          <div class="history">
          <?php if (!$missingRates): ?>
            <h3>История ставок (<span><?= count($lot) ?></span>)</h3>
            <?php else: ?>
              <h3>История ставок отсутствует</h3>
              <?php endif; ?>
            <table class="history__list">
            <?php if (!$missingRates): ?>
            <?php foreach ($lot as $rate): ?>
              <tr class="history__item">
                <td class="history__name"><?= $rate['name'] ?></td>
                <td class="history__price"><?= $rate['valueRate'] ?> р</td>
                <?php
                 $hours = abs(get_minutes($rate['dateCreating'])[0]);
                 $fullText = get_noun_plural_form($hours, 'час', 'часа', 'часов') . ' назад'; 
                 ?>
                <td class="history__time"><?= $fullText ?></td>
              </tr>
              <?php endforeach; ?>
              <?php endif; ?>
            </table>
          </div>
        </div>
          </div>
         </div>
        <?php endif; ?>
      </div>
    </section>
  </main>
</div>
</body>