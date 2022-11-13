USE yeticave;


INSERT categories (name, keyword)
VALUES 
('Доски и лыжи', 'boards'),
('Крепления', 'attachment'),
('Ботинки', 'boots'),
('Одежда', 'clothing'),
('Инструменты', 'tools'),
('Разное', 'other');


INSERT users (name, email)
VALUES 
('Андрей', 'ander@mail.ru'),
('Александр', 'sanya@gmail.ru'),
('Алексей', 'lexa@yandex.ru');


INSERT lots (title, description, img, categoryId,
             createrId, dateClosing,
             initialPrice, step)
VALUES 
('2014 Rossignol District Snowboard', 'Заряженный борд для катания, отличается высокой прочностью', 'img/lot-1.jpg', 1, 1, 2022-10-10, 50000, 5000),
('DC Ply Mens 2016/2017 Snowboard', 'Практичный борд для катания, отличается лёгкостью материала', 'img/lot-2.jpg', 1, 3, 2022-10-15, 70000, 10000),
('Крепления Union Contact Pro 2015 года размер L/XL', 'Эргономичные крепления, работают даже при абсолютном нуле', 'img/lot-3.jpg', 2, 1, 2022-10-22, 10000, 500),
('Ботинки для сноуборда DC Mutiny Charocal', 'Тёплые и прочные ботинки, выдерживают килотонну нагрузки', 'img/lot-4.jpg', 3, 2, 2022-10-05, 25000, 5000),
('Куртка для сноуборда DC Mutiny Charocal', 'Лимитированная куртка для хейтеров (10 в мире), тёплая и удобная', 'img/lot-5.jpg', 4, 1, 2022-10-25, 60000, 10000),
('Маска Oakley Canopy', 'Морозостойкая маска с прибором ночного видения', 'img/lot-6.jpg', 6, 2, 2022-10-21, 15000, 1000);


INSERT rates (userId, valueRate, lotId)
VALUES 
(1, 16000, 6),
(3, 17000, 6)