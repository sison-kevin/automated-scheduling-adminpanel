<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Veterinary Services Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- FullCalendar CSS & JS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

:root {
  --primary: #ff914d;
  --light-orange: #ffb47b;
  --bg: #f7f9fb;
  --text: #222;
  --card: #fff;
  --border: #e5e7eb;
  --muted: #6b7280;
  --shadow: 0 6px 20px rgba(0,0,0,0.05);
  --radius: 14px;
}

* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

body {
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
  background-color: var(--bg);
  color: var(--text);
  line-height: 1.6;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  font-size: 16px;
}

/* ===== HEADER ===== */
header {
  position: sticky;
  top: 0;
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(20px) saturate(180%);
  box-shadow: 0 4px 16px rgba(255, 145, 77, 0.08), 0 2px 4px rgba(0, 0, 0, 0.04);
  border-bottom: 1px solid rgba(255, 145, 77, 0.1);
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 50px;
  z-index: 1000;
  transition: all 0.3s ease;
}

header h1 {
  background: linear-gradient(135deg, var(--primary), var(--light-orange));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  font-size: 1.625rem;
  font-weight: 800;
  letter-spacing: -0.5px;
  margin: 0;
}

header > div {
  display: flex;
  align-items: center;
  gap: 16px;
}

.user-info {
  font-size: 0.9rem;
  color: #6b7280;
  font-weight: 500;
}

.btn-logout {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  border-radius: 10px;
  font-size: 0.9375rem;
  font-weight: 600;
  height: 42px;
  padding: 0 24px;
  background: linear-gradient(135deg, var(--primary), var(--light-orange));
  color: white;
  text-decoration: none;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  border: none;
  cursor: pointer;
  box-shadow: 0 4px 12px rgba(255, 145, 77, 0.3), 0 2px 4px rgba(255, 145, 77, 0.2);
  position: relative;
  overflow: hidden;
}

.btn-logout::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
  transition: left 0.5s ease;
}

.btn-logout:hover::before {
  left: 100%;
}

.btn-logout:hover {
  transform: translateY(-2px) scale(1.02);
  box-shadow: 0 8px 20px rgba(255, 145, 77, 0.4), 0 4px 8px rgba(255, 145, 77, 0.25);
}

.btn-logout:active {
  transform: translateY(0) scale(0.98);
}

/* ===== LAYOUT ===== */
.dashboard {
  display: grid;
  grid-template-columns: 240px 1fr;
  min-height: calc(100vh - 64px);
}

