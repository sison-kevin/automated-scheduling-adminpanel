<!-- app/Views/set-password.php -->
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Set Password</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    body{font-family:Inter,system-ui,Arial;margin:0;background:#f7f9fb}
    .card{max-width:420px;margin:80px auto;padding:22px;background:#fff;border-radius:8px;box-shadow:0 6px 18px rgba(20,20,50,.06)}
    h1{margin:0 0 10px;font-size:20px;color:#222}
    label{color:#222}
    input{width:100%;padding:10px;margin-top:8px;border:1px solid #e5e7eb;border-radius:8px}
    button{margin-top:16px;width:100%;padding:10px;border:0;border-radius:8px;background:linear-gradient(135deg,#ff914d,#ffb47b);color:#fff;font-weight:600;cursor:pointer;transition:all .15s}
    button:hover{background:linear-gradient(135deg,#ff7a33,#ff9d5c);transform:translateY(-1px)}
    .muted{font-size:13px;color:#6b7280;margin-top:12px}
  </style>
</head>
<body>
  <div class="card">
    <h1>Create a password</h1>
    <p class="muted">Choose a secure password for your account.</p>

    <form action="<?= site_url('/set-password') ?>" method="post">
      <label for="phone">Phone</label>
      <input id="phone" name="phone" type="text" value="<?= esc(get('phone') ?? (isset($_GET['phone'])? $_GET['phone'] : '')) ?>" required>

      <label for="password">Password</label>
      <input id="password" name="password" type="password" minlength="6" required>

      <label for="password2">Confirm password</label>
      <input id="password2" name="password2" type="password" minlength="6" required>

      <button type="submit">Save password</button>
    </form>
  </div>

  <script>
    // simple client-side confirmation check
    const form = document.querySelector('form');
    form.addEventListener('submit', (e) => {
      const p1 = document.getElementById('password').value;
      const p2 = document.getElementById('password2').value;
      if (p1 !== p2) {
        e.preventDefault();
        alert('Passwords do not match.');
        return false;
      }
    });
  </script>
</body>
</html>
