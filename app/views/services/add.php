<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Service | Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

:root {
  --primary: #ff914d;
  --primary-dark: #ff7a1f;
  --bg: linear-gradient(135deg, #fff7f0 0%, #f8fafc 100%);
  --card: rgba(255, 255, 255, 0.9);
  --text: #222;
  --border: #e5e7eb;
  --shadow: 0 8px 25px rgba(0,0,0,0.08);
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Inter', sans-serif;
  background: var(--bg);
  color: var(--text);
  line-height: 1.6;
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

/* CONTAINER */
.container {
  max-width: 600px;
  width: 90%;
  margin: auto;
  margin-top: 80px;
  margin-bottom: 60px;
  background: var(--card);
  backdrop-filter: blur(16px);
  border-radius: 20px;
  padding: 50px 40px;
  box-shadow: var(--shadow);
  animation: fadeUp 0.5s ease;
  border: 1px solid rgba(255,145,77,0.15);
}

@keyframes fadeUp {
  from { opacity: 0; transform: translateY(25px); }
  to { opacity: 1; transform: translateY(0); }
}

h2 {
  color: var(--primary);
  font-weight: 700;
  text-align: center;
  margin-bottom: 30px;
  letter-spacing: -0.5px;
}

/* FORM ELEMENTS */
form label {
  display: block;
  font-weight: 600;
  margin-bottom: 6px;
  color: #444;
}

form input, form textarea {
  width: 100%;
  padding: 12px 14px;
  border: 1px solid var(--border);
  border-radius: 10px;
  margin-bottom: 18px;
  font-size: 0.95rem;
  background: #fff;
  transition: border 0.2s ease, box-shadow 0.2s ease;
}

form input:focus, form textarea:focus {
  border-color: var(--primary);
  outline: none;
  box-shadow: 0 0 0 3px rgba(255,145,77,0.25);
}

/* BUTTONS */
.btn-save {
  background: var(--primary);
  color: #fff;
  padding: 12px 28px;
  border-radius: 10px;
  border: none;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 4px 14px rgba(255,145,77,0.3);
}
.btn-save:hover {
  background: var(--primary-dark);
  transform: translateY(-2px);
  box-shadow: 0 6px 18px rgba(255,145,77,0.35);
}

.btn-secondary {
  background: #f3f4f6;
  color: #333;
  padding: 12px 28px;
  border-radius: 10px;
  text-decoration: none;
  font-weight: 600;
  transition: all 0.3s ease;
}
.btn-secondary:hover {
  background: #e5e7eb;
  transform: translateY(-2px);
}

/* BUTTON WRAPPER */
.actions {
  display: flex;
  justify-content: center;
  gap: 15px;
  margin-top: 25px;
}

/* FOOTER */
footer {
  text-align: center;
  padding: 20px;
  color: #777;
  font-size: 0.9rem;
  margin-top: auto;
}
</style>
</head>

<body>

<div class="container">
  <h2>Add Service</h2>

  <form method="POST" action="<?= site_url('services/add') ?>">
    <label for="service_name">Service Name</label>
    <input type="text" name="service_name" id="service_name" placeholder="Enter service name" required>

    <label for="description">Description</label>
    <textarea name="description" id="description" rows="3" placeholder="Enter service description"></textarea>

    <label for="fee">Price (₱)</label>
    <input type="number" step="0.01" name="fee" id="fee" placeholder="Enter service price" required>

    <div class="actions">
      <button type="submit" class="btn-save">Save Service</button>
      <a href="<?= site_url('services') ?>" class="btn-secondary">Back</a>
    </div>
  </form>
</div>

<footer>
  &copy; <?= date('Y'); ?> Automated Scheduling and Tracking System for Veterinary Services – Calapan City, Oriental Mindoro
</footer>

</body>
</html>
