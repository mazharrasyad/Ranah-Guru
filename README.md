## List Task

# Download Yii2 Basic

- Buka Command Line
- Pindahkan direktori ke localhost seperti berikut :
```
cd /opt/lampp/htdocs 
atau 
cd /var/www/html
atau
cd c:/xampp/htdocs
```
- Ketikkan perintah berikut
```
composer create-project --prefer-dist yiisoft/yii2-app-basic Web-Ranah-Guru
```
- sudo chmod 777 -R Web-Ranah-Guru

# Create Database

- Buat Database db_ranahguru
- Buat ERD di MySQL Workbench
- Forward ERD tadi ke db_ranah guru
- Buka file Web-Ranah-Guru/config/db.php
- Cari kode berikut :
```
'dsn' => 'mysql:host=127.0.0.1;dbname=yii2basic',
'username' => 'root',
'password' => '',
```
- Kemudian sesuaikan dengan database localhost seperti berikut :
```
'dsn' => 'mysql:host=127.0.0.1;dbname=db_ranahguru',
'username' => 'root',
'password' => '',
```

# Change Name Application

- Buka file Web-Ranah-Guru/config/web.php
- Tambahkan kode berikut :
```
'name' => 'Ranah Guru',
```
- Cari dan letakkan di bawah kode berikut  :
```
'id' => 'basic',
```
- Sehingga menjadi :
```
'id' => 'basic',
'name' => 'Ranah Guru',
```
- Simpan file tersebut

# Pretty URL

- Buka file Web-Ranah-Guru/config/web.php
- Cari kode berikut :
```
/*
'urlManager' => [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
    ],
],
*/
```
- Kemudian hilangkan komentarnya menjadi :
```
'urlManager' => [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
    ],
],
```
- Simpan file tersebut

# Remove URL /web

- Buka file Web-Ranah-Guru/config/web.php
- Tambahkan kode berikut :
```
'homeUrl' => '/Web-Ranah-Guru',
```
- Letakkan seperti berikut :
```
$config = [
    ...
    'homeUrl' => '/Web-Ranah-Guru',
    ...
];
```
- Kemudian tambahkan lagi kode berikut :
```
'baseUrl' => '/Web-Ranah-Guru',
```
- Letakkan seperti berikut :
```
$config = [
    'components' => [
        'request' => [
            ...
            'baseUrl' => '/Web-Ranah-Guru',
            ...
        ],
    ],
];
```
- Simpan file tersebut
- Buat file baru dengan nama .htaccess
- Letakkan di Web-Ranah-Guru/.htaccess
- Tambahkan kode berikut :
```
# prevent directory listings
Options -Indexes
IndexIgnore */*
 
# follow symbolic links
Options FollowSymlinks
RewriteEngine on
RewriteRule ^(.+)?$ web/$1
```
- Simpan file tersebut

# Widgets

- https://github.com/dektrium/yii2-user
- https://github.com/kartik-v/yii2-widget-select2
- https://github.com/kartik-v/yii2-widget-datepicker
- https://github.com/mdmsoft/yii2-admin

# Mode Production

- Buka file Web-Ranah-Guru/web/index.php
- Cari code berikut :
```
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
```
- Kemudian hapus
- Simpan file tersebut