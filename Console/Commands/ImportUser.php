<?php

namespace Artisan\Console\Commands;

use Illuminate\Console\Command;
use League\Csv\Reader;
use PDO;

class ImportUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:import';
    protected  $database;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import User from CSV Files';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->database = include('config/database.php');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Import strated');
        $con = $this->database['mysql'];
        $con['dsn'] ='mysql:'.$con['host'].'=localhost;dbname='.$con['database'].';unix_socket='.$con['unix_socket'];
        $link = new PDO($con['dsn'], $con['username'], $con['password']);
        $sth = $link->prepare(
            "INSERT INTO users (name, email) VALUES (:name, :email)"
        );
        $csv = Reader::createFromPath(getcwd().'/Storage/2015.csv');
        $csv->setOffset(1);
        $nbInsert = $csv->each(function ($row) use (&$sth) {
            //Do not forget to validate your data before inserting it in your database
            $sth->bindValue(':name', $row[0], PDO::PARAM_STR);
            $sth->bindValue(':email', $row[1], PDO::PARAM_STR);
            //return $sth->execute(); //if the function return false then the iteration will stop
        });
        $this->info('Job Queued');
    }
}
