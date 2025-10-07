<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Status Kelas</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <!-- SweetAlert2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body class="container py-4">

  <h3 class="mb-3"><i class="fa-solid fa-chalkboard"></i> Status Kelas</h3>

  <div class="mb-3">
    <span class="badge bg-primary">
      <i class="fa-solid fa-user"></i> Login sebagai: <b><?= $this->session->userdata('nama') ?></b>
    </span>
    <a href="<?= site_url('auth/logout') ?>" class="btn btn-danger btn-sm ms-2">
      <i class="fa-solid fa-right-from-bracket"></i> Logout
    </a>
    <a href="<?= site_url('kelas/log') ?>" class="btn btn-info btn-sm ms-2">
      <i class="fa-solid fa-clock-rotate-left"></i> Lihat Log
    </a>
  </div>

  <!-- SweetAlert Flashdata -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <?php if ($this->session->flashdata('msg')): 
    $msg = $this->session->flashdata('msg'); 
    if (is_array($msg)): ?>
      <script>
        Swal.fire({
          icon: '<?= $msg['type']; ?>',
          title: '<?= $msg['title']; ?>',
          html: '<?= $msg['text']; ?>',
          timer: 3000,
          showConfirmButton: false
        });
      </script>
    <?php else: ?>
      <script>
        Swal.fire({
          icon: 'success',
          title: 'Berhasil!',
          text: '<?= $msg; ?>',
          timer: 3000,
          showConfirmButton: false
        });
      </script>
    <?php endif; ?>
  <?php endif; ?>

  <!-- Area scanner -->
  <div class="card shadow mb-4">
    <div class="card-header bg-success text-white">
      <i class="fa-solid fa-qrcode"></i> Scan QR Code
    </div>
    <div class="card-body text-center">
      <div id="reader" style="width:300px; margin:auto"></div>
      <form id="scanForm" method="post" action="<?= site_url('kelas/scan') ?>">
        <input type="hidden" name="kode" id="kode">
        <input type="text" class="form-control mt-3" name="keterangan" id="keterangan" 
               placeholder="Kasih keterangan (opsional)">
      </form>
    </div>
  </div>

  <!-- Tabel Bootstrap -->
  <div class="card shadow">
    <div class="card-header bg-primary text-white">
      <i class="fa-solid fa-list"></i> Daftar Kelas
    </div>
    <div class="card-body">
      <table class="table table-bordered table-striped">
        <thead class="table-dark">
          <tr>
            <th><i class="fa-solid fa-chalkboard"></i> Nama Kelas</th>
            <th><i class="fa-solid fa-circle-info"></i> Status</th>
            <th><i class="fa-solid fa-user-tag"></i> Dipakai oleh</th>
            <th><i class="fa-solid fa-note-sticky"></i> Keterangan</th>
            <th><i class="fa-solid fa-gear"></i> Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($kelas as $k): ?>
          <tr>
            <td><?= $k->nama_kelas ?></td>
            <td>
              <?php if ($k->status == 'isi'): ?>
                <span class="badge bg-danger"><i class="fa-solid fa-lock"></i> Isi</span>
              <?php else: ?>
                <span class="badge bg-success"><i class="fa-solid fa-unlock"></i> Kosong</span>
              <?php endif; ?>
            </td>
            <td><?= $k->nama_user ?: '-' ?></td>
            <td><?= $k->keterangan ?: '-' ?></td>
            <td>
              <?php if ($k->status == 'isi' && $k->id_user == $this->session->userdata('user_id')): ?>
                <a href="<?= site_url('kelas/kosongkan/'.$k->id_kelas) ?>" 
                   class="btn btn-warning btn-sm">
                  <i class="fa-solid fa-ban"></i> Kosongkan
                </a>
              <?php else: ?>
                <span class="text-muted">-</span>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Script QR Code Scanner -->
  <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
  <script>
    function onScanSuccess(decodedText, decodedResult) {
      document.getElementById("kode").value = decodedText;

      // 🔹 SweetAlert Toast (notifikasi cepat)
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
      });
      Toast.fire({
        icon: 'info',
        title: 'QR Terdeteksi: ' + decodedText
      });

      // 🔹 SweetAlert konfirmasi sebelum submit
      Swal.fire({
        title: 'Konfirmasi Scan',
        text: "Kode QR: " + decodedText,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="fa-solid fa-paper-plane"></i> Kirim',
        cancelButtonText: '<i class="fa-solid fa-xmark"></i> Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById("scanForm").submit();
        }
      });
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
      "reader", { fps: 10, qrbox: 250 });
    html5QrcodeScanner.render(onScanSuccess);
  </script>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
