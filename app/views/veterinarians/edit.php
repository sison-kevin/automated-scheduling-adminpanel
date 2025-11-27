<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Veterinarian | Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

:root {
  --primary: #ff914d;
  --primary-dark: #ff7a1f;
  --bg: linear-gradient(135deg, #fff7f0 0%, #f8fafc 100%);
  --card: rgba(255, 255, 255, 0.95);
  --text: #1f2937;
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
  margin-bottom: 35px;
  letter-spacing: -0.5px;
}

/* FORM STYLES */
form label {
  display: block;
  font-weight: 600;
  margin-bottom: 6px;
  color: #374151;
}

form input {
  width: 100%;
  padding: 12px 14px;
  border: 1px solid var(--border);
  border-radius: 10px;
  margin-bottom: 20px;
  font-size: 0.95rem;
  background: #fff;
  transition: border 0.2s ease, box-shadow 0.2s ease;
}

form input:focus {
  border-color: var(--primary);
  outline: none;
  box-shadow: 0 0 0 3px rgba(255,145,77,0.25);
}

form select {
  width: 100%;
  padding: 12px 14px;
  border: 1px solid var(--border);
  border-radius: 10px;
  margin-bottom: 20px;
  font-size: 0.95rem;
  background: #fff;
  transition: border 0.2s ease, box-shadow 0.2s ease;
  cursor: pointer;
}

form select:focus {
  border-color: var(--primary);
  outline: none;
  box-shadow: 0 0 0 3px rgba(255,145,77,0.25);
}

/* BUTTONS */
.actions {
  display: flex;
  justify-content: center;
  gap: 15px;
  margin-top: 25px;
}

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
  border: 1px solid #e5e7eb;
}

.btn-secondary:hover {
  background: #e5e7eb;
  transform: translateY(-2px);
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
  <h2>Edit Veterinarian</h2>

  <form method="POST" action="<?= site_url('./veterinarians/edit/' . $vet['id']) ?>">
    <label for="name">Full Name</label>
    <input type="text" id="name" name="name" value="<?= $vet['name'] ?>" placeholder="Enter veterinarian name" required>

    <label for="specialization">Specialization</label>
    <input type="text" id="specialization" name="specialization" value="<?= $vet['specialization'] ?>" placeholder="Enter field of specialization">

    <label for="contact">Contact</label>
    <input type="text" id="contact" name="contact" value="<?= $vet['contact'] ?>" placeholder="Enter contact number or email">

    <label for="is_active">Status</label>
    <select id="is_active" name="is_active">
      <option value="1" <?= $vet['is_active'] == 1 ? 'selected' : '' ?>>Active</option>
      <option value="0" <?= $vet['is_active'] == 0 ? 'selected' : '' ?>>Inactive</option>
    </select>

    <div class="actions">
      <button type="submit" class="btn-save">Update Veterinarian</button>
      <a href="<?= site_url('veterinarians') ?>" class="btn-secondary">Back</a>
    </div>
  </form>
</div>

<footer>
  &copy; <?= date('Y'); ?> Automated Scheduling and Tracking System for Veterinary Services – Calapan City, Oriental Mindoro
</footer>

</body>
</html>
