# Appointment Time Slot Management - Implementation Guide

## ✅ Features Implemented

### 1. **Prevent Past Date Appointments**
- Users cannot select dates before today when booking appointments
- JavaScript validation sets `min` attribute on date input to current date

### 2. **30-Minute Time Slot System**
- Each appointment has a fixed 30-minute duration
- Time slots available from 8:00 AM to 5:00 PM in 30-minute intervals
- Users select both date AND time when booking

### 3. **Prevent Double Booking**
- Real-time checking of available time slots per veterinarian
- When a time slot is booked, it becomes unavailable for other users
- AJAX call checks booked slots when date or veterinarian changes
- Booked slots are marked as "(Booked)" and disabled in the dropdown

---

## 📋 Database Update Required

**IMPORTANT:** You must run the SQL migration to update your database schema.

### Steps to Update Database:

1. **Open phpMyAdmin** (http://localhost/phpmyadmin)
2. **Select your database** (the one used by your veterinary system)
3. **Click "SQL" tab**
4. **Copy and paste** the contents of `update_appointment_datetime.sql`
5. **Click "Go"** to execute

**Or using MySQL command line:**

```bash
mysql -u root -p your_database_name < update_appointment_datetime.sql
```

This migration will:
- Change `appointment_date` column from `DATE` to `DATETIME`
- Add database index for faster queries
- Update existing appointments with default time (9:00 AM)

---

## 🔧 Files Modified

### Controller
- `app/controllers/AppointmentController.php`
  - Updated `add()` method to combine date + time
  - Updated `edit()` method to handle time field
  - Added `getBookedSlots()` endpoint for AJAX requests
  - Added time slot conflict validation

### Model
- `app/models/AppointmentModel.php`
  - Added `isTimeSlotBooked()` - checks if a time slot is already taken
  - Added `isTimeSlotBookedExcluding()` - checks slot when editing (excludes current appointment)
  - Added `getBookedTimeSlots()` - returns array of booked times for a specific date/vet

### Views
- `app/views/admin/appointment_add.php`
  - Added time slot dropdown (30-minute intervals)
  - Added JavaScript to block past dates
  - Added AJAX to fetch and disable booked slots
  - Added form validation before submit

- `app/views/admin/appointment_edit.php`
  - Added time slot dropdown with current time pre-selected
  - Added past date blocking
  - Added AJAX slot availability checking
  - Excludes current appointment when checking conflicts

---

## 🎯 How It Works

### Booking Flow:

1. **User selects a date** → JavaScript blocks past dates
2. **User selects a veterinarian** → AJAX fetches booked slots for that vet on selected date
3. **System disables booked time slots** → User sees only available times
4. **User submits form** → Backend validates:
   - Time slot is not already booked
   - Date is not in the past
5. **Appointment saved** with datetime (e.g., `2025-11-15 09:30:00`)

### Editing Flow:

- Same as booking, but the current appointment's time slot is NOT marked as booked
- This allows users to keep the same time when editing other details

---

## 🧪 Testing Checklist

### Test Case 1: Past Date Blocking
- [ ] Try to select yesterday's date → Should be disabled/blocked
- [ ] Only today and future dates should be selectable

### Test Case 2: Time Slot Booking
- [ ] Create appointment for Vet A at 9:00 AM on Dec 1
- [ ] Try to create another appointment for same Vet A at 9:00 AM on Dec 1
- [ ] 9:00 AM should show as "(Booked)" and be disabled

### Test Case 3: Different Vets Same Time
- [ ] Create appointment for Vet A at 9:00 AM
- [ ] Create appointment for Vet B at 9:00 AM (same date)
- [ ] Should succeed - different vets can have same time slot

### Test Case 4: 30-Minute Window
- [ ] Book Vet A at 9:00 AM
- [ ] 9:00 AM slot should be unavailable for Vet A
- [ ] 9:30 AM slot should still be available

### Test Case 5: Edit Without Conflict
- [ ] Edit existing appointment but keep same time
- [ ] Should succeed - doesn't conflict with itself

---

## 🚀 Usage Instructions

### For Admins:

1. Navigate to **Appointments > Add Appointment**
2. Select **Client**, **Veterinarian**, and **Service**
3. Choose **Date** (only future dates available)
4. Choose **Time** from dropdown
   - Booked slots will show as "(Booked)"
5. Set **Status** (Pending/Approved/etc.)
6. Click **Save Appointment**

### For Clients (if you have a client-facing booking page):

You'll need to apply the same logic to any client-facing appointment booking forms.

---

## 🔒 Validation Layers

### Frontend (JavaScript)
- Blocks past dates
- Disables booked time slots
- Shows visual feedback "(Booked)"
- Prevents form submission if slot is booked

### Backend (PHP)
- Double-checks time slot availability
- Validates veterinarian exists
- Ensures date is not in past
- Prevents race conditions

### Database
- Index on (vet_id, appointment_date) for fast queries
- DATETIME type stores both date and time

---

## 📱 API Endpoint

### Get Booked Slots
**Endpoint:** `appointments/getBookedSlots`

**Method:** GET

**Parameters:**
- `date` (required): Date in Y-m-d format (e.g., 2025-11-15)
- `vet_id` (required): Veterinarian ID
- `exclude_id` (optional): Appointment ID to exclude (for editing)

**Response:**
```json
{
  "bookedSlots": ["09:00", "09:30", "14:00"]
}
```

---

## 🎨 Time Slot Options

Available time slots (all 30 minutes):
- 08:00 AM - 08:30 AM
- 08:30 AM - 09:00 AM
- 09:00 AM - 09:30 AM
- ... (continues every 30 minutes)
- 16:30 PM - 17:00 PM
- 17:00 PM - 17:30 PM

**Business Hours:** 8:00 AM to 5:00 PM

---

## 🐛 Troubleshooting

### Issue: Booked slots not showing
**Solution:** Check browser console for JavaScript errors. Ensure the endpoint `appointments/getBookedSlots` is accessible.

### Issue: Can still book past dates
**Solution:** Ensure JavaScript is enabled. Check if `min` attribute is set on date input.

### Issue: Time slots not updating when changing vet
**Solution:** Check that event listeners are attached to vet dropdown. Verify AJAX calls in browser Network tab.

### Issue: Database error when saving
**Solution:** Run the SQL migration script. Ensure `appointment_date` column is DATETIME type.

---

## 📞 Support

If you encounter issues:
1. Check browser console for JavaScript errors
2. Check PHP error logs
3. Verify database schema was updated correctly
4. Test the `/appointments/getBookedSlots` endpoint manually

---

**Implementation Date:** November 11, 2025
**Version:** 1.0
