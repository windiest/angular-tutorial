# SI CAPTCHA
# This file is put in the public domain.
#
# Plugin URI: http://www.642weather.com/weather/scripts-wordpress-captcha.php
# Description: A CAPTCHA to protect comment posts and or registrations in WordPress
# Version: 1.6
# Author: Mike Challis
# Author URI: http://www.642weather.com/weather/scripts.php
#
#
msgid ""
msgstr ""
"Project-Id-Version: 1.6\n"
"Report-Msgid-Bugs-To: http://wordpress.org/tag/si-captcha-for-wordpress\n"
"POT-Creation-Date: 2008-12-14 17:48+0000\n"
"PO-Revision-Date: 2009-07-24 23:49+0100\n"
"Last-Translator: Tomasz Ziółczyński <tomasz@ziolczynski.pl>\n"
"Language-Team:  <tomasz@ziolczynski.pl>\n"
"MIME-Version: 1.0\n"
"Content-Type: text/plain; charset=utf-8\n"
"Content-Transfer-Encoding: 8bit\n"
"X-Poedit-Language: Polish\n"
"X-Poedit-Country: POLAND\n"
"X-Poedit-SourceCharset: utf-8\n"

#: si-captcha.php:38
#: si-captcha.php:99
msgid "SI Captcha Options"
msgstr "Opcje SI CAPTCHA"

#: si-captcha.php:62
msgid "You do not have permissions for managing this option"
msgstr "Nie masz uprawnień do zarządzania tą opcją"

#: si-captcha.php:96
msgid "Options saved."
msgstr "Opcje zapisane."

#: si-captcha.php:102
msgid "Your theme must have a"
msgstr "Twój template musi zawierać linię"

#: si-captcha.php:102
msgid "tag inside your comments.php form. Most themes do."
msgstr "w pliku comments.php twojego templatu. Większość tempatów zawiera taką linię."

#: si-captcha.php:103
msgid "The best place to locate the tag is before the comment textarea, you may want to move it if it is below the comment textarea, or the captcha image and captcha code entry might display after the submit button."
msgstr "Najlepszą lokalizacją dla CAPTCHY jest miejsce przed polem gdzie wpisywany jest komentarz, najprawdopodobniej będziesz chciał przesunąć CAPTCHĘ w to miejsce jeśli będzie pojawiać się niżej, poniżej przycisku wyślij. "

#: si-captcha.php:115
msgid "CAPTCHA on Register Form:"
msgstr "CAPTCHA na formularzu rejestracji:"

#: si-captcha.php:119
msgid "Enable CAPTCHA on the register form."
msgstr "Aktywuj CAPTCHE dla formularza rejestracji."

#: si-captcha.php:124
msgid "CAPTCHA on Comment Form:"
msgstr "CAPTCHA na formularzu komentarza."

#: si-captcha.php:127
msgid "Enable CAPTCHA on the comment form."
msgstr "Aktywuj CAPTCHE dla pola komentarza."

#: si-captcha.php:130
msgid "Hide CAPTCHA for"
msgstr "Ukryj CAPTCHE dla:"

#: si-captcha.php:131
msgid "registered"
msgstr "zarejestrowany"

#: si-captcha.php:132
msgid "users who can:"
msgstr "użytkownicy którzy mogą:"

#: si-captcha.php:135
msgid "CSS class name for CAPTCHA input field on the comment form"
msgstr "Klasa CSS dla pola tekstowego CAPTCHY w  formularzu komentarza"

#: si-captcha.php:136
msgid "(Enter a CSS class name only if your theme uses one for comment text inputs. Default is blank for none.)"
msgstr "(Podaj klasę CSS tylko wtedy,jeśli template używa jakiejś dla pole wprowadzania komentarza. Domyślna wartość: puste pole.)"

#: si-captcha.php:141
msgid "Comment Form Rearrange:"
msgstr "Rearanżacja formulaża komentarzy."

#: si-captcha.php:145
msgid "Change the display order of the catpcha input field on the comment form. (see note below)."
msgstr "Zmień położenie CAPTCHY w polu komentarza (patrz uwagę poniżej)"

#: si-captcha.php:152
msgid "Problem:"
msgstr "Problem:"

#: si-captcha.php:153
msgid "Sometimes the captcha image and captcha input field are displayed AFTER the submit button on the comment form."
msgstr "Czasami CAPTCHA jest wyświetlana poniżej przycisku wyślij w polu komentarza."

#: si-captcha.php:154
msgid "Fix:"
msgstr "Rozwiązanie:"

#: si-captcha.php:155
msgid "Edit your current theme comments.php file and locate this line:"
msgstr "Otwórz plik comments.php swojego formularza i znajdź linię:"

