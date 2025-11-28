<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title> PetCare Admin Login</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

    :root {
      --primary: #ff914d;
      --light-orange: #ffb47b;
      --bg: #f7f9fb;
      --text: #222;
      --card: #fff;
      --border: #e5e7eb;
      --muted: #f3f4f6;
      --muted-foreground: #6b7280;
      --radius: 8px;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
      background: var(--bg);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      -webkit-font-smoothing: antialiased;
      font-size: 16px;
    }

    /* HEADER / LOGO */
    .header {
      position: fixed;
      top: 24px;
      left: 32px;
      display: flex;
      align-items: center;
      z-index: 100;
    }

    .logo {
      font-size: 1.5rem;
      font-weight: 600;
      color: var(--text);
      letter-spacing: -0.025em;
      display: flex;
      align-items: center;
    }

    .admin-badge {
      background: linear-gradient(135deg, var(--primary), var(--light-orange));
      color: #fff;
      font-size: 0.75rem;
      font-weight: 500;
      padding: 4px 10px;
      border-radius: var(--radius);
      margin-left: 8px;
    }



    /* LOGIN CARD */
    .login-card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: 40px;
      width: 100%;
      max-width: 420px;
      box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
      text-align: center;
    }

    .login-card h2 {
      font-size: 1.5rem;
      color: var(--text);
      margin-bottom: 28px;
      font-weight: 700;
      letter-spacing: -0.025em;
    }

    .login-card form {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .form-input {
      position: relative;
      text-align: left;
    }

    .form-input label {
      display: block;
      font-size: 0.9375rem;
      font-weight: 500;
      color: var(--text);
      margin-bottom: 8px;
    }

    .form-input input {
      width: 100%;
      height: 44px;
      padding: 0 14px;
      border: 1px solid var(--border);
      border-radius: var(--radius);
      font-size: 0.9375rem;
      background: var(--card);
      color: var(--text);
      transition: all 0.15s;
      outline: none;
    }

    /* Password wrapper to position the eye icon */
    .password-wrapper {
      position: relative;
      display: block;
    }

    .toggle-password {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      background: transparent;
      border: none;
      cursor: pointer;
      color: var(--muted-foreground);
      font-size: 18px;
      line-height: 1;
      padding: 4px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }

    .form-input input:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(255, 145, 77, 0.1);
    }

    .login-btn {
      height: 44px;
      padding: 0 20px;
      background: linear-gradient(135deg, var(--primary), var(--light-orange));
      border: none;
      border-radius: var(--radius);
      color: #fff;
      font-size: 0.9375rem;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.15s;
      margin-top: 8px;
    }

    .login-btn:hover {
      background: linear-gradient(135deg, #ff7a33, #ff9d5c);
      transform: translateY(-1px);
    }

    .login-btn:active {
      scale: 0.98;
    }

    .footer-text {
      margin-top: 24px;
      font-size: 0.875rem;
      color: var(--muted-foreground);
    }

  </style>
  <?php if (config_item('recaptcha_site_key')): ?>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <?php endif; ?>
</head>
<body>

  <!-- HEADER -->
  <div class="header">
    <div class="logo">
      PetCare
      <div class="admin-badge">Admin</div>
    </div>
  </div>

  <!-- LOGIN CARD -->
  <div class="login-card">
    <h2>Admin Login</h2>
    <form action="<?= site_url('login/submit') ?>" method="POST">
      <div class="form-input">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Enter your username" required>
      </div>
      <div class="form-input">
        <label for="password">Password</label>
        <span class="password-wrapper">
          <input type="password" id="password" name="password" placeholder="Enter your password" required>
          <button type="button" class="toggle-password" aria-label="Show password" title="Show password">&#128065;</button>
        </span>
      </div>
      <?php if (config_item('recaptcha_site_key')): ?>
      <div class="form-input">
        <div class="g-recaptcha" data-sitekey="<?= config_item('recaptcha_site_key') ?>"></div>
      </div>
      <?php endif; ?>
      <button type="submit" class="login-btn">Login</button>
    </form>

    <p class="footer-text">© 2025 PetCare Veterinary Portal</p>
  </div>



  <script>
    (function(){
      var btn = document.querySelector('.toggle-password');
      if (!btn) return;
      var input = document.getElementById('password');
      btn.addEventListener('click', function(e){
        e.preventDefault();
        if (!input) return;
        if (input.type === 'password') {
          input.type = 'text';
          btn.setAttribute('aria-label', 'Hide password');
          btn.title = 'Hide password';
          btn.innerHTML = '&#128064;';
        } else {
          input.type = 'password';
          btn.setAttribute('aria-label', 'Show password');
          btn.title = 'Show password';
          btn.innerHTML = '&#128065;';
        }
      });
    })();
  </script>
</body>
</html>
