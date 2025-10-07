<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login Komting</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <!-- SweetAlert2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

  <style>
    body {
      background: #f4f6f9;
    }
    .login-card {
      max-width: 400px;
      margin: 80px auto;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      background: #fff;
    }
  </style>
</head>
<body>

  <div class="login-card">
    <h3 class="text-center mb-4"><i class="fa-solid fa-right-to-bracket"></i> Login Komting</h3>

    <form method="post" action="<?= site_url('auth/login') ?>">
      <div class="mb-3">
        <label class="form-label"><i class="fa-solid fa-user"></i> Username</label>
        <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
      </div>

      <div class="mb-3">
        <label class="form-label"><i class="fa-solid fa-lock"></i> Password</label>
        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
      </div>

      <button type="submit" class="btn btn-primary w-100">
        <i class="fa-solid fa-paper-plane"></i> Login
      </button>
    </form>
  </div>

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <?php if ($this->session->flashdata('error')): ?>
  <script>
    Swal.fire({
      icon: 'error',
      title: 'Login Gagal!',
      text: '<?= $this->session->flashdata('error'); ?>',
      confirmButtonText: '<i class="fa-solid fa-check"></i> OK'
    });
  </script>
  <?php endif; ?>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
