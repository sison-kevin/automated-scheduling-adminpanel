<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Appointments | Admin Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
  color: var(--text);
  line-height: 1.6;
  -webkit-font-smoothing: antialiased;
  font-size: 16px;
}

/* ===== HEADER ===== */
header {
  position: sticky;
  top: 0;
  background: white;
  backdrop-filter: blur(8px);
  border-bottom: 1px solid var(--border);
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 16px 32px;
  z-index: 100;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

header h1 {
  color: var(--primary);
  font-size: 1.5rem;
  font-weight: 700;
  letter-spacing: -0.025em;
}

header > div {
  display: flex;
  align-items: center;
  gap: 16px;
}

.user-info {
  color: var(--muted-foreground);
  font-size: 0.9375rem;
}

.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  height: 40px;
  padding: 0 20px;
  background: var(--primary);
  color: white !important;
  border-radius: var(--radius);
  text-decoration: none;
  font-weight: 500;
  font-size: 0.9375rem;
  transition: all 0.2s;
  border: none;
  cursor: pointer;
  box-shadow: 0 2px 8px rgba(255, 145, 77, 0.2);
}

.btn:hover {
  background: var(--light-orange);
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(255, 145, 77, 0.3);
}

/* ===== LAYOUT ===== */
.dashboard {
  display: grid;
  grid-template-columns: 240px 1fr;
  min-height: calc(100vh - 64px);
}

/* ===== SIDEBAR ===== */
.sidebar {
  background: white;
  border-right: 1px solid var(--border);
  padding: 24px 16px;
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.sidebar h3 {
  padding: 12px 16px 8px;
  color: var(--muted-foreground);
  font-size: 0.75rem;
  font-weight: 700;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  margin-bottom: 4px;
}

.sidebar a {
  display: flex;
  align-items: center;
  padding: 12px 16px;
  border-radius: var(--radius);
  color: var(--muted-foreground);
  font-weight: 500;
  font-size: 0.9375rem;
  text-decoration: none;
  transition: all 0.2s;
  gap: 10px;
}

.sidebar a:hover {
  background: #fff7ed;
  color: var(--primary);
  transform: translateX(4px);
}

.sidebar a.active {
  background: linear-gradient(135deg, var(--primary), var(--light-orange));
  color: white;
  font-weight: 600;
  box-shadow: 0 4px 6px -1px rgba(255, 145, 77, 0.3);
}

/* ===== MAIN CONTENT ===== */
.main-content {
  padding: 48px 56px;
  max-width: 1600px;
  margin: 0 auto;
  background: var(--bg);
}

/* ===== CARD ===== */
.card {
  background: white;
  border: 1px solid var(--border);
  border-radius: var(--radius);
  padding: 40px;
  margin-bottom: 36px;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
  transition: all 0.3s;
}

.card:hover {
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.card h3 {
  color: var(--text);
  margin-bottom: 32px;
  font-size: 1.375rem;
  font-weight: 700;
  letter-spacing: -0.025em;
  display: flex;
  align-items: center;
  gap: 10px;
}

/* ===== TABLE ===== */
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
  background: white;
  border-radius: var(--radius);
  overflow: hidden;
  border: 1px solid var(--border);
}

th, td {
  padding: 20px 24px;
  text-align: left;
  border-bottom: 1px solid var(--border);
  vertical-align: middle;
  font-size: 0.9375rem;
}

th {
  background: var(--muted);
  color: var(--muted-foreground);
  font-weight: 600;
  font-size: 0.8125rem;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

tr:nth-child(even) {
  background: rgba(243, 244, 246, 0.5);
}

tr:hover {
  background: rgba(255, 145, 77, 0.05);
}

/* ===== STATUS BADGES ===== */
.badge {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 4px 10px;
  border-radius: 6px;
  font-weight: 500;
  font-size: 0.75rem;
  text-transform: capitalize;
  letter-spacing: 0.025em;
}

.bg-warning {
  background: #fef3c7;
  color: #92400e;
  border: 1px solid #fde68a;
}

.bg-info {
  background: #dbeafe;
  color: #1e40af;
  border: 1px solid #93c5fd;
}

.bg-success {
  background: #d1fae5;
  color: #065f46;
  border: 1px solid #6ee7b7;
}

.bg-danger {
  background: #fee2e2;
  color: #991b1b;
  border: 1px solid #fca5a5;
}

/* ===== ACTION BUTTONS ===== */
.action-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  padding: 6px 12px;
  border-radius: var(--radius);
  font-size: 0.8125rem;
  font-weight: 500;
  text-decoration: none;
  transition: all 0.15s;
  height: 32px;
}

.btn-edit {
  background: var(--muted);
  color: var(--text);
  border: 1px solid var(--border);
}

.btn-edit:hover {
  background: #fff7ed;
  border-color: var(--primary);
  color: var(--primary);
}

.btn-delete {
  background: #fee2e2;
  color: #991b1b;
  border: 1px solid #fca5a5;
}

.btn-delete:hover {
  background: #dc2626;
  color: white;
  border-color: #dc2626;
}

/* ===== FILTER BUTTONS ===== */
.filter-buttons {
  display: flex;
  gap: 8px;
  margin-bottom: 28px;
  flex-wrap: wrap;
}

.filter-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  height: 42px;
  padding: 0 20px;
  border-radius: var(--radius);
  font-weight: 500;
  font-size: 0.9375rem;
  cursor: pointer;
  transition: all 0.15s;
  border: 1px solid var(--border);
  background: white;
  color: var(--text);
  text-decoration: none;
}

