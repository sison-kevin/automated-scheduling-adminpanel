<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Report</title>
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
    </style>
</head>
<body>
    <div class="container my-4">
        <div class="report-header">
            <h1><i class="fas fa-users me-2"></i>Client Activity Report</h1>
            <p class="mb-0">Generated on: <?= date('F d, Y h:i A') ?></p>
            <?php if ($start_date && $end_date): ?>
                <p class="mb-0">Period: <?= date('M d, Y', strtotime($start_date)) ?> - <?= date('M d, Y', strtotime($end_date)) ?></p>
            <?php endif; ?>
        </div>

        <div class="mb-3 no-print">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print me-2"></i>Print Report
            </button>
            <a href="<?= site_url('reports/export?type=clients&start_date=' . $start_date . '&end_date=' . $end_date) ?>" 
               class="btn btn-success">
                <i class="fas fa-file-excel me-2"></i>Export to CSV
            </a>
            <button onclick="window.close()" class="btn btn-secondary">
                <i class="fas fa-times me-2"></i>Close
            </button>
        </div>

        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Client Engagement Statistics</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Client Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Total Appointments</th>
                                <th>Completed</th>
                                <th>Completion Rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($clients)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p>No client data available</p>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($clients as $client): ?>
                                    <tr>
                                        <td>
                                            <i class="fas fa-user text-primary me-2"></i>
                                            <?= htmlspecialchars($client['name']) ?>
                                        </td>
                                        <td><?= htmlspecialchars($client['email']) ?></td>
                                        <td><?= htmlspecialchars($client['phone'] ?? 'N/A') ?></td>
                                        <td>
                                            <span class="badge bg-primary"><?= $client['total_appointments'] ?></span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success"><?= $client['completed_count'] ?></span>
                                        </td>
                                        <td>
                                            <?php if ($client['total_appointments'] > 0): ?>
                                                <?php $rate = round(($client['completed_count'] / $client['total_appointments']) * 100); ?>
                                                <div class="progress" style="height: 20px; width: 100px;">
                                                    <div class="progress-bar <?= $rate >= 70 ? 'bg-success' : ($rate >= 40 ? 'bg-warning' : 'bg-danger') ?>" 
                                                         style="width: <?= $rate ?>%">
                                                        <?= $rate ?>%
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-muted">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <?php if (!empty($clients)): ?>
            <div class="card mt-3">
                <div class="card-body">
                    <h6><i class="fas fa-info-circle me-2"></i>Summary</h6>
                    <p class="mb-0">
                        <strong>Total Active Clients:</strong> <?= count($clients) ?><br>
                        <strong>Average Appointments per Client:</strong> 
                        <?= round(array_sum(array_column($clients, 'total_appointments')) / count($clients), 2) ?>
                    </p>
                </div>
            </div>
        <?php endif; ?>

        <div class="text-center text-muted mt-4">
            <small>&copy; <?= date('Y') ?> Veterinary Services System</small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
