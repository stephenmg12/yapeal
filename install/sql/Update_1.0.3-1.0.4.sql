SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
ALTER TABLE `{table_prefix}accountCharacters` ADD COLUMN `allianceID` BIGINT(20) UNSIGNED NOT NULL;
ALTER TABLE `{table_prefix}accountCharacters` ADD COLUMN `allianceName` VARCHAR(255) NOT NULL;
ALTER TABLE `{table_prefix}accountCharacters` ADD COLUMN `factionID` BIGINT(20) UNSIGNED NOT NULL;
ALTER TABLE `{table_prefix}accountCharacters` ADD COLUMN `factionName` VARCHAR(255) NOT NULL;
ALTER TABLE `{table_prefix}mapFacWarSystems` ADD COLUMN `victoryPoints` BIGINT(20) UNSIGNED NOT NULL;
ALTER TABLE `{table_prefix}mapFacWarSystems` ADD COLUMN `victoryPointThreshold` BIGINT(20) UNSIGNED NOT NULL;
