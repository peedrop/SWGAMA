<?php

class Banco
{
	/*
    private static $dbNome = 'swgama';
    private static $dbHost = 'localhost';
    private static $dbUsuario = 'root';
    private static $dbSenha = 'root';
	*/
	
	private static $dbNome = 'swgama';
    private static $dbHost = 'localhost';
    private static $dbUsuario = 'root';
    private static $dbSenha = 'root';
    
    private static $cont = null;
 	
    private function __construct() 
    {
    }
    
    public static function conectar()
    {
        if(null == self::$cont)
        {
            try
            { 
                 self::$cont = new PDO("mysql:host=".self::$dbHost."; dbname=".self::$dbNome."; charset=utf8",  self::$dbUsuario,  self::$dbSenha,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            }
            catch(PDOException $exception)
            {
                die($exception->getMessage());
            }
        }
        return self::$cont;
    }
    
    public static function desconectar()
    {
        self::$cont = null;
    }
}

?>
