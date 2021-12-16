## RU: Тестовое задание

Текст задания на разработку - поиск самых выгодных курсов валют 

1. Реализовать загрузку курсов, которые находятся в файле bm_rates.dat 
   <br/><br/>
   Файл сосит из набора строк типа "118;89;454;66.82258603;1;123638.43;0.2506;1", где первое число - идентификатор отправляемой валюты, второе - идентификатор получаемой валюты, четвертое - курс отправления, пятое - курс получения.
   <br/><br/>
   Необходимо найти максимально выгодный курс для каждой пары валют, то есть курс того обменника, который стоит на первом месте для каждой валютной пары.
   <br/><br/>
   Все выгодные курсы записывать в базу данных.
   <br/><br/>

2. Написать REST API для получения выгодных курсов.
   <br/><br/>
   Реализовать два метода:
   <br/><br/>
   <b>GET /courses</b> - получение массива всех курсов с фильтрацией
   <br/><br/>
   Возможные фильтры:
   <br/><br/>
   - отправляемая валюта
   <br/><br/>
   - получаемая валюта
   <br/><br/>
   
   <b>GET /course/$send_currency/$recive_currency</b>, где $send_currency - отправляемая валюта, $recive_currency - получаемая валюта.
   <br/><br/>
   Все запросы должны подписываться токеном Bearer.
   <br/><br/>
   Язык программирования PHP и фреймворк Laravel.

## Screens

<p align="center">
<img src="https://github.com/makklays/currencies/blob/main/public/img/1.png" alt="Screen 1">
<br/>
<a href="https://github.com/makklays/currencies/blob/main/public/img/2.png">
<img src="https://github.com/makklays/currencies/blob/main/public/img/2.png" alt="Screen 2">
</a><br/>
<a href="https://github.com/makklays/currencies/blob/main/public/img/3.png">
<img src="https://github.com/makklays/currencies/blob/main/public/img/3.png" alt="Screen 3">
</a><br/>
<a href="https://github.com/makklays/currencies/blob/main/public/img/4.png">
<img src="https://github.com/makklays/currencies/blob/main/public/img/4.png" alt="Screen 4">
</a><br/>
<a href="https://github.com/makklays/currencies/blob/main/public/img/5.png">
<img src="https://github.com/makklays/currencies/blob/main/public/img/5.png" alt="Screen 5">
</a><br/>
<a href="https://github.com/makklays/currencies/blob/main/public/img/6.png">
<img src="https://github.com/makklays/currencies/blob/main/public/img/6.png" alt="Screen 6">
</a><br/>
<a href="https://github.com/makklays/currencies/blob/main/public/img/7.png">
<img src="https://github.com/makklays/currencies/blob/main/public/img/7.png" alt="Screen 7">
</a><br/>
<a href="https://github.com/makklays/currencies/blob/main/public/img/8.png">
<img src="https://github.com/makklays/currencies/blob/main/public/img/8.png" alt="Screen 8">
</a><br/>
<a href="https://github.com/makklays/currencies/blob/main/public/img/9.png">
<img src="https://github.com/makklays/currencies/blob/main/public/img/9.png" alt="Screen 9">
</a><br/>
<a href="https://github.com/makklays/currencies/blob/main/public/img/10.png">
<img src="https://github.com/makklays/currencies/blob/main/public/img/10.png" alt="Screen 10">
</a>
</p>


<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

