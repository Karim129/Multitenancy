@echo off
set DOMAIN=karim1234.multitenancy.test
set PROJECT_DIR=C:\laragon\www\multitenancy
set HOSTS_FILE=%WINDIR%\System32\drivers\etc\hosts
set APACHE_CONFIG_DIR=C:\laragon\bin\apache\httpd-2.4.54-win64-VS16\conf\extra
set APACHE_VHOST_FILE=%APACHE_CONFIG_DIR%\httpd-vhosts.conf

echo Adding %DOMAIN% to %HOSTS_FILE%
echo 127.0.0.1    %DOMAIN%>> %HOSTS_FILE%

echo Creating Apache virtual host configuration for %DOMAIN%
(
    echo ^<VirtualHost *:80^>
    echo     ServerAdmin webmaster@%DOMAIN%
    echo     DocumentRoot "%PROJECT_DIR%\public"
    echo     ServerName %DOMAIN%
    echo     ErrorLog "logs/%DOMAIN%-error.log"
    echo     CustomLog "logs/%DOMAIN%-access.log" common
    echo     ^<Directory "%PROJECT_DIR%\public"^>
    echo         Options Indexes FollowSymLinks
    echo         AllowOverride All
    echo         Require all granted
    echo     ^</Directory^>
    echo ^</VirtualHost^>
)>> %APACHE_VHOST_FILE%

echo Restarting Apache
net stop "Laragon Apache"
net start "Laragon Apache"

echo %DOMAIN% setup completed!