.filter-btn:hover {
  background: #fff7ed;
  color: var(--primary);
  border-color: var(--light-orange);
}

.filter-btn.active {
  background: var(--primary);
  color: white;
  border-color: var(--primary);
  box-shadow: 0 2px 8px rgba(255, 145, 77, 0.3);
}

.filter-btn.all.active {
  background: #6b7280;
  color: white;
}

.filter-btn.approved.active {
  background: #3b82f6;
  color: white;
}

.filter-btn.pending.active {
  background: #f59e0b;
  color: white;
}

.filter-btn.cancelled.active {
  background: #dc2626;
  color: white;
}

.filter-btn.completed.active {
  background: #10b981;
  color: white;
}

.filter-count {
  background: rgba(255, 255, 255, 0.3);
  padding: 2px 8px;
  border-radius: 12px;
  font-size: 0.85rem;
  font-weight: 700;
}

/* ===== FOOTER ===== */
footer {
  text-align: center;
  padding: 20px;
  color: #666;
  font-size: 0.9rem;
  border-top: 1px solid var(--border);
  background: #fff;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 900px) {
  .dashboard {
    grid-template-columns: 1fr;
  }
  .sidebar {
    flex-direction: row;
    justify-content: center;
    border-right: none;
    border-bottom: 1px solid var(--border);
  }
  .main-content {
    padding: 30px 20px;
  }
  th, td {
    font-size: 0.9rem;
  }
}
</style>
</head>

<body>

<header>
  <div>
    <h1>PetCare Admin Dashboard</h1>
  </div>
  <div>
    <div class="user-info">
      <?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin'); ?> |
      <?= htmlspecialchars($_SESSION['user_email'] ?? 'admin@gmail.com'); ?>
    </div>
    <a href="<?= site_url('auth/logout') ?>" class="btn">Logout</a>
  </div>
</header>

