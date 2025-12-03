<?php
/**
 * Class Database
 * Deskripsi: Class untuk koneksi dan operasi database menggunakan OOP
 */

class Database {
    protected $host;
    protected $user;
    protected $password;
    protected $db_name;
    protected $conn;

    public function __construct() {
        $this->getConfig();
        $this->connect();
    }

    private function getConfig() {
        // Load config file
        if (!file_exists("config.php")) {
            die("Error: config.php tidak ditemukan!");
        }
        
        require_once("config.php");
        
        // Gunakan konstanta dari config.php
        $this->host = DB_HOST;
        $this->user = DB_USER;
        $this->password = DB_PASS;
        $this->db_name = DB_NAME;
    }

    private function connect() {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->db_name);
        
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        
        // Set charset ke utf8
        $this->conn->set_charset("utf8");
    }

    /**
     * Eksekusi query SQL custom
     */
    public function query($sql) {
        $result = $this->conn->query($sql);
        if (!$result) {
            echo "Error Query: " . $this->conn->error . "<br>";
            echo "SQL: " . $sql . "<br>";
        }
        return $result;
    }

    /**
     * Mengambil data dari tabel
     * @param string $table nama tabel
     * @param string $where kondisi where (opsional)
     * @return mysqli_result|false hasil query
     */
    public function get($table, $where = null) {
        $whereClause = "";
        if ($where) {
            $whereClause = " WHERE " . $where;
        }
        $sql = "SELECT * FROM " . $table . $whereClause;
        return $this->query($sql);
    }

    /**
     * Mengambil satu baris data
     * @param string $table nama tabel
     * @param string $where kondisi where (opsional)
     * @return array|null satu baris data
     */
    public function getOne($table, $where = null) {
        $result = $this->get($table, $where);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }

    /**
     * Insert data ke tabel
     * @param string $table nama tabel
     * @param array $data data yang akan diinsert (key => value)
     * @return int|false insert_id atau false
     */
    public function insert($table, $data) {
        if (is_array($data)) {
            $column = array();
            $value = array();
            
            foreach($data as $key => $val) {
                $column[] = $key;
                $value[] = "'{$val}'";
            }
            
            $columns = implode(",", $column);
            $values = implode(",", $value);
        }
        
        $sql = "INSERT INTO " . $table . " (" . $columns . ") VALUES (" . $values . ")";
        $result = $this->query($sql);
        
        if ($result) {
            return $this->conn->insert_id;
        } else {
            return false;
        }
    }

    /**
     * Update data di tabel
     * @param string $table nama tabel
     * @param array $data data yang akan diupdate
     * @param string $where kondisi where
     * @return boolean
     */
    public function update($table, $data, $where) {
        $update_value = array();
        
        if (is_array($data)) {
            foreach($data as $key => $val) {
                $update_value[] = "$key='{$val}'";
            }
            $update_value = implode(",", $update_value);
        }
        
        $sql = "UPDATE " . $table . " SET " . $update_value . " WHERE " . $where;
        $result = $this->query($sql);
        
        return $result ? true : false;
    }

    /**
     * Hapus data dari tabel
     * @param string $table nama tabel
     * @param string $where kondisi where
     * @return boolean
     */
    public function delete($table, $where) {
        $sql = "DELETE FROM " . $table . " WHERE " . $where;
        $result = $this->query($sql);
        
        return $result ? true : false;
    }

    /**
     * Escape string untuk keamanan
     */
    public function escape($value) {
        return $this->conn->real_escape_string($value);
    }

    /**
     * Tutup koneksi database
     */
    public function close() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
    
    /**
     * Destructor - tutup koneksi otomatis
     */
    public function __destruct() {
        $this->close();
    }
}
?>