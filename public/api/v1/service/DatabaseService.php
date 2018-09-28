<?php
/**
 * Singleton (Design pattern!)
 * Class Database
 */
class DatabaseService
{
    const DB_SERVER = "185.182.57.122";
    const DB_USER = "codebusters_luuk";
    const DB_PASSWD = "XlrcaZqc";
    const DB_NAME = "codebusters_oryx";

    private $connection = null;

    public static function getInstance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new DatabaseService();
        }
        return $inst;
    }

    /**
     * Private ctor so nobody else can instantiate it
     *
     */
    private function __construct()
    {
    }

    /**
     * Creates a new connection with a database.
     * @return mysqli connection
     */
    public function getConnection()
    {
        if (!isset($this->connection)) {
            $this->connection = new mysqli(self::DB_SERVER, self::DB_USER, self::DB_PASSWD, self::DB_NAME, 3306);
        }

        if ($this->connection->connect_errno) {
            printf("Connect failed: %s\n", $this->connection->connect_error);
            exit();
        }
        return $this->connection;
    }


}
