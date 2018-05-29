<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PdoController extends Controller
{
    public $pdo;

    public function __construct()
    {
      $dsn = "mysql:host=".env('DB_HOST').";dbname=".env('DB_DATABASE');
      try{
        $pdo = new \PDO($dsn, env('DB_USERNAME'), env("DB_PASSWORD"));
      }catch (PDOException $e){
        die("PdoController:fail to connect PDOmysql".$e->getMessage());
      }
      $this->pdo = $pdo;
    }

    public function getPdo()
    {
      return $this->pdo;
    }
}
