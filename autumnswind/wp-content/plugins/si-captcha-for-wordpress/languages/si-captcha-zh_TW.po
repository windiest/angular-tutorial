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
"Project-Id-Version: si-captcha zh_TW Translation\n"
"Report-Msgid-Bugs-To: \n"
"POT-Creation-Date: 2009-09-01 23:38+0800\n"
"PO-Revision-Date: 2009-09-01 23:39+0800\n"
"Last-Translator: CJH <cjh@cjh.cc>\n"
"Language-Team: CJH\n"
"MIME-Version: 1.0\n"
"Content-Type: text/plain; charset=UTF-8\n"
"Content-Transfer-Encoding: 8bit\n"
"Plural-Forms: nplurals=2; plural=n > 1\n"
"X-Poedit-Language: Chinese\n"
"X-Poedit-Country: TAIWAN\n"
"X-Poedit-SourceCharset: utf-8\n"
"X-Poedit-KeywordsList: __;_e;sprintf\n"
"X-Poedit-Basepath: .\n"
"X-Poedit-SearchPath-0: .\n"

#: si-captcha.php:34
#: si-captcha.php:112
msgid "SI Captcha Options"
msgstr "SI Captcha 設定"

#: si-captcha.php:70
msgid "You do not have permissions for managing this option"
msgstr "你沒有調整設定的權限"

#: si-captcha.php:109
msgid "Options saved."
msgstr "設定已儲存"

#: si-captcha.php:124
msgid "Donate"
msgstr "贊助"

#: si-captcha.php:135
msgid "If you find this plugin useful to you, please consider making a small donation to help contribute to further development. Thanks for your kind support!"
msgstr "如果你覺得這個外掛對你很有用，為了幫助軟體後續的開發，請考慮給予贊助。感謝你的支持！"

#: si-captcha.php:139
msgid "Usage"
msgstr "使用說明"

#: si-captcha.php:142
msgid "Your theme must have a"
msgstr "你的佈景主題必須有"

#: si-captcha.php:142
msgid "tag inside your comments.php form. Most themes do."
msgstr "程式碼在comments.php裡面，大部分的佈景主題都有。"

#: si-captcha.php:143
msgid "The best place to locate the tag is before the comment textarea, you may want to move it if it is below the comment textarea, or the captcha image and captcha code entry might display after the submit button."
msgstr "最好將此程式碼放在「輸入回應的文字框」的前一行，如果此程式碼位置錯誤(放在「輸入回應的文字框」之後，或「送出回應」的按鈕之後)，你可能需要自行手動調整"

#: si-captcha.php:146
msgid "Options"
msgstr "設定"

#: si-captcha.php:156
msgid "CAPTCHA Support Test:"
msgstr "CAPTCHA支援測試："

#: si-captcha.php:158
msgid "Test if your PHP installation will support the CAPTCHA"
msgstr "測試你的PHP版本是否支援 CAPTCHA"

#: si-captcha.php:162
msgid "CAPTCHA on Register Form:"
msgstr "註冊帳號頁面使用CAPTCHA："

#: si-captcha.php:165
msgid "Enable CAPTCHA on the register form."
msgstr "在註冊帳號頁面啟用CAPTCHA"

#: si-captcha.php:170
msgid "CAPTCHA on Comment Form:"
msgstr "文章回應頁面使用CAPTCHA："

#: si-captcha.php:173
msgid "Enable CAPTCHA on the comment form."
msgstr "在文章回應頁面啟用CAPTCHA"

#: si-captcha.php:176
msgid "Hide CAPTCHA for"
msgstr "隱藏CAPTCHA檔："

#: si-captcha.php:177
msgid "registered"
msgstr "已註冊"

#: si-captcha.php:178
msgid "users who can:"
msgstr "使用者權限為："

#: si-captcha.php:181
msgid "CSS class name for CAPTCHA input field on the comment form"
msgstr "CAPTCHA 輸入文字框的CSS class名稱"

#: si-captcha.php:182
msgid "(Enter a CSS class name only if your theme uses one for comment text inputs. Default is blank for none.)"
msgstr "(只有在你的佈景主題有針對回應文字框設定CSS class時才填入，預設為空白)"

#: si-captcha.php:187
msgid "Comment Form Rearrange:"
msgstr "自動排列："

#: si-captcha.php:190
msgid "Change the display order of the catpcha input field on the comment form. (see note below)."
msgstr "自動調整留言驗證碼的顯示位置(請看下述說明)"

#: si-captcha.php:194
msgid "Accessibility:"
msgstr "網站親和力："

#: si-captcha.php:197
msgid "Enable aria-required tags for screen readers"
msgstr "針對使用螢幕閱讀器(視力不良者)啟用 aria-required tags"

#: si-captcha.php:198
msgid "Click for Help!"
msgstr "點我讀取說明！"

#: si-captcha.php:198
msgid "help"
msgstr "本項說明"

#: si-captcha.php:200
msgid "aria-required is a form input WAI ARIA tag. Screen readers use it to determine which fields are required. Enabling this is good for accessability, but will cause the HTML to fail the W3C Validation (there is no attribute \"aria-required\"). WAI ARIA attributes are soon to be accepted by the HTML validator, so you can safely ignore the validation error it will cause."
msgstr "aria-required 是一個表單輸入的 WAI ARIA tag. 視力不良者利用此判斷那個欄位是必填的。啟用此設定有助於提高網站親和力，但會造成HTML的W3C驗證失敗(因為沒有屬性叫做 \"aria-required\"). WAI ARIA 屬性很快的會被HTML驗證器所接受，所以你可以安全的忽視掉驗證錯誤的問題。"

