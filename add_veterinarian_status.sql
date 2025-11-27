-- ========================================
-- ADD STATUS COLUMN TO VETERINARIANS TABLE
-- ========================================

-- Add is_active column (1 = active, 0 = inactive)
ALTER TABLE `veterinarians` 
ADD COLUMN `is_active` TINYINT(1) NOT NULL DEFAULT 1 AFTER `contact`;

-- Update existing veterinarians to be active by default
UPDATE `veterinarians` SET `is_active` = 1;
