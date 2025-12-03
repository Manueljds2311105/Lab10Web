<div class="content">
    <h2>Data Barang</h2>
    <div class="actions">
        <a href="index.php?page=barang/add" class="btn-tambah">+ Tambah Barang</a>
    </div>
    
    <div class="main">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Gambar</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id_barang']; ?></td>
                        <td>
                            <?php if(!empty($row['gambar'])): ?>
                                <img src="<?= $row['gambar']; ?>" alt="<?= $row['nama']; ?>" width="80">
                            <?php else: ?>
                                <span style="color: #999;">No Image</span>
                            <?php endif; ?>
                        </td>
                        <td><?= $row['nama']; ?></td>
                        <td><?= $row['kategori']; ?></td>
                        <td>Rp <?= number_format($row['harga_beli'], 0, ',', '.'); ?></td>
                        <td>Rp <?= number_format($row['harga_jual'], 0, ',', '.'); ?></td>
                        <td><?= $row['stok']; ?></td>
                        <td>
                            <a href="index.php?page=barang/edit&id=<?= $row['id_barang']; ?>" class="btn-edit">Edit</a>
                            <a href="index.php?page=barang/delete&id=<?= $row['id_barang']; ?>" 
                               onclick="return confirm('Yakin ingin menghapus data ini?')" 
                               class="btn-hapus">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" style="text-align: center;">Belum ada data</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>