<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Log Aktivitas Kelas</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      background: #f8f9fa;
    }
    .log-card {
      margin: 30px auto;
      max-width: 900px;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

  <div class="card log-card">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
      <h3 class="mb-0"><i class="fa-solid fa-clipboard-list"></i> Log Aktivitas Kelas</h3>
      <a href="<?= site_url('kelas') ?>" class="btn btn-light btn-sm">
        <i class="fa-solid fa-arrow-left"></i> Kembali
      </a>
    </div>

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
          <thead class="table-dark">
            <tr>
              <th><i class="fa-regular fa-clock"></i> Waktu</th>
              <th><i class="fa-solid fa-chalkboard"></i> Nama Kelas</th>
              <th><i class="fa-solid fa-user"></i> User</th>
              <th><i class="fa-solid fa-gear"></i> Aksi</th>
              <th><i class="fa-solid fa-note-sticky"></i> Keterangan</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($log as $l): ?>
            <tr>
              <td><?= $l->waktu ?></td>
              <td><?= $l->nama_kelas ?></td>
              <td><?= $l->nama_user ?: '-' ?></td>
              <td>
                <?php if ($l->aksi == "isi"): ?>
                  <span class="badge bg-success"><i class="fa-solid fa-check"></i> <?= $l->aksi ?></span>
                <?php elseif ($l->aksi == "kosongkan"): ?>
                  <span class="badge bg-danger"><i class="fa-solid fa-xmark"></i> <?= $l->aksi ?></span>
                <?php else: ?>
                  <span class="badge bg-secondary"><i class="fa-solid fa-info-circle"></i> <?= $l->aksi ?></span>
                <?php endif; ?>
              </td>
              <td><?= $l->keterangan ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
