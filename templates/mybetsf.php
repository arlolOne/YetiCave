<head>
  <meta charset="UTF-8">
  <title>Мои ставки</title>
  <link href="../css/normalize.min.css" rel="stylesheet">
  <link href="../css/style.css" rel="stylesheet">
</head>
<body>
<div class="page-wrapper">
  <main>
    <section class="rates container">
      <h2>Мои ставки</h2>
      <table class="rates__list">
      <?php foreach ($rates as $rate): ?>
        <?php 
        $state = getState($rate['lotId'], $rate['id'], $rate['dateClosing']);
        $stateClass = '';
        if ($state == 'win') { $stateClass = ' rates__item--win'; } 
        elseif ($state == 'lose') { $stateClass = ' rates__item--end'; }
        ?>
        <tr class="rates__item <?= $stateClass ?>">
          <td class="rates__info">
            <div class="rates__img">
              <img src="<?= $rate['img'] ?>" width="54" height="40" alt="<?= $rate['title'] ?>">
            </div>
            <div>
            <h3 class="rates__title"><a href="/lot.php?id=<?= $rate['lotId'] ?>"><?= $rate['title'] ?></a></h3>
            <?php if ($state == 'win'): ?>
            <p><?= $rate['contacts'] ?></p>
            <?php endif; ?>
            </div>
          </td>
          <td class="rates__category">
          <?= $rate['name'] ?>
          </td>
          <?php if ($state == 'continue'): ?>
          <td class="rates__timer">
          <?php $timeArr = get_minutes($rate['dateClosing']); ?>
            <div class="timer <?= (!(int)$timeArr[0]) ? 'timer--finishing' : '' ?>">
            <?= $timeArr[0] . ':' . $timeArr[1] ?></div>
          </td>
          <?php elseif ($state == 'win'): ?>
            <td class="rates__timer">
            <div class="timer timer--win">Ставка выиграла</div>
          </td>
          <?php else: ?>
            <td class="rates__timer">
            <div class="timer timer--end">Торги окончены</div>
          </td>
          <?php endif; ?>
          <td class="rates__price">
          <?= $rate['valueRate'] ?>
          </td>
          <td class="rates__time">
          <?php
          $hours = abs(get_minutes($rate['dateCreating'])[0]);
          $fullText = get_noun_plural_form($hours, 'час', 'часа', 'часов') . ' назад'; 
          ?>
          <?= $fullText ?>
          </td>
        </tr>
        <?php endforeach; ?> 
      </table>
    </section>
  </main>
</div>
</body>