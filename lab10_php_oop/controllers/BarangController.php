<?php
/**
 * Class BarangController
 * Deskripsi: Controller untuk handle request barang
 */

require_once 'models/Barang.php';
require_once 'lib/Form.php';

class BarangController {
    protected $model;

    public function __construct() {
        $this->model = new Barang();
    }

    /**
     * Tampilkan list barang
     */
    public function index() {
        $result = $this->model->getAll();
        include 'views/barang/list.php';
    }

    /**
     * Form tambah barang
     */
    public function add() {
        // Proses form jika ada submit
        if (isset($_POST['submit'])) {
            // Set properties
            $this->model->nama = $_POST['nama'];
            $this->model->kategori = $_POST['kategori'];
            $this->model->harga_beli = $_POST['harga_beli'];
            $this->model->harga_jual = $_POST['harga_jual'];
            $this->model->stok = $_POST['stok'];

            // Upload gambar
            if (isset($_FILES['file_gambar'])) {
                $gambar = $this->model->uploadImage($_FILES['file_gambar']);
                if ($gambar) {
                    $this->model->gambar = $gambar;
                }
            }

            // Insert ke database
            if ($this->model->insert()) {
                echo "<script>alert('Data berhasil ditambahkan'); window.location='index.php?page=barang/list';</script>";
                exit;
            } else {
                $error = "Gagal menambahkan data";
            }
        }

        // Buat form menggunakan class Form
        $form = new Form("index.php?page=barang/add", "Simpan");
        $form->addInput("nama", "Nama Barang", "text", "", true);
        $form->addSelect("kategori", "Kategori", $this->model->getKategoriList(), "", true);
        $form->addInput("harga_beli", "Harga Beli", "number", "", true);
        $form->addInput("harga_jual", "Harga Jual", "number", "", true);
        $form->addInput("stok", "Stok", "number", "", true);
        $form->addFile("file_gambar", "Gambar");

        // Load view
        include 'views/barang/form_add.php';
    }

    /**
     * Form edit barang
     */
    public function edit($id) {
        if (!$id) {
            echo "<script>alert('ID tidak ditemukan'); window.location='index.php?page=barang/list';</script>";
            exit;
        }

        // Ambil data barang
        $data = $this->model->getById($id);

        if (!$data) {
            echo "<script>alert('Data tidak ditemukan'); window.location='index.php?page=barang/list';</script>";
            exit;
        }

        // Proses form jika ada submit
        if (isset($_POST['submit'])) {
            // Set properties
            $this->model->nama = $_POST['nama'];
            $this->model->kategori = $_POST['kategori'];
            $this->model->harga_beli = $_POST['harga_beli'];
            $this->model->harga_jual = $_POST['harga_jual'];
            $this->model->stok = $_POST['stok'];

            // Upload gambar baru jika ada
            if (isset($_FILES['file_gambar']) && $_FILES['file_gambar']['error'] == 0) {
                $gambar = $this->model->uploadImage($_FILES['file_gambar']);
                if ($gambar) {
                    // Hapus gambar lama
                    if (!empty($data['gambar'])) {
                        $this->model->deleteImage($data['gambar']);
                    }
                    $this->model->gambar = $gambar;
                }
            }

            // Update ke database
            if ($this->model->update($id)) {
                echo "<script>alert('Data berhasil diupdate'); window.location='index.php?page=barang/list';</script>";
                exit;
            } else {
                $error = "Gagal mengupdate data";
            }
        }

        // Buat form menggunakan class Form
        $form = new Form("index.php?page=barang/edit&id=" . $id, "Update");
        $form->addInput("nama", "Nama Barang", "text", $data['nama'], true);
        $form->addSelect("kategori", "Kategori", $this->model->getKategoriList(), $data['kategori'], true);
        $form->addInput("harga_beli", "Harga Beli", "number", $data['harga_beli'], true);
        $form->addInput("harga_jual", "Harga Jual", "number", $data['harga_jual'], true);
        $form->addInput("stok", "Stok", "number", $data['stok'], true);
        $form->addFile("file_gambar", "Ganti Gambar (Opsional)");

        // Load view
        include 'views/barang/form_edit.php';
    }

    /**
     * Hapus barang
     */
    public function delete($id) {
        if (!$id) {
            header('Location: index.php?page=barang/list');
            exit;
        }

        // Ambil data untuk hapus gambar
        $data = $this->model->getById($id);

        // Hapus dari database
        if ($this->model->delete($id)) {
            // Hapus file gambar
            if (!empty($data['gambar'])) {
                $this->model->deleteImage($data['gambar']);
            }
        }

        header('Location: index.php?page=barang/list');
        exit;
    }
}
?>