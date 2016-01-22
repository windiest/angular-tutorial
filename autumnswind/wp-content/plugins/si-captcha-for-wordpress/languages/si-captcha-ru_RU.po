msgid ""
msgstr ""
"Project-Id-Version: SI Captcha 1.6\n"
"Report-Msgid-Bugs-To: http://wordpress.org/tag/si-captcha-for-wordpress\n"
"POT-Creation-Date: 2008-12-14 17:48+0000\n"
"PO-Revision-Date: 2009-05-29 13:18+0300\n"
"Last-Translator: Neponyatka & Nelius <http://translate.nelius.in>\n"
"Language-Team: Neponyatka & Nelius <http://translate.nelius.in>\n"
"MIME-Version: 1.0\n"
"Content-Type: text/plain; charset=UTF-8\n"
"Content-Transfer-Encoding: 8bit\n"
"X-Poedit-Language: Russian\n"
"X-Poedit-Country: RUSSIAN FEDERATION\n"

# For Nelius version, where Options link moved into Options menu section.
#: si-captcha.php:38
#: si-captcha.php:99
msgid "SI Captcha Options"
msgstr "SI Captcha"

#: si-captcha.php:62
msgid "You do not have permissions for managing this option"
msgstr "У вас недостаточно прав для изменения данной опции"

#: si-captcha.php:96
msgid "Options saved."
msgstr "Настройки сохранены."

#: si-captcha.php:102
msgid "Your theme must have a"
msgstr "Ваша тема должна содержать строку"

#: si-captcha.php:102
msgid "tag inside your comments.php form. Most themes do."
msgstr "в файле формы &laquo;comments.php&raquo;. Большинство тем содержат эту строку и не нуждаются в редактировании."

#: si-captcha.php:103
msgid "The best place to locate the tag is before the comment textarea, you may want to move it if it is below the comment textarea, or the captcha image and captcha code entry might display after the submit button."
msgstr "Лучшее всего  расположить этот тег до текстового поля (textarea) комментария. Вы должны переместить тег если он находится после текстового поля, иначе captcha изображение может отображаться после кнопки отправки комментария."

#: si-captcha.php:115
msgid "CAPTCHA on Register Form:"
msgstr "CAPTCHA в форме регистрации:"

#: si-captcha.php:119
msgid "Enable CAPTCHA on the register form."
msgstr "Включить CAPTCHA для формы регистрации."

#: si-captcha.php:124
msgid "CAPTCHA on Comment Form:"
msgstr "CAPTCHA в форме добавления комментария:"

#: si-captcha.php:127
msgid "Enable CAPTCHA on the comment form."
msgstr "Включить CAPTCHA для формы комментария."

#: si-captcha.php:130
msgid "Hide CAPTCHA for"
msgstr "Скрыть CAPTCHA для"

#: si-captcha.php:131
msgid "registered"
msgstr "зарегистрированных"

#: si-captcha.php:132
msgid "users who can:"
msgstr "пользователей которые могут:"

#: si-captcha.php:135
msgid "CSS class name for CAPTCHA input field on the comment form"
msgstr "Имя CSS класса для поля ввода CAPTCHA в форме комментария"

#: si-captcha.php:136
msgid "(Enter a CSS class name only if your theme uses one for comment text inputs. Default is blank for none.)"
msgstr "(Вводите имя CSS класса только если ваша текущая тема использует собственные классы для текстовых полей. По умолчанию не указанно.)"

#: si-captcha.php:141
msgid "Comment Form Rearrange:"
msgstr "Авто-изменение формы комментария: (не рекомендуется)"

#: si-captcha.php:145
msgid "Change the display order of the catpcha input field on the comment form. (see note below)."
msgstr "Измените порядок отображения поля ввода captcha в форме комментария. (см. пояснение внизу страницы)"

#: si-captcha.php:152
msgid "Problem:"
msgstr "Проблема:"

#: si-captcha.php:153
msgid "Sometimes the captcha image and captcha input field are displayed AFTER the submit button on the comment form."
msgstr "Иногда captcha изображение и текстовое поле отображаются после кнопки отправки комментария."

#: si-captcha.php:154
msgid "Fix:"
msgstr "Решение:"

#: si-captcha.php:155
msgid "Edit your current theme comments.php file and locate this line:"
msgstr "Откройте файл &laquo;comments.php&raquo; вашей текущей темы в редакторе и найдите следующую строку: "

#: si-captcha.php:157
msgid "This tag is exactly where the captcha image and captcha code entry will display on the form, so move the line to BEFORE the comment textarea, uncheck the option box above, and the problem should be fixed."
msgstr "Captcha изображение и поле ввода кода будут отображаться именно в этом месте, поместите эту строку до текстового поля (textarea) комментария, выключите опцию авто-изменения формы комментария, после этого проблема должна быть решена."

