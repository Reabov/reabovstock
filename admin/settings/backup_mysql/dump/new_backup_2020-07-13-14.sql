--2020-07-13 17:37:13
DROP TABLE IF EXISTS ws_backup_mysql;

CREATE TABLE `ws_backup_mysql` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `add_date` datetime NOT NULL,
  `rec_date` datetime NOT NULL,
  `del_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO ws_backup_mysql VALUES("1","1","new_backup_2018-05-28-14.sql","2018-05-28 17:04:26","0000-00-00 00:00:00","0000-00-00 00:00:00");



DROP TABLE IF EXISTS ws_cities;

CREATE TABLE `ws_cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_ru` varchar(64) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '500',
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO ws_cities VALUES("1","Кишинев","500","1");



DROP TABLE IF EXISTS ws_cpu;

CREATE TABLE `ws_cpu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `cpu` varchar(384) NOT NULL,
  `lang` varchar(2) NOT NULL,
  `elem_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO ws_cpu VALUES("1","3","/ajax/ru/","ru","");
INSERT INTO ws_cpu VALUES("2","1","/","ru","");



DROP TABLE IF EXISTS ws_inteface_lang;

CREATE TABLE `ws_inteface_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(2) NOT NULL,
  `title` varchar(32) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO ws_inteface_lang VALUES("2","ru","Русский","1");



DROP TABLE IF EXISTS ws_inteface_lang_content;

