# Reports Feature Documentation

## Overview
A comprehensive reporting system has been added to the Veterinary Services application.

## Features

### 1. **Appointment Report**
- Filter by date range
- Filter by status (Pending, Approved, Completed, Cancelled)
- Filter by veterinarian
- Shows summary statistics
- Export to CSV
- Print functionality

### 2. **Service Report**
- Service usage statistics
- Completion rates
- Visual progress bars
- Date range filtering
- Export to CSV

### 3. **Veterinarian Performance Report**
- Appointment workload per veterinarian
- Completion rates
- Status breakdown (Pending, Approved, Completed)
- Contact information
- Export to CSV

### 4. **Client Activity Report**
- Client engagement metrics
- Total appointments per client
- Completion rates with color-coded progress bars
- Average appointments per client summary
- Export to CSV

## Files Created

### Controllers
- `app/controllers/ReportController.php` - Handles all report generation and exports

### Views
- `app/views/reports/index.php` - Main reports page with 4 report cards
- `app/views/reports/appointment_report.php` - Detailed appointment report
- `app/views/reports/service_report.php` - Service statistics report
- `app/views/reports/veterinarian_report.php` - Veterinarian performance report
- `app/views/reports/client_report.php` - Client activity report

### Routes Added
```php
$router->get('/reports', 'ReportController::index');
$router->post('/reports/appointments', 'ReportController::appointments');
$router->post('/reports/services', 'ReportController::services');
$router->post('/reports/veterinarians', 'ReportController::veterinarians');
$router->post('/reports/clients', 'ReportController::clients');
$router->get('/reports/export', 'ReportController::export');
```

## How to Access

1. Navigate to the dashboard
2. Click on "📊 Reports" in the sidebar
3. Choose a report type from the 4 cards:
   - **Appointment Report** (Purple card)
   - **Service Report** (Blue card)
   - **Veterinarian Report** (Green card)
   - **Client Report** (Orange card)
4. Select date range and filters (if applicable)
5. Click "Generate Report"
6. Report opens in a new window/tab

## Report Actions

Each report includes:
- **Print** button - Print the report directly
- **Export to CSV** button - Download data as CSV file
- **Close** button - Close the report window

## Export Format

CSV exports include:
- **Appointments**: ID, Date, Time, Client, Email, Service, Veterinarian, Status
- **Services**: Service Name, Description, Total Appointments, Completed, Cancelled
- **Veterinarians**: Name, Specialization, Email, Phone, Total Appointments, Completed
- **Clients**: Name, Email, Phone, Total Appointments, Completed

## Design Features

- Modern gradient headers (color-coded per report type)
- Hover effects on report cards
- Responsive Bootstrap 5 layout
- Font Awesome icons
- Print-optimized styling
- Professional color scheme

## Technical Details

- Uses LavaLust's database query builder
- Supports LEFT JOIN for comprehensive data
- Date filtering with SQL WHERE clauses
- CSV generation using PHP's fputcsv()
- Opens reports in new window (target="_blank")

## Navigation
Added "📊 Reports" link to the dashboard sidebar for easy access.