/* ===== SIDEBAR ===== */
.sidebar {
  background-color: hsl(var(--card));
  border-right: 1px solid hsl(var(--border));
  padding: 24px 16px;
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.sidebar h3 {
  padding: 12px 16px 8px;
  color: hsl(var(--muted-foreground));
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
  border-radius: 8px;
  color: #6b7280;
  font-weight: 500;
  font-size: 0.9375rem;
  text-decoration: none;
  transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
  gap: 12px;
  position: relative;
  overflow: hidden;
}

.sidebar a::before {
  content: '';
  position: absolute;
  left: 0;
  top: 0;
  height: 100%;
  width: 3px;
  background: var(--primary);
  transform: scaleY(0);
  transition: transform 0.25s ease;
}

.sidebar a:hover {
  background: linear-gradient(to right, rgba(255, 145, 77, 0.08), transparent);
  color: var(--primary);
  transform: translateX(4px);
}

.sidebar a:hover::before {
  transform: scaleY(1);
}

.sidebar a.active {
  background: linear-gradient(135deg, var(--primary), var(--light-orange));
  color: white;
  font-weight: 600;
  box-shadow: 0 4px 12px rgba(255, 145, 77, 0.4), 0 2px 4px rgba(255, 145, 77, 0.2);
}

.sidebar a.active::before {
  display: none;
}

/* ===== MAIN ===== */
.main-content {
  padding: 32px 40px;
  max-width: 1600px;
  margin: 0 auto;
  background-color: #f7f9fb;
}

/* ===== CARDS ===== */
.card {
  background: linear-gradient(to bottom right, #ffffff, #fefefe);
  border: 1px solid #e5e7eb;
  border-radius: 16px;
  padding: 32px;
  margin-bottom: 28px;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  position: relative;
  overflow: hidden;
}

.card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(90deg, var(--primary), var(--light-orange), #fbbf24);
  opacity: 0;
  transition: opacity 0.3s ease;
}

.card:hover {
  box-shadow: 0 12px 24px -8px rgba(255, 145, 77, 0.15), 0 4px 8px -2px rgba(0, 0, 0, 0.08);
  transform: translateY(-2px);
  border-color: rgba(255, 145, 77, 0.2);
}

.card:hover::before {
  opacity: 1;
}

.card h3 {
  color: #111827;
  font-size: 1.375rem;
  font-weight: 700;
  margin-bottom: 12px;
  letter-spacing: -0.025em;
  background: linear-gradient(135deg, #111827, #374151);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.card p {
  color: #6b7280;
  font-size: 0.9375rem;
  line-height: 1.7;
}

/* ===== STATS ===== */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 24px;
  margin-bottom: 32px;
}

.stat-card {
  position: relative;
  border-radius: 20px;
  padding: 28px 24px;
  overflow: hidden;
  box-shadow: 0 10px 25px rgba(255, 145, 77, 0.15), 0 4px 10px rgba(0, 0, 0, 0.05);
  transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
  display: flex;
  flex-direction: column;
  gap: 12px;
  cursor: pointer;
}

.stat-card::before {
  content: '';
  position: absolute;
  inset: 0;
  opacity: 1;
  z-index: 0;
  transition: all 0.35s ease;
}

.stat-card::after {
  content: '';
  position: absolute;
  top: -50%;
  right: -50%;
  width: 200%;
  height: 200%;
  background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
  opacity: 0;
  transition: opacity 0.35s ease;
}

.stat-card:nth-child(1)::before { 
  background: linear-gradient(135deg, #ff914d 0%, #ffb47b 50%, #ffc996 100%);
}
.stat-card:nth-child(2)::before { 
  background: linear-gradient(135deg, #fb923c 0%, #fdba74 50%, #fcd9a6 100%);
}
.stat-card:nth-child(3)::before { 
  background: linear-gradient(135deg, #10b981 0%, #34d399 50%, #6ee7b7 100%);
}

.stat-card:hover { 
  transform: translateY(-8px) scale(1.02);
  box-shadow: 0 20px 40px rgba(255, 145, 77, 0.25), 0 8px 16px rgba(0, 0, 0, 0.1);
}

.stat-card:hover::after {
  opacity: 1;
}

.stat-card > * { position: relative; z-index: 1; }

.stat-card .icon {
  width: 64px;
  height: 64px;
  border-radius: 16px;
  background: rgba(255,255,255,0.2);
  backdrop-filter: blur(10px);
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-size: 28px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
}

.stat-card:hover .icon {
  transform: scale(1.1) rotate(5deg);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.stat-card h4 { 
  color: rgba(255,255,255,0.98); 
  font-size: 0.875rem; 
  margin: 0; 
  font-weight: 700; 
  text-transform: uppercase; 
  letter-spacing: 0.08em;
  text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
.stat-number { 
  font-size: 2.75rem; 
  font-weight: 800; 
  color: #fff; 
  margin: 8px 0 0;
  line-height: 1;
  text-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
  letter-spacing: -0.02em;
}
.stat-meta { 
  font-size: 0.875rem; 
  color: rgba(255,255,255,0.9); 
  opacity: 0.95; 
  margin-top: 8px;
  font-weight: 500;
}

/* ===== CHARTS ===== */
.chart-card {
  background: linear-gradient(to bottom right, #ffffff, #fefefe);
  border: 1px solid #e5e7eb;
  border-radius: 16px;
  padding: 28px;
  margin-bottom: 28px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05), 0 1px 3px rgba(0, 0, 0, 0.08);
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  position: relative;
  overflow: hidden;
}

.chart-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 3px;
  background: linear-gradient(90deg, var(--primary), var(--light-orange));
  opacity: 0;
  transition: opacity 0.3s ease;
}

.chart-card:hover {
  box-shadow: 0 12px 28px rgba(255, 145, 77, 0.12), 0 4px 12px rgba(0, 0, 0, 0.08);
  transform: translateY(-2px);
  border-color: rgba(255, 145, 77, 0.3);
}

.chart-card:hover::before {
  opacity: 1;
}

.chart-card h3 {
  color: #111827;
  margin-bottom: 24px;
  font-size: 1.25rem;
  font-weight: 700;
  letter-spacing: -0.025em;
}

.charts-container {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
  margin-bottom: 28px;
}

.chart-wrap { width:100%; height:100%; display:block; }
.chart-card .chart-head .muted { color: #6b7280; font-size: 0.9rem; }
.chart-card { padding: 24px; }

/* Export button */
.btn-export {
  background: white;
  border: 1.5px solid #e5e7eb;
  padding: 8px 16px;
  border-radius: 8px;
  font-size: 0.875rem;
  font-weight: 500;
  cursor: pointer;
  color: #374151;
  backdrop-filter: blur(4px);
  transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}
.btn-export:hover { 
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(255, 145, 77, 0.15);
  border-color: var(--primary);
  color: var(--primary);
  background: linear-gradient(to right, #fff7ed, white);
}

/* ===== FULLCALENDAR CUSTOM STYLING ===== */
#calendar {
  font-family: 'Inter', sans-serif;
  background: white;
  border: 1px solid #e5e7eb;
  border-radius: 8px;
  padding: 16px;
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
}

/* Toolbar styling */
.fc .fc-toolbar {
  gap: 12px;
  margin-bottom: 20px !important;
}

/* Calendar header buttons */
.fc .fc-button-primary {
  background: #ff914d !important;
  border: 1px solid #ff914d !important;
  color: white !important;
  font-weight: 500 !important;
  border-radius: 8px !important;
  padding: 8px 16px !important;
  transition: all 0.15s !important;
  font-size: 0.875rem !important;
  height: 36px !important;
}

.fc .fc-button-primary:hover {
  opacity: 0.9 !important;
}

.fc .fc-button-primary:active {
  scale: 0.98;
}

.fc .fc-button-primary:disabled {
  opacity: 0.5 !important;
  cursor: not-allowed;
}

/* Today button highlight */
.fc .fc-button-active {
  background: #ff914d !important;
  opacity: 1 !important;
}

/* Calendar title */
.fc .fc-toolbar-title {
  color: #111827 !important;
  font-size: 1.25rem !important;
  font-weight: 600 !important;
  letter-spacing: -0.025em !important;
}

/* Day headers */
.fc .fc-col-header-cell {
  background: #f3f4f6 !important;
  padding: 12px 8px !important;
  font-weight: 600 !important;
  color: #6b7280 !important;
  border: 1px solid #e5e7eb !important;
  text-transform: uppercase !important;
  font-size: 0.75rem !important;
  letter-spacing: 0.05em !important;
}

/* Calendar cells */
.fc .fc-daygrid-day {
  transition: all 0.15s;
  border: 1px solid #e5e7eb !important;
}

.fc .fc-daygrid-day:hover {
  background: #f3f4f6 !important;
}

/* Today highlight */
.fc .fc-day-today {
  background: #fff7ed !important;
  border: 1px solid #ff914d !important;
}

.fc .fc-day-today .fc-daygrid-day-number {
  color: #ff914d;
  font-weight: 700;
}

/* Event styling */
.fc-event {
  border-radius: 6px !important;
  padding: 4px 8px !important;
  font-weight: 500 !important;
  border: none !important;
  /* Removed background override to allow individual event colors */
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
  cursor: pointer !important;
  transition: all 0.15s !important;
  margin: 2px !important;
}

.fc-event:hover {
  opacity: 0.9;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
}

/* Event title */
.fc-event-title {
  font-weight: 500 !important;
  font-size: 0.8125rem !important;
}

.fc-event-time {
  font-weight: 400 !important;
  font-size: 0.75rem !important;
}

/* Day numbers */
.fc .fc-daygrid-day-number {
  color: #111827;
  font-weight: 500;
  padding: 8px;
  font-size: 0.875rem;
}

/* More events link */
.fc .fc-more-link {
  color: #ff914d !important;
  font-weight: 500 !important;
  font-size: 0.875rem !important;
}

.fc .fc-more-link:hover {
  text-decoration: underline;
}

/* Popover for more events */
.fc .fc-popover {
  background: white;
  border-radius: 8px;
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
  border: 1px solid #e5e7eb !important;
}

.fc .fc-popover-header {
  background: #f3f4f6 !important;
  color: #111827 !important;
  border-radius: 8px 8px 0 0 !important;
  padding: 12px !important;
  font-weight: 600 !important;
  font-size: 0.875rem !important;
}

/* List view styling */
.fc .fc-list-event:hover td {
  background-color: #f3f4f6 !important;
}

/* Scrollbar styling */
.fc-scroller::-webkit-scrollbar {
  width: 8px;
  height: 8px;
}

.fc-scroller::-webkit-scrollbar-track {
  background: #f3f4f6;
  border-radius: 4px;
}

.fc-scroller::-webkit-scrollbar-thumb {
  background: #6b7280;
  border-radius: 4px;
}

.fc-scroller::-webkit-scrollbar-thumb:hover {
  background: #111827;
}

/* Empty day cells */
.fc .fc-daygrid-day-frame {
  min-height: 100px;
}

/* ===== APPOINTMENT MODAL ===== */
.appointment-modal {
  display: none;
  position: fixed;
  z-index: 9999;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  backdrop-filter: blur(4px);
  animation: fadeIn 0.2s ease-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

@keyframes slideUp {
  from {
    transform: translateY(30px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

.appointment-modal-content {
  background-color: white;
  margin: 10% auto;
  border-radius: 12px;
  width: 90%;
  max-width: 500px;
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
  animation: slideUp 0.3s ease-out;
  overflow: hidden;
}

.appointment-modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 24px;
  background: linear-gradient(135deg, #ff914d 0%, #ffb47b 100%);
  color: white;
}

.appointment-modal-header h3 {
  margin: 0;
  font-size: 1.25rem;
  font-weight: 600;
}

.modal-close-btn {
  background: rgba(255, 255, 255, 0.2);
  border: none;
  color: white;
  font-size: 28px;
  font-weight: 300;
  cursor: pointer;
  width: 32px;
  height: 32px;
  border-radius: 6px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background 0.2s;
  line-height: 1;
  padding: 0;
}

.modal-close-btn:hover {
  background: rgba(255, 255, 255, 0.3);
}

.appointment-modal-body {
  padding: 24px;
}

.detail-row {
  display: flex;
  align-items: flex-start;
  gap: 12px;
  margin-bottom: 20px;
  padding-bottom: 20px;
  border-bottom: 1px solid #e5e7eb;
}

.detail-row:last-child {
  margin-bottom: 0;
  padding-bottom: 0;
  border-bottom: none;
}

.detail-icon {
  font-size: 20px;
  flex-shrink: 0;
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f3f4f6;
  border-radius: 8px;
}

.detail-content {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.detail-content label {
  font-size: 0.75rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: #6b7280;
}

.detail-content span {
  font-size: 0.95rem;
  font-weight: 500;
  color: #111827;
}

.status-badge {
  display: inline-block;
  padding: 6px 12px;
  border-radius: 6px;
  font-size: 0.875rem;
  font-weight: 600;
  text-transform: capitalize;
}

.status-badge.approved {
  background-color: #d1fae5;
  color: #065f46;
}

.status-badge.pending {
  background-color: #fef3c7;
  color: #92400e;
}

.status-badge.completed {
  background-color: #dbeafe;
  color: #1e40af;
}

.status-badge.cancelled {
  background-color: #fee2e2;
  color: #991b1b;
}

/* ===== FOOTER ===== */
footer {
  text-align: center;
  padding: 16px;
  color: #6b7280;
  font-size: 0.875rem;
  border-top: 1px solid #e5e7eb;
  background-color: white;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 992px) {
  .dashboard {
    grid-template-columns: 1fr;
  }
  .sidebar {
    flex-direction: row;
    justify-content: center;
    padding: 16px;
    border-bottom: 1px solid #e5e7eb;
  }
  .main-content {
    padding: 16px;
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
    <a href="<?= site_url('auth/logout') ?>" class="btn-logout">Logout</a>
  </div>
</header>

<div class="dashboard">
  <!-- Sidebar -->
  <aside class="sidebar">
    <h3>Navigation</h3>
    <a href="<?= site_url('dashboard') ?>" class="<?= strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false ? 'active' : '' ?>">Dashboard</a>
    <a href="<?= site_url('appointments') ?>" class="<?= strpos($_SERVER['REQUEST_URI'], 'appointments') !== false ? 'active' : '' ?>">Appointments</a>
    <a href="<?= site_url('services') ?>" class="<?= strpos($_SERVER['REQUEST_URI'], 'services') !== false ? 'active' : '' ?>">Services</a>
    <a href="<?= site_url('veterinarians') ?>" class="<?= strpos($_SERVER['REQUEST_URI'], 'veterinarians') !== false ? 'active' : '' ?>">Veterinarians</a>
    <a href="<?= site_url('reports') ?>" class="<?= strpos($_SERVER['REQUEST_URI'], 'reports') !== false ? 'active' : '' ?>">Reports</a>
  </aside>

  <!-- Main Content -->
  <section class="main-content">

    <div class="card">
      <h3>Welcome Back, <?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin'); ?>!</h3>
      <p>Manage appointments, monitor services, and analyze veterinarian performance — all in one organized, modern dashboard.</p>
    </div>

    <!-- Statistics -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="icon">📅</div>
        <h4>Total Appointments</h4>
        <p class="stat-number"><?= $totalAppointments ?></p>
        <p class="stat-meta">Appointments scheduled this year</p>
      </div>
      <div class="stat-card">
        <div class="icon">🩺</div>
        <h4>Total Services</h4>
        <p class="stat-number"><?= $totalServices ?></p>
        <p class="stat-meta">Active service offerings</p>
      </div>
      <div class="stat-card">
        <div class="icon">👩‍⚕️</div>
        <h4>Total Veterinarians</h4>
        <p class="stat-number"><?= $totalVets ?></p>
        <p class="stat-meta">Licensed veterinarians</p>
      </div>
    </div>

    <!-- Charts -->
    <div class="charts-container">
      <div class="chart-card">
        <div class="chart-head" style="display:flex;justify-content:space-between;align-items:center;gap:12px;"> 
          <h3>Monthly Appointments</h3>
          <div style="display:flex;align-items:center;gap:10px;">
            <div class="muted">Last 12 months</div>
            <button class="btn-export" data-target="monthlyChart" title="Export chart as PNG">Export</button>
          </div>
        </div>
        <div class="chart-wrap">
          <canvas id="monthlyChart" height="280"></canvas>
        </div>
      </div>

      <div class="chart-card">
        <div class="chart-head" style="display:flex;justify-content:space-between;align-items:center;gap:12px;"> 
          <h3>Service Popularity</h3>
          <div style="display:flex;align-items:center;gap:10px;">
            <div class="muted">By number of bookings</div>
            <button class="btn-export" data-target="serviceChart" title="Export chart as PNG">Export</button>
          </div>
        </div>
        <div class="chart-wrap" style="display:flex;align-items:center;justify-content:center;padding:20px 0;">
          <canvas id="serviceChart" style="max-width:420px;width:100%;"></canvas>
        </div>
      </div>
    </div>

   <!-- ✅ FullCalendar - Appointment Calendar -->
<div class="chart-card">
  <h3>📅 Appointment Calendar</h3>
  <div style="display:flex;gap:16px;margin-bottom:16px;flex-wrap:wrap;font-size:0.875rem;">
    <span style="display:flex;align-items:center;gap:6px;">
      <span style="width:12px;height:12px;background:#198754;border-radius:2px;"></span> Approved
    </span>
    <span style="display:flex;align-items:center;gap:6px;">
      <span style="width:12px;height:12px;background:#ffc107;border-radius:2px;"></span> Pending
    </span>
  </div>
  <div id="calendar"></div>
</div>

<!-- Appointment Details Modal -->
<div id="appointmentModal" class="appointment-modal">
  <div class="appointment-modal-content">
    <div class="appointment-modal-header">
      <h3 id="modalTitle">📋 Appointment Details</h3>
      <button class="modal-close-btn" onclick="closeAppointmentModal()">&times;</button>
    </div>
    <div class="appointment-modal-body">
      <div class="detail-row">
        <span class="detail-icon">👤</span>
        <div class="detail-content">
          <label>Patient/Client:</label>
          <span id="modalPatient"></span>
        </div>
      </div>
      <div class="detail-row">
        <span class="detail-icon">📅</span>
        <div class="detail-content">
          <label>Date:</label>
          <span id="modalDate"></span>
        </div>
      </div>
      <div class="detail-row">
        <span class="detail-icon">🕐</span>
        <div class="detail-content">
          <label>Time:</label>
          <span id="modalTime"></span>
        </div>
      </div>
      <div class="detail-row" id="modalDescriptionRow" style="display:none;">
        <span class="detail-icon">📝</span>
        <div class="detail-content">
          <label>Notes:</label>
          <span id="modalDescription"></span>
        </div>
      </div>
      <div class="detail-row">
        <span class="detail-icon">🏷️</span>
        <div class="detail-content">
          <label>Status:</label>
          <span id="modalStatus" class="status-badge"></span>
        </div>
      </div>
    </div>
  </div>
</div>

  </section>
</div>

<footer>
  &copy; <?= date('Y'); ?> Automated Scheduling and Tracking System for Veterinary Services – Calapan City, Oriental Mindoro
</footer>

<!-- ===== CHARTS ===== -->
<script>
// Enhance Chart.js visuals and defaults
Chart.defaults.font.family = "Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial";
Chart.defaults.color = getComputedStyle(document.documentElement).getPropertyValue('--muted-foreground') || '#6b7280';

// Monthly Appointments - Bar with gradient and rounded corners
const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');

new Chart(monthlyCtx, {
  type: 'bar',
  data: {
    labels: <?= $monthlyLabels ?>,
    datasets: [{
      label: 'Appointments',
      data: <?= $monthlyValues ?>,
      backgroundColor: 'rgba(255, 145, 77, 0.85)',
      borderColor: 'rgba(255, 145, 77, 1)',
      borderWidth: 0,
      borderRadius: 6,
      barPercentage: 0.65,
      categoryPercentage: 0.75,
      maxBarThickness: 60
    }]
  },
  options: {
    maintainAspectRatio: true,
    aspectRatio: 2.5,
    responsive: true,
    plugins: {
      legend: { 
        display: true,
        position: 'top',
        align: 'end',
        labels: {
          boxWidth: 12,
          padding: 15,
          font: { size: 12, weight: '500' }
        }
      },
      tooltip: {
        enabled: true,
        mode: 'index',
        intersect: false,
        callbacks: {
          label: function(context) {
            const v = context.parsed.y ?? context.raw ?? 0;
            return context.dataset.label + ': ' + v.toLocaleString();
          }
        },
        backgroundColor: 'rgba(0,0,0,0.8)',
        titleColor: '#fff',
        bodyColor: '#fff',
        padding: 12,
        cornerRadius: 6,
        titleFont: { size: 13, weight: '600' },
        bodyFont: { size: 12 }
      }
    },
    scales: {
      y: {
        beginAtZero: true,
        grid: { 
          color: 'rgba(0,0,0,0.06)',
          drawBorder: false
        },
        ticks: { 
          precision: 0,
          padding: 8,
          font: { size: 11 }
        },
        title: {
          display: true,
          text: 'Number of Appointments',
          font: { size: 12, weight: '600' },
          padding: { top: 0, bottom: 10 }
        }
      },
      x: { 
        grid: { display: false },
        ticks: { 
          maxRotation: 0, 
          minRotation: 0,
          font: { size: 11 }
        },
        title: {
          display: true,
          text: 'Month',
          font: { size: 12, weight: '600' },
          padding: { top: 10 }
        }
      }
    }
  }
});

// Service Popularity - Doughnut with subtle spacing and improved legend
const serviceCtx = document.getElementById('serviceChart').getContext('2d');
new Chart(serviceCtx, {
  type: 'doughnut',
  data: {
    labels: <?= $serviceLabels ?>,
    datasets: [{
      data: <?= $serviceValues ?>,
      backgroundColor: ['#ff914d', '#10b981', '#3b82f6', '#f59e0b', '#8b5cf6', '#ec4899'],
      hoverOffset: 0,
      spacing: 2,
      borderWidth: 3,
      borderColor: getComputedStyle(document.documentElement).getPropertyValue('--card') || '#fff'
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: true,
    aspectRatio: 1.4,
    cutout: '65%',
    plugins: {
      legend: { 
        position: 'bottom', 
        labels: { 
          boxWidth: 14, 
          padding: 12,
          font: { size: 11, weight: '500' },
          usePointStyle: true,
          pointStyle: 'circle'
        } 
      },
      tooltip: { 
        padding: 12, 
        cornerRadius: 6,
        backgroundColor: 'rgba(0,0,0,0.8)',
        titleFont: { size: 13, weight: '600' },
        bodyFont: { size: 12 },
        callbacks: {
          label: function(context) {
            const label = context.label || '';
            const value = context.parsed || 0;
            const total = context.dataset.data.reduce((a, b) => a + b, 0);
            const percentage = ((value / total) * 100).toFixed(1);
            return label + ': ' + value + ' (' + percentage + '%)';
          }
        }
      }
    }
  }
});

// Small plugin to draw value labels on top of bars and subtle shadow
const valueLabelPlugin = {
  id: 'valueLabelPlugin',
  afterDatasetsDraw(chart, args, options) {
    const {ctx, data, chartArea: {top, bottom, left, right}} = chart;
    ctx.save();
    chart.data.datasets.forEach((dataset, dsIndex) => {
      const meta = chart.getDatasetMeta(dsIndex);
      meta.data.forEach((element, index) => {
        // Only label bars (for bar chart)
        if (element && element.visible) {
          const value = dataset.data[index];
          if (value === null || value === undefined) return;
          const position = element.tooltipPosition();
          ctx.fillStyle = '#374151';
          ctx.font = '600 12px Inter, system-ui, -apple-system';
          ctx.textAlign = 'center';
          ctx.textBaseline = 'bottom';
          ctx.fillText(value.toLocaleString(), position.x, position.y - 8);
        }
      });
    });
    ctx.restore();
  }
};

// Disable animations and hover expansions for a static, professional look
Chart.defaults.animation = false;
// Prevent hover-driven visual shifts (e.g., doughnut slice pop-out or bar hover growth)
Chart.defaults.hover = { mode: null };

// Re-create monthly chart with plugin registered locally (to ensure plugin is available)
// Note: we already created charts above. For safety we attach plugin to Chart global registry so it's available to existing charts.
Chart.register(valueLabelPlugin);

// Export helper for canvases
function downloadChart(canvasId, filename) {
  const canvas = document.getElementById(canvasId);
  if (!canvas) return;
  const link = document.createElement('a');
  link.download = filename || (canvasId + '.png');
  link.href = canvas.toDataURL('image/png', 1.0);
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}

// Bind export buttons
document.addEventListener('click', function(e) {
  const btn = e.target.closest('.btn-export');
  if (!btn) return;
  const target = btn.getAttribute('data-target');
  if (!target) return;
  downloadChart(target, target + '-' + new Date().toISOString().slice(0,10) + '.png');
});

// ===== FULLCALENDAR INITIALIZATION ===== 
document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,listWeek'
    },
    // Show approved appointments from database
    events: <?= $calendarEvents ?>,
    eventClick: function(info) {
      // Populate modal with appointment details
      document.getElementById('modalPatient').textContent = info.event.title;
      
      if (info.event.start) {
        document.getElementById('modalDate').textContent = info.event.start.toLocaleDateString('en-US', {
          weekday: 'long',
          year: 'numeric',
          month: 'long',
          day: 'numeric'
        });
        document.getElementById('modalTime').textContent = info.event.start.toLocaleTimeString('en-US', {
          hour: '2-digit',
          minute: '2-digit',
          hour12: true
        });
      }
      
      // Handle description/notes
      if (info.event.extendedProps.description) {
        document.getElementById('modalDescription').textContent = info.event.extendedProps.description;
        document.getElementById('modalDescriptionRow').style.display = 'flex';
      } else {
        document.getElementById('modalDescriptionRow').style.display = 'none';
      }
      
      // Handle status badge
      const status = info.event.extendedProps.status || 'pending';
      const statusBadge = document.getElementById('modalStatus');
      statusBadge.textContent = status;
      statusBadge.className = 'status-badge ' + status.toLowerCase();
      
      // Show the modal
      document.getElementById('appointmentModal').style.display = 'block';
    },
    height: 'auto',
    displayEventTime: true,
    eventTimeFormat: {
      hour: '2-digit',
      minute: '2-digit',
      meridiem: 'short'
    },
    // Remove default colors so individual event colors are used
    buttonText: {
      today: 'Today',
      month: 'Month',
      week: 'Week',
      list: 'List'
    },
    eventDisplay: 'block',
    dayMaxEvents: 3
  });
  calendar.render();
});

// ===== APPOINTMENT MODAL FUNCTIONS =====
function closeAppointmentModal() {
  document.getElementById('appointmentModal').style.display = 'none';
}

// Close modal when clicking outside of it
window.onclick = function(event) {
  const modal = document.getElementById('appointmentModal');
  if (event.target === modal) {
    closeAppointmentModal();
  }
}

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
  if (event.key === 'Escape') {
    closeAppointmentModal();
  }
});
</script>
</body>
</html>
