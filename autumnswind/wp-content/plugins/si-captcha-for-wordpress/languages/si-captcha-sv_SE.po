# SI CAPTCHA
# This file is put in the public domain.
#
# Plugin URI: http://www.642weather.com/weather/scripts-wordpress-captcha.php
# Description: A CAPTCHA to protect comment posts and or registrations in WordPress
# Version: 1.1
# Author: Mike Challis
# Author URI: http://www.642weather.com/weather/scripts.php
#
#
msgid ""
msgstr ""
"Project-Id-Version: 1.3\n"
"Report-Msgid-Bugs-To: http://wordpress.org/tag/si-captcha-for-wordpress\n"
"POT-Creation-Date: 2008-12-14 17:48+0000\n"
"PO-Revision-Date: 2009-05-15 19:07+0100\n"
"Last-Translator: Benct Philip Jonsson <bpj@melroch.se>\n"
"Language-Team: \n"
"MIME-Version: 1.0\n"
"Content-Type: text/plain; charset=utf-8\n"
"Content-Transfer-Encoding: 8bit\n"
"X-Poedit-Language: Swedish\n"
"X-Poedit-Country: SWEDEN\n"

#: si-captcha.php:38
#: si-captcha.php:96
msgid "Captcha Options"
msgstr "Inställningar för CAPTCHA"

#: si-captcha.php:61
msgid "You do not have permissions for managing this option"
msgstr "Du har inte rättigheter för att utföra ändringar här"

#: si-captcha.php:93
msgid "Options saved."
msgstr "Inställningarna har sparats."

#: si-captcha.php:99
msgid "Your theme must have a"
msgstr "Ditt tema måste ha en"

#: si-captcha.php:99
msgid "tag inside your comments.php form. Most themes do."
msgstr "tagg inuti formuläret i filen comments.php.  De flesta teman har det."

#: si-captcha.php:100
msgid "The best place to locate the tag is before the comment textarea, you may want to move it if it is below the comment textarea, or the captcha image and captcha code entry might display after the submit button."
msgstr "Det bästa stället att placera taggen är före kommentar-textfältet.  Du kanske vill flytta den om den är nedanför kommentar-textrutan, annars kanske CAPTCHA-bilden och fältet fär att skriva in CAPTCHA-koden hamnar efter knappen för att skicka kommentaren."

#: si-captcha.php:112
msgid "CAPTCHA on Register Form:"
msgstr "CAPTCHA i registreringsformuläret:"

#: si-captcha.php:116
msgid "Enable CAPTCHA on the register form."
msgstr "Aktivera CAPTCHA i registreringsformuläret."

#: si-captcha.php:122
msgid "CAPTCHA on Comment Form:"
msgstr "CAPTCHA i kommentarformuläret:"

#: si-captcha.php:125
msgid "Enable CAPTCHA on the comment form."
msgstr "Aktivera CAPTCHA i kommentarformuläret."

#: si-captcha.php:128
msgid "Hide CAPTCHA for"
msgstr "Dölj CAPTCHA för"

#: si-captcha.php:129
msgid "registered"
msgstr "registrerade"

#: si-captcha.php:130
msgid "users who can:"
msgstr "användare som kan:"

#: si-captcha.php:137
msgid "Comment Form Rearrange:"
msgstr "Omstrukturering av kommentarformulär:"

#: si-captcha.php:141
msgid "Change the display order of the catpcha input field on the comment form. (see note below)."
msgstr "Ändra ordningsföljden för visning av CAPTCHA-inmatningsfält i kommentarformuläret. (Se beskrivning nedan.)"

#: si-captcha.php:147
msgid "Problem:"
msgstr "Problem:"

#: si-captcha.php:148
msgid "Sometimes the captcha image and captcha input field are displayed AFTER the submit button on the comment form."
msgstr "Ibland visas CAPTCHA-bilden och CAPTCHA-inmatningsfältet i kommentarformuläret EFTER knappen för att skicka kommentaren."

#: si-captcha.php:149
msgid "Fix:"
msgstr "Korrigera:"

#: si-captcha.php:150
msgid "Edit your current theme comments.php file and locate this line:"
msgstr "Redigera filen comments.php i ditt tema och lokalisera följande rad:"

#: si-captcha.php:152
msgid "This tag is exactly where the captcha image and captcha code entry will display on the form, so move the line to BEFORE the comment textarea, uncheck the option box above, and the problem should be fixed."
msgstr "Denna tagg står precis där CAPTCHA-bilden och textfältet för inskrivning av CAPTCHA-koden kommer att visas i formuläret, så flytta denna rad till FÖRE kommentar-textrutan, avmarkera kryssrutan här ovanför, och problemet ska vara löst."

