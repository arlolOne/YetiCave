<head>
    <meta charset="UTF-8">
    <title>Yeticave</title>
    <link href="../css/normalize.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
<section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
        <ul class="promo__list">
            <?php foreach ($categories as $category): ?>
            <li class="promo__item promo__item--<?= $category['keyword'] ?>">
            <?php 
            $catId = $category['id'];
            $path = "index.php?page=1&cat=$catId" 
            ?>
                <a class="promo__link" href="<?= $path ?>"><?= $category['name'] ?></a>
            </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
        <?php if ($currentCategory == 'all'): ?>
            <h2>Лоты аукциона</h2>
        <?php else: ?>
            <h2><?= $categories[$currentCategory - 1]['name'] ?></h2>
        <?php endif; ?>
        </div>
        <ul class="lots__list">
        <?php foreach ($items as $item): ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?= $item['img'] ?>" width="350" height="260" alt="<?= $item['title'] ?>">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?= $item['category'] ?></span>
                    <h3 class="lot__title"><a class="text-link" href="/lot.php?id=<?= $item['id'] ?>"><?= $item['title'] ?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount"><?= $item['initialPrice'] ?></span>
                            <span class="lot__cost"><?= formatingPrice($item['currentPrice']) ?></span>
                        </div>
                        <?php $timeArr = get_minutes($item['dateClosing']); ?>
                        <?php if ($timeArr[0] >= 0): ?>
                        <div class="lot__timer timer <?= (!(int)$timeArr[0]) ? 'timer--finishing' : '' ?>">
                            <?= $timeArr[0] . ':' . $timeArr[1] ?>
                        </div>
                        <?php else: ?>
                            <div class="lot__timer timer">Торги окончены</div> 
                        <?php endif; ?>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
        </ul>
    </section>
    <?php if ($countPage > 1): ?>
      <ul class="pagination-list">
      <?php $linkP = "index.php?page=" . $currentPage - 1 . "&cat=" . $currentCategory ?>
        <li class="pagination-item pagination-item-prev"><a
        <?= $currentPage != 1 ? 'href="' . $linkP . '"' : '' ?>>Назад</a></li>
        <?php for ($i = 1; $i <= $countPage; $i++): ?>
        <li class="pagination-item <?= $i == $currentPage ? 'pagination-item-active' : '' ?>">
          <a href="index.php?page=<?= $i . "&cat=$currentCategory" ?>"><?= $i ?></a></li>
        <?php endfor; ?>
        <?php $linkN = "index.php?page=" . $currentPage + 1 . "&cat=" . $currentCategory ?>
        <li class="pagination-item pagination-item-next"><a
          <?= $currentPage != $countPage ? 'href="' . $linkN . '"' : '' ?>>Вперед</a></li>
      </ul>
      <?php endif; ?>
	</body>