<?php
// Ini buat nyambungin ke database, path-nya harus benar ya!
// Pastikan path ke koneksi/koneksi.php sudah benar dari folder actions/
require '../../koneksi/koneksi.php';

// Ambil parameter lokasi (domestic/international)
$location = $_GET['location'] ?? 'domestic'; 

// Terjemahkan lokasi ke format database
$negara_filter = ($location === 'domestic') ? 'Dalam negeri' : 'Luar negeri';

// Cek kalau ada error di luar itu
if ($location !== 'domestic' && $location !== 'international') {
    die("<div class=\"alert alert-danger\">Parameter lokasi ($location) gak valid, bro.</div>");
}

// Query utamanya: JOIN 4 tabel, mengambil SEMUA detail
$query = "
    SELECT
        b.nama_beasiswa, 
        b.deadline, 
        b.deskripsi AS deskripsi_singkat, 
        b.link_daftar, 
        
        -- Gabungin semua detail info
        GROUP_CONCAT(DISTINCT db.isi_detail SEPARATOR ' ||| ') AS detail_isi_beasiswa,
        
        -- Gabungin semua persyaratan
        GROUP_CONCAT(DISTINCT CONCAT(dp.kategori, ': ', dp.persyaratan) SEPARATOR ' ||| ') AS daftar_persyaratan,

        -- Gabungin semua dokumen
        GROUP_CONCAT(DISTINCT d.isi_dokumen SEPARATOR ' ||| ') AS daftar_dokumen
        
    FROM 
        beasiswa b
    LEFT JOIN detail_beasiswa db ON b.id = db.beasiswa_id
    LEFT JOIN detail_persyaratan dp ON b.id = dp.beasiswa_id
    LEFT JOIN dokumen d ON b.id = d.beasiswa_id
    
    -- Filter beasiswa S2 berdasarkan negara
    WHERE 
        b.jenjang = 'S2' AND b.negara = ? 
        
    GROUP BY 
        b.id
        
    ORDER BY 
        b.deadline ASC
";

$stmt = $db->prepare($query);

if ($stmt === false) {
    die("<div class=\"alert alert-danger\">Error SQL: " . $db->error . "</div>");
}

// Bind parameter dan eksekusi
$stmt->bind_param("s", $negara_filter);
$stmt->execute();
$result = $stmt->get_result();
?>

<!-- Output HTML buat di-load ke halaman S2.php -->
<?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="card mb-3 shadow-sm border-0 rounded-lg">
            <div class="card-body">
                <h5 class="card-title text-primary fw-bold"><?= htmlspecialchars($row['nama_beasiswa']) ?></h5>
                <p class="card-text text-muted small mb-3">
                    Deadline: <span class="badge bg-danger text-white"><?= htmlspecialchars($row['deadline']) ?></span>
                </p>
                
                <p class="card-text small text-dark mb-3"><?= nl2br(htmlspecialchars($row['deskripsi_singkat'])) ?></p>
                
                <hr class="my-2">
                
                <!-- DETAIL PERSYARATAN (dari tabel detail_persyaratan) -->
                <?php 
                    $persyaratan = explode(' ||| ', $row['daftar_persyaratan']); 
                    // Pastikan detail pertama bukan string 'NULL' yang mungkin muncul dari LEFT JOIN
                    if (!empty($persyaratan[0]) && $persyaratan[0] != 'NULL'):
                ?>
                    <p class="mb-1 mt-2 fw-semibold text-success">Syarat Penting:</p>
                    <ul class="list-unstyled small ps-3">
                        <?php foreach($persyaratan as $syarat): ?>
                            <li class="text-secondary">- <?= htmlspecialchars($syarat) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <!-- DETAIL INFO LAIN (dari tabel detail_beasiswa) -->
                <?php 
                    $details = explode(' ||| ', $row['detail_isi_beasiswa']); 
                    if (!empty($details[0]) && $details[0] != 'NULL'):
                ?>
                    <p class="mb-1 mt-2 fw-semibold text-info">Detail Info Lain:</p>
                    <ul class="list-unstyled small ps-3">
                        <?php foreach($details as $detail): ?>
                            <li class="text-secondary">- <?= htmlspecialchars($detail) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <!-- DETAIL DOKUMEN (dari tabel dokumen) -->
                <?php 
                    $dokumen = explode(' ||| ', $row['daftar_dokumen']); 
                    if (!empty($dokumen[0]) && $dokumen[0] != 'NULL'):
                ?>
                    <p class="mb-1 mt-2 fw-semibold text-warning">Dokumen Wajib Disiapkan:</p>
                    <ul class="list-unstyled small ps-3">
                        <?php foreach($dokumen as $doc): ?>
                            <li class="text-secondary">- <?= htmlspecialchars($doc) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>


                <!-- Tombol Daftar -->
                <?php if (!empty($row['link_daftar'])): ?>
                    <a href="<?= htmlspecialchars($row['link_daftar']) ?>" target="_blank" class="btn btn-sm btn-primary mt-3 w-100">Cek & Daftar Sekarang!</a>
                <?php endif; ?>
            </div>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <div class="alert alert-info text-center" role="alert">
        Waduh, belum ada Beasiswa S2 untuk lokasi "<?= htmlspecialchars($negara_filter) ?>" nih. Cek lagi nanti ya!
    </div>
<?php endif; ?>