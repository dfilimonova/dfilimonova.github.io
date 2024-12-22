<?php session_start(); 
$host = 'localhost'; 
$db_name = 'theater'; 
$username = 'root'; 
$password = ''; 
try { $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password); 
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); } 
catch (PDOException $e) { die("Ошибка подключения к базе данных: " . $e->getMessage()); } ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Театр</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: auto;
            overflow-y: auto;
        }

        header {
            background: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .slider {
            position: relative;
            width: 100%;
            height: 95vh; /* Высота слайдера */
            overflow: hidden;
            margin-bottom: 0;
        }

        .slides {
            display: flex;
            transition: transform 0.5s ease;
            height: 100%;
        }

        .slide {
            min-width: 100%;
            height: 100%;
            position: relative;
        }

        .slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .info {
            position: absolute;
            padding: 20px;
            color: #fff;
            border-radius: 8px;
            background: rgba(0, 0, 0, 0.6);
            z-index: 2;
        }

        .info-1 { top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; font-size: 25px; }
        .info-2 { top: 50%; left: 3%; transform: translateY(-50%); text-align: left; font-size: 25px; }
        .info-3 { bottom: 10%; right: 10%; text-align: right; font-size: 25px; }

        .prev, .next {
            background: rgba(255, 255, 255, 0.8);
            border: none;
            cursor: pointer;
            padding: 10px;
            border-radius: 5px;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 3;
        }
        
        .prev { left: 10px; }
        .next { right: 10px; }
        .prev:hover, .next:hover { background: rgba(255, 255, 255, 1); }

        .content {
            padding: 20px;
            color: #000;
            background-color: #ffffff;
            border-radius: 8px;
            margin-top: 0;
        }

        .content h2 { text-align: center; font-size: 28px; }

        .show-case {
            display: flex;
            flex-direction: column;
            margin: 10px 0;
        }

        .show-item {
            display: flex;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            overflow: hidden;
        }

        .show-item img {
            width: 150px;
            margin-top: 10px;
            margin-left: 10px;
            height: 90px;
            object-fit: cover;
        }

        .show-details {
            padding: 10px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .show-title { font-size: 20px; font-weight: bold; }
        .show-age { font-size: 16px; margin: 5px 0; }
        .show-description { font-size: 14px; margin-bottom: 5px; }
        .show-time { font-size: 14px; font-weight: bold; }

        .behind-the-scenes {
            padding: 20px;
            background-color: #333;
        }

        .behind-the-scenes h2 { text-align: center; font-size: 28px; color: 
#f8f8f8; }

        .video-container {
            display: flex;
            justify-content: space-around;
            margin-top: 10px;
        }

       .video-item {
    flex: 1; 
    margin: 0 10px; 
    padding: 10px; /* Отступ внутри рамки */
    background-color: #444; /* Цвет фона рамки */
    border-radius: 10px; /* Скругленные углы */
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5); /* Тень для рамки */
}

.video-item video {
    width: 70%; 
    height: 500px; /* Установленная высота для видео */
    border-radius: 8px; /* Скругление углов видео */
    display: block; /* Делает элемент блочным, чтобы margin: auto работал */
    margin: auto; /* Центрирует видео по горизонтали */
margin-bottom: 10px;
}

        footer {
            text-align: center;
            padding: 20px;
            background-color: #f8f8f8;
            color: #333;
        }
    </style>
</head>
<body>
<?php include "views/layout.php"; ?> 
<main>
    <!-- Слайдер -->
    <div class="slider">
        <div class="slides">
            <div class="slide">
                <img src="https://static.tildacdn.com/tild3264-6638-4137-b363-626631323635/DSCF2116_1.jpg" alt="Слайд 1">
                <div class="info info-1">
                    <h2>Зеркало истории</h2>
                    <p>В каждом спектакле — частичка жизни!</p>
                </div>
            </div>
            <div class="slide">
                <img src="https://i.timeout.ru/pix/517360.jpeg" alt="Слайд 2">
                <div class="info info-2">
                    <h2>Сон в летнюю ночь</h2>
                    <p>Эта комедия перенесет вас в мир, где любовь и волшебство пересекаются...</p>
                </div>
            </div>
            <div class="slide">
                <img src="https://cdn.pbilet.com/origin/d444120a-8cfd-414e-ac69-1f83bada01fb.jpeg" alt="Слайд 3">
                <div class="info info-3">
                    <h2>Трагедия любви</h2>
                    <p>Наши спектакли погружают в бездну эмоций и чувств.</p>
                </div>
            </div>
        </div>
        <button class="prev" onclick="changeSlide(-1)">&#10094;</button>
        <button class="next" onclick="changeSlide(1)">&#10095;</button>
    </div>

    <!-- Блок с предстоящими новогодними сеансами -->
    <div class="content">
        <h2>Предстоящие новогодние сеансы</h2>
        <div class="show-case">
            <div class="show-item">
                <img src="https://avatars.mds.yandex.net/i?id=c7ba672a9dcf8b5d6b36cfbe59a612e3_l-4311007-images-thumbs&n=13" alt="Спектакль 1">
                <div class="show-details">
                    <div class="show-title">Новогодний переполох в Ледяном Королевстве</div>
                    <div class="show-age">12+</div>
                    <div class="show-description">Захватывающая история о том, как друзья-зверята помогают Деду Морозу спасти праздник от коварных планов Снежной Королевы.</div>
                    <div class="show-time">Когда: 25 декабря, 18:00. Билеты ограничены!</div>
                </div>
            </div>
            <div class="show-item">
                <img src="https://cdn.culture.ru/images/9ba6cc4e-872b-5aea-a049-93d4e96752aa" alt="Спектакль 2">
                <div class="show-details">
                    <div class="show-title">Репка на всю катушку</div>
                    <div class="show-age">6+</div>
                    <div class="show-description">Забавная история о том, как вся семья и лесные жители объединяются, чтобы вытащить огромную репку из земли, показывая, что совместные усилия могут преодолеть любые преграды.</div>
                    <div class="show-time">Когда: 26 декабря, 19:00. Билеты ограничены!</div>
                </div>
            </div>
            <div class="show-item">
                <img src="https://s1.afisha.ru/mediastorage/b0/aa/30fd8c3e08d44b088dc7d172aab0.jpg" alt="Спектакль 3">
                <div class="show-details">
                    <div class="show-title">Эльфийские чудеса</div>
                    <div class="show-age">0+</div>
                    <div class="show-description">В этом ярком спектакле маленький эльф отправляется в волшебное приключение, чтобы спасти Рождество, находя друзей и преодолевая трудности на своем пути.</div>
                    <div class="show-time">Когда: 27 декабря, 17:00. Билеты ограничены!</div>
                </div>
            </div>
            <div class="show-item">
                <img src="https://avatars.mds.yandex.net/i?id=346d09669429bd912d157883bf3a01ee_l-10465776-images-thumbs&n=13" alt="Спектакль 4">
                <div class="show-details">
                    <div class="show-title">Волшебные приключения Снежинки</div>
                    <div class="show-age">6+</div>
                    <div class="show-description">Веселый музыкальный спектакль, в котором маленькая снежинка отправляется в увлекательное путешествие, чтобы найти свое место в зимней сказке.</div>
                    <div class="show-time">Когда: 28 декабря, 20:00. Билеты ограничены!</div>
                </div>
            </div>
            <div class="show-item">
                <img src="https://avatars.mds.yandex.net/i?id=d96e607acf48caa2704b51a0faef036c_l-5220865-images-thumbs&n=13" alt="Спектакль 5">
                <div class="show-details">
                    <div class="show-title">Приключения Зайчонка в Зимнем Лесу</div>
                    <div class="show-age">6+</div>
                    <div class="show-description">Яркий и красочный спектакль о маленьком Зайчонке, который отправляется в путешествие по зимнему лесу, где встречает новых друзей и учится ценить настоящую дружбу.</div>
                    <div class="show-time">Когда: 29 декабря, 19:00. Билеты ограничены!</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Блок "Жизнь театра за кулисами" -->
<div class="behind-the-scenes">
    <h2>Жизнь театра за кулисами</h2>
    <div class="video-container">
        <div class="video-item">
            <video controls>
                <source src="https://video-preview.s3.yandex.net/iaPcZwAAAAA.mp4">
                Ваш браузер не поддерживает видео.
            </video>
        </div>
    </div>
</div>
    
    <!-- Подвал -->
    <footer>
        <p>&copy; 2023 Театр. Все права защищены.</p>
        <p>Контакт: <a href="mailto:info@theater.com" style="color: #333;">info@theater.com</a></p>
    </footer>
</main>

<script>
let currentSlide = 0; 

function changeSlide(direction) {
    const slides = document.querySelectorAll('.slide');
    const totalSlides = slides.length;

    // Изменяем индекс текущего слайда
    currentSlide = (currentSlide + direction + totalSlides) % totalSlides;

    // Обновляем слайды
    updateSlides();
}

function updateSlides() {
    const slides = document.querySelector('.slides');
    const offset = currentSlide * -100; // Двигаем на 100% влево для нового слайда
    slides.style.transform = `translateX(${offset}%)`;
}

// Автоматическая смена слайдов
setInterval(() => changeSlide(1), 5000);
</script>
</body>
</html>