#: si-captcha.php:153
msgid "Alernately you can just check the box above and javascript will attempt to rearrange it for you, but editing the comments.php, moving the tag, and unchecking this box is the best solution."
msgstr "Alternativt kan du bara markera kryssrutan här ovanför och tillägget kommer att försökas att arrangera om fälten åt dig med hjälp av javascript, men att redigera comments.php, flytta taggen och avmarkera kryssrutan är den bästa lösningen."

#: si-captcha.php:154
msgid "Why is it better to uncheck this and move the tag? because the XHTML will no longer validate on the comment page if it is checked."
msgstr "Varför är det bättre att avmarkera denna kryssruta och flytta taggen?  Därför att sidan med kommentarformuläret inte längre kommer att vara giltig XHTML om kryssrutan är markerad."

#: si-captcha.php:157
msgid "Update Options"
msgstr "Uppdaterar inställningarna"

#: si-captcha.php:167
msgid "All registered users"
msgstr "Alla registrerade användare"

#: si-captcha.php:168
msgid "Edit posts"
msgstr "Ändra inlägg"

#: si-captcha.php:169
msgid "Publish Posts"
msgstr "Publicera inlägg"

#: si-captcha.php:170
msgid "Moderate Comments"
msgstr "Moderera kommentarer"

#: si-captcha.php:171
msgid "Administer site"
msgstr "Administrera webbplatsen"

#: si-captcha.php:190
msgid "ERROR: si-captcha.php plugin says GD image support not detected in PHP!"
msgstr "FEL: tillägget si-captcha.php säger att stöd för GD-bilder inte kan hittas i PHP!"

#: si-captcha.php:191
msgid "Contact your web host and ask them why GD image support is not enabled for PHP."
msgstr "Kontakta din webbvärd och fråga varför stöd för GD inte är aktiverat för PHP."

#: si-captcha.php:195
msgid "ERROR: si-captcha.php plugin says imagepng function not detected in PHP!"
msgstr "FEL: tillägget si-captcha.php säger att funktionen imagepng inte kan hittas i PHP."

#: si-captcha.php:196
msgid "Contact your web host and ask them why imagepng function is not enabled for PHP."
msgstr "Kontakta din webbvärd och fråga varför funktionen imagepng inte är aktiverad för PHP."

#: si-captcha.php:200
msgid "ERROR: si-captcha.php plugin says captcha_library not found."
msgstr "FEL: tillägget si-captcha.php säger att captcha_library inte hittades."

#: si-captcha.php:234
#: si-captcha.php:290
msgid "CAPTCHA Image"
msgstr "CAPTCHA-bild"

#: si-captcha.php:235
#: si-captcha.php:291
msgid "Audible Version of CAPTCHA"
msgstr "Ljudfilsversion av CAPTCHA"

#: si-captcha.php:236
#: si-captcha.php:292
msgid "Audio Version"
msgstr "Ljudfilsversion"

#: si-captcha.php:240
#: si-captcha.php:296
msgid "Reload Image"
msgstr "Hämta om bild"

#: si-captcha.php:245
#: si-captcha.php:301
msgid "CAPTCHA Code (required)"
msgstr "Skriv in koden från CAPTCHA-bilden (obligatorisk)"

#: si-captcha.php:263
msgid "Submit Comment"
msgstr "Skicka kommentar"

#: si-captcha.php:294
msgid "Refresh Image"
msgstr "Uppdatera bild"

#: si-captcha.php:314
#: si-captcha.php:328
#: si-captcha.php:338
#: si-captcha.php:351
msgid "ERROR"
msgstr "FEL"

#: si-captcha.php:314
#: si-captcha.php:338
msgid "Please complete the CAPTCHA."
msgstr "Vänligen slutför CAPTCHA-verifieringen"

#: si-captcha.php:328
#: si-captcha.php:351
msgid "That CAPTCHA was incorrect."
msgstr "CAPTCHA-koden du skrev var fel."

#: si-captcha.php:378
msgid "Error: You did not enter a Captcha phrase. Press your browsers back button and try again."
msgstr "FEL: Du skrev inte in någon CAPTCHA-kod.  Tryck på din webbläsares bakåtknapp och försök igen!"

#: si-captcha.php:390
msgid "Error: You entered in the wrong Captcha phrase. Press your browsers back button and try again."
msgstr "FEL: Du skrev in fel CAPTCHA-kod.  Tryck på din webbläsares bakåtknapp och försök igen!"