#: si-captcha.php:158
msgid "Alernately you can just check the box above and javascript will attempt to rearrange it for you, but editing the comments.php, moving the tag, and unchecking this box is the best solution."
msgstr "В качестве альтернативы вы можете просто включить соответствующую опцию, и плагин попробует переместить поле ввода автоматически с использованием JavaScript, но лучшее решение - это отредактировать файл формы комментария, переместить тег и выключить опцию."

#: si-captcha.php:159
msgid "Why is it better to uncheck this and move the tag? because the XHTML will no longer validate on the comment page if it is checked."
msgstr "Почему лучше выключить эту опцию и отредактировать файл темы? Потому что если эта опция включена, то страница с формой комментария не будет проходить XHTML валидацию."

#: si-captcha.php:162
msgid "Update Options"
msgstr "Сохранить изменения"

#: si-captcha.php:172
msgid "All registered users"
msgstr "Все зарегистрированные пользователи"

#: si-captcha.php:173
msgid "Edit posts"
msgstr "Редактировать посты"

#: si-captcha.php:174
msgid "Publish Posts"
msgstr "Публиковать посты"

#: si-captcha.php:175
msgid "Moderate Comments"
msgstr "Модерировать Комментарии"

#: si-captcha.php:176
msgid "Administer site"
msgstr "Администрировать сайт"

#: si-captcha.php:195
msgid "ERROR: si-captcha.php plugin says GD image support not detected in PHP!"
msgstr "ОШИБКА: Плагин &laquo;si-captcha.php&raquo; обнаружил, отсутствие поддержки GD image в PHP!"

#: si-captcha.php:196
msgid "Contact your web host and ask them why GD image support is not enabled for PHP."
msgstr "Свяжитесь с администратором вашего сервера или хостинга и выясните, почему не включена поддержка GD image в PHP."

#: si-captcha.php:200
msgid "ERROR: si-captcha.php plugin says imagepng function not detected in PHP!"
msgstr "Ошибка: Плагин &laquo;si-captcha.php&raquo; не может найти функцию &laquo;imagepng&raquo; в PHP!"

#: si-captcha.php:201
msgid "Contact your web host and ask them why imagepng function is not enabled for PHP."
msgstr "Свяжитесь с администратором вашего сервера или хостинга и выясните, почему функция &laquo;imagepng&raquo; недоступна в PHP."

#: si-captcha.php:205
msgid "ERROR: si-captcha.php plugin says captcha_library not found."
msgstr "ERROR: Плагин &laquo;si-captcha.php&raquo; не может найти &laquo;captcha_library&raquo;, какой ужас!"

#: si-captcha.php:240
#: si-captcha.php:302
msgid "CAPTCHA Image"
msgstr "CAPTCHA изображение"

#: si-captcha.php:241
#: si-captcha.php:303
msgid "Audible Version of CAPTCHA"
msgstr "Версия CAPTCHA для прослушивания"

#: si-captcha.php:242
#: si-captcha.php:304
msgid "Audio Version"
msgstr "Аудио версия"

#: si-captcha.php:244
#: si-captcha.php:306
msgid "Refresh Image"
msgstr "Обновить изображение"

#: si-captcha.php:246
#: si-captcha.php:308
msgid "Reload Image"
msgstr "Перезагрузить изображение"

#: si-captcha.php:257
#: si-captcha.php:313
msgid "CAPTCHA Code (required)"
msgstr "CAPTCHA код (обязательно)"

#: si-captcha.php:275
msgid "Submit Comment"
msgstr "Отправить комментарий"

#: si-captcha.php:327
#: si-captcha.php:341
#: si-captcha.php:351
#: si-captcha.php:364
msgid "ERROR"
msgstr "ОШИБКА"

#: si-captcha.php:327
#: si-captcha.php:351
msgid "Please complete the CAPTCHA."
msgstr "Пожалуйста заполните поле CAPTCHA."

#: si-captcha.php:341
#: si-captcha.php:364
msgid "That CAPTCHA was incorrect."
msgstr "CAPTCHA неверна."

#: si-captcha.php:399
msgid "Error: You did not enter a Captcha phrase. Press your browsers back button and try again."
msgstr "Ошибка: Вы не ввели код Captcha. Нажмите кнопку назад в вашем браузере и попробуйте снова."

#: si-captcha.php:411
msgid "Error: You entered in the wrong Captcha phrase. Press your browsers back button and try again."
msgstr "Ошибка: Вы ввели неверный Captcha код. Нажмите кнопку &laquo;назад&raquo; в вашем браузере и попробуйте снова."

