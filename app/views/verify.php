<!-- app/Views/verify.php -->
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Verify Code</title>
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
    a{color:#ff914d;text-decoration:none}
  </style>
</head>
<body>
  <div class="card">
    <h1>Enter verification code</h1>
    <p class="muted">We sent a 6-digit code to the phone you provided.</p>

    <form action="<?= site_url('/verify') ?>" method="post">
      <label for="phone">Phone</label>
     <?php 
$phone = isset($_GET['phone']) ? htmlspecialchars($_GET['phone']) : '';
?>
<input id="phone" name="phone" type="text" value="<?= $phone ?>" required>

      <label for="otp">6-digit code</label>
      <input id="otp" name="otp" type="text" pattern="\d{6}" maxlength="6" required>

      <button type="submit">Verify code</button>
    </form>

    <p class="muted">Didn't receive a code? <a href="<?= site_url('/register') ?>">Send again</a></p>
  </div>
</body>
</html>