CREATE TABLE `ws_inteface_lang_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0-общие для всех проектов, 1 - индивидуальные',
  `code` varchar(64) NOT NULL,
  `text` text NOT NULL,
  `comment` tinytext NOT NULL,
  `lang` varchar(2) NOT NULL DEFAULT 'en',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=138 DEFAULT CHARSET=utf8;

INSERT INTO ws_inteface_lang_content VALUES("1","","ACCOUNT_IS_BLOCKED","Your account has been suspended","","ru");
INSERT INTO ws_inteface_lang_content VALUES("3","","LOGIN_TO_START","Sign in to start your session","","ru");
INSERT INTO ws_inteface_lang_content VALUES("4","","YOUR_LOGIN","Your login","","ru");
INSERT INTO ws_inteface_lang_content VALUES("5","","PASSWORD","Password","","ru");
INSERT INTO ws_inteface_lang_content VALUES("6","","LOGIN_BTN","Login","Login button","ru");
INSERT INTO ws_inteface_lang_content VALUES("7","","INVALID_LOGIN_OR_PASS","Invalid login or password","","ru");
INSERT INTO ws_inteface_lang_content VALUES("8","","INVALID_CAPTCHA","Invalid captcha code","","ru");
INSERT INTO ws_inteface_lang_content VALUES("9","","CONTROL_PANEL","Control panel","","ru");
INSERT INTO ws_inteface_lang_content VALUES("10","","STUDIO_WEBMASTER_CP","Studio Webmaster","","ru");
INSERT INTO ws_inteface_lang_content VALUES("11","","AUTHORIZED","Authorized","","ru");
INSERT INTO ws_inteface_lang_content VALUES("12","","PROFILE","Profile","","ru");
INSERT INTO ws_inteface_lang_content VALUES("13","","QUIT","Quit","","ru");
INSERT INTO ws_inteface_lang_content VALUES("14","","PUBLIC_PART","Public part","","ru");
INSERT INTO ws_inteface_lang_content VALUES("15","","LEFTMENU_MENU","MENU","","ru");
INSERT INTO ws_inteface_lang_content VALUES("16","","LEFTMENU_SETTINGS","SETTINGS","","ru");
INSERT INTO ws_inteface_lang_content VALUES("17","","ADD_ELEM","Add element","","ru");
INSERT INTO ws_inteface_lang_content VALUES("18","","EDIT_ELEM","Edit element","","ru");
INSERT INTO ws_inteface_lang_content VALUES("19","","DELETE_ELEM","Delete element","","ru");
INSERT INTO ws_inteface_lang_content VALUES("20","","LIST_ELEMENTS","List elements","","ru");
INSERT INTO ws_inteface_lang_content VALUES("21","","CHANGE_ACTIVITY","Change activity","","ru");
INSERT INTO ws_inteface_lang_content VALUES("22","","TITLE","Title","","ru");
INSERT INTO ws_inteface_lang_content VALUES("23","","IMAGE","Image","","ru");
INSERT INTO ws_inteface_lang_content VALUES("24","","USER","User","","ru");
INSERT INTO ws_inteface_lang_content VALUES("25","","EMAIL","E-mail","","ru");
INSERT INTO ws_inteface_lang_content VALUES("26","","USERNAME","Username","","ru");
INSERT INTO ws_inteface_lang_content VALUES("27","","PRICE","Price","","ru");
INSERT INTO ws_inteface_lang_content VALUES("28","","VIEW_ELEM","View element","","ru");
INSERT INTO ws_inteface_lang_content VALUES("29","","SURE_TO_DELETE","Are you sure you want to delete this item?","","ru");
INSERT INTO ws_inteface_lang_content VALUES("30","","ACTIONS","Actions","","ru");
INSERT INTO ws_inteface_lang_content VALUES("31","","PAGE_TITLE","Page title (tag title)","","ru");
INSERT INTO ws_inteface_lang_content VALUES("32","","PAGE_METAD","Page description (meta description)","","ru");
INSERT INTO ws_inteface_lang_content VALUES("33","","PAGE_METAK","Page keywords (meta keywords)","","ru");
INSERT INTO ws_inteface_lang_content VALUES("34","","PAGE_TEXT","Page text","","ru");
INSERT INTO ws_inteface_lang_content VALUES("35","","PAGE_ADDR","Page address (url)","","ru");
INSERT INTO ws_inteface_lang_content VALUES("36","","PAGE_PHOTOGALLERY","Photo gallery","","ru");
INSERT INTO ws_inteface_lang_content VALUES("37","","CODE","Code","","ru");
INSERT INTO ws_inteface_lang_content VALUES("38","","GO_BACK","Go back","","ru");
INSERT INTO ws_inteface_lang_content VALUES("39","","DESCRIPTION","Description","","ru");
INSERT INTO ws_inteface_lang_content VALUES("40","","NO_EDITABLE_DATA","No data to edit","","ru");
INSERT INTO ws_inteface_lang_content VALUES("41","","SORT","Sort (output order value)","","ru");
INSERT INTO ws_inteface_lang_content VALUES("42","","SAVE","Save","","ru");
INSERT INTO ws_inteface_lang_content VALUES("43","","ACTIVE","Active","","ru");
INSERT INTO ws_inteface_lang_content VALUES("44","","INACTIVE","Inactive","","ru");
INSERT INTO ws_inteface_lang_content VALUES("45","","CURRENT_IMAGE","Current image","","ru");
INSERT INTO ws_inteface_lang_content VALUES("46","","IMAGE_IS_NOT_SET","Image is not set","","ru");
INSERT INTO ws_inteface_lang_content VALUES("47","","SEARCH_KEY","Search key","","ru");
INSERT INTO ws_inteface_lang_content VALUES("48","","LANG","Language","","ru");
INSERT INTO ws_inteface_lang_content VALUES("49","","CHANGE_IMAGE","Change image","","ru");
INSERT INTO ws_inteface_lang_content VALUES("50","","CATEGORY","Category","","ru");
INSERT INTO ws_inteface_lang_content VALUES("51","","PREVIEW","Preview","","ru");
INSERT INTO ws_inteface_lang_content VALUES("52","","PARAMETERS","Parameters","","ru");
INSERT INTO ws_inteface_lang_content VALUES("53","","AUTHOR","Author","","ru");
INSERT INTO ws_inteface_lang_content VALUES("54","","DATA_ADDED","Data successfully added!","","ru");
INSERT INTO ws_inteface_lang_content VALUES("55","","DATA_UPDATED","Data successfully updated!","","ru");
INSERT INTO ws_inteface_lang_content VALUES("56","","VALUE","Value","","ru");
INSERT INTO ws_inteface_lang_content VALUES("57","","PASSWORDS_NOT_MATCH","The passwords you entered do not match","","ru");
INSERT INTO ws_inteface_lang_content VALUES("58","","PASS_CONFIRM","Password confirmation\n","","ru");
INSERT INTO ws_inteface_lang_content VALUES("59","","USER_NAME","User name","","ru");
INSERT INTO ws_inteface_lang_content VALUES("60","","USER_LEVEL","User level","","ru");
INSERT INTO ws_inteface_lang_content VALUES("61","","USER_LANGUAGE","User language","","ru");
INSERT INTO ws_inteface_lang_content VALUES("62","","NEW_PASSWORD","New password","","ru");
INSERT INTO ws_inteface_lang_content VALUES("63","","IS_BLOCKED","Is blocked","","ru");
INSERT INTO ws_inteface_lang_content VALUES("64","","MESSAGE","Message","","ru");
INSERT INTO ws_inteface_lang_content VALUES("65","","FILES","Files","","ru");
INSERT INTO ws_inteface_lang_content VALUES("66","","PHONE_NUMBER","Phone number","","ru");
INSERT INTO ws_inteface_lang_content VALUES("67","","GO_OUT_QUESTION","Go out?","","ru");
INSERT INTO ws_inteface_lang_content VALUES("68","","ERROR_OCCURED","An error has occurred!","","ru");
INSERT INTO ws_inteface_lang_content VALUES("69","","LINK","Link","","ru");
INSERT INTO ws_inteface_lang_content VALUES("70","","TEXT","Text","","ru");
INSERT INTO ws_inteface_lang_content VALUES("71","","ALLADATA","All data","","ru");
INSERT INTO ws_inteface_lang_content VALUES("72","","USERLOGIN","User login","","ru");
INSERT INTO ws_inteface_lang_content VALUES("73","","COLOR_THEME","Color theme","","ru");
INSERT INTO ws_inteface_lang_content VALUES("74","","CHANGE_PASSWORD","Set new password","","ru");
INSERT INTO ws_inteface_lang_content VALUES("75","","REPEAT_NEW_PASS","Repeat new password","","ru");
INSERT INTO ws_inteface_lang_content VALUES("76","","PASS_HAS_EXPIRED","Your password has expired. Password sent to your e-mail","","ru");
INSERT INTO ws_inteface_lang_content VALUES("77","","YOUR_NEW_PASSWORD","Automatic password change","","ru");
INSERT INTO ws_inteface_lang_content VALUES("78","","YOUR_NEW_PASSWORD_IS","Your new password is #password#","","ru");
INSERT INTO ws_inteface_lang_content VALUES("79","","DATE","Date","","ru");
INSERT INTO ws_inteface_lang_content VALUES("80","","JOBPOST","Должность","","ru");
INSERT INTO ws_inteface_lang_content VALUES("81","","YEAR","Year","","ru");
INSERT INTO ws_inteface_lang_content VALUES("82","","MINSUM","Min. sum","","ru");
INSERT INTO ws_inteface_lang_content VALUES("83","","MAXSUM","Max. sum","","ru");
INSERT INTO ws_inteface_lang_content VALUES("84","","COMMISSION","Commission","","ru");
INSERT INTO ws_inteface_lang_content VALUES("85","","ONE_TIME_FEE","One time fee","","ru");
INSERT INTO ws_inteface_lang_content VALUES("86","","ADDITIONAL_ANNUAL_FEE","Additional annual fee","","ru");
INSERT INTO ws_inteface_lang_content VALUES("87","","ADDITIONAL_ANNUAL_FEE_PERCENT","Additional annual fee percent","","ru");
INSERT INTO ws_inteface_lang_content VALUES("88","","MIN_PERCENT","Min. percent","","ru");
INSERT INTO ws_inteface_lang_content VALUES("89","","MAX_PERCENT","Max. percent","","ru");
INSERT INTO ws_inteface_lang_content VALUES("90","","MIN_TERM","Min. term","","ru");
INSERT INTO ws_inteface_lang_content VALUES("91","","MAX_TERM","Max. term","","ru");
INSERT INTO ws_inteface_lang_content VALUES("92","","PERIOD","Period","","ru");
INSERT INTO ws_inteface_lang_content VALUES("93","","PLEDGE","Pledge","","ru");
INSERT INTO ws_inteface_lang_content VALUES("94","","IN_MDL","In MDL","","ru");
INSERT INTO ws_inteface_lang_content VALUES("95","","AUTOPROLONGATION","Autoprolongation","","ru");
INSERT INTO ws_inteface_lang_content VALUES("96","","WITHDRAWING","Withdrawing","","ru");
INSERT INTO ws_inteface_lang_content VALUES("97","","CAPITALISATION","Capitalisation","Capitalisation","ru");
INSERT INTO ws_inteface_lang_content VALUES("98","","REFILL","Refill","","ru");
INSERT INTO ws_inteface_lang_content VALUES("99","","ADDRESS","Address","","ru");
INSERT INTO ws_inteface_lang_content VALUES("100","","WORKDAYS","Working schedule on weekdays","","ru");
INSERT INTO ws_inteface_lang_content VALUES("101","","SATURDAY","Working schedule on saturday","","ru");
INSERT INTO ws_inteface_lang_content VALUES("102","","SUNDAY","Working schedule on sunday","","ru");
INSERT INTO ws_inteface_lang_content VALUES("103","","WEEKEND","Work on weekends","","ru");
INSERT INTO ws_inteface_lang_content VALUES("104","","LAT","Latitude","","ru");
INSERT INTO ws_inteface_lang_content VALUES("105","","LON","Longitude","","ru");
INSERT INTO ws_inteface_lang_content VALUES("106","","HAS_ATM","Has an ATM","","ru");
INSERT INTO ws_inteface_lang_content VALUES("107","","LOCATION","Location","","ru");
INSERT INTO ws_inteface_lang_content VALUES("108","","STUDIO_FOOTER_LINK","https://webmaster.md","","ru");
INSERT INTO ws_inteface_lang_content VALUES("109","","SEARCH_WORD","Искать","","ru");
INSERT INTO ws_inteface_lang_content VALUES("110","","ID_WORD","ID","","ru");
INSERT INTO ws_inteface_lang_content VALUES("112","","COMMENT","Комментарий","","ru");
INSERT INTO ws_inteface_lang_content VALUES("113","","SUCCES_COPY","Скопировано","","ru");
INSERT INTO ws_inteface_lang_content VALUES("114","","EXISTS_WORD","already exists!","","ru");
INSERT INTO ws_inteface_lang_content VALUES("115","","CREATED_WORD","Создан","","ru");
INSERT INTO ws_inteface_lang_content VALUES("116","","VIEW_WORD","Просмотр","","ru");
INSERT INTO ws_inteface_lang_content VALUES("117","","SETTING_CHANGE"," Настройки изменены","","ru");
INSERT INTO ws_inteface_lang_content VALUES("118","","ENTRY_VALUE","Укажите значение","","ru");
INSERT INTO ws_inteface_lang_content VALUES("119","","LANG_ADDS_SUCCESS","Язык добавлен!","","ru");
INSERT INTO ws_inteface_lang_content VALUES("120","","LANGUAS_FOR_COPY","Язык для копий значений всех таблиц ","","ru");
INSERT INTO ws_inteface_lang_content VALUES("121","","CODE_NEW_LANG","Код нового языка (например: ru, en, fr)","","ru");
INSERT INTO ws_inteface_lang_content VALUES("122","","NAME_NEW_LANG","Название нового языка","","ru");
INSERT INTO ws_inteface_lang_content VALUES("123","","MEDIUM","Средний","","ru");
INSERT INTO ws_inteface_lang_content VALUES("124","","COMPLICATED","Сложный","","ru");
INSERT INTO ws_inteface_lang_content VALUES("125","","SIMPLE","Простой","","ru");
INSERT INTO ws_inteface_lang_content VALUES("126","","NOT","Not","","ru");
INSERT INTO ws_inteface_lang_content VALUES("127","","COMPLICITED_PASSWORD","Сложность пароля","","ru");
INSERT INTO ws_inteface_lang_content VALUES("128","","LANG_INTERFACE","Язык интерфейса","","ru");
INSERT INTO ws_inteface_lang_content VALUES("129","","LOGIN_WORD","Логин","","ru");
INSERT INTO ws_inteface_lang_content VALUES("130","","INVALID_BLOCK_TYPE","Invalid block type","","ru");
INSERT INTO ws_inteface_lang_content VALUES("131","","ELEMENT_WORD","Element","","ru");
INSERT INTO ws_inteface_lang_content VALUES("132","","NOT_FOUND_WORD","Not found","","ru");
INSERT INTO ws_inteface_lang_content VALUES("133","","CURRENT_IMAGES","Текущие изображения","","ru");
INSERT INTO ws_inteface_lang_content VALUES("134","","DELETE_IMAGE_","Удалить изображение?","","ru");
INSERT INTO ws_inteface_lang_content VALUES("135","","ADD_IMAGE_GALLERY","Добавить изображения","","ru");
INSERT INTO ws_inteface_lang_content VALUES("136","","LEFTMENU_CONSTRUCTOR","CONSTRUCTOR","","ru");
INSERT INTO ws_inteface_lang_content VALUES("137","1","LIST_ELEMENTS","List elements","","en");



DROP TABLE IF EXISTS ws_lang_dictionary;

CREATE TABLE `ws_lang_dictionary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section_id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `title_ru` text NOT NULL,
  `edit_by_user` tinyint(1) NOT NULL DEFAULT '1',
  `comments` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