<div class="dashboard">
  <!-- Sidebar -->
  <aside class="sidebar">
    <h3>Navigation</h3>
    <a href="<?= site_url('dashboard') ?>">Dashboard</a>
    <a href="<?= site_url('appointments') ?>" class="active">Appointments</a>
    <a href="<?= site_url('services') ?>">Services</a>
    <a href="<?= site_url('veterinarians') ?>">Veterinarians</a>
    <a href="<?= site_url('reports') ?>">Reports</a>
  </aside>

  <!-- Main Content -->
  <section class="main-content">
    <div class="card">
      <h3>Appointments Overview</h3>
      <a href="<?= site_url('appointments/add') ?>" class="btn" style="margin-bottom:20px;">Add Appointment</a>

      <!-- Filter Buttons -->
      <div class="filter-buttons">
        <button class="filter-btn all active" data-status="all">
          📋 All <span class="filter-count"><?= count($appointments) ?></span>
        </button>
        <button class="filter-btn approved" data-status="Approved">
          ✅ Approved <span class="filter-count"><?= count(array_filter($appointments, fn($a) => $a['status'] == 'Approved')) ?></span>
        </button>
        <button class="filter-btn pending" data-status="Pending">
          ⏳ Pending <span class="filter-count"><?= count(array_filter($appointments, fn($a) => $a['status'] == 'Pending')) ?></span>
        </button>
        <button class="filter-btn cancelled" data-status="Cancelled">
          ❌ Cancelled <span class="filter-count"><?= count(array_filter($appointments, fn($a) => $a['status'] == 'Cancelled')) ?></span>
        </button>
        <button class="filter-btn completed" data-status="Completed">
          ✔️ Completed <span class="filter-count"><?= count(array_filter($appointments, fn($a) => $a['status'] == 'Completed')) ?></span>
        </button>
      </div>

      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Client</th>
            <th>Veterinarian</th>
            <th>Service</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
            <th style="text-align:center;">Actions</th>
          </tr>
        </thead>
        <tbody id="appointmentsTable">
          <?php if (!empty($appointments)): ?>
            <?php foreach ($appointments as $a): ?>
              <tr data-status="<?= htmlspecialchars($a['status']); ?>">
                <td><?= htmlspecialchars($a['id']); ?></td>
                <td><?= htmlspecialchars($a['user_name']); ?></td>
                <td><?= htmlspecialchars($a['vet_name']); ?></td>
                <td><?= htmlspecialchars($a['service_name']); ?></td>
                <td><?= htmlspecialchars($a['appointment_date']); ?></td>
                <td><?= isset($a['appointment_time']) ? htmlspecialchars(substr($a['appointment_time'], 0, 5)) : '00:00'; ?></td>
                <td>
                  <span class="badge bg-<?=
                    $a['status'] == 'Pending' ? 'warning' :
                    ($a['status'] == 'Approved' ? 'info' :
                    ($a['status'] == 'Completed' ? 'success' : 'danger')) ?>">
                    <?= htmlspecialchars($a['status']); ?>
                  </span>
                </td>
                <td style="text-align:center;">
                  <a href="<?= site_url('appointments/edit/' . $a['id']); ?>" class="action-btn btn-edit">Edit</a>
                  <a href="<?= site_url('appointments/delete/' . $a['id']); ?>"
                     onclick="return confirm('Are you sure you want to delete this appointment?');"
                     class="action-btn btn-delete">Delete</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr class="no-data"><td colspan="8" style="text-align:center; color:#777;">No appointments found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </section>
</div>

<footer>
  &copy; <?= date('Y'); ?> Automated Scheduling and Tracking System for Veterinary Services – Calapan City, Oriental Mindoro
</footer>

<script>
// Filter functionality
document.addEventListener('DOMContentLoaded', function() {
  const filterButtons = document.querySelectorAll('.filter-btn');
  const tableRows = document.querySelectorAll('#appointmentsTable tr[data-status]');
  const noDataRow = document.querySelector('#appointmentsTable tr.no-data');

  filterButtons.forEach(button => {
    button.addEventListener('click', function() {
      const filterStatus = this.getAttribute('data-status');
      
      // Update active button
      filterButtons.forEach(btn => btn.classList.remove('active'));
      this.classList.add('active');

      // Filter table rows
      let visibleCount = 0;
      tableRows.forEach(row => {
        const rowStatus = row.getAttribute('data-status');
        
        if (filterStatus === 'all' || rowStatus === filterStatus) {
          row.style.display = '';
          visibleCount++;
        } else {
          row.style.display = 'none';
        }
      });

      // Show/hide no data message
      if (noDataRow) {
        noDataRow.style.display = visibleCount === 0 ? '' : 'none';
      }
    });
  });
});
</script>

</body>
</html>
