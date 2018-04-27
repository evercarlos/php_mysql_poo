<?php

class conecction
{
    protected $host;
    protected $user;
    protected $pass;
    protected $type_bd;
    protected $bd;

    public function __construct($host = 'localhost', $user = 'root', $pass = '', $bd = 'dbphpmysql', $type_bd = 'mysql')
    {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->bd = $bd;
        $this->type_bd = $type_bd;

        try {
            switch ($this->type_bd) {
                case 'mysql':
                    $link = mysql_connect($host, $user, $pass);
                    break;
                case 'pg':
                    $link = pg_connect("host:" . $host . " user=" . $user . " password=" . $pass . " db=" . $bd . " ");
                    break;
            }

            mysql_select_db($this->bd);

            return  $link;
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }
}

?>