INSERT INTO ws_lang_dictionary VALUES("1","","ALL","Основные термины","1","");



DROP TABLE IF EXISTS ws_mailer_news;

CREATE TABLE `ws_mailer_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('news','promo') NOT NULL DEFAULT 'news',
  `news_id` int(11) NOT NULL,
  `last_user_id` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0-new/1-process /2- end',
  `date` datetime NOT NULL COMMENT 'добавлен',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS ws_main_menu;

CREATE TABLE `ws_main_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `title_ru` tinytext NOT NULL,
  `link_ru` tinytext NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '500',
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS ws_menu_admin;

CREATE TABLE `ws_menu_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `section_id` int(5) NOT NULL,
  `title` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `access` varchar(255) NOT NULL DEFAULT '1,2',
  `access_delete` varchar(32) DEFAULT '1,2',
  `num_page` int(11) NOT NULL DEFAULT '20',
  `page_id` int(11) NOT NULL,
  `sort` int(5) NOT NULL DEFAULT '500',
  `assoc_table` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=79 DEFAULT CHARSET=utf8;

INSERT INTO ws_menu_admin VALUES("1","1","","Содержание сайта","/{WS_PANEL}/content/","fa-list","1,2,3,4,5,6,7,8,9","","20","","600","");
INSERT INTO ws_menu_admin VALUES("2","1","","Инфоблоки","/{WS_PANEL}/iblock/","fa-cubes","1,2,3,4,5,6,7,8,9","","20","","550","");
INSERT INTO ws_menu_admin VALUES("3","1","","Администрирование","/{WS_PANEL}/settings/","fa-wrench","1,2,3","","20","","30","");
INSERT INTO ws_menu_admin VALUES("6","1","1","Все страницы","/{WS_PANEL}/content/pages/","","1,2,3,4,5,6,7,8,9","1,2","20","","500","ws_pages");
INSERT INTO ws_menu_admin VALUES("9","1","3","Словарь терминов","/{WS_PANEL}/settings/lang_term/","","1,2,3,4","","20","","30","ws_lang_dictionary");
INSERT INTO ws_menu_admin VALUES("12","1","1","Текстовые блоки","/{WS_PANEL}/content/page_inc/","","1,2,3,4,5,6,7,8,9","","20","","20","ws_pages_inc");
INSERT INTO ws_menu_admin VALUES("13","1","3","Настройки сайта","/{WS_PANEL}/settings/site/","","1,2,3","1,2,3","20","","600","ws_settings");
INSERT INTO ws_menu_admin VALUES("14","1","","Пользователи","/{WS_PANEL}/users/","fa-user","1,2","1","20","","400","ws_users");
INSERT INTO ws_menu_admin VALUES("15","1","3","Бэкапы базы данных","/{WS_PANEL}/settings/backup_mysql/","","1,2,3","1,2","20","","500","ws_backup_mysql");
INSERT INTO ws_menu_admin VALUES("16","","3","Управления языками сайта","/{WS_PANEL}/settings/languages/","","1","1,2","50","","500","ws_site_languages");
INSERT INTO ws_menu_admin VALUES("21","","3","Мастер настроек","/{WS_PANEL}/settings/wizard/","","","","","","500","");
INSERT INTO ws_menu_admin VALUES("20","1","14","Администраторы","/{WS_PANEL}/users/users/","","1,2,3,4,5,6,7,8,9","1,2","20","","500","ws_users");
INSERT INTO ws_menu_admin VALUES("8","","1","Меню","/{WS_PANEL}/content/menu/","","1,2","1,2","20","","500","ws_main_menu");
INSERT INTO ws_menu_admin VALUES("76","","2","Месяцы","/{WS_PANEL}/iblock/months/","","1,2","1","20","","500","ws_months");
INSERT INTO ws_menu_admin VALUES("77","","2","Города","/{WS_PANEL}/iblock/cities/","","1,2","1,2","20","","500","ws_cities");
INSERT INTO ws_menu_admin VALUES("72","1","","Обратная связь","/{WS_PANEL}/feedback/"," fa-commenting-o","1,2","1,2","20","","500","");
INSERT INTO ws_menu_admin VALUES("73","1","72","Сообщения","/{WS_PANEL}/feedback/contacts/","","1,2","1,2","20","","500","ws_messages");
INSERT INTO ws_menu_admin VALUES("78","1","2","Новости","/{WS_PANEL}/iblock/news/","","1,2","1,2","20","","500","ws_news");



DROP TABLE IF EXISTS ws_menu_admin_settings;

CREATE TABLE `ws_menu_admin_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section_id` int(11) NOT NULL,
  `param` varchar(128) NOT NULL,
  `value` varchar(1024) NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;

INSERT INTO ws_menu_admin_settings VALUES("1","14","image","/{WS_PANEL}/templates/lte/dist/img/users/","");
INSERT INTO ws_menu_admin_settings VALUES("2","20","image","/{WS_PANEL}/templates/lte/dist/img/users/","");
INSERT INTO ws_menu_admin_settings VALUES("3","20","image_width","160","Ширина аватары");
INSERT INTO ws_menu_admin_settings VALUES("4","20","image_height","160","Высота аватары");
INSERT INTO ws_menu_admin_settings VALUES("61","78","image","/upload/news/","");
INSERT INTO ws_menu_admin_settings VALUES("62","78","image_width","300","");
INSERT INTO ws_menu_admin_settings VALUES("63","78","image_height","200","");



DROP TABLE IF EXISTS ws_messages;

CREATE TABLE `ws_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `name` varchar(130) NOT NULL,
  `email` varchar(50) NOT NULL,
  `message` varchar(300) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO ws_messages VALUES("3","1","Вася","admin@test.ro","Lorem ipsum message text dolor set amet","022 123654","2018-03-08 10:13:02");



