<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<form method="post" action="/login">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <div class="g-recaptcha" data-sitekey="<?= config_item('recaptcha_site_key') ?>"></div>
    <button type="submit">Login</button>
</form>