#: si-captcha.php:207
msgid "Problem:"
msgstr "已知問題："

#: si-captcha.php:208
msgid "Sometimes the captcha image and captcha input field are displayed AFTER the submit button on the comment form."
msgstr "有時留言驗證碼的輸入框，會跑到「送出回應」的按鈕之後"

#: si-captcha.php:209
msgid "Fix:"
msgstr "如何修正："

#: si-captcha.php:210
msgid "Edit your current theme comments.php file and locate this line:"
msgstr "編輯目前使用的佈景主題內的 comments.php 檔案，並搜尋下面這行程式碼："

#: si-captcha.php:212
msgid "This tag is exactly where the captcha image and captcha code entry will display on the form, so move the line to BEFORE the comment textarea, uncheck the option box above, and the problem should be fixed."
msgstr "這行程式碼就是留言驗證碼會顯示的位置，只要將其移動到「輸入回應的文字框」之前，並取消勾選上面「自動排列」的選項，此問題即可修正"

#: si-captcha.php:213
msgid "Alernately you can just check the box above and javascript will attempt to rearrange it for you, but editing the comments.php, moving the tag, and unchecking this box is the best solution."
msgstr "或者你也可以只選取上面「自動排列」的選項，javascript程式會嘗試調整位置，但直接以手動調整comments.php裡面的程式碼順序，才是最佳的解決方式"

#: si-captcha.php:214
msgid "Why is it better to uncheck this and move the tag? because the XHTML will no longer validate on the comment page if it is checked."
msgstr "為何手動調整程式碼較好呢？因為若「自動排列」選項啟動，則在comment頁面不會執行XHTML驗證"

#: si-captcha.php:217
msgid "Update Options"
msgstr "儲存設定"

#: si-captcha.php:227
msgid "All registered users"
msgstr "所有已註冊的使用者"

#: si-captcha.php:228
msgid "Edit posts"
msgstr "可修改文章"

#: si-captcha.php:229
msgid "Publish Posts"
msgstr "可發表文章"

#: si-captcha.php:230
msgid "Moderate Comments"
msgstr "可管理回應"

#: si-captcha.php:231
msgid "Administer site"
msgstr "網站管理員"

#: si-captcha.php:249
msgid "ERROR: si-captcha.php plugin says GD image support not detected in PHP!"
msgstr "錯誤：偵測到目前PHP版本不支援GD image模組"

#: si-captcha.php:250
msgid "Contact your web host and ask them why GD image support is not enabled for PHP."
msgstr "聯絡你的主機商，詢問為何主機PHP版本不支援 GD image模組"

#: si-captcha.php:254
msgid "ERROR: si-captcha.php plugin says imagepng function not detected in PHP!"
msgstr "錯誤：偵測到目前PHP版本不支援 imagepng 函式"

#: si-captcha.php:255
msgid "Contact your web host and ask them why imagepng function is not enabled for PHP."
msgstr "聯絡你的主機商，詢問為何主機PHP版本不支援  imagepng 函式"

#: si-captcha.php:259
msgid "ERROR: si-captcha.php plugin says captcha_library not found."
msgstr "錯誤： 沒有找到captcha程式庫(captcha_library)"

#: si-captcha.php:300
#: si-captcha.php:368
msgid "CAPTCHA Image"
msgstr "CAPTCHA 驗證圖片"

#: si-captcha.php:301
#: si-captcha.php:369
msgid "Audible Version of CAPTCHA"
msgstr "CAPTCHA的語音版本"

#: si-captcha.php:302
#: si-captcha.php:370
msgid "Audio Version"
msgstr "語音版本"

#: si-captcha.php:304
#: si-captcha.php:372
msgid "Refresh Image"
msgstr "更換一張圖片"

#: si-captcha.php:306
#: si-captcha.php:374
msgid "Reload Image"
msgstr "重新載入圖片"

#: si-captcha.php:317
#: si-captcha.php:379
msgid "CAPTCHA Code (required)"
msgstr "留言驗證碼(必須填寫)"

#: si-captcha.php:335
msgid "Submit Comment"
msgstr "送出回應"

#: si-captcha.php:393
#: si-captcha.php:397
#: si-captcha.php:410
#: si-captcha.php:421
#: si-captcha.php:425
#: si-captcha.php:436
#: si-captcha.php:470
msgid "ERROR"
msgstr "錯誤"

#: si-captcha.php:393
#: si-captcha.php:421
#: si-captcha.php:470
msgid "Could not read CAPTCHA cookie. Make sure you have cookies enabled and not blocking in your web browser settings. Or another plugin is conflicting. See plugin FAQ."
msgstr "無法讀取 CAPTCHA cookie。請確認瀏覽器設定已啟用且沒有阻擋cookie功能，也有可能是其他plugin衝突所造成。請參考plugin FAQ。"

#: si-captcha.php:397
#: si-captcha.php:425
msgid "Please complete the CAPTCHA."
msgstr "請輸入完整的驗證碼"

#: si-captcha.php:410
#: si-captcha.php:436
msgid "That CAPTCHA was incorrect. Make sure you have not disabled cookies."
msgstr "輸入的CAPTCHA驗證碼不正確。請確定你沒有停用cookies功能"

#: si-captcha.php:473
msgid "Error: You did not enter a Captcha phrase. Press your browsers back button and try again."
msgstr "錯誤：沒有輸入任何留言驗證碼，請回到上一頁重新輸入"

#: si-captcha.php:484
msgid "Error: You entered in the wrong Captcha phrase. Press your browsers back button and try again."
msgstr "錯誤：輸入的留言驗證碼不正確，請回到上一頁重新輸入"

#: si-captcha.php:494
msgid "Settings"
msgstr "設定"

