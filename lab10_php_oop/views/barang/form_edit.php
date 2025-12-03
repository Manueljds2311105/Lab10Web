<div class="content">
    <h2>Edit Barang</h2>
    
    <?php if(isset($error)): ?>
        <div class="alert alert-error">
            <?= $error; ?>
        </div>
    <?php endif; ?>
    
    <div class="main">
        <div class="form-info">
            <p><strong>Form dibuat menggunakan Class Form (OOP)</strong></p>
            <p>Field yang diberi tanda <span style="color:red;">*</span> wajib diisi</p>
        </div>
        
        <div class="current-image">
            <label>Gambar Saat Ini:</label>
            <?php if(!empty($data['gambar'])): ?>
                <img src="<?= $data['gambar']; ?>" alt="<?= $data['nama']; ?>" width="200" style="border-radius: 4px; margin: 10px 0;">
            <?php else: ?>
                <p style="color: #999;">Tidak ada gambar</p>
            <?php endif; ?>
        </div>
        
        <?php 
        // Tampilkan form yang sudah dibuat di controller
        $form->displayForm(); 
        ?>
        
        <div class="form-actions">
            <a href="index.php?page=barang/list" class="btn-cancel">Kembali ke List</a>
        </div>
    </div>
</div>