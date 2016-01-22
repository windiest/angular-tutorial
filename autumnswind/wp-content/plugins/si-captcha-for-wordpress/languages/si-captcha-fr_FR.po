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
"Project-Id-Version: si-captcha 1.1\n"
"Report-Msgid-Bugs-To: http://wordpress.org/tag/si-captcha-for-wordpress\n"
"POT-Creation-Date: 2008-11-22 04:20+0000\n"
"PO-Revision-Date: 2008-12-14 12:00+0100\n"
"Last-Translator: Pierre\n"
"Language-Team: Pierre\n"
"MIME-Version: 1.0\n"
"Content-Type: text/plain; charset=utf-8\n"
"Content-Transfer-Encoding: 8bit\n"
"Plural-Forms: nplurals=2; plural=n > 1\n"
"X-Poedit-Language: French\n"
"X-Poedit-Country: FRANCE\n"
"X-Poedit-SourceCharset: utf-8\n"
"X-Poedit-KeywordsList: __;_e;sprintf\n"
"X-Poedit-Basepath: .\n"
"X-Poedit-SearchPath-0: .\n"
"X-Poedit-SearchPath-1: ./captcha-secureimage\n"

#: si-captcha.php:38
#: si-captcha.php:96
msgid "Captcha Options"
msgstr "Options du Captcha"

#: si-captcha.php:61
msgid "You do not have permissions for managing this option"
msgstr "Vous n'avez pas les droits nécessaires pour gérer cette option"

#: si-captcha.php:93
msgid "Options saved."
msgstr "Options sauvegardées."

#: si-captcha.php:99
msgid "Your theme must have a"
msgstr "Votre thème doit avoir la balise"

#: si-captcha.php:99
msgid "tag inside your comments.php form. Most themes do."
msgstr "dans votre formulaire comment.php. La plupart l'ont. "

#: si-captcha.php:100
msgid "The best place to locate the tag is before the comment textarea, you may want to move it if it is below the comment textarea, or the captcha image and captcha code entry might display after the submit button."
msgstr "Le meilleur endroit pour placer la balise est avant la zone de texte de commentaire, vous pouvez vouloir la placer sous celle-ci ou l'image captcha et le la zone de saisie du code peuvent être affiché après le bouton d'envoi."

#: si-captcha.php:112
msgid "CAPTCHA on Register Form:"
msgstr "CAPTCHA sur le formulaire d'inscription :"

#: si-captcha.php:116
msgid "Enable CAPTCHA on the register form."
msgstr "Activer le CAPTCHA sur le formulaire d'inscription."

#: si-captcha.php:122
msgid "CAPTCHA on Comment Form:"
msgstr "CAPTCHA sur le formulaire de commentaire :"

#: si-captcha.php:125
msgid "Enable CAPTCHA on the comment form."
msgstr "Activer le CAPTCHA sur le formulaire de commentaire."

#: si-captcha.php:128
msgid "Hide CAPTCHA for"
msgstr "Cacher le CAPTCHA pour"

#: si-captcha.php:129
msgid "registered"
msgstr "les utilisateurs enregistrés"

#: si-captcha.php:130
msgid "users who can:"
msgstr "qui peuvent :"

#: si-captcha.php:137
msgid "Comment Form Rearrange:"
msgstr "Ré-arrangement du formulaire de commentaire :"

#: si-captcha.php:141
msgid "Change the display order of the catpcha input field on the comment form. (see note below)."
msgstr "Changer l'ordre d'affichage du champ du captcha sur le formulaire de commentaire. (voir les infos ci-dessous)."

#: si-captcha.php:147
msgid "Problem:"
msgstr "Problème :"

#: si-captcha.php:148
msgid "Sometimes the captcha image and captcha input field are displayed AFTER the submit button on the comment form."
msgstr "Parfois l'image du captcha et le champ sont affichés APRES le bouton envoi du formulaire de commentaire."

#: si-captcha.php:149
msgid "Fix:"
msgstr "Pour corriger :"

#: si-captcha.php:150
msgid "Edit your current theme comments.php file and locate this line:"
msgstr "Editez le fichier comment.php de votre thème actuel et localisez cette ligne :"

#: si-captcha.php:152
msgid "This tag is exactly where the captcha image and captcha code entry will display on the form, so move the line to BEFORE the comment textarea, uncheck the option box above, and the problem should be fixed."
msgstr "Cette balise est a l'emplacement exact où l'image et la zone de saisie du captcha seront affichées sur le formulaire, déplcez la ligne AVANT la zone de texte de commentaire, décochez cette case d'option et le problème devrait être corrigé."

