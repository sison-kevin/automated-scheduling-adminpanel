-- ========================================
-- UPDATE APPOINTMENTS TABLE TO SUPPORT TIME
-- ========================================

-- Change appointment_date from DATE to DATETIME
ALTER TABLE `appointments` 
MODIFY COLUMN `appointment_date` DATETIME NOT NULL;

-- Add index for faster queries on vet_id and appointment_date
CREATE INDEX idx_vet_appointment ON `appointments` (`vet_id`, `appointment_date`);

-- Optional: Update existing appointments to have a default time if they only have dates
UPDATE `appointments` 
SET `appointment_date` = CONCAT(`appointment_date`, ' 09:00:00') 
WHERE `appointment_date` NOT LIKE '%:%';
