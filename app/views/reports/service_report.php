<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @media print {
            .no-print { display: none; }
        }
        .report-header {
            background: linear-gradient(135deg, #ff914d 0%, #ffb47b 100%);
            color: white;
            padding: 2rem;
            border-radius: 8px;
            margin-bottom: 2rem;
        }
        .progress { height: 25px; }
    </style>
</head>
<body>
    <div class="container my-4">
        <div class="report-header">
            <h1><i class="fas fa-stethoscope me-2"></i>Service Report</h1>
            <p class="mb-0">Generated on: <?= date('F d, Y h:i A') ?></p>
            <?php if ($start_date && $end_date): ?>
                <p class="mb-0">Period: <?= date('M d, Y', strtotime($start_date)) ?> - <?= date('M d, Y', strtotime($end_date)) ?></p>
            <?php endif; ?>
        </div>

        <div class="mb-3 no-print">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print me-2"></i>Print Report
            </button>
            <a href="<?= site_url('reports/export?type=services&start_date=' . $start_date . '&end_date=' . $end_date) ?>" 
               class="btn btn-success">
                <i class="fas fa-file-excel me-2"></i>Export to CSV
            </a>
            <button onclick="window.close()" class="btn btn-secondary">
                <i class="fas fa-times me-2"></i>Close
            </button>
        </div>

        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Service Statistics</h5>
            </div>
            <div class="card-body">
                <?php if (empty($services)): ?>
                    <p class="text-center text-muted py-4">No service data available</p>
                <?php else: ?>
                    <?php foreach ($services as $service): ?>
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0"><?= htmlspecialchars($service['service_name']) ?></h6>
                                <span class="badge bg-primary"><?= $service['total_appointments'] ?> Total</span>
                            </div>
                            <p class="text-muted small mb-2"><?= htmlspecialchars($service['description']) ?></p>
                            
                            <div class="row g-2 mb-2">
                                <div class="col-4">
                                    <small class="text-success">✓ Completed: <?= $service['completed_count'] ?></small>
                                </div>
                                <div class="col-4">
                                    <small class="text-warning">⏳ Pending: <?= $service['pending_count'] ?></small>
                                </div>
                                <div class="col-4">
                                    <small class="text-danger">✗ Cancelled: <?= $service['cancelled_count'] ?></small>
                                </div>
                            </div>
                            
                            <?php if ($service['total_appointments'] > 0): ?>
                                <div class="progress">
                                    <div class="progress-bar bg-success" style="width: <?= ($service['completed_count'] / $service['total_appointments']) * 100 ?>%">
                                        <?= round(($service['completed_count'] / $service['total_appointments']) * 100) ?>%
                                    </div>
                                </div>
                            <?php endif; ?>
                            <hr class="mt-3">
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="text-center text-muted mt-4">
            <small>&copy; <?= date('Y') ?> Veterinary Services System</small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
