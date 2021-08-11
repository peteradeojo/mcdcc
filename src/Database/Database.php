<?php

namespace Database;

use Exception;
use mysqli;

class Database
{
  private $dbname;
  private $dbhost;
  private $dbuser;
  private $dbpassword;
  public $cxn = null;

  /**
   * Initialize Database class
   */
  function __construct()
  {
    $this->dbname = $_ENV['DBNAME'];
    $this->dbhost = $_ENV['DBHOST'];
    $this->dbuser = $_ENV['DBUSER'];
    $this->dbpassword = $_ENV['DBPASSWORD'];

    if (!$this->connect()) {
      die("Database connection failed: " . $this->cxn->error);
    }
  }

  /**
   * Check Table existence in Database
   * @function tableExists
   */
  private function tableExists(string $table)
  {
    $table = $this->cxn->real_escape_string($table);
    $sql = "SHOW TABLES LIKE '$table'";
    $query = $this->cxn->query($sql);
    if ($query and $query->fetch_all(MYSQLI_BOTH)) {
      return true;
    }
    return false;
  }


  /**
   * @function connect
   * @desc Connect to the mysqli server with parameters from environment
   */
  function connect()
  {
    if (!$this->cxn) {
      $cxn = new mysqli($this->dbhost, $this->dbuser, $this->dbpassword, $this->dbname);
      $this->cxn = $cxn;
      if ($this->cxn) {
        return true;
      } else {
        return false;
      }
    }
  }

  /**
   * retrieve data from mysql table
   * @function select
   * @param {string} table
   * @return array|bool
   */
  function select(string $table, string $rows = null, string $where = null, array $orderby = null, int $limit = 100): array|false
  {
    if ($this->tableExists($table)) {
      if (!$rows) {
        $rows = '*';
      }
      $sql = "SELECT $rows FROM $table";
      if ($where) {
        $sql .= " WHERE $where";
      }
      if ($orderby) {
        $sql .= " ORDER BY ";
        $sql .= join(', ', $orderby);
      }
      $sql .= " LIMIT $limit;";
      $query = $this->cxn->query($sql);
      if ($query) {
        return $query->fetch_all(MYSQLI_ASSOC);
      } else {
        throw new Exception($this->cxn->error);
      }
    } else {
      throw new Exception($this->cxn->error);
    }
  }

  /**
   * @function join
   * @param
   * @return array|bool
   */
  function join(string $table1, array $joins, string $rows = null, string $where = null, int $limit = 100): array|false
  {
    if ($this->tableExists($table1)) {
      if (!$rows) $rows = "*";

      $joins_ons = '';

      // Construct join statements from array
      for ($i = 0; $i < count($joins); $i += 1) {
        $joins_ons .= "{$joins[$i][0]} JOIN {$joins[$i][1]} ON {$joins[$i][2]} ";
      }

      $sql = "SELECT $rows FROM $table1 $joins_ons";
      if ($where) {
        $sql .= " WHERE $where";
      }
      $sql .= " LIMIT $limit;";
      $query = $this->cxn->query($sql);
      if ($query) {
        return $query->fetch_all(MYSQLI_ASSOC);
      }
      echo $this->cxn->error;
      return false;
    } else {
      return false;
    }
  }

  /**
   * Insert into database
   * @param {string} table
   */
  function insert(string $table, array $rowval)
  {
    if ($this->tableExists($table)) {
      if (!$rowval) {
        return false;
      }

      $sql = "INSERT INTO $table (" . join(",", array_keys($rowval)) . ") VALUES(" . join(", ", array_values($rowval)) . ")";
      // echo $sql;

      $query = $this->cxn->query($sql);
      if ($query and $this->cxn->affected_rows) {
        return true;
      } else {
        throw new Exception($this->cxn->error);
      }
    } else {
      throw new Exception("Table '$table' does not exist");
    }
  }

  function multiInsert(array $data)
  {
    $sql = [];
    foreach ($data as $table => $info) {
      if ($this->tableExists($table)) {
        $sql[] = "INSERT INTO $table (" . join(',', array_keys($info)) . ") VALUES (" . join(',', array_values($info)) . ")";
      }
    }
    $sql = join('; ', $sql);
    // echo $sql;
    // return;
    $query = $this->cxn->multi_query($sql);
    if ($query) {
      return true;
    }
    return false;
  }

  function update(string $table, array $data, string $where)
  {
    if ($this->tableExists($table)) {
      if (!$where) {
        throw new Exception("Invalid where statement");
      }
      $sql = "UPDATE $table SET ";
      $list = [];
      foreach ($data as $k => $v) {
        $list[] = "$k='$v'";
      }
      $sql .= join(', ', $list) . " WHERE $where;";

      $query = $this->cxn->query($sql);
      if ($query) {
        return true;
      } else {
        throw new Exception($this->cxn->error, 101);
      }
    } else {
      throw new Exception("Table '$table' does not exist");
    }
  }

  /**
   * Delete a record from database
   * @param table
   * @param where
   */
  function delete(string $table, string $where)
  {
    if ($this->tableExists($table)) {
      // $where = $this->cxn->escape_string(htmlspecialchars(trim($where)));
      $sql = "DELETE FROM $table WHERE $where";

      $query = $this->cxn->query($sql);
      if ($query) {
        return true;
      } else {
        throw new Exception($this->cxn->error);
      }
    }
  }

  function getError()
  {
    return $this->cxn->error;
  }

  function disconnect(): bool
  {
    if ($this->cxn) {
      $this->cxn->close();
      $this->cxn = null;
    }
    return true;
  }

  function __destruct()
  {
    $this->disconnect();
  }
}
