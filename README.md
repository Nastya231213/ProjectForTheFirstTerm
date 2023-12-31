<h2>Огляд</h2>

"NetSpheret" - це соціальна мережа, яка дозволяє користувачам об'єднуватися, спілкуватися та ділитися інформацією в онлайн-середовищі. Мережа включає основні функції соціальних мереж, такі як створення профілю, додавання друзів, публікації, коментарі, відзначення тощо. Мови програмування: PHP, Javascript

<h2>Based On</h2>

Проект був створений за туторілом https://www.youtube.com/playlist?list=PLY3j36HMSHNWaKUC73RJlwi6oU-WTpTPM, в якому є такі основні етапи:

* Cтворення бази даних "mynetwork" з 8 таблиць через phpMyAdmin
  
* Процес створення акаунта (з хэшуванням пароля)
  
* Звичайна реєстрація аккаунту
  
* Система сповіщень. Користувач отримує сповіщення, коли під його постом з’являється коментар, коли його пост або коментар отримує “лайк”, коли його додають до друзів, відповідають на коментарі або запрошують до групи. Користувач може переглядати ці сповіщення і відмічати їх як прочитані.

* Лента новин, де користувачі можуть переглядати пости своїх друзів та свої пости. 

* Реалізація пошуку користувачів через основне текстове поле в заголовковому файлі
  
* Відправка повідомлень: Користувачі можуть відправляти текстові повідомлення один одному в реальному часі. Крім тексту, користувачі можуть надсилати медіафайли, такі як зображення, відео.

* Додавання у друзі інших користувачів. Підтвердження запита на дружбу.

* Групи , можливість створення груп або спільнот, де користувачі можуть взаємодіяти як друзі.

* Редагування Профілю. Зміна особистих даних та налаштувань профіл.

У проекті були внесені деякі зміни та доповнення:

*  Дизайн та макет проекту були трохи змінені, файли зі стилем були розміщени во окремій папці "style". "style/profile.css"-основний стиль сайту, він використовується майже на кожній сторінці, "style/login_page.css"-стиль, що використовується для сторінок регістрації(singup.php) та логіну (login.php)

* Створена фунція "pagination_link", яка створює посилення на попередню та наступну сторінку після того, як в проекті була реалізовано переписування URL-адрес. До посилань додається параметр "$page",що вказує сторінку через "/" . В туторіалі залишився баг, бо функція, реалізованая там, не враховувала переписування URL-адрес.
  
* Система "лайків" для постів була створена шляхом додавання +1 до поля num_likes в таблиці posts і додавання даних до таблиці likes. В цих даних content_id - це ID контенту, який отримує вподобайку, type - це тип контенту, а також JSON-кодування, в якому зберігається двовимірний масив. Цей масив містить userid (ID користувача, який ставить “лайк”) і час, коли це відбувається. Також сторінка оновлюється автоматично.

* В моїй версії користувач отримує сповіщення, коли під його постом з’являється коментар , його пост або коментар отримує “лайк” чи його додали в друзі. Також нереалізовано 
видалення сповіщення.

* Була створена окрема папка "includes" для файлів , які включаються в основні сторінки (Наприклад, для "profile.php" -це "profile_content_default.php","profile_content_followers.php","profile_content_photos.php","profile_content_setting.php").

* Функція додавання відеороликів до постів або передача відеороликів у чаті ще не була реалізована.

* Нереалізовано можливість створювати, редагувати, видаляти групи, запрошувати інших користувачів вступати до них, можливість шукати групи та запрошувати інших користувачів вступити до них. 

<h2>Майбутній розвиток</h2>
<p>
 
* Планується додати можливість створювати групи ,змінювати їхні налаштування та видаляти їх,  запрошувати користувача вступити до неї.
 
* Система сповіщень для учасників груп щодо нових повідомлень, подій чи оновлень в  групі.
 
* Додавання сторінки адміністратора , де буде інформація про загальну кількість користувачів, нові реєстрації, активні користувачі, тощо. Вона надає адміністраторам інструменти для ефективного керування та забезпечення безпеки спільноти.

* Внедрення шаблонів (templates) у проект PHP для обробки HTML коду

* Виправлення багів
  
* Додати можливість завантажувати відеороліки на сайт</p>

<h2>Використані технології</h2>
<p>

 
  * HTML/CSS: Використання HTML та CSS для розробки фронтенду веб-сайту.
 
  * AJAX-синхронний обміну даними між клієнтом та сервером без перезавантаження сторінки.
    
  * MySQLi (MySQL Improved) - це розширення PHP, яке додає в мову повну підтримку баз даних MySQL
    
  * phpMyAdmin - це вільне програмне забезпечення, що дозволяє керувати MySQL через веб-браузер.
    
  * Розширення PHP GD – це бібліотека, що надає функції для роботи із зображеннями у PHP

  * Модуль mod_rewrite в Apache для переписування URL-адрес. Це дозволяє створювати ‘чисті’ URL-адреси, які легше читаються людьми і пошуковими системами 
  
  * Git i GitHub: Сервіси для створення та підтримки віддалених репозиторіїв та контролю версій продукту.
Figma: Інструмент веб-дизайну.
  * Query - це бібліотека JavaScript, яка зосереджується на спрощенні та полегшенні роботи з веб-розробкою. 
    
</p>

<h2>Лабораторна робота 2</h2> 

8 окремих сторінок з 1 чи більше інтегрованими компонентами(login.php,edit.php,profile.php,signup.php,signle_post.php,notifications.php,index.php,messages.php),28 елементів керування власного створення, 24 обробників подій,



<h2>Використані джерела</h2>
Звичайно, для створення проекту було використано багато навчальних джерел. Ось основні з них, що допомогли мені написати свій код:

* https://www.youtube.com/playlist?list=PLY3j36HMSHNWaKUC73RJlwi6oU-WTpTPM

* https://www.php.net/manual/en/book.mysqli.php

* https://www.php.net/manual/en/book.image.php
  
* https://api.jquery.com/
  
* https://www.phpmyadmin.net/docs/

* https://httpd.apache.org/docs/2.4/mod/mod_rewrite.html

