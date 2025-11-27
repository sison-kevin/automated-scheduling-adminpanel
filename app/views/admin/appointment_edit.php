<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Appointment | Admin</title>
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

/* CONTAINER CARD */
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

form select, form input {
  width: 100%;
  padding: 12px 14px;
  border: 1px solid var(--border);
  border-radius: 10px;
  margin-bottom: 18px;
  font-size: 0.95rem;
  background: #fff;
  transition: border 0.2s ease, box-shadow 0.2s ease;
}

form select:focus, form input:focus {
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
  <h2>Edit Appointment</h2>

  <form method="POST" action="<?= site_url('appointments/edit/' . $appointment['id']) ?>">
    <label>Client</label>
    <select name="user_id" required>
      <?php foreach ($users as $user): ?>
        <option value="<?= $user['id'] ?>" <?= $user['id'] == $appointment['user_id'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($user['name']); ?>
        </option>
      <?php endforeach; ?>
    </select>

    <label>Service</label>
    <select name="service_id" id="serviceSelect" required>
      <?php foreach ($services as $service): ?>
        <option value="<?= $service['id'] ?>" data-specialization="<?= htmlspecialchars($service['service_name']); ?>" <?= $service['id'] == $appointment['service_id'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($service['service_name']); ?>
        </option>
      <?php endforeach; ?>
    </select>

    <label>Veterinarian</label>
    <select name="vet_id" id="vetSelect" required>
      <?php foreach ($vets as $vet): ?>
        <option value="<?= $vet['id'] ?>" data-specialization="<?= htmlspecialchars($vet['specialization']); ?>" <?= $vet['id'] == $appointment['vet_id'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($vet['name']); ?> (<?= htmlspecialchars($vet['specialization']); ?>)
        </option>
      <?php endforeach; ?>
    </select>

    <label>Appointment Date</label>
    <input type="date" name="appointment_date" id="appointmentDate" value="<?= date('Y-m-d', strtotime($appointment['appointment_date'])) ?>" required>

    <label>Appointment Time</label>
    <select name="appointment_time" id="appointmentTime" required>
      <option value="">-- Select Time --</option>
      <?php
      $currentTime = date('H:i', strtotime($appointment['appointment_time']));
      $times = [
        '08:00' => '08:00 AM', '08:30' => '08:30 AM', '09:00' => '09:00 AM', '09:30' => '09:30 AM',
        '10:00' => '10:00 AM', '10:30' => '10:30 AM', '11:00' => '11:00 AM', '11:30' => '11:30 AM',
        '12:00' => '12:00 PM', '12:30' => '12:30 PM', '13:00' => '01:00 PM', '13:30' => '01:30 PM',
        '14:00' => '02:00 PM', '14:30' => '02:30 PM', '15:00' => '03:00 PM', '15:30' => '03:30 PM',
        '16:00' => '04:00 PM', '16:30' => '04:30 PM', '17:00' => '05:00 PM'
      ];
      foreach ($times as $value => $label):
      ?>
        <option value="<?= $value ?>" <?= $value == $currentTime ? 'selected' : '' ?>><?= $label ?></option>
      <?php endforeach; ?>
    </select>

    <label>Status</label>
    <select name="status">
      <?php foreach (['Pending','Approved','Completed','Cancelled'] as $status): ?>
        <option value="<?= $status ?>" <?= $status == $appointment['status'] ? 'selected' : '' ?>><?= $status ?></option>
      <?php endforeach; ?>
    </select>

    <div class="actions">
      <button type="submit" class="btn-save">Update Appointment</button>
      <a href="<?= site_url('appointments') ?>" class="btn-secondary">Back</a>
    </div>
  </form>
</div>

<footer>
  &copy; <?= date('Y'); ?> Automated Scheduling and Tracking System for Veterinary Services – Calapan City, Oriental Mindoro
</footer>

<script>
// ========================================
// 🎯 FILTER VETERINARIANS BY SERVICE
// ========================================
const serviceSelect = document.getElementById('serviceSelect');
const vetSelect = document.getElementById('vetSelect');
const originalVetId = '<?= $appointment['vet_id'] ?>';

serviceSelect.addEventListener('change', function() {
  const selectedService = serviceSelect.options[serviceSelect.selectedIndex];
  const serviceSpecialization = selectedService ? selectedService.dataset.specialization : '';
  
  if (!serviceSpecialization) {
    vetSelect.disabled = true;
    return;
  }
  
  // Build new options with only matching veterinarians
  let newOptions = '<option value="">-- Choose veterinarian --</option>';
  let matchCount = 0;
  
  <?php foreach ($vets as $vet): ?>
  {
    const vetSpec = <?= json_encode($vet['specialization']); ?>;
    const vetId = "<?= $vet['id']; ?>";
    const isSelected = vetId === originalVetId;
    if (vetSpec === serviceSpecialization) {
      newOptions += '<option value="' + vetId + '" data-specialization="' + vetSpec + '"' + (isSelected ? ' selected' : '') + '><?= htmlspecialchars($vet['name']); ?> (' + vetSpec + ')</option>';
      matchCount++;
    }
  }
  <?php endforeach; ?>
  
  if (matchCount === 0) {
    vetSelect.innerHTML = '<option value="">-- No veterinarians available for this service --</option>';
    vetSelect.disabled = true;
  } else {
    vetSelect.innerHTML = newOptions;
    vetSelect.disabled = false;
  }
});

// Trigger service change to initialize vet dropdown state
serviceSelect.dispatchEvent(new Event('change'));

// ========================================
// 🚫 BLOCK PAST DATES
// ========================================
const dateInput = document.getElementById('appointmentDate');
const timeSelect = document.getElementById('appointmentTime');

// Set minimum date to today
const today = new Date().toISOString().split('T')[0];
dateInput.setAttribute('min', today);

// ========================================
// 🕐 CHECK AVAILABLE TIME SLOTS
// ========================================
let bookedSlots = [];
const currentAppointmentId = <?= $appointment['id'] ?>;
const allTimeSlots = [
  '08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
  '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30',
  '16:00', '16:30', '17:00', '17:30', '18:00'
];

async function checkAvailableSlots() {
  const selectedDate = dateInput.value;
  const selectedVet = vetSelect.value;
  
  if (!selectedDate || !selectedVet) return;

  try {
    const response = await fetch('<?= site_url('appointments/getBookedSlots') ?>?date=' + selectedDate + '&vet_id=' + selectedVet + '&exclude_id=' + currentAppointmentId);
    const data = await response.json();
    bookedSlots = data.bookedSlots || [];
    
    // Store current selection
    const currentValue = timeSelect.value;
    
    // Rebuild the time select with only available slots (plus current value)
    timeSelect.innerHTML = '<option value="">-- Choose time slot --</option>';
    
    allTimeSlots.forEach(slot => {
      if (!bookedSlots.includes(slot) || slot === currentValue) {
        const option = document.createElement('option');
        option.value = slot;
        option.textContent = slot;
        if (slot === currentValue) {
          option.selected = true;
        }
        timeSelect.appendChild(option);
      }
    });
  } catch (error) {
    console.error('Error fetching booked slots:', error);
  }
}

// Listen for date and vet changes
dateInput.addEventListener('change', checkAvailableSlots);
vetSelect.addEventListener('change', checkAvailableSlots);

// Load available slots on page load to preserve current appointment time
window.addEventListener('DOMContentLoaded', function() {
  checkAvailableSlots();
});

// ========================================
// ✅ FORM VALIDATION BEFORE SUBMIT
// ========================================
document.querySelector('form').addEventListener('submit', function(e) {
  const selectedTime = timeSelect.value;
  
  if (bookedSlots.includes(selectedTime)) {
    e.preventDefault();
    alert('⚠️ This time slot is already booked. Please select another time.');
    return false;
  }
});
</script>

</body>
</html>