DROP TABLE IF EXISTS ws_months;

CREATE TABLE `ws_months` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_ru` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

INSERT INTO ws_months VALUES("1","Января");
INSERT INTO ws_months VALUES("2","Февраля");
INSERT INTO ws_months VALUES("3","Марта");
INSERT INTO ws_months VALUES("4","Апреля");
INSERT INTO ws_months VALUES("5","Май");
INSERT INTO ws_months VALUES("6","Июня");
INSERT INTO ws_months VALUES("7","Июль");
INSERT INTO ws_months VALUES("8","Августа");
INSERT INTO ws_months VALUES("9","Сентября");
INSERT INTO ws_months VALUES("10","Октября");
INSERT INTO ws_months VALUES("11","Ноября");
INSERT INTO ws_months VALUES("12","Декабря");



DROP TABLE IF EXISTS ws_news;

CREATE TABLE `ws_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `title_ru` varchar(192) NOT NULL,
  `preview_ru` varchar(256) NOT NULL,
  `text_ru` longtext NOT NULL,
  `image` varchar(32) NOT NULL,
  `page_title_ru` varchar(256) NOT NULL,
  `meta_d_ru` varchar(256) NOT NULL,
  `meta_k_ru` varchar(256) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '500',
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS ws_pages;

CREATE TABLE `ws_pages` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `section_id` int(11) NOT NULL DEFAULT '0',
  `page` varchar(255) NOT NULL,
  `assoc_table` varchar(255) NOT NULL,
  `edit_by_user` tinyint(1) NOT NULL DEFAULT '0',
  `search` tinyint(4) NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL DEFAULT '500',
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `title_ru` varchar(255) NOT NULL,
  `show_gallery` tinyint(4) NOT NULL DEFAULT '0',
  `show_text` tinyint(4) NOT NULL DEFAULT '1',
  `page_title_ru` varchar(384) NOT NULL,
  `text_ru` longtext NOT NULL,
  `meta_k_ru` varchar(255) NOT NULL,
  `meta_d_ru` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=69 DEFAULT CHARSET=utf8;

