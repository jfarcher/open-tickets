<?php
class db {

    // Connect to the database
    function connect($althost = "", $altuser = "", $altpass = "", $altdatabase = "") {
        $linkid = "";
        if ($althost != "") { $this->dbhost = $althost; }
        if ($altuser != "") { $this->dbuser = $altuser; }
        if ($altpass != "") { $this->dbpass = $altpass; }
        if ($altdatabase != "") { $this->database = $altdatabase; }

        if ($this->dbpass == "") {
            $linkid = mysql_connect($this->dbhost,$this->dbuser);
        } else {
            $linkid = mysql_connect($this->dbhost,$this->dbuser,$this->dbpass) or die("Connection to Database Failed");
        }
        if ($this->database != "") {
            mysql_select_db($this->database, $linkid);
        }
        return $linkid;
    }

    // query database
    function query($lid = "",$sql = "") {
        $queryid = mysql_query($sql, $lid);
        return $queryid;
    }
        
    // fetch single row
    function fetcharray($qid = "") {
        $record = mysql_fetch_array($qid);
        return $record;
    }

    // free result
    function freeresult($qid = "") {
        return @mysql_free_result($qid);
    }

    // get number of rows
    function numrows($qid = "") {
        return mysql_num_rows($qid);
    }

    // get number from last auto_insert field
    function insert_id($lid) {
        return mysql_insert_id($lid);
    }

    // close connection
    function close($lid = "") {
        mysql_close($lid);
    }

}

?>
