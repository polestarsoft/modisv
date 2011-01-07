SET PHP_DIR="D:\Programs\EasyPHP\php"
DEL /Q %~dp0\..\core\components\modisv\model\modisv\entities\mysql\*.php
CD /d %~dp0
%PHP_DIR%\php.exe build.schema.php
PAUSE