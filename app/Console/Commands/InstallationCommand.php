<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for installing the application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // get and set application name
        $appName = $this->ask('What is the application name?');
        $this->setAppName($appName);

        // set application key
        $this->call('key:generate');

        // ask for database informations
        $dbHost = $this->ask('What is the database host?');
        $dbName = $this->ask('What is the database name?');
        $dbUser = $this->ask('What is the database user?');
        $dbPassword = $this->ask('What is the database password?');

        // set database information's
        $this->setDatabaseConfig($dbHost, $dbName, $dbUser, $dbPassword);

        // migrate fresh
        $this->call('migrate:fresh');

        // seed database
        $this->call('db:seed');

        // install jwt secret
        $this->call('jwt:secret');

        // ask for mail configuration
        $mailDriver = $this->ask('What is the mail driver?');
        $mailHost = $this->ask('What is the mail host?');
        $mailPort = $this->ask('What is the mail port?');
        $mailUsername = $this->ask('What is the mail username?');
        $mailPassword = $this->ask('What is the mail password?');
        $mailEncryption = $this->ask('What is the mail encryption?');

        // set mail configuration
        $this->setMailConfig($mailDriver, $mailHost, $mailPort, $mailUsername, $mailPassword, $mailEncryption);
    }

    private function setAppName(mixed $appName = 'Task Management')
    {
        $envFile = base_path('.env');
        $envContent = file_get_contents($envFile);

        // replace with quation mark
        $envContent = preg_replace('/APP_NAME=(.*)/', "APP_NAME=\"$appName\"", $envContent);

        file_put_contents($envFile, $envContent);
    }

    private function setDatabaseConfig(mixed $dbHost, mixed $dbName, mixed $dbUser, mixed $dbPassword)
    {
        $envFile = base_path('.env');
        $envContent = file_get_contents($envFile);

        // replace with quation mark
        $envContent = preg_replace('/DB_HOST=(.*)/', "DB_HOST=\"$dbHost\"", $envContent);
        $envContent = preg_replace('/DB_DATABASE=(.*)/', "DB_DATABASE=\"$dbName\"", $envContent);
        $envContent = preg_replace('/DB_USERNAME=(.*)/', "DB_USERNAME=\"$dbUser\"", $envContent);
        $envContent = preg_replace('/DB_PASSWORD=(.*)/', "DB_PASSWORD=\"$dbPassword\"", $envContent);

        file_put_contents($envFile, $envContent);
    }

    private function setMailConfig(mixed $mailDriver, mixed $mailHost, mixed $mailPort, mixed $mailUsername, mixed $mailPassword, mixed $mailEncryption)
    {
        $envFile = base_path('.env');
        $envContent = file_get_contents($envFile);

        // replace with quation mark
        $envContent = preg_replace('/MAIL_MAILER=(.*)/', "MAIL_MAILER=\"$mailDriver\"", $envContent);
        $envContent = preg_replace('/MAIL_HOST=(.*)/', "MAIL_HOST=\"$mailHost\"", $envContent);
        $envContent = preg_replace('/MAIL_PORT=(.*)/', "MAIL_PORT=\"$mailPort\"", $envContent);
        $envContent = preg_replace('/MAIL_USERNAME=(.*)/', "MAIL_USERNAME=\"$mailUsername\"", $envContent);
        $envContent = preg_replace('/MAIL_PASSWORD=(.*)/', "MAIL_PASSWORD=\"$mailPassword\"", $envContent);
        $envContent = preg_replace('/MAIL_ENCRYPTION=(.*)/', "MAIL_ENCRYPTION=\"$mailEncryption\"", $envContent);

        file_put_contents($envFile, $envContent);
    }
}