#: si-captcha.php:153
msgid "Alernately you can just check the box above and javascript will attempt to rearrange it for you, but editing the comments.php, moving the tag, and unchecking this box is the best solution."
msgstr "Alternativement vous pouvez juste cocher cette case et le javascript essayera de tout ré-arranger pour vous, mais éditer le fichier comment.php, en déplaçant la balise et endécochant cette case est la meilleure solution."

#: si-captcha.php:154
msgid "Why is it better to uncheck this and move the tag? because the XHTML will no longer validate on the comment page if it is checked."
msgstr "Pourquoi est-il préférable de décocher cette option et de déplacer la balise ?Parce que le XHTML ne sera plus valide sur votre page de commentaire si cette option est cochée."

#: si-captcha.php:157
msgid "Update Options"
msgstr "Mettre à jour les Options"

#: si-captcha.php:167
msgid "All registered users"
msgstr "Tous les utilisateurs enregistrés"

#: si-captcha.php:168
msgid "Edit posts"
msgstr "Editer les billets"

#: si-captcha.php:169
msgid "Publish Posts"
msgstr "Publier des Billets"

#: si-captcha.php:170
msgid "Moderate Comments"
msgstr "Modérer les Commentaires"

#: si-captcha.php:171
msgid "Administer site"
msgstr "Administrer le site"

#: si-captcha.php:190
msgid "ERROR: si-captcha.php plugin says GD image support not detected in PHP!"
msgstr "ERREUR : le plugin si-captcha signale que le support de la librairie image GD n'est pas détécté dans le PHP !"

#: si-captcha.php:191
msgid "Contact your web host and ask them why GD image support is not enabled for PHP."
msgstr "Contactez votre hébergeur et demandez pourquoi le support de la librairie image GD n'est pas activé pour PHP."

#: si-captcha.php:195
msgid "ERROR: si-captcha.php plugin says imagepng function not detected in PHP!"
msgstr "ERREUR : le plugin si-captcha signale que la fonction imagepng n'est pas détectée dans PHP !"

#: si-captcha.php:196
msgid "Contact your web host and ask them why imagepng function is not enabled for PHP."
msgstr "Contactez votre hébergeur et demandez lui pourquoi la fonction imagepng n'est pas activée pour le PHP"

#: si-captcha.php:200
msgid "ERROR: si-captcha.php plugin says captcha_library not found."
msgstr "ERREUR : le plugin si-captcha signale que captcha_library est introuvable."

#: si-captcha.php:234
#: si-captcha.php:290
msgid "CAPTCHA Image"
msgstr "Image CAPTCHA"

#: si-captcha.php:235
#: si-captcha.php:291
msgid "Audible Version of CAPTCHA"
msgstr "Version audible du CAPTCHA"

#: si-captcha.php:236
#: si-captcha.php:292
msgid "Audio Version"
msgstr "Version Audio"

#: si-captcha.php:240
#: si-captcha.php:296
msgid "Reload Image"
msgstr "Recharger l'image"

#: si-captcha.php:245
#: si-captcha.php:301
msgid "CAPTCHA Code (required)"
msgstr "Code CAPTCHA (nécessaire)"

#: si-captcha.php:294
msgid "Refresh Image"
msgstr "Rafraîchir l'image"

#: si-captcha.php:314
#: si-captcha.php:328
#: si-captcha.php:338
#: si-captcha.php:351
msgid "ERROR"
msgstr "ERREUR"

#: si-captcha.php:314
#: si-captcha.php:338
msgid "Please complete the CAPTCHA."
msgstr "Compléter le CAPTCHA svp."

#: si-captcha.php:328
#: si-captcha.php:351
msgid "That CAPTCHA was incorrect."
msgstr "Ce CAPTCHA est incorrect."

#: si-captcha.php:378
msgid "Error: You did not enter a Captcha phrase. Press your browsers back button and try again."
msgstr "Erreur : Vous n'avez pas saisit la phrase du Captcha. Appuyez sur le bouton page précédente de votre navigateur et ré-essayez."

#: si-captcha.php:390
msgid "Error: You entered in the wrong Captcha phrase. Press your browsers back button and try again."
msgstr "Erreur : Vous avez commis une faute dans la phrase du Captcha. Appuyez sur le bouton page précédente de votre navigateur et ré-essayez."

