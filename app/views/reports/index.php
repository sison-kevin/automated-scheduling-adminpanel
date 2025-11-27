<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - Veterinary System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            font-size: 0.9375rem;
            color: var(--muted-foreground);
            font-weight: 400;
        }

        .btn-logout {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--radius);
            font-size: 0.9375rem;
            font-weight: 500;
            height: 40px;
            padding: 0 20px;
            background-color: var(--primary);
            color: white;
            border: none;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(255, 145, 77, 0.2);
        }

        .btn-logout:hover {
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
            background-color: white;
            border-right: 1px solid var(--border);
            padding: 24px 16px;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .sidebar h3 {
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--muted-foreground);
            margin-bottom: 16px;
            padding: 0 12px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 10px 12px;
            color: var(--text);
            text-decoration: none;
            border-radius: calc(var(--radius) - 4px);
            transition: all 0.15s;
            font-size: 0.9375rem;
            font-weight: 500;
        }

        .sidebar a:hover {
            background-color: #fff7ed;
            color: var(--primary);
        }

        .sidebar a.active {
            background: linear-gradient(135deg, var(--primary), var(--light-orange));
            color: white;
            font-weight: 600;
            box-shadow: 0 4px 6px -1px rgba(255, 145, 77, 0.3);
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            padding: 32px;
            overflow-y: auto;
            background-color: var(--bg);
        }

        .card {
            background-color: white;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            margin-bottom: 24px;
        }

        .card h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text);
        }

        .card p {
            color: var(--muted-foreground);
            font-size: 0.9375rem;
            margin-bottom: 0;
        }

        .card p {
            color: var(--muted-foreground);
            font-size: 0.9375rem;
            margin-bottom: 0;
        }

        /* Report Cards Grid */
        .reports-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }

        .report-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 24px;
            transition: all 0.2s;
            cursor: pointer;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .report-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            border-color: var(--primary);
        }

        .report-icon {
            font-size: 2.5rem;
            margin-bottom: 16px;
            display: block;
        }

        .icon-purple { color: var(--primary); }
        .icon-blue { color: #3b82f6; }
        .icon-green { color: #10b981; }
        .icon-orange { color: var(--primary); }

        .report-card h5 {
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text);
        }

        .report-card p {
            color: var(--muted-foreground);
            font-size: 0.875rem;
            margin-bottom: 16px;
            line-height: 1.5;
        }

        .btn-generate {
            width: 100%;
            padding: 10px 16px;
            border-radius: calc(var(--radius) - 4px);
            font-weight: 600;
            font-size: 0.9375rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            box-shadow: 0 2px 8px rgba(255, 145, 77, 0.2);
        }

        .btn-primary:hover {
            background: var(--light-orange);
            transform: scale(1.02);
            box-shadow: 0 4px 12px rgba(255, 145, 77, 0.3);
        }

        .btn-info {
            background-color: #3b82f6;
            color: white;
        }

        .btn-info:hover {
            opacity: 0.9;
            transform: scale(1.02);
        }

        .btn-success {
            background-color: #10b981;
            color: white;
        }

        .btn-success:hover {
            opacity: 0.9;
            transform: scale(1.02);
        }

        .btn-warning {
            background-color: var(--primary);
            color: white;
        }

        .btn-warning:hover {
            opacity: 0.9;
            transform: scale(1.02);
        }

        /* Modal styles */
        .card-header-custom {
            background: linear-gradient(135deg, var(--primary) 0%, var(--light-orange) 100%);
            color: white;
            border-radius: 12px 12px 0 0 !important;
            padding: 1.5rem;
        }

        .modal-content {
            border-radius: var(--radius);
            border: 1px solid var(--border);
        }

        .form-label {
            font-weight: 500;
            font-size: 0.9375rem;
            color: var(--text);
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            border: 1px solid var(--border);
            border-radius: calc(var(--radius) - 4px);
            padding: 10px 12px;
            font-size: 0.9375rem;
            background-color: white;
            color: var(--text);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 145, 77, 0.1);
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 16px;
            color: var(--muted-foreground);
            font-size: 0.875rem;
            border-top: 1px solid var(--border);
            background-color: white;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .dashboard {
                grid-template-columns: 1fr;
            }
            .sidebar {
                border-right: none;
                border-bottom: 1px solid hsl(var(--border));
                flex-direction: row;
                overflow-x: auto;
            }
            .main-content {
                padding: 16px;
            }
        }
    </style>
</head>
<body>

<!-- Header -->
<header>
    <h1>Veterinary Services Dashboard</h1>
    <div>
        <span class="user-info">Welcome, <?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin'); ?></span>
        <a href="<?= site_url('auth/logout') ?>" class="btn-logout">Logout</a>
    </div>
</header>

<div class="dashboard">
    <!-- Sidebar -->
    <aside class="sidebar">
        <h3>Navigation</h3>
        <a href="<?= site_url('dashboard') ?>">Dashboard</a>
        <a href="<?= site_url('appointments') ?>">Appointments</a>
        <a href="<?= site_url('services') ?>">Services</a>
        <a href="<?= site_url('veterinarians') ?>">Veterinarians</a>
        <a href="<?= site_url('reports') ?>" class="active">Reports</a>
    </aside>

    <!-- Main Content -->
    <section class="main-content">
        <div class="card">
            <h3>Reports & Analytics</h3>
            <p>Generate comprehensive reports for appointments, services, veterinarians, and clients</p>
        </div>

        <div class="reports-grid">
            <!-- Appointment Report -->
            <div class="report-card" data-bs-toggle="modal" data-bs-target="#appointmentModal">
                <span class="report-icon icon-purple">
                    <i class="fas fa-calendar-check"></i>
                </span>
                <h5>Appointment Report</h5>
                <p>View and analyze all appointments with filters by date, status, and veterinarian</p>
                <button class="btn-generate btn-primary" type="button">
                    <i class="fas fa-file-alt"></i>Generate
                </button>
            </div>

            <!-- Service Report -->
            <div class="report-card" data-bs-toggle="modal" data-bs-target="#serviceModal">
                <span class="report-icon icon-blue">
                    <i class="fas fa-stethoscope"></i>
                </span>
                <h5>Service Report</h5>
                <p>Service popularity and usage statistics with completion rates</p>
                <button class="btn-generate btn-info" type="button">
                    <i class="fas fa-file-alt"></i>Generate
                </button>
            </div>

            <!-- Veterinarian Report -->
            <div class="report-card" data-bs-toggle="modal" data-bs-target="#veterinarianModal">
                <span class="report-icon icon-green">
                    <i class="fas fa-user-md"></i>
                </span>
                <h5>Veterinarian Report</h5>
                <p>Performance and workload analysis for all veterinarians</p>
                <button class="btn-generate btn-success" type="button">
                    <i class="fas fa-file-alt"></i>Generate
                </button>
            </div>

            <!-- Client Report -->
            <div class="report-card" data-bs-toggle="modal" data-bs-target="#clientModal">
                <span class="report-icon icon-orange">
                    <i class="fas fa-users"></i>
                </span>
                <h5>Client Report</h5>
                <p>Client activity and engagement data with completion metrics</p>
                <button class="btn-generate btn-warning" type="button">
                    <i class="fas fa-file-alt"></i>Generate
                </button>
            </div>
        </div>

        <div class="card">
            <h3><i class="fas fa-info-circle"></i> Quick Tips</h3>
            <ul style="margin-bottom: 0; padding-left: 20px; color: hsl(var(--muted-foreground));">
                <li>Select date ranges to filter reports by specific time periods</li>
                <li>Use the export feature to download reports in CSV format</li>
                <li>Apply filters to focus on specific statuses or veterinarians</li>
                <li>Reports can be printed directly from the browser</li>
            </ul>
        </div>
    </section>
</div>

<footer>
    &copy; <?= date('Y'); ?> Automated Scheduling and Tracking System for Veterinary Services – Calapan City, Oriental Mindoro
</footer>

    <!-- Appointment Report Modal -->
    <div class="modal fade" id="appointmentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header card-header-custom">
                    <h5 class="modal-title"><i class="fas fa-calendar-check me-2"></i>Appointment Report Options</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="<?= site_url('reports/appointments') ?>" target="_blank">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Date Range</label>
                            <div class="row">
                                <div class="col-6">
                                    <input type="date" class="form-control" name="start_date" required>
                                    <small class="text-muted">Start Date</small>
                                </div>
                                <div class="col-6">
                                    <input type="date" class="form-control" name="end_date" required>
                                    <small class="text-muted">End Date</small>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status Filter</label>
                            <select class="form-select" name="status">
                                <option value="all">All Statuses</option>
                                <option value="Pending">Pending</option>
                                <option value="Approved">Approved</option>
                                <option value="Completed">Completed</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Veterinarian Filter</label>
                            <select class="form-select" name="veterinarian_id">
                                <option value="all">All Veterinarians</option>
                                <!-- Will be populated dynamically -->
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-file-alt me-2"></i>Generate Report</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Service Report Modal -->
    <div class="modal fade" id="serviceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header card-header-custom">
                    <h5 class="modal-title"><i class="fas fa-stethoscope me-2"></i>Service Report Options</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="<?= site_url('reports/services') ?>" target="_blank">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Date Range (Optional)</label>
                            <div class="row">
                                <div class="col-6">
                                    <input type="date" class="form-control" name="start_date">
                                    <small class="text-muted">Start Date</small>
                                </div>
                                <div class="col-6">
                                    <input type="date" class="form-control" name="end_date">
                                    <small class="text-muted">End Date</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-info text-white"><i class="fas fa-file-alt me-2"></i>Generate Report</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Veterinarian Report Modal -->
    <div class="modal fade" id="veterinarianModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header card-header-custom">
                    <h5 class="modal-title"><i class="fas fa-user-md me-2"></i>Veterinarian Report Options</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="<?= site_url('reports/veterinarians') ?>" target="_blank">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Date Range (Optional)</label>
                            <div class="row">
                                <div class="col-6">
                                    <input type="date" class="form-control" name="start_date">
                                    <small class="text-muted">Start Date</small>
                                </div>
                                <div class="col-6">
                                    <input type="date" class="form-control" name="end_date">
                                    <small class="text-muted">End Date</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success"><i class="fas fa-file-alt me-2"></i>Generate Report</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Client Report Modal -->
    <div class="modal fade" id="clientModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header card-header-custom">
                    <h5 class="modal-title"><i class="fas fa-users me-2"></i>Client Report Options</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="<?= site_url('reports/clients') ?>" target="_blank">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Date Range (Optional)</label>
                            <div class="row">
                                <div class="col-6">
                                    <input type="date" class="form-control" name="start_date">
                                    <small class="text-muted">Start Date</small>
                                </div>
                                <div class="col-6">
                                    <input type="date" class="form-control" name="end_date">
                                    <small class="text-muted">End Date</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning text-white"><i class="fas fa-file-alt me-2"></i>Generate Report</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
