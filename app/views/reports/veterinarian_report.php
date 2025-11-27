<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veterinarian Report</title>
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
        .vet-card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="container my-4">
        <div class="report-header">
            <h1><i class="fas fa-user-md me-2"></i>Veterinarian Performance Report</h1>
            <p class="mb-0">Generated on: <?= date('F d, Y h:i A') ?></p>
            <?php if ($start_date && $end_date): ?>
                <p class="mb-0">Period: <?= date('M d, Y', strtotime($start_date)) ?> - <?= date('M d, Y', strtotime($end_date)) ?></p>
            <?php endif; ?>
        </div>

        <div class="mb-3 no-print">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print me-2"></i>Print Report
            </button>
            <a href="<?= site_url('reports/export?type=veterinarians&start_date=' . $start_date . '&end_date=' . $end_date) ?>" 
               class="btn btn-success">
                <i class="fas fa-file-excel me-2"></i>Export to CSV
            </a>
            <button onclick="window.close()" class="btn btn-secondary">
                <i class="fas fa-times me-2"></i>Close
            </button>
        </div>

        <?php if (empty($veterinarians)): ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>No veterinarian data available for the selected period.
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($veterinarians as $vet): ?>
                    <div class="col-md-6">
                        <div class="card vet-card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <i class="fas fa-user-md text-success me-2"></i>
                                    <?= htmlspecialchars($vet['name']) ?>
                                </h5>
                                <p class="text-muted mb-3">
                                    <i class="fas fa-briefcase-medical me-1"></i>
                                    <?= htmlspecialchars($vet['specialization']) ?>
                                </p>
                                
                                <div class="row text-center mb-3">
                                    <div class="col-3">
                                        <h4 class="mb-0 text-primary"><?= $vet['total_appointments'] ?></h4>
                                        <small class="text-muted">Total</small>
                                    </div>
                                    <div class="col-3">
                                        <h4 class="mb-0 text-success"><?= $vet['completed_count'] ?></h4>
                                        <small class="text-muted">Completed</small>
                                    </div>
                                    <div class="col-3">
                                        <h4 class="mb-0 text-warning"><?= $vet['pending_count'] ?></h4>
                                        <small class="text-muted">Pending</small>
                                    </div>
                                    <div class="col-3">
                                        <h4 class="mb-0 text-info"><?= $vet['approved_count'] ?></h4>
                                        <small class="text-muted">Approved</small>
                                    </div>
                                </div>

                                <?php if ($vet['total_appointments'] > 0): ?>
                                    <div class="progress" style="height: 25px;">
                                        <div class="progress-bar bg-success" 
                                             style="width: <?= ($vet['completed_count'] / $vet['total_appointments']) * 100 ?>%"
                                             title="Completed">
                                            <?= round(($vet['completed_count'] / $vet['total_appointments']) * 100) ?>%
                                        </div>
                                    </div>
                                    <small class="text-muted">Completion Rate</small>
                                <?php endif; ?>

                                <hr>
                                <div class="small text-muted">
                                    <i class="fas fa-user-md me-1"></i><?= htmlspecialchars($vet['specialization']) ?><br>
                                    <i class="fas fa-phone me-1"></i><?= htmlspecialchars($vet['contact'] ?? 'N/A') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="text-center text-muted mt-4">
            <small>&copy; <?= date('Y') ?> Veterinary Services System</small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
