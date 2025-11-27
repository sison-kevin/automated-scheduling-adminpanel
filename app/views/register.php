<!-- app/Views/register.php -->
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Sign Up</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    body{font-family:Inter,system-ui,Arial;margin:0;background:#f7f9fb}
    .card{max-width:420px;margin:80px auto;padding:28px;background:#fff;border-radius:8px;box-shadow:0 6px 18px rgba(20,20,50,.06)}
    h1{margin:0 0 10px;font-size:20px}
    label{display:block;margin-top:12px;font-size:13px;color:#222}
    input{width:100%;padding:10px;margin-top:6px;border:1px solid #e5e7eb;border-radius:8px}
    button{margin-top:18px;width:100%;padding:10px;border:0;border-radius:8px;background:linear-gradient(135deg,#ff914d,#ffb47b);color:#fff;font-weight:600;cursor:pointer;transition:all .15s}
    button:hover{background:linear-gradient(135deg,#ff7a33,#ff9d5c);transform:translateY(-1px)}
    .muted{font-size:13px;color:#6b7280;margin-top:12px}
    a{color:#ff914d;text-decoration:none}
  </style>
</head>
<body>
  <div class="card">
    <h1>Create account</h1>
    <p class="muted">Enter your details to sign up. OTP will be sent to your phone.</p>

    <form action="<?= site_url('/signup') ?>" method="post">
      <label for="name">Full name</label>
      <input id="name" name="name" type="text" required>

      <label for="username">Username</label>
      <input id="username" name="username" type="text" required>

      <label for="phone">Phone (+63XXXXXXXXXX)</label>
      <input id="phone" name="phone" type="text" placeholder="+63" required>

      <button type="submit">Send verification code</button>
    </form>

    <p class="muted">Already have an account? <a href="<?= site_url('/login') ?>">Log in</a></p>
  </div>
</body>
</html>
