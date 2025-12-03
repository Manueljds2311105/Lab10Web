<?php
/**
 * Class Barang
 * Deskripsi: Class untuk handle data barang (Model)
 */

require_once 'lib/Database.php';

class Barang {
    protected $db;
    protected $table = 'data_barang';

    // Properties
    public $id_barang;
    public $nama;
    public $kategori;
    public $harga_beli;
    public $harga_jual;
    public $stok;
    public $gambar;

    public function __construct() {
        try {
            $this->db = new Database();
        } catch (Exception $e) {
            die("Error Database Connection: " . $e->getMessage());
        }
    }

    /**
     * Ambil semua data barang
     */
    public function getAll() {
        return $this->db->get($this->table);
    }

    /**
     * Ambil data barang berdasarkan ID
     */
    public function getById($id) {
        return $this->db->getOne($this->table, "id_barang = '$id'");
    }

    /**
     * Cari barang berdasarkan nama
     */
    public function search($keyword) {
        $sql = "SELECT * FROM {$this->table} WHERE nama LIKE '%{$keyword}%' OR kategori LIKE '%{$keyword}%'";
        return $this->db->query($sql);
    }

    /**
     * Tambah data barang
     */
    public function insert() {
        $data = array(
            'nama' => $this->nama,
            'kategori' => $this->kategori,
            'harga_beli' => $this->harga_beli,
            'harga_jual' => $this->harga_jual,
            'stok' => $this->stok,
            'gambar' => $this->gambar
        );

        return $this->db->insert($this->table, $data);
    }

    /**
     * Update data barang
     */
    public function update($id) {
        $data = array(
            'nama' => $this->nama,
            'kategori' => $this->kategori,
            'harga_beli' => $this->harga_beli,
            'harga_jual' => $this->harga_jual,
            'stok' => $this->stok
        );

        // Tambahkan gambar jika ada
        if (!empty($this->gambar)) {
            $data['gambar'] = $this->gambar;
        }

        return $this->db->update($this->table, $data, "id_barang = '$id'");
    }

    /**
     * Hapus data barang
     */
    public function delete($id) {
        return $this->db->delete($this->table, "id_barang = '$id'");
    }

    /**
     * Upload gambar
     */
    public function uploadImage($file) {
        if ($file['error'] == 0) {
            $filename = str_replace(' ', '_', $file['name']);
            $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            // Validasi ekstensi file
            if (!in_array($extension, ALLOWED_EXTENSIONS)) {
                return false;
            }

            // Validasi ukuran file
            if ($file['size'] > MAX_FILE_SIZE) {
                return false;
            }

            // Buat nama file unik
            $newFilename = time() . '_' . $filename;
            $destination = UPLOAD_PATH . $newFilename;

            // Buat folder jika belum ada
            if (!file_exists(UPLOAD_PATH)) {
                mkdir(UPLOAD_PATH, 0777, true);
            }

            // Upload file
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                return 'gambar/' . $newFilename;
            }
        }

        return false;
    }

    /**
     * Hapus file gambar
     */
    public function deleteImage($filename) {
        if (file_exists($filename)) {
            return unlink($filename);
        }
        return false;
    }

    /**
     * Get kategori list
     */
    public function getKategoriList() {
        return array(
            'Komputer' => 'Komputer',
            'Elektronik' => 'Elektronik',
            'Hand Phone' => 'Hand Phone'
        );
    }
}
?>