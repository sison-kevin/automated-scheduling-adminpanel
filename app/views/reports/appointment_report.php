<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @media print {
            .no-print { display: none; }
            .card { border: 1px solid #dee2e6 !important; }
        }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .report-header {
            background: linear-gradient(135deg, #ff914d 0%, #ffb47b 100%);
            color: white;
            padding: 2rem;
            border-radius: 8px;
            margin-bottom: 2rem;
        }
        .stat-card {
            border-left: 4px solid;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        .stat-pending { border-left-color: #ffc107; }
        .stat-approved { border-left-color: #198754; }
        .stat-completed { border-left-color: #0d6efd; }
        .stat-cancelled { border-left-color: #dc3545; }
        .badge-pending { background-color: #ffc107; }
        .badge-approved { background-color: #198754; }
        .badge-completed { background-color: #0d6efd; }
        .badge-cancelled { background-color: #dc3545; }
    </style>
</head>
<body>
    <div class="container my-4">
        <div class="report-header">
            <h1><i class="fas fa-calendar-check me-2"></i>Appointment Report</h1>
            <p class="mb-0">Generated on: <?= date('F d, Y h:i A') ?></p>
            <?php if ($start_date && $end_date): ?>
                <p class="mb-0">Period: <?= date('M d, Y', strtotime($start_date)) ?> - <?= date('M d, Y', strtotime($end_date)) ?></p>
            <?php endif; ?>
        </div>

        <!-- Summary Statistics -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card stat-card">
                    <h6 class="text-muted mb-1">Total Appointments</h6>
                    <h3 class="mb-0"><?= $total_appointments ?></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card stat-pending">
                    <h6 class="text-muted mb-1">Pending</h6>
                    <h3 class="mb-0 text-warning"><?= $status_counts['Pending'] ?></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card stat-approved">
                    <h6 class="text-muted mb-1">Approved</h6>
                    <h3 class="mb-0 text-success"><?= $status_counts['Approved'] ?></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card stat-completed">
                    <h6 class="text-muted mb-1">Completed</h6>
                    <h3 class="mb-0 text-primary"><?= $status_counts['Completed'] ?></h3>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mb-3 no-print">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print me-2"></i>Print Report
            </button>
            <a href="<?= site_url('reports/export?type=appointments&start_date=' . $start_date . '&end_date=' . $end_date) ?>" 
               class="btn btn-success">
                <i class="fas fa-file-excel me-2"></i>Export to CSV
            </a>
            <button onclick="window.close()" class="btn btn-secondary">
                <i class="fas fa-times me-2"></i>Close
            </button>
        </div>

        <!-- Appointments Table -->
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-list me-2"></i>Appointment Details</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Date & Time</th>
                                <th>Client</th>
                                <th>Service</th>
                                <th>Veterinarian</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($appointments)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p>No appointments found for the selected criteria</p>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($appointments as $appt): ?>
                                    <tr>
                                        <td><?= $appt['id'] ?></td>
                                        <td>
                                            <strong><?= date('M d, Y', strtotime($appt['appointment_date'])) ?></strong><br>
                                            <small class="text-muted"><?= date('h:i A', strtotime($appt['appointment_date'])) ?></small>
                                        </td>
                                        <td><?= htmlspecialchars($appt['user_name']) ?></td>
                                        <td><?= htmlspecialchars($appt['service_name']) ?></td>
                                        <td><?= htmlspecialchars($appt['vet_name']) ?></td>
                                        <td>
                                            <span class="badge badge-<?= strtolower($appt['status']) ?>">
                                                <?= $appt['status'] ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="text-center text-muted mt-4">
            <small>&copy; <?= date('Y') ?> Veterinary Services System - Calapan City, Oriental Mindoro</small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