INSERT INTO ws_pages VALUES("1","","/index.php","","1","","500","1","Главная","","1","Главная страница","","Главная страница","Главная страница");
INSERT INTO ws_pages VALUES("3","","/ajax.php","","","","500","1","ajax","","","ajax","","","");
INSERT INTO ws_pages VALUES("2","","/404.php","","","","500","1","Not found","","1","Not found","Not found","","");



DROP TABLE IF EXISTS ws_pages_inc;

CREATE TABLE `ws_pages_inc` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `title_ru` varchar(255) NOT NULL,
  `text_ru` longtext NOT NULL,
  `edit_by_user` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO ws_pages_inc VALUES("1","NEW_NEWS","Текст рассылки","<p>Лорем ипсум! Приветсвуем</p>\n\n<p>Это текст о том, что появилась новая публикация &ndash;&nbsp;{title}</p>\n\n<p>А далее следует текст о том, что по этой ссылке &ndash;&nbsp;{link} &ndash;&nbsp;можно перейти и прочитать</p>\n","1");



DROP TABLE IF EXISTS ws_photogallery;

CREATE TABLE `ws_photogallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `elem_id` int(11) NOT NULL,
  `image` varchar(64) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '500',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS ws_photogallery_params;

CREATE TABLE `ws_photogallery_params` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'если требуется резать много, то просто черехз запятую',
  `page_id` int(11) NOT NULL,
  `resize_library` int(1) NOT NULL COMMENT 'использовать библиотеку для ресайза',
  `thumb_width` varchar(128) NOT NULL,
  `thumb_height` varchar(128) NOT NULL,
  `image_width` varchar(128) NOT NULL,
  `image_height` varchar(128) NOT NULL,
  `filter_gray` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'фильтр для функции makefiler',
  `save_original_image` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'если картинка менее, чем какой-то размер - сохранять исходный размер',
  `comment` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO ws_photogallery_params VALUES("1","","","","","","","","","");



DROP TABLE IF EXISTS ws_settings;

CREATE TABLE `ws_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `title` varchar(32) NOT NULL,
  `code` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `description` text NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '500',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

INSERT INTO ws_settings VALUES("1","1","Окончание ЧПУ","CPU_KEYWORD","new","Окончание для ЧПУ (если уже существует такой ЧПУ)","500");
INSERT INTO ws_settings VALUES("2","1","Поисковый ключ по-умолчанию","DEFAULT_SEARCH_KEY","SearchWord","Поисковый ключ по-умолчанию","500");
INSERT INTO ws_settings VALUES("3","1","Домен сайта в текущий момент","DOMAIN","domain.com","Не находясь на домене, сайт будет закрыт заглушкой для поисковых систем","500");
INSERT INTO ws_settings VALUES("4","1","SMTP MAIL","SMTP_MAIL","test@allananas.ru","Сервис отправки почты","500");
INSERT INTO ws_settings VALUES("5","1","SMTP_SERVER","SMTP_SERVER","140.140.140.25","Сервис отправки почты","500");
INSERT INTO ws_settings VALUES("6","1","SMTP_PASS","SMTP_PASS","8k82DRq1hA","Сервис отправки почты","500");
INSERT INTO ws_settings VALUES("7","1","SMTP_PORT","SMTP_PORT","587","Сервис отправки почты","500");
INSERT INTO ws_settings VALUES("8","1","latitude ","MAP_LAT","46.978976","latitude","500");
INSERT INTO ws_settings VALUES("9","1","longitude","MAP_LNG","28.854929","longitude","500");