#: si-captcha.php:157
msgid "This tag is exactly where the captcha image and captcha code entry will display on the form, so move the line to BEFORE the comment textarea, uncheck the option box above, and the problem should be fixed."
msgstr "Ten tag wskazuje miejsce gdzie wyświetlii się CAPTCHA. Przenieś tą linię nad pole gdzie wpisywany jest komentarz, odznacz powyższą opcję. Problem powinien zostać rozwiązany."

#: si-captcha.php:158
msgid "Alernately you can just check the box above and javascript will attempt to rearrange it for you, but editing the comments.php, moving the tag, and unchecking this box is the best solution."
msgstr "Jako alternatywę możesz wykorzystać zaznaczenie powyższej opcji. Javascrip przearanżuje położenie. Jednak najlepszym wyjściem jest edycja comments.php, przeniesienie tagu i odznaczenie tej opcji."

#: si-captcha.php:159
msgid "Why is it better to uncheck this and move the tag? because the XHTML will no longer validate on the comment page if it is checked."
msgstr "Dlaczego lepiej jest odznaczyć tą opcję i przesunąć linię kodu w inne miejsce? Ponieważ, gdy zaznaczona jest ta opcja walidator XHTML nie zweryfikuje pozytywnie strony."

#: si-captcha.php:162
msgid "Update Options"
msgstr "Zapisz opcje"

#: si-captcha.php:172
msgid "All registered users"
msgstr "Wszyscy zarejestrowani użytkownicy"

#: si-captcha.php:173
msgid "Edit posts"
msgstr "Edytuj wypowiedź"

#: si-captcha.php:174
msgid "Publish Posts"
msgstr "Publikuj wypowiedź"

#: si-captcha.php:175
msgid "Moderate Comments"
msgstr "Moderuj komentarze"

#: si-captcha.php:176
msgid "Administer site"
msgstr "Zarządzanie stroną"

#: si-captcha.php:195
msgid "ERROR: si-captcha.php plugin says GD image support not detected in PHP!"
msgstr "BŁĄD: wtyczka si-captcha.php nie wykryła wsparcia GD dla obrazów w PHP!"

#: si-captcha.php:196
msgid "Contact your web host and ask them why GD image support is not enabled for PHP."
msgstr "Skontaktuj się ze swoim hostingiem i zapytaj dlaczego wsparcie GD dla oprazów w PHP nie jest aktywowane."

#: si-captcha.php:200
msgid "ERROR: si-captcha.php plugin says imagepng function not detected in PHP!"
msgstr "BŁĄD: wtyczka si-captcha.php nie wykryła funkcji imagepng w PHP!"

#: si-captcha.php:201
msgid "Contact your web host and ask them why imagepng function is not enabled for PHP."
msgstr "Skontaktuj się z hostingiem i zadaj pytanie dlaczego funkcja imagepng jest wyłączona dla PHP."

#: si-captcha.php:205
msgid "ERROR: si-captcha.php plugin says captcha_library not found."
msgstr "BŁĄD: wtyczka si-captcha.php zwraca błąd, captcha_library nieodnaleziona."

#: si-captcha.php:240
#: si-captcha.php:302
msgid "CAPTCHA Image"
msgstr "Obraz CAPTCHY"

#: si-captcha.php:241
#: si-captcha.php:303
msgid "Audible Version of CAPTCHA"
msgstr "Dźwięowa wersja CAPTCHY"

#: si-captcha.php:242
#: si-captcha.php:304
msgid "Audio Version"
msgstr "Wercja dźwiękowa"

#: si-captcha.php:244
#: si-captcha.php:306
msgid "Refresh Image"
msgstr "Odśwież obrazek"

#: si-captcha.php:246
#: si-captcha.php:308
msgid "Reload Image"
msgstr "Przeładuj obrazek"

#: si-captcha.php:257
#: si-captcha.php:313
msgid "CAPTCHA Code (required)"
msgstr "Kod CAPTCHA (wymagany)"

#: si-captcha.php:275
msgid "Submit Comment"
msgstr "Wyślij komentarz"

#: si-captcha.php:327
#: si-captcha.php:341
#: si-captcha.php:351
#: si-captcha.php:364
msgid "ERROR"
msgstr "BŁĄD"

#: si-captcha.php:327
#: si-captcha.php:351
msgid "Please complete the CAPTCHA."
msgstr "Proszę wypełnich CAPTCHE"

#: si-captcha.php:341
#: si-captcha.php:364
msgid "That CAPTCHA was incorrect."
msgstr "CAPTCHA jest nieprawidłowa"

#: si-captcha.php:399
msgid "Error: You did not enter a Captcha phrase. Press your browsers back button and try again."
msgstr "BŁĄD: Nie wprowadziłeś z obraka CAPTCHA. Proszę kliknij wstecz i spróbuj ponownie."

#: si-captcha.php:411
msgid "Error: You entered in the wrong Captcha phrase. Press your browsers back button and try again."
msgstr "BŁĄD: Wprowadzono niepoprawną frazę z obraka CAPTCHA. Proszę kliknij wstecz i spróbuj ponownie."

