<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetupDomain extends Command
{
    protected $signature = 'setup:domain {domain} {projectDir}';
    protected $description = 'Generate a script to set up a new domain and Apache virtual host';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $domain = $this->argument('domain');
        $projectDir = $this->argument('projectDir');

        $scriptContent = "@echo off\r\n";
        $scriptContent .= "set DOMAIN={$domain}\r\n";
        $scriptContent .= "set PROJECT_DIR={$projectDir}\r\n";
        $scriptContent .= "set HOSTS_FILE=%WINDIR%\\System32\\drivers\\etc\\hosts\r\n";
        $scriptContent .= "set APACHE_CONFIG_DIR=C:\\laragon\\bin\\apache\\httpd-2.4.54-win64-VS16\\conf\\extra\r\n";
        $scriptContent .= "set APACHE_VHOST_FILE=%APACHE_CONFIG_DIR%\\httpd-vhosts.conf\r\n";
        $scriptContent .= "\r\n";
        $scriptContent .= "echo Adding %DOMAIN% to %HOSTS_FILE%\r\n";
        $scriptContent .= "echo 127.0.0.1    %DOMAIN%>> %HOSTS_FILE%\r\n";
        $scriptContent .= "\r\n";
        $scriptContent .= "echo Creating Apache virtual host configuration for %DOMAIN%\r\n";
        $scriptContent .= "(\r\n";
        $scriptContent .= "    echo ^<VirtualHost *:80^>\r\n";
        $scriptContent .= "    echo     ServerAdmin webmaster@%DOMAIN%\r\n";
        $scriptContent .= "    echo     DocumentRoot \"%PROJECT_DIR%\\public\"\r\n";
        $scriptContent .= "    echo     ServerName %DOMAIN%\r\n";
        $scriptContent .= "    echo     ErrorLog \"logs/%DOMAIN%-error.log\"\r\n";
        $scriptContent .= "    echo     CustomLog \"logs/%DOMAIN%-access.log\" common\r\n";
        $scriptContent .= "    echo     ^<Directory \"%PROJECT_DIR%\\public\"^>\r\n";
        $scriptContent .= "    echo         Options Indexes FollowSymLinks\r\n";
        $scriptContent .= "    echo         AllowOverride All\r\n";
        $scriptContent .= "    echo         Require all granted\r\n";
        $scriptContent .= "    echo     ^</Directory^>\r\n";
        $scriptContent .= "    echo ^</VirtualHost^>\r\n";
        $scriptContent .= ")>> %APACHE_VHOST_FILE%\r\n";
        $scriptContent .= "\r\n";
        $scriptContent .= "echo Restarting Apache\r\n";
        $scriptContent .= "net stop \"Laragon Apache\"\r\n";
        $scriptContent .= "net start \"Laragon Apache\"\r\n";
        $scriptContent .= "\r\n";
        $scriptContent .= "echo %DOMAIN% setup completed!\r\n";

        $scriptPath = storage_path('scripts/setup-domain.bat');
        file_put_contents($scriptPath, $scriptContent);

        $this->info("Script created at: $scriptPath");
        $this->info("Run the script with administrative privileges to complete the setup.");

        return 0;
    }
}