DROP TABLE IF EXISTS ws_site_languages;

CREATE TABLE `ws_site_languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(8) NOT NULL,
  `title` varchar(32) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '500',
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `is_default` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO ws_site_languages VALUES("1","ru","Русский","500","1","1");



DROP TABLE IF EXISTS ws_subscribers;

CREATE TABLE `ws_subscribers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `lang` varchar(2) NOT NULL DEFAULT 'ro',
  `name` varchar(128) NOT NULL,
  `email` varchar(96) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

INSERT INTO ws_subscribers VALUES("10","2018-05-03 22:54:37","ru","","simion.webmaster@gmail.com");
INSERT INTO ws_subscribers VALUES("11","2018-05-03 22:55:22","ru","","45nm45nm@gmail.com");



DROP TABLE IF EXISTS ws_user_group;

CREATE TABLE `ws_user_group` (
  `id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

INSERT INTO ws_user_group VALUES("1","admin","Разработчик");
INSERT INTO ws_user_group VALUES("2","main_editor","Главный администратор");
INSERT INTO ws_user_group VALUES("3","worker","Администратор");
INSERT INTO ws_user_group VALUES("4","content_manager","Контент-менеджер");



DROP TABLE IF EXISTS ws_users;

CREATE TABLE `ws_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `usergroup` int(3) NOT NULL COMMENT 'ws_user_group',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `user_name` varchar(255) NOT NULL COMMENT 'first_name',
  `email` varchar(64) NOT NULL,
  `lang` varchar(8) NOT NULL DEFAULT 'ru',
  `interface_lang` varchar(4) NOT NULL DEFAULT 'en',
  `pass` varchar(384) NOT NULL,
  `login_crypt` varchar(255) NOT NULL,
  `block` tinyint(4) NOT NULL DEFAULT '0',
  `image` varchar(64) NOT NULL,
  `auth_date` datetime NOT NULL,
  `skin` varchar(64) NOT NULL DEFAULT 'skin-blue',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

INSERT INTO ws_users VALUES("1","paik","1","1","user","user@gmail.com","ru","ru","b5fdc4be2b9ce6bb7118819200e44b30c6ea421987a561a0a7f12bea319c51fc3a3719f430500ba9d65fcbece0494d3cb71ea413f8eead3603f242a0ef9eadb3","$1$B29o/z0Y$zs5JfmprlhOx5gCk.u39p1","","nbpibyax.jpg","2020-07-13 15:24:20","skin-blue");



