<?php if (config_item('recaptcha_site_key')): ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php endif; ?>
<form method="post" action="/login">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <?php if (config_item('recaptcha_site_key')): ?>
    <div class="g-recaptcha" data-sitekey="<?= config_item('recaptcha_site_key') ?>"></div>
    <?php endif; ?>
    <button type="submit">Login</button>
</form>
