SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
CREATE DATABASE IF NOT EXISTS `{database}`
    DEFAULT CHARACTER SET utf8
    COLLATE utf8_unicode_ci;
USE `{database}`;
CREATE TABLE IF NOT EXISTS `{table_prefix}accountAccountStatus` (
    `keyID`        BIGINT(20) UNSIGNED NOT NULL,
    `createDate`   DATETIME            NOT NULL,
    `logonCount`   BIGINT(20) UNSIGNED NOT NULL,
    `logonMinutes` BIGINT(20) UNSIGNED NOT NULL,
    `paidUntil`    DATETIME            NOT NULL,
    PRIMARY KEY (`keyID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}accountAPIKeyInfo` (
    `keyID`      BIGINT(20) UNSIGNED NOT NULL,
    `accessMask` BIGINT(20) UNSIGNED NOT NULL,
    `expires`    DATETIME            NOT NULL DEFAULT '2038-01-19 03:14:07',
    `type`       ENUM('Account', 'Character', 'Corporation')
                 CHARACTER SET ascii NOT NULL,
    PRIMARY KEY (`keyID`),
    KEY `accountAPIKeyInfo1` (`type`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}accountCharacters` (
    `characterID`     BIGINT(20) UNSIGNED NOT NULL,
    `characterName`   VARCHAR(255)        NOT NULL,
    `corporationID`   BIGINT(20) UNSIGNED NOT NULL,
    `corporationName` VARCHAR(255)        NOT NULL,
    PRIMARY KEY (`characterID`),
    KEY `accountCharacters1` (`corporationID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}accountKeyBridge` (
    `keyID`       BIGINT(20) UNSIGNED NOT NULL,
    `characterID` BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`keyID`, `characterID`),
    UNIQUE KEY `accountKeyBridge1` (`characterID`, `keyID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}characcountbalance` (
    `ownerID`    BIGINT(20) UNSIGNED  NOT NULL,
    `accountID`  BIGINT(20) UNSIGNED  NOT NULL,
    `accountKey` SMALLINT(4) UNSIGNED NOT NULL,
    `balance`    DECIMAL(17, 2)       NOT NULL,
    PRIMARY KEY (`ownerID`, `accountKey`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}charAllianceContactList` (
    `ownerID`       BIGINT(20) UNSIGNED NOT NULL,
    `contactID`     BIGINT(20) UNSIGNED NOT NULL,
    `contactTypeID` BIGINT(20) UNSIGNED DEFAULT NULL,
    `contactName`   VARCHAR(255)        NOT NULL,
    `standing`      DECIMAL(5, 2)       NOT NULL,
    PRIMARY KEY (`ownerID`, `contactID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `{table_prefix}charAssetList` (
    `ownerID`     BIGINT(20) UNSIGNED  NOT NULL,
    `flag`        SMALLINT(5) UNSIGNED NOT NULL,
    `itemID`      BIGINT(20) UNSIGNED  NOT NULL,
    `lft`         BIGINT(20) UNSIGNED  NOT NULL,
    `locationID`  BIGINT(20) UNSIGNED  NOT NULL,
    `lvl`         TINYINT(2) UNSIGNED  NOT NULL,
    `quantity`    BIGINT(20) UNSIGNED  NOT NULL,
    `rawQuantity` BIGINT(20) DEFAULT NULL,
    `rgt`         BIGINT(20) UNSIGNED  NOT NULL,
    `singleton`   TINYINT(1)           NOT NULL,
    `typeID`      BIGINT(20) UNSIGNED  NOT NULL,
    PRIMARY KEY (`ownerID`, `itemID`),
    KEY `charAssetList1` (`lft`),
    KEY `charAssetList2` (`locationID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}charAttackers` (
    `killID`          BIGINT(20) UNSIGNED NOT NULL,
    `allianceID`      BIGINT(20) UNSIGNED NOT NULL,
    `allianceName`    VARCHAR(255)
        DEFAULT NULL,
    `characterID`     BIGINT(20) UNSIGNED NOT NULL,
    `characterName`   VARCHAR(255)
        DEFAULT NULL,
    `corporationID`   BIGINT(20) UNSIGNED NOT NULL,
    `corporationName` VARCHAR(255) DEFAULT NULL,
    `damageDone`      BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    `factionID`       BIGINT(20) UNSIGNED NOT NULL,
    `factionName`     VARCHAR(255) DEFAULT NULL,
    `finalBlow`       TINYINT(1)          NOT NULL,
    `securityStatus`  DOUBLE              NOT NULL,
    `shipTypeID`      BIGINT(20) UNSIGNED NOT NULL,
    `weaponTypeID`    BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`killID`, `characterID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}charAttributeEnhancers` (
    `ownerID`          BIGINT(20) UNSIGNED NOT NULL,
    `augmentatorName`  VARCHAR(100)        NOT NULL,
    `augmentatorValue` TINYINT(2) UNSIGNED NOT NULL,
    `bonusName`        VARCHAR(100)        NOT NULL,
    PRIMARY KEY (`ownerID`, `bonusName`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}charAttributes` (
    `charisma`     TINYINT(2) UNSIGNED NOT NULL,
    `intelligence` TINYINT(2) UNSIGNED NOT NULL,
    `memory`       TINYINT(2) UNSIGNED NOT NULL,
    `ownerID`      BIGINT(20) UNSIGNED NOT NULL,
    `perception`   TINYINT(2) UNSIGNED NOT NULL,
    `willpower`    TINYINT(2) UNSIGNED NOT NULL,
    PRIMARY KEY (`ownerID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}charCalendarEventAttendees` (
    `ownerID`       BIGINT(20) UNSIGNED NOT NULL,
    `characterID`   BIGINT(20) UNSIGNED NOT NULL,
    `characterName` VARCHAR(255)        NOT NULL,
    `response`      VARCHAR(32)         NOT NULL,
    PRIMARY KEY (`ownerID`, `characterID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}charCertificates` (
    `ownerID`       BIGINT(20) UNSIGNED NOT NULL,
    `certificateID` BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`ownerID`, `certificateID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}charCharacterSheet` (
    `allianceID`       BIGINT(20) UNSIGNED DEFAULT '0',
    `allianceName`     VARCHAR(255) DEFAULT '',
    `ancestry`         VARCHAR(255)        NOT NULL,
    `balance`          DECIMAL(17, 2)      NOT NULL,
    `bloodLine`        VARCHAR(255)        NOT NULL,
    `characterID`      BIGINT(20) UNSIGNED NOT NULL,
    `cloneName`        VARCHAR(255)        NOT NULL,
    `cloneSkillPoints` BIGINT(20) UNSIGNED NOT NULL,
    `corporationID`    BIGINT(20) UNSIGNED NOT NULL,
    `corporationName`  VARCHAR(255)        NOT NULL,
    `DoB`              DATETIME            NOT NULL,
    `gender`           VARCHAR(255)        NOT NULL,
    `name`             VARCHAR(255)        NOT NULL,
    `race`             VARCHAR(255)        NOT NULL,
    PRIMARY KEY (`characterID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}charContactList` (
    `ownerID`       BIGINT(20) UNSIGNED NOT NULL,
    `contactID`     BIGINT(20) UNSIGNED NOT NULL,
    `contactTypeID` BIGINT(20) UNSIGNED DEFAULT NULL,
    `contactName`   VARCHAR(255)        NOT NULL,
    `inWatchlist`   TINYINT(1)          NOT NULL,
    `standing`      DECIMAL(5, 2)       NOT NULL,
    PRIMARY KEY (`ownerID`, `contactID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}charContactNotifications` (
    `ownerID`        BIGINT(20) UNSIGNED NOT NULL,
    `notificationID` BIGINT(20) UNSIGNED NOT NULL,
    `senderID`       BIGINT(20) UNSIGNED NOT NULL,
    `senderName`     VARCHAR(255)        NOT NULL,
    `sentDate`       DATETIME            NOT NULL,
    `messageData`    TEXT,
    PRIMARY KEY (`ownerID`, `notificationID`, `senderID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}charContracts` (
    `ownerID`        BIGINT(20) UNSIGNED  NOT NULL,
    `contractID`     BIGINT(20) UNSIGNED  NOT NULL,
    `issuerID`       BIGINT(20) UNSIGNED  NOT NULL,
    `issuerCorpID`   BIGINT(20) UNSIGNED  NOT NULL,
    `assigneeID`     BIGINT(20) UNSIGNED  NOT NULL,
    `acceptorID`     BIGINT(20) UNSIGNED  NOT NULL,
    `startStationID` BIGINT(20) UNSIGNED  NOT NULL,
    `endStationID`   BIGINT(20) UNSIGNED  NOT NULL,
    `type`           VARCHAR(255)         NOT NULL,
    `status`         VARCHAR(255)         NOT NULL,
    `title`          VARCHAR(255) DEFAULT NULL,
    `forCorp`        TINYINT(1)           NOT NULL,
    `availability`   VARCHAR(255)         NOT NULL,
    `dateIssued`     DATETIME             NOT NULL,
    `dateExpired`    DATETIME             NOT NULL,
    `dateAccepted`   DATETIME DEFAULT NULL,
    `numDays`        SMALLINT(3) UNSIGNED NOT NULL,
    `dateCompleted`  DATETIME DEFAULT NULL,
    `price`          DECIMAL(17, 2)       NOT NULL,
    `reward`         DECIMAL(17, 2)       NOT NULL,
    `collateral`     DECIMAL(17, 2)       NOT NULL,
    `buyout`         DECIMAL(17, 2)       NOT NULL,
    `volume`         BIGINT(20) UNSIGNED  NOT NULL,
    PRIMARY KEY (`ownerID`, `contractID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `{table_prefix}charCorporateContactList` (
    `ownerID`       BIGINT(20) UNSIGNED NOT NULL,
    `contactID`     BIGINT(20) UNSIGNED NOT NULL,
    `contactTypeID` BIGINT(20) UNSIGNED DEFAULT NULL,
    `contactName`   VARCHAR(255)        NOT NULL,
    `standing`      DECIMAL(5, 2)       NOT NULL,
    PRIMARY KEY (`ownerID`, `contactID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}charCorporationRoles` (
    `ownerID`  BIGINT(20) UNSIGNED NOT NULL,
    `roleID`   BIGINT(20) UNSIGNED NOT NULL,
    `roleName` VARCHAR(255)        NOT NULL,
    PRIMARY KEY (`ownerID`, `roleID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}charCorporationRolesAtBase` (
    `ownerID`  BIGINT(20) UNSIGNED NOT NULL,
    `roleID`   BIGINT(20) UNSIGNED NOT NULL,
    `roleName` VARCHAR(255)        NOT NULL,
    PRIMARY KEY (`ownerID`, `roleID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}charCorporationRolesAtHQ` (
    `ownerID`  BIGINT(20) UNSIGNED NOT NULL,
    `roleID`   BIGINT(20) UNSIGNED NOT NULL,
    `roleName` VARCHAR(255)        NOT NULL,
    PRIMARY KEY (`ownerID`, `roleID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}charCorporationRolesAtOther` (
    `ownerID`  BIGINT(20) UNSIGNED NOT NULL,
    `roleID`   BIGINT(20) UNSIGNED NOT NULL,
    `roleName` VARCHAR(255)        NOT NULL,
    PRIMARY KEY (`ownerID`, `roleID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}charCorporationTitles` (
    `ownerID`   BIGINT(20) UNSIGNED NOT NULL,
    `titleID`   BIGINT(20) UNSIGNED NOT NULL,
    `titleName` VARCHAR(255)        NOT NULL,
    PRIMARY KEY (`ownerID`, `titleID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}charFacWarStats` (
    `ownerID`                BIGINT(20) UNSIGNED NOT NULL,
    `factionID`              BIGINT(20) UNSIGNED NOT NULL,
    `factionName`            VARCHAR(32)         NOT NULL,
    `enlisted`               DATETIME            NOT NULL,
    `currentRank`            BIGINT(20) UNSIGNED NOT NULL,
    `highestRank`            BIGINT(20) UNSIGNED NOT NULL,
    `killsYesterday`         BIGINT(20) UNSIGNED NOT NULL,
    `killsLastWeek`          BIGINT(20) UNSIGNED NOT NULL,
    `killsTotal`             BIGINT(20) UNSIGNED NOT NULL,
    `victoryPointsYesterday` BIGINT(20) UNSIGNED NOT NULL,
    `victoryPointsLastWeek`  BIGINT(20) UNSIGNED NOT NULL,
    `victoryPointsTotal`     BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`ownerID`),
    KEY `charFacWarStats1` (`factionID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}charIndustryJobs` (
    `ownerID`                                      BIGINT(20) UNSIGNED  NOT NULL,
    `activityID`                                   TINYINT(2) UNSIGNED  NOT NULL,
    `assemblyLineID`                               BIGINT(20) UNSIGNED  NOT NULL,
    `beginProductionTime`                          DATETIME             NOT NULL,
    `charMaterialMultiplier`                       DECIMAL(4, 2)        NOT NULL,
    `charTimeMultiplier`                           DECIMAL(4, 2)        NOT NULL,
    `completed`                                    TINYINT(1)           NOT NULL,
    `completedStatus`                              TINYINT(2) UNSIGNED  NOT NULL,
    `completedSuccessfully`                        TINYINT(2) UNSIGNED  NOT NULL,
    `containerID`                                  BIGINT(20) UNSIGNED  NOT NULL,
    `containerLocationID`                          BIGINT(20) UNSIGNED  NOT NULL,
    `containerTypeID`                              BIGINT(20) UNSIGNED  NOT NULL,
    `endProductionTime`                            DATETIME             NOT NULL,
    `installedInSolarSystemID`                     BIGINT(20) UNSIGNED  NOT NULL,
    `installedItemCopy`                            BIGINT(20) UNSIGNED  NOT NULL,
    `installedItemFlag`                            SMALLINT(5) UNSIGNED NOT NULL,
    `installedItemID`                              BIGINT(20) UNSIGNED  NOT NULL,
    `installedItemLicensedProductionRunsRemaining` BIGINT(20)           NOT NULL,
    `installedItemLocationID`                      BIGINT(20) UNSIGNED  NOT NULL,
    `installedItemMaterialLevel`                   BIGINT(20)           NOT NULL,
    `installedItemProductivityLevel`               BIGINT(20)           NOT NULL,
    `installedItemQuantity`                        BIGINT(20) UNSIGNED  NOT NULL,
    `installedItemTypeID`                          BIGINT(20) UNSIGNED  NOT NULL,
    `installerID`                                  BIGINT(20) UNSIGNED  NOT NULL,
    `installTime`                                  DATETIME             NOT NULL,
    `jobID`                                        BIGINT(20) UNSIGNED  NOT NULL,
    `licensedProductionRuns`                       BIGINT(20)           NOT NULL,
    `materialMultiplier`                           DECIMAL(4, 2)        NOT NULL,
    `outputFlag`                                   SMALLINT(5) UNSIGNED NOT NULL,
    `outputLocationID`                             BIGINT(20) UNSIGNED  NOT NULL,
    `outputTypeID`                                 BIGINT(20) UNSIGNED  NOT NULL,
    `pauseProductionTime`                          DATETIME             NOT NULL,
    `runs`                                         BIGINT(20) UNSIGNED  NOT NULL,
    `timeMultiplier`                               DECIMAL(4, 2)        NOT NULL,
    PRIMARY KEY (`ownerID`, `jobID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}charItems` (
    `flag`         SMALLINT(5) UNSIGNED NOT NULL,
    `killID`       BIGINT(20) UNSIGNED  NOT NULL,
    `lft`          BIGINT(20) UNSIGNED  NOT NULL,
    `lvl`          TINYINT(2) UNSIGNED  NOT NULL,
    `rgt`          BIGINT(20) UNSIGNED  NOT NULL,
    `qtyDropped`   BIGINT(20) UNSIGNED  NOT NULL,
    `qtyDestroyed` BIGINT(20) UNSIGNED  NOT NULL,
    `singleton`    SMALLINT(5) UNSIGNED NOT NULL,
    `typeID`       BIGINT(20) UNSIGNED  NOT NULL,
    PRIMARY KEY (`killID`, `lft`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}charKillMails` (
    `killID`        BIGINT(20) UNSIGNED NOT NULL,
    `killTime`      DATETIME            NOT NULL,
    `moonID`        BIGINT(20) UNSIGNED NOT NULL,
    `solarSystemID` BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`killID`, `killTime`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `{table_prefix}charMailBodies` (
    `ownerID`   BIGINT(20) UNSIGNED NOT NULL,
    `body`      TEXT,
    `messageID` BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`ownerID`, `messageID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}charMailingLists` (
    `ownerID`     BIGINT(20) UNSIGNED NOT NULL,
    `displayName` VARCHAR(255)        NOT NULL,
    `listID`      BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`ownerID`, `listID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}charMailMessages` (
    `ownerID`            BIGINT(20) UNSIGNED NOT NULL,
    `messageID`          BIGINT(20) UNSIGNED NOT NULL,
    `senderID`           BIGINT(20) UNSIGNED NOT NULL,
    `sentDate`           DATETIME            NOT NULL,
    `title`              VARCHAR(255) DEFAULT NULL,
    `toCharacterIDs`     TEXT
                         COLLATE utf8_unicode_ci,
    `toCorpOrAllianceID` BIGINT(20) UNSIGNED DEFAULT '0',
    `toListID`           TEXT
                         COLLATE utf8_unicode_ci,
    `senderTypeID`       BIGINT(20) UNSIGNED DEFAULT NULL,
    PRIMARY KEY (`ownerID`, `messageID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}charMarketOrders` (
    `ownerID`      BIGINT(20) UNSIGNED  NOT NULL,
    `accountKey`   SMALLINT(4) UNSIGNED NOT NULL,
    `bid`          TINYINT(1)           NOT NULL,
    `charID`       BIGINT(20) UNSIGNED  NOT NULL,
    `duration`     SMALLINT(3) UNSIGNED NOT NULL,
    `escrow`       DECIMAL(17, 2)       NOT NULL,
    `issued`       DATETIME             NOT NULL,
    `minVolume`    BIGINT(20) UNSIGNED  NOT NULL,
    `orderID`      BIGINT(20) UNSIGNED  NOT NULL,
    `orderState`   TINYINT(2) UNSIGNED  NOT NULL,
    `price`        DECIMAL(17, 2)       NOT NULL,
    `range`        SMALLINT(6)          NOT NULL,
    `stationID`    BIGINT(20) UNSIGNED DEFAULT NULL,
    `typeID`       BIGINT(20) UNSIGNED DEFAULT NULL,
    `volEntered`   BIGINT(20) UNSIGNED  NOT NULL,
    `volRemaining` BIGINT(20) UNSIGNED  NOT NULL,
    PRIMARY KEY (`ownerID`, `orderID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}charNotifications` (
    `ownerID`        BIGINT(20) UNSIGNED  NOT NULL,
    `notificationID` BIGINT(20) UNSIGNED  NOT NULL,
    `read`           TINYINT(1)           NOT NULL,
    `senderID`       BIGINT(20) UNSIGNED  NOT NULL,
    `sentDate`       DATETIME             NOT NULL,
    `typeID`         SMALLINT(5) UNSIGNED NOT NULL,
    PRIMARY KEY (`ownerID`, `notificationID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}charNotificationTexts` (
    `ownerID`        BIGINT(20) UNSIGNED NOT NULL,
    `notificationID` BIGINT(20) UNSIGNED NOT NULL,
    `text`           TEXT,
    PRIMARY KEY (`ownerID`, `notificationID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}charResearch` (
    `ownerID`           BIGINT(20) UNSIGNED NOT NULL,
    `agentID`           BIGINT(20) UNSIGNED NOT NULL,
    `pointsPerDay`      DECIMAL(5, 2)       NOT NULL,
    `skillTypeID`       BIGINT(20) UNSIGNED DEFAULT NULL,
    `remainderPoints`   DOUBLE              NOT NULL,
    `researchStartDate` DATETIME            NOT NULL,
    PRIMARY KEY (`ownerID`, `agentID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}charSkillInTraining` (
    `currentTQTime`         DATETIME DEFAULT NULL,
    `offset`                TINYINT(2)          NOT NULL,
    `ownerID`               BIGINT(20) UNSIGNED NOT NULL,
    `skillInTraining`       TINYINT(1) UNSIGNED NOT NULL,
    `trainingDestinationSP` BIGINT(20) UNSIGNED NOT NULL,
    `trainingEndTime`       DATETIME DEFAULT NULL,
    `trainingStartSP`       BIGINT(20) UNSIGNED NOT NULL,
    `trainingStartTime`     DATETIME DEFAULT NULL,
    `trainingToLevel`       TINYINT(1) UNSIGNED NOT NULL,
    `trainingTypeID`        BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`ownerID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}charSkillQueue` (
    `endSP`         BIGINT(20) UNSIGNED NOT NULL,
    `endTime`       DATETIME            NOT NULL,
    `level`         TINYINT(1) UNSIGNED NOT NULL,
    `ownerID`       BIGINT(20) UNSIGNED NOT NULL,
    `queuePosition` TINYINT(2) UNSIGNED NOT NULL,
    `startSP`       BIGINT(20) UNSIGNED NOT NULL,
    `startTime`     DATETIME            NOT NULL,
    `typeID`        BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`ownerID`, `queuePosition`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}charSkills` (
    `level`       TINYINT(1) UNSIGNED NOT NULL,
    `ownerID`     BIGINT(20) UNSIGNED NOT NULL,
    `skillpoints` BIGINT(20) UNSIGNED NOT NULL,
    `typeID`      BIGINT(20) UNSIGNED NOT NULL,
    `published`   TINYINT(1)          NOT NULL,
    PRIMARY KEY (`ownerID`, `typeID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `{table_prefix}charStandingsFromAgents` (
    `ownerID`  BIGINT(20) UNSIGNED NOT NULL,
    `fromID`   BIGINT(20) UNSIGNED NOT NULL,
    `fromName` VARCHAR(255)        NOT NULL,
    `standing` DECIMAL(5, 2)       NOT NULL,
    PRIMARY KEY (`ownerID`, `fromID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}charStandingsFromFactions` (
    `ownerID`  BIGINT(20) UNSIGNED NOT NULL,
    `fromID`   BIGINT(20) UNSIGNED NOT NULL,
    `fromName` VARCHAR(255)        NOT NULL,
    `standing` DECIMAL(5, 2)       NOT NULL,
    PRIMARY KEY (`ownerID`, `fromID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}charStandingsFromNPCCorporations` (
    `ownerID`  BIGINT(20) UNSIGNED NOT NULL,
    `fromID`   BIGINT(20) UNSIGNED NOT NULL,
    `fromName` VARCHAR(255)        NOT NULL,
    `standing` DECIMAL(5, 2)       NOT NULL,
    PRIMARY KEY (`ownerID`, `fromID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}charVictim` (
    `killID`          BIGINT(20) UNSIGNED NOT NULL,
    `allianceID`      BIGINT(20) UNSIGNED NOT NULL,
    `allianceName`    VARCHAR(255)
        DEFAULT NULL,
    `characterID`     BIGINT(20) UNSIGNED NOT NULL,
    `characterName`   VARCHAR(255)
        DEFAULT NULL,
    `corporationID`   BIGINT(20) UNSIGNED NOT NULL,
    `corporationName` VARCHAR(255)
        DEFAULT NULL,
    `damageTaken`     BIGINT(20) UNSIGNED NOT NULL,
    `factionID`       BIGINT(20) UNSIGNED NOT NULL,
    `factionName`     VARCHAR(255)
        DEFAULT NULL,
    `shipTypeID`      BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`killID`, `characterID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}charWalletJournal` (
    `ownerID`       BIGINT(20) UNSIGNED  NOT NULL,
    `accountKey`    SMALLINT(4) UNSIGNED NOT NULL,
    `amount`        DECIMAL(17, 2)       NOT NULL,
    `argID1`        BIGINT(20) UNSIGNED DEFAULT NULL,
    `argName1`      VARCHAR(255) DEFAULT NULL,
    `balance`       DECIMAL(17, 2)       NOT NULL,
    `date`          DATETIME             NOT NULL,
    `ownerID1`      BIGINT(20) UNSIGNED DEFAULT NULL,
    `ownerID2`      BIGINT(20) UNSIGNED DEFAULT NULL,
    `ownerName1`    VARCHAR(255) DEFAULT NULL,
    `ownerName2`    VARCHAR(255) DEFAULT NULL,
    `reason`        TEXT,
    `refID`         BIGINT(20) UNSIGNED  NOT NULL,
    `refTypeID`     INT(3) UNSIGNED      NOT NULL,
    `taxAmount`     DECIMAL(17, 2)       NOT NULL,
    `taxReceiverID` BIGINT(20) UNSIGNED DEFAULT '0',
    `owner1TypeID`  BIGINT(20) UNSIGNED DEFAULT NULL,
    `owner2TypeID`  BIGINT(20) UNSIGNED DEFAULT NULL,
    PRIMARY KEY (`ownerID`, `refID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}charWalletTransactions` (
    `ownerID`              BIGINT(20) UNSIGNED  NOT NULL,
    `accountKey`           SMALLINT(4) UNSIGNED NOT NULL,
    `clientID`             BIGINT(20) UNSIGNED DEFAULT NULL,
    `clientName`           VARCHAR(255) DEFAULT NULL,
    `clientTypeID`         BIGINT(20) UNSIGNED DEFAULT NULL,
    `journalTransactionID` BIGINT(20) UNSIGNED  NOT NULL,
    `price`                DECIMAL(17, 2)       NOT NULL,
    `quantity`             BIGINT(20) UNSIGNED  NOT NULL,
    `stationID`            BIGINT(20) UNSIGNED DEFAULT NULL,
    `stationName`          VARCHAR(255) DEFAULT NULL,
    `transactionDateTime`  DATETIME             NOT NULL,
    `transactionFor`       VARCHAR(255)         NOT NULL DEFAULT 'corporation',
    `transactionID`        BIGINT(20) UNSIGNED  NOT NULL,
    `transactionType`      VARCHAR(255)         NOT NULL DEFAULT 'sell',
    `typeID`               BIGINT(20) UNSIGNED  NOT NULL,
    `typeName`             VARCHAR(255)         NOT NULL,
    PRIMARY KEY (`ownerID`, `transactionID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}corpAccountBalance` (
    `ownerID`    BIGINT(20) UNSIGNED  NOT NULL,
    `accountID`  BIGINT(20) UNSIGNED  NOT NULL,
    `accountKey` SMALLINT(4) UNSIGNED NOT NULL,
    `balance`    DECIMAL(17, 2)       NOT NULL,
    PRIMARY KEY (`ownerID`, `accountKey`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}corpAllianceContactList` (
    `ownerID`       BIGINT(20) UNSIGNED NOT NULL,
    `contactID`     BIGINT(20) UNSIGNED NOT NULL,
    `contactTypeID` BIGINT(20) UNSIGNED DEFAULT NULL,
    `contactName`   VARCHAR(255)        NOT NULL,
    `standing`      DECIMAL(5, 2)       NOT NULL,
    PRIMARY KEY (`ownerID`, `contactID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}corpAssetList` (
    `ownerID`     BIGINT(20) UNSIGNED  NOT NULL,
    `flag`        SMALLINT(5) UNSIGNED NOT NULL,
    `itemID`      BIGINT(20) UNSIGNED  NOT NULL,
    `lft`         BIGINT(20) UNSIGNED  NOT NULL,
    `locationID`  BIGINT(20) UNSIGNED  NOT NULL,
    `lvl`         TINYINT(2) UNSIGNED  NOT NULL,
    `quantity`    BIGINT(20) UNSIGNED  NOT NULL,
    `rawQuantity` BIGINT(20) DEFAULT NULL,
    `rgt`         BIGINT(20) UNSIGNED  NOT NULL,
    `singleton`   TINYINT(1)           NOT NULL,
    `typeID`      BIGINT(20) UNSIGNED  NOT NULL,
    PRIMARY KEY (`ownerID`, `itemID`),
    KEY `corpAssetList1` (`lft`),
    KEY `corpAssetList2` (`locationID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}corpAttackers` (
    `killID`          BIGINT(20) UNSIGNED NOT NULL,
    `allianceID`      BIGINT(20) UNSIGNED NOT NULL,
    `allianceName`    VARCHAR(255) DEFAULT NULL,
    `characterID`     BIGINT(20) UNSIGNED NOT NULL,
    `characterName`   VARCHAR(255) DEFAULT NULL,
    `corporationID`   BIGINT(20) UNSIGNED NOT NULL,
    `corporationName` VARCHAR(255) DEFAULT NULL,
    `damageDone`      BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    `factionID`       BIGINT(20) UNSIGNED NOT NULL,
    `factionName`     VARCHAR(255)        NOT NULL,
    `finalBlow`       TINYINT(1)          NOT NULL,
    `securityStatus`  DOUBLE              NOT NULL,
    `shipTypeID`      BIGINT(20) UNSIGNED NOT NULL,
    `weaponTypeID`    BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`killID`, `characterID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `{table_prefix}corpCalendarEventAttendees` (
    `ownerID`       BIGINT(20) UNSIGNED NOT NULL,
    `characterID`   BIGINT(20) UNSIGNED NOT NULL,
    `characterName` VARCHAR(255)        NOT NULL,
    `response`      VARCHAR(32)         NOT NULL,
    PRIMARY KEY (`ownerID`, `characterID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}corpCombatSettings` (
    `ownerID`                 BIGINT(20) UNSIGNED    NOT NULL,
    `posID`                   BIGINT(20) UNSIGNED    NOT NULL,
    `onAggressionEnabled`     TINYINT(1)             NOT NULL,
    `onCorporationWarEnabled` TINYINT(1)             NOT NULL,
    `onStandingDropStanding`  DECIMAL(5, 2) UNSIGNED NOT NULL,
    `onStatusDropEnabled`     TINYINT(1)             NOT NULL,
    `onStatusDropStanding`    DECIMAL(5, 2) UNSIGNED NOT NULL,
    `useStandingsFromOwnerID` BIGINT(20) UNSIGNED    NOT NULL,
    PRIMARY KEY (`ownerID`, `posID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}corpContainerLog` (
    `ownerID`          BIGINT(20) UNSIGNED  NOT NULL,
    `action`           VARCHAR(255)         NOT NULL,
    `actorID`          BIGINT(20) UNSIGNED  NOT NULL,
    `actorName`        VARCHAR(255)         NOT NULL,
    `flag`             SMALLINT(5) UNSIGNED NOT NULL,
    `itemID`           BIGINT(20) UNSIGNED  NOT NULL,
    `itemTypeID`       BIGINT(20) UNSIGNED  NOT NULL,
    `locationID`       BIGINT(20) UNSIGNED  NOT NULL,
    `logTime`          DATETIME             NOT NULL,
    `newConfiguration` SMALLINT(4) UNSIGNED NOT NULL,
    `oldConfiguration` SMALLINT(4) UNSIGNED NOT NULL,
    `passwordType`     VARCHAR(255)         NOT NULL,
    `quantity`         BIGINT(20) UNSIGNED  NOT NULL,
    `typeID`           BIGINT(20) UNSIGNED  NOT NULL,
    PRIMARY KEY (`ownerID`, `itemID`, `logTime`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}corpContracts` (
    `ownerID`        BIGINT(20) UNSIGNED  NOT NULL,
    `contractID`     BIGINT(20) UNSIGNED  NOT NULL,
    `issuerID`       BIGINT(20) UNSIGNED  NOT NULL,
    `issuerCorpID`   BIGINT(20) UNSIGNED  NOT NULL,
    `assigneeID`     BIGINT(20) UNSIGNED  NOT NULL,
    `acceptorID`     BIGINT(20) UNSIGNED  NOT NULL,
    `startStationID` BIGINT(20) UNSIGNED  NOT NULL,
    `endStationID`   BIGINT(20) UNSIGNED  NOT NULL,
    `type`           VARCHAR(255)         NOT NULL,
    `status`         VARCHAR(255)         NOT NULL,
    `title`          VARCHAR(255) DEFAULT NULL,
    `forCorp`        TINYINT(1)           NOT NULL,
    `availability`   VARCHAR(255)         NOT NULL,
    `dateIssued`     DATETIME             NOT NULL,
    `dateExpired`    DATETIME             NOT NULL,
    `dateAccepted`   DATETIME DEFAULT NULL,
    `numDays`        SMALLINT(3) UNSIGNED NOT NULL,
    `dateCompleted`  DATETIME DEFAULT NULL,
    `price`          DECIMAL(17, 2)       NOT NULL,
    `reward`         DECIMAL(17, 2)       NOT NULL,
    `collateral`     DECIMAL(17, 2)       NOT NULL,
    `buyout`         DECIMAL(17, 2)       NOT NULL,
    `volume`         BIGINT(20) UNSIGNED  NOT NULL,
    PRIMARY KEY (`ownerID`, `contractID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}corpCorporateContactList` (
    `ownerID`       BIGINT(20) UNSIGNED NOT NULL,
    `contactID`     BIGINT(20) UNSIGNED NOT NULL,
    `contactTypeID` BIGINT(20) UNSIGNED DEFAULT NULL,
    `contactName`   VARCHAR(255)        NOT NULL,
    `standing`      DECIMAL(5, 2)       NOT NULL,
    PRIMARY KEY (`ownerID`, `contactID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}corpCorporationSheet` (
    `allianceID`      BIGINT(20) UNSIGNED    NOT NULL DEFAULT '0',
    `allianceName`    VARCHAR(255) DEFAULT NULL,
    `ceoID`           BIGINT(20) UNSIGNED    NOT NULL,
    `ceoName`         VARCHAR(255)           NOT NULL,
    `corporationID`   BIGINT(20) UNSIGNED    NOT NULL,
    `corporationName` VARCHAR(255)           NOT NULL,
    `description`     TEXT,
    `factionID`       BIGINT(20) UNSIGNED    NOT NULL DEFAULT '0',
    `memberCount`     SMALLINT(5) UNSIGNED   NOT NULL,
    `memberLimit`     SMALLINT(5)            NOT NULL DEFAULT '0',
    `shares`          BIGINT(20) UNSIGNED    NOT NULL,
    `stationID`       BIGINT(20) UNSIGNED    NOT NULL,
    `stationName`     VARCHAR(255)           NOT NULL,
    `taxRate`         DECIMAL(5, 2) UNSIGNED NOT NULL,
    `ticker`          VARCHAR(255)           NOT NULL,
    `url`             VARCHAR(255)
        DEFAULT NULL,
    PRIMARY KEY (`corporationID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}corpDivisions` (
    `ownerID`     BIGINT(20) UNSIGNED  NOT NULL,
    `accountKey`  SMALLINT(4) UNSIGNED NOT NULL,
    `description` VARCHAR(255)         NOT NULL,
    PRIMARY KEY (`ownerID`, `accountKey`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}corpFacWarStats` (
    `ownerID`                BIGINT(20) UNSIGNED NOT NULL,
    `factionID`              BIGINT(20) UNSIGNED NOT NULL,
    `factionName`            VARCHAR(32)         NOT NULL,
    `enlisted`               DATETIME            NOT NULL,
    `currentRank`            BIGINT(20) UNSIGNED NOT NULL,
    `highestRank`            BIGINT(20) UNSIGNED NOT NULL,
    `killsYesterday`         BIGINT(20) UNSIGNED NOT NULL,
    `killsLastWeek`          BIGINT(20) UNSIGNED NOT NULL,
    `killsTotal`             BIGINT(20) UNSIGNED NOT NULL,
    `victoryPointsYesterday` BIGINT(20) UNSIGNED NOT NULL,
    `victoryPointsLastWeek`  BIGINT(20) UNSIGNED NOT NULL,
    `victoryPointsTotal`     BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`ownerID`),
    KEY `corpFacWarStats1` (`factionID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}corpFuel` (
    `ownerID`  BIGINT(20) UNSIGNED NOT NULL,
    `posID`    BIGINT(20) UNSIGNED NOT NULL,
    `typeID`   BIGINT(20) UNSIGNED NOT NULL,
    `quantity` BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`ownerID`, `posID`, `typeID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}corpGeneralSettings` (
    `ownerID`                 BIGINT(20) UNSIGNED  NOT NULL,
    `posID`                   BIGINT(20) UNSIGNED  NOT NULL,
    `allowAllianceMembers`    TINYINT(1)           NOT NULL,
    `allowCorporationMembers` TINYINT(1)           NOT NULL,
    `deployFlags`             SMALLINT(5) UNSIGNED NOT NULL,
    `usageFlags`              SMALLINT(5) UNSIGNED NOT NULL,
    PRIMARY KEY (`ownerID`, `posID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `{table_prefix}corpIndustryJobs` (
    `ownerID`                                      BIGINT(20) UNSIGNED  NOT NULL,
    `activityID`                                   TINYINT(2) UNSIGNED  NOT NULL,
    `assemblyLineID`                               BIGINT(20) UNSIGNED  NOT NULL,
    `beginProductionTime`                          DATETIME             NOT NULL,
    `charMaterialMultiplier`                       DECIMAL(4, 2)        NOT NULL,
    `charTimeMultiplier`                           DECIMAL(4, 2)        NOT NULL,
    `completed`                                    TINYINT(1)           NOT NULL,
    `completedStatus`                              TINYINT(2) UNSIGNED  NOT NULL,
    `completedSuccessfully`                        TINYINT(2) UNSIGNED  NOT NULL,
    `containerID`                                  BIGINT(20) UNSIGNED  NOT NULL,
    `containerLocationID`                          BIGINT(20) UNSIGNED  NOT NULL,
    `containerTypeID`                              BIGINT(20) UNSIGNED  NOT NULL,
    `endProductionTime`                            DATETIME             NOT NULL,
    `installedInSolarSystemID`                     BIGINT(20) UNSIGNED  NOT NULL,
    `installedItemCopy`                            BIGINT(20) UNSIGNED  NOT NULL,
    `installedItemFlag`                            SMALLINT(5) UNSIGNED NOT NULL,
    `installedItemID`                              BIGINT(20) UNSIGNED  NOT NULL,
    `installedItemLicensedProductionRunsRemaining` BIGINT(20)           NOT NULL,
    `installedItemLocationID`                      BIGINT(20) UNSIGNED  NOT NULL,
    `installedItemMaterialLevel`                   BIGINT(20)           NOT NULL,
    `installedItemProductivityLevel`               BIGINT(20)           NOT NULL,
    `installedItemQuantity`                        BIGINT(20) UNSIGNED  NOT NULL,
    `installedItemTypeID`                          BIGINT(20) UNSIGNED  NOT NULL,
    `installerID`                                  BIGINT(20) UNSIGNED  NOT NULL,
    `installTime`                                  DATETIME             NOT NULL,
    `jobID`                                        BIGINT(20) UNSIGNED  NOT NULL,
    `licensedProductionRuns`                       BIGINT(20)           NOT NULL,
    `materialMultiplier`                           DECIMAL(4, 2)        NOT NULL,
    `outputFlag`                                   SMALLINT(5) UNSIGNED NOT NULL,
    `outputLocationID`                             BIGINT(20) UNSIGNED  NOT NULL,
    `outputTypeID`                                 BIGINT(20) UNSIGNED  NOT NULL,
    `pauseProductionTime`                          DATETIME             NOT NULL,
    `runs`                                         BIGINT(20) UNSIGNED  NOT NULL,
    `timeMultiplier`                               DECIMAL(4, 2)        NOT NULL,
    PRIMARY KEY (`ownerID`, `jobID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}corpItems` (
    `flag`         SMALLINT(5) UNSIGNED NOT NULL,
    `killID`       BIGINT(20) UNSIGNED  NOT NULL,
    `lft`          BIGINT(20) UNSIGNED  NOT NULL,
    `lvl`          TINYINT(2) UNSIGNED  NOT NULL,
    `rgt`          BIGINT(20) UNSIGNED  NOT NULL,
    `qtyDropped`   BIGINT(20) UNSIGNED  NOT NULL,
    `qtyDestroyed` BIGINT(20) UNSIGNED  NOT NULL,
    `singleton`    SMALLINT(5) UNSIGNED NOT NULL,
    `typeID`       BIGINT(20) UNSIGNED  NOT NULL,
    PRIMARY KEY (`killID`, `lft`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}corpKillMails` (
    `killID`        BIGINT(20) UNSIGNED NOT NULL,
    `killTime`      DATETIME            NOT NULL,
    `moonID`        BIGINT(20) UNSIGNED NOT NULL,
    `solarSystemID` BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`killID`, `killTime`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}corpLogo` (
    `ownerID`   BIGINT(20) UNSIGNED  NOT NULL,
    `color1`    SMALLINT(5) UNSIGNED NOT NULL,
    `color2`    SMALLINT(5) UNSIGNED NOT NULL,
    `color3`    SMALLINT(5) UNSIGNED NOT NULL,
    `graphicID` BIGINT(20) UNSIGNED  NOT NULL,
    `shape1`    SMALLINT(5) UNSIGNED NOT NULL,
    `shape2`    SMALLINT(5) UNSIGNED NOT NULL,
    `shape3`    SMALLINT(5) UNSIGNED NOT NULL,
    PRIMARY KEY (`ownerID`, `graphicID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}corpMarketOrders` (
    `ownerID`      BIGINT(20) UNSIGNED  NOT NULL,
    `accountKey`   SMALLINT(4) UNSIGNED NOT NULL,
    `bid`          TINYINT(1)           NOT NULL,
    `charID`       BIGINT(20) UNSIGNED  NOT NULL,
    `duration`     SMALLINT(3) UNSIGNED NOT NULL,
    `escrow`       DECIMAL(17, 2)       NOT NULL,
    `issued`       DATETIME             NOT NULL,
    `minVolume`    BIGINT(20) UNSIGNED  NOT NULL,
    `orderID`      BIGINT(20) UNSIGNED  NOT NULL,
    `orderState`   TINYINT(2) UNSIGNED  NOT NULL,
    `price`        DECIMAL(17, 2)       NOT NULL,
    `range`        SMALLINT(6)          NOT NULL,
    `stationID`    BIGINT(20) UNSIGNED DEFAULT NULL,
    `typeID`       BIGINT(20) UNSIGNED DEFAULT NULL,
    `volEntered`   BIGINT(20) UNSIGNED  NOT NULL,
    `volRemaining` BIGINT(20) UNSIGNED  NOT NULL,
    PRIMARY KEY (`ownerID`, `orderID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}corpMedals` (
    `ownerID`     BIGINT(20) UNSIGNED NOT NULL,
    `created`     DATETIME            NOT NULL,
    `creatorID`   BIGINT(20) UNSIGNED NOT NULL,
    `description` TEXT,
    `medalID`     BIGINT(20) UNSIGNED NOT NULL,
    `title`       VARCHAR(255)        NOT NULL,
    PRIMARY KEY (`ownerID`, `medalID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}corpMemberMedals` (
    `ownerID`     BIGINT(20) UNSIGNED NOT NULL,
    `medalID`     BIGINT(20) UNSIGNED NOT NULL,
    `characterID` BIGINT(20) UNSIGNED NOT NULL,
    `issued`      DATETIME            NOT NULL,
    `issuerID`    BIGINT(20) UNSIGNED NOT NULL,
    `reason`      TEXT,
    `status`      VARCHAR(32)         NOT NULL,
    PRIMARY KEY (`ownerID`, `medalID`, `characterID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}corpMemberTracking` (
    `base`           VARCHAR(255) DEFAULT NULL,
    `baseID`         BIGINT(20) UNSIGNED DEFAULT NULL,
    `characterID`    BIGINT(20) UNSIGNED NOT NULL,
    `grantableRoles` VARCHAR(64) DEFAULT NULL,
    `location`       VARCHAR(255) DEFAULT NULL,
    `locationID`     BIGINT(20) UNSIGNED DEFAULT NULL,
    `logoffDateTime` DATETIME DEFAULT NULL,
    `logonDateTime`  DATETIME DEFAULT NULL,
    `name`           VARCHAR(255)        NOT NULL,
    `ownerID`        BIGINT(20) UNSIGNED NOT NULL,
    `roles`          VARCHAR(64) DEFAULT NULL,
    `shipType`       VARCHAR(255) DEFAULT NULL,
    `shipTypeID`     BIGINT(20) DEFAULT NULL,
    `startDateTime`  DATETIME            NOT NULL,
    `title`          TEXT,
    PRIMARY KEY (`characterID`),
    KEY `corpMemberTrackingindex1` (`ownerID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}corpOutpostList` (
    `ownerID`                  BIGINT(20) UNSIGNED NOT NULL,
    `dockingCostPerShipVolume` DECIMAL(17, 2)      NOT NULL,
    `officeRentalCost`         DECIMAL(17, 2)      NOT NULL,
    `reprocessingEfficiency`   DECIMAL(5, 4)       NOT NULL,
    `reprocessingStationTake`  DECIMAL(5, 4)       NOT NULL,
    `solarSystemID`            BIGINT(20) UNSIGNED NOT NULL,
    `standingOwnerID`          BIGINT(20) UNSIGNED NOT NULL,
    `stationID`                BIGINT(20) UNSIGNED NOT NULL,
    `stationName`              VARCHAR(255)        NOT NULL,
    `stationTypeID`            BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`ownerID`, `stationID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}corpOutpostServiceDetail` (
    `ownerID`                 BIGINT(20) UNSIGNED    NOT NULL,
    `stationID`               BIGINT(20) UNSIGNED    NOT NULL,
    `discountPerGoodStanding` DECIMAL(5, 2)          NOT NULL,
    `minStanding`             DECIMAL(5, 2) UNSIGNED NOT NULL,
    `serviceName`             VARCHAR(255)           NOT NULL,
    `surchargePerBadStanding` DECIMAL(5, 2)          NOT NULL,
    PRIMARY KEY (`ownerID`, `stationID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `{table_prefix}corpStandingsFromAgents` (
    `ownerID`  BIGINT(20) UNSIGNED NOT NULL,
    `fromID`   BIGINT(20) UNSIGNED NOT NULL,
    `fromName` VARCHAR(255)        NOT NULL,
    `standing` DECIMAL(5, 2)       NOT NULL,
    PRIMARY KEY (`ownerID`, `fromID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}corpStandingsFromFactions` (
    `ownerID`  BIGINT(20) UNSIGNED NOT NULL,
    `fromID`   BIGINT(20) UNSIGNED NOT NULL,
    `fromName` VARCHAR(255)        NOT NULL,
    `standing` DECIMAL(5, 2)       NOT NULL,
    PRIMARY KEY (`ownerID`, `fromID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}corpStandingsFromNPCCorporations` (
    `ownerID`  BIGINT(20) UNSIGNED NOT NULL,
    `fromID`   BIGINT(20) UNSIGNED NOT NULL,
    `fromName` VARCHAR(255)        NOT NULL,
    `standing` DECIMAL(5, 2)       NOT NULL,
    PRIMARY KEY (`ownerID`, `fromID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}corpStarbaseDetail` (
    `ownerID`         BIGINT(20) UNSIGNED NOT NULL,
    `posID`           BIGINT(20) UNSIGNED NOT NULL,
    `onlineTimestamp` DATETIME            NOT NULL,
    `state`           TINYINT(2) UNSIGNED NOT NULL,
    `stateTimestamp`  DATETIME            NOT NULL,
    PRIMARY KEY (`ownerID`, `posID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}corpStarbaseList` (
    `ownerID`         BIGINT(20) UNSIGNED NOT NULL,
    `itemID`          BIGINT(20) UNSIGNED NOT NULL,
    `locationID`      BIGINT(20) UNSIGNED NOT NULL,
    `moonID`          BIGINT(20) UNSIGNED NOT NULL,
    `onlineTimestamp` DATETIME            NOT NULL,
    `standingOwnerID` BIGINT(20) UNSIGNED NOT NULL,
    `state`           TINYINT(2) UNSIGNED NOT NULL,
    `stateTimestamp`  DATETIME            NOT NULL,
    `typeID`          BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`ownerID`, `itemID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}corpVictim` (
    `killID`          BIGINT(20) UNSIGNED NOT NULL,
    `allianceID`      BIGINT(20) UNSIGNED NOT NULL,
    `allianceName`    VARCHAR(255) DEFAULT NULL,
    `characterID`     BIGINT(20) UNSIGNED NOT NULL,
    `characterName`   VARCHAR(255) DEFAULT NULL,
    `corporationID`   BIGINT(20) UNSIGNED NOT NULL,
    `corporationName` VARCHAR(255) DEFAULT NULL,
    `damageTaken`     BIGINT(20) UNSIGNED NOT NULL,
    `factionID`       BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    `factionName`     VARCHAR(255)        NOT NULL,
    `shipTypeID`      BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`killID`, `characterID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}corpWalletDivisions` (
    `ownerID`     BIGINT(20) UNSIGNED  NOT NULL,
    `accountKey`  SMALLINT(4) UNSIGNED NOT NULL,
    `description` VARCHAR(255)         NOT NULL,
    PRIMARY KEY (`ownerID`, `accountKey`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}corpWalletJournal` (
    `ownerID`      BIGINT(20) UNSIGNED  NOT NULL,
    `accountKey`   SMALLINT(4) UNSIGNED NOT NULL,
    `amount`       DECIMAL(17, 2)       NOT NULL,
    `argID1`       BIGINT(20) UNSIGNED DEFAULT NULL,
    `argName1`     VARCHAR(255) DEFAULT NULL,
    `balance`      DECIMAL(17, 2)       NOT NULL,
    `date`         DATETIME             NOT NULL,
    `ownerID1`     BIGINT(20) UNSIGNED DEFAULT NULL,
    `ownerID2`     BIGINT(20) UNSIGNED DEFAULT NULL,
    `ownerName1`   VARCHAR(255) DEFAULT NULL,
    `ownerName2`   VARCHAR(255) DEFAULT NULL,
    `reason`       TEXT,
    `refID`        BIGINT(20) UNSIGNED  NOT NULL,
    `refTypeID`    SMALLINT(5) UNSIGNED NOT NULL,
    `owner1TypeID` BIGINT(20) UNSIGNED DEFAULT NULL,
    `owner2TypeID` BIGINT(20) UNSIGNED DEFAULT NULL,
    PRIMARY KEY (`ownerID`, `accountKey`, `refID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}corpWalletTransactions` (
    `ownerID`              BIGINT(20) UNSIGNED  NOT NULL,
    `accountKey`           SMALLINT(4) UNSIGNED NOT NULL,
    `characterID`          BIGINT(20) UNSIGNED DEFAULT NULL,
    `characterName`        VARCHAR(255) DEFAULT NULL,
    `clientID`             BIGINT(20) UNSIGNED DEFAULT NULL,
    `clientName`           VARCHAR(255) DEFAULT NULL,
    `clientTypeID`         BIGINT(20) UNSIGNED DEFAULT NULL,
    `journalTransactionID` BIGINT(20) UNSIGNED  NOT NULL,
    `price`                DECIMAL(17, 2)       NOT NULL,
    `quantity`             BIGINT(20) UNSIGNED  NOT NULL,
    `stationID`            BIGINT(20) UNSIGNED DEFAULT NULL,
    `stationName`          VARCHAR(255) DEFAULT NULL,
    `transactionDateTime`  DATETIME             NOT NULL,
    `transactionFor`       VARCHAR(255)         NOT NULL DEFAULT 'corporation',
    `transactionID`        BIGINT(20) UNSIGNED  NOT NULL,
    `transactionType`      VARCHAR(255)         NOT NULL DEFAULT 'sell',
    `typeID`               BIGINT(20) UNSIGNED  NOT NULL,
    `typeName`             VARCHAR(255)         NOT NULL,
    PRIMARY KEY (`ownerID`, `accountKey`, `transactionID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}eveAllianceList` (
    `allianceID`     BIGINT(20) UNSIGNED NOT NULL,
    `executorCorpID` BIGINT(20) UNSIGNED DEFAULT NULL,
    `memberCount`    BIGINT(20) UNSIGNED DEFAULT NULL,
    `name`           VARCHAR(255) DEFAULT NULL,
    `shortName`      VARCHAR(255) DEFAULT NULL,
    `startDate`      DATETIME DEFAULT NULL,
    PRIMARY KEY (`allianceID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `{table_prefix}eveCharactersKillsLastWeek` (
    `characterID`   BIGINT(20) UNSIGNED NOT NULL,
    `characterName` VARCHAR(32) DEFAULT NULL,
    `kills`         BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`characterID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}eveCharactersKillsTotal` (
    `characterID`   BIGINT(20) UNSIGNED NOT NULL,
    `characterName` VARCHAR(32) DEFAULT NULL,
    `kills`         BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`characterID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}eveCharactersKillsYesterday` (
    `characterID`   BIGINT(20) UNSIGNED NOT NULL,
    `characterName` VARCHAR(32) DEFAULT NULL,
    `kills`         BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`characterID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}eveCharactersVictoryPointsLastWeek` (
    `characterID`   BIGINT(20) UNSIGNED NOT NULL,
    `characterName` VARCHAR(32) DEFAULT NULL,
    `victoryPoints` BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`characterID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}eveCharactersVictoryPointsTotal` (
    `characterID`   BIGINT(20) UNSIGNED NOT NULL,
    `characterName` VARCHAR(32) DEFAULT NULL,
    `victoryPoints` BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`characterID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}eveCharactersVictoryPointsYesterday` (
    `characterID`   BIGINT(20) UNSIGNED NOT NULL,
    `characterName` VARCHAR(32) DEFAULT NULL,
    `victoryPoints` BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`characterID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}eveConquerableStationList` (
    `corporationID`   BIGINT(20) UNSIGNED DEFAULT NULL,
    `corporationName` VARCHAR(255) DEFAULT NULL,
    `solarSystemID`   BIGINT(20) UNSIGNED DEFAULT NULL,
    `stationID`       BIGINT(20) UNSIGNED NOT NULL,
    `stationName`     VARCHAR(255) DEFAULT NULL,
    `stationTypeID`   BIGINT(20) UNSIGNED DEFAULT NULL,
    PRIMARY KEY (`stationID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}eveCorporationsKillsLastWeek` (
    `corporationID`   BIGINT(20) UNSIGNED NOT NULL,
    `corporationName` VARCHAR(255) DEFAULT NULL,
    `kills`           BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`corporationID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}eveCorporationsKillsTotal` (
    `corporationID`   BIGINT(20) UNSIGNED NOT NULL,
    `corporationName` VARCHAR(255) DEFAULT NULL,
    `kills`           BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`corporationID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}eveCorporationsKillsYesterday` (
    `corporationID`   BIGINT(20) UNSIGNED NOT NULL,
    `corporationName` VARCHAR(255) DEFAULT NULL,
    `kills`           BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`corporationID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `{table_prefix}eveCorporationsVictoryPointsLastWeek` (
    `corporationID`   BIGINT(20) UNSIGNED NOT NULL,
    `corporationName` VARCHAR(255) DEFAULT NULL,
    `victoryPoints`   BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`corporationID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}eveCorporationsVictoryPointsTotal` (
    `corporationID`   BIGINT(20) UNSIGNED NOT NULL,
    `corporationName` VARCHAR(255) DEFAULT NULL,
    `victoryPoints`   BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`corporationID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}eveCorporationsVictoryPointsYesterday` (
    `corporationID`   BIGINT(20) UNSIGNED NOT NULL,
    `corporationName` VARCHAR(255) DEFAULT NULL,
    `victoryPoints`   BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`corporationID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}eveErrorList` (
    `errorCode` SMALLINT(3) UNSIGNED NOT NULL,
    `errorText` TEXT,
    PRIMARY KEY (`errorCode`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}eveFactions` (
    `factionID`              BIGINT(20) UNSIGNED NOT NULL,
    `factionName`            VARCHAR(32) DEFAULT NULL,
    `killsYesterday`         BIGINT(20) UNSIGNED NOT NULL,
    `killsLastWeek`          BIGINT(20) UNSIGNED NOT NULL,
    `killsTotal`             BIGINT(20) UNSIGNED NOT NULL,
    `pilots`                 BIGINT(20) UNSIGNED NOT NULL,
    `systemsControlled`      BIGINT(20) UNSIGNED NOT NULL,
    `victoryPointsYesterday` BIGINT(20) UNSIGNED NOT NULL,
    `victoryPointsLastWeek`  BIGINT(20) UNSIGNED NOT NULL,
    `victoryPointsTotal`     BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`factionID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}eveFactionsKillsLastWeek` (
    `factionID`   BIGINT(20) UNSIGNED NOT NULL,
    `factionName` VARCHAR(32) DEFAULT NULL,
    `kills`       BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`factionID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}eveFactionsKillsTotal` (
    `factionID`   BIGINT(20) UNSIGNED NOT NULL,
    `factionName` VARCHAR(32) DEFAULT NULL,
    `kills`       BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`factionID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}eveFactionsKillsYesterday` (
    `factionID`   BIGINT(20) UNSIGNED NOT NULL,
    `factionName` VARCHAR(32) DEFAULT NULL,
    `kills`       BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`factionID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}eveFactionsVictoryPointsLastWeek` (
    `factionID`     BIGINT(20) UNSIGNED NOT NULL,
    `factionName`   VARCHAR(32) DEFAULT NULL,
    `victoryPoints` BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`factionID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}eveFactionsVictoryPointsTotal` (
    `factionID`     BIGINT(20) UNSIGNED NOT NULL,
    `factionName`   VARCHAR(32) DEFAULT NULL,
    `victoryPoints` BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`factionID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `{table_prefix}eveFactionsVictoryPointsYesterday` (
    `factionID`     BIGINT(20) UNSIGNED NOT NULL,
    `factionName`   VARCHAR(32) DEFAULT NULL,
    `victoryPoints` BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`factionID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}eveFactionWars` (
    `factionID`   BIGINT(20) UNSIGNED NOT NULL,
    `factionName` VARCHAR(32) DEFAULT NULL,
    `againstID`   BIGINT(20) UNSIGNED NOT NULL,
    `againstName` VARCHAR(32)
        DEFAULT NULL
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}eveFacWarStats` (
    `killsYesterday`         BIGINT(20) UNSIGNED NOT NULL,
    `killsLastWeek`          BIGINT(20) UNSIGNED NOT NULL,
    `killsTotal`             BIGINT(20) UNSIGNED NOT NULL,
    `victoryPointsYesterday` BIGINT(20) UNSIGNED NOT NULL,
    `victoryPointsLastWeek`  BIGINT(20) UNSIGNED NOT NULL,
    `victoryPointsTotal`     BIGINT(20) UNSIGNED NOT NULL
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}eveMemberCorporations` (
    `allianceID`    BIGINT(20) UNSIGNED NOT NULL,
    `corporationID` BIGINT(20) UNSIGNED NOT NULL,
    `startDate`     DATETIME DEFAULT NULL,
    PRIMARY KEY (`corporationID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}eveRefTypes` (
    `refTypeID`   SMALLINT(5) UNSIGNED NOT NULL,
    `refTypeName` VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (`refTypeID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}mapFacWarSystems` (
    `contested`            TINYINT(1)          NOT NULL,
    `occupyingFactionID`   BIGINT(20) UNSIGNED DEFAULT NULL,
    `occupyingFactionName` VARCHAR(255) DEFAULT NULL,
    `owningFactionID`      BIGINT(20) UNSIGNED DEFAULT NULL,
    `owningFactionName`    VARCHAR(255) DEFAULT NULL,
    `solarSystemID`        BIGINT(20) UNSIGNED NOT NULL,
    `solarSystemName`      VARCHAR(255)        NOT NULL,
    PRIMARY KEY (`solarSystemID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}mapJumps` (
    `shipJumps`     BIGINT(20) UNSIGNED NOT NULL,
    `solarSystemID` BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`solarSystemID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}mapKills` (
    `factionKills`  BIGINT(20) UNSIGNED NOT NULL,
    `podKills`      BIGINT(20) UNSIGNED NOT NULL,
    `shipKills`     BIGINT(20) UNSIGNED NOT NULL,
    `solarSystemID` BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`solarSystemID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}mapSovereignty` (
    `allianceID`      BIGINT(20) UNSIGNED NOT NULL,
    `corporationID`   BIGINT(20) UNSIGNED NOT NULL,
    `factionID`       BIGINT(20) UNSIGNED NOT NULL,
    `solarSystemID`   BIGINT(20) UNSIGNED NOT NULL,
    `solarSystemName` VARCHAR(255)        NOT NULL,
    PRIMARY KEY (`solarSystemID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}serverServerStatus` (
    `onlinePlayers` BIGINT(20) UNSIGNED NOT NULL,
    `serverName`    VARCHAR(32)         NOT NULL,
    `serverOpen`    VARCHAR(32)         NOT NULL,
    PRIMARY KEY (`serverName`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `{table_prefix}utilAccessMask` (
    `section`     VARCHAR(8)          NOT NULL,
    `api`         VARCHAR(32)         NOT NULL,
    `description` TEXT,
    `mask`        BIGINT(20) UNSIGNED NOT NULL,
    `status`      TINYINT(3) UNSIGNED NOT NULL,
    PRIMARY KEY (`section`, `api`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =ascii;
TRUNCATE TABLE `{table_prefix}utilAccessMask`;
INSERT INTO `{table_prefix}utilAccessMask` (`section`, `api`, `description`, `mask`, `status`)
VALUES
    ('account', 'AccountStatus', 'EVE player account status.', 33554432, 16),
('account', 'APIKeyInfo', 'Used to get information about a keyID', 1, 16),
('char', 'AccountBalance', 'Current balance of characters wallet.', 1, 16),
('char', 'AssetList', 'Entire asset list of character.', 2, 16),
('char', 'CalendarEventAttendees', 'Event attendee responses. Requires UpcomingCalendarEvents to function.', 4, 2),
('char', 'CharacterSheet', 'Character Sheet information. Contains basic "Show Info" information along with clones, account balance, implants, attributes, skills, certificates and corporation roles.', 8, 16),
('char', 'ContactList', 'List of character contacts and relationship levels.', 16, 16),
('char', 'ContactNotifications', 'Most recent contact notifications for the character.', 32, 16),
('char', 'Contracts', 'List of all Contracts the character is involved in.', 67108864, 16),
('char', 'FacWarStats', 'Characters Factional Warfare Statistics.', 64, 8),
('char', 'IndustryJobs', 'Character jobs, completed and active.', 128, 16),
('char', 'KillMails', 'Character''s killmails.', 256, 16),
('char', 'Locations', 'Allows the fetching of coordinate and name data for items owned by the character.', 134217728, 1),
('char', 'MailBodies', 'EVE Mail bodies. Requires MailMessages as well to function.', 512, 16),
('char', 'MailingLists', 'List of all Mailing Lists the character subscribes to.', 1024, 16),
('char', 'MailMessages', 'List of all messages in the characters EVE Mail Inbox.', 2048, 16),
('char', 'MarketOrders', 'List of all Market Orders the character has made.', 4096, 16),
('char', 'Medals', 'Medals awarded to the character.', 8192, 2),
('char', 'Notifications', 'List of recent notifications sent to the character.', 16384, 16),
('char', 'NotificationTexts', 'Actual body of notifications sent to the character. Requires Notification access to function.', 32768, 16),
('char', 'Research', 'List of all Research agents working for the character and the progress of the research.', 65536, 16),
('char', 'SkillInTraining', 'Skill currently in training on the character. Subset of entire Skill Queue.', 131072, 16),
('char', 'SkillQueue', 'Entire skill queue of character.', 262144, 16),
('char', 'Standings', 'NPC Standings towards the character.', 524288, 16),
('char', 'UpcomingCalendarEvents', 'Upcoming events on characters calendar.', 1048576, 2),
('char', 'WalletJournal', 'Wallet journal of character.', 2097152, 16),
('char', 'WalletTransactions', 'Market transaction journal of character.', 4194304, 16),
('corp', 'AccountBalance', 'Current balance of all corporation accounts.', 1, 16),
('corp', 'AssetList', 'List of all corporation assets.', 2, 16),
('corp', 'ContactList', 'Corporate contact list and relationships.', 16, 16),
('corp', 'ContainerLog', 'Corporate secure container access log.', 32, 16),
('corp', 'Contracts', 'List of recent Contracts the corporation is involved in.', 8388608, 16),
('corp', 'CorporationSheet', 'Exposes basic "Show Info" information as well as Member Limit and basic division and wallet info.', 8, 16),
('corp', 'FacWarStats', 'Corporations Factional Warfare Statistics.', 64, 8),
('corp', 'IndustryJobs', 'Corporation jobs, completed and active.', 128, 16),
('corp', 'KillMails', 'Corporation killmails.', 256, 16),
('corp', 'Locations', 'Allows the fetching of coordinate and name data for items owned by the corporation.', 16777216, 1),
('corp', 'MarketOrders', 'List of all corporate market orders.', 4096, 16),
('corp', 'Medals', 'List of all medals created by the corporation.', 8192, 16),
('corp', 'MemberMedals', 'List of medals awarded to corporation members.', 4, 16),
('corp', 'MemberSecurity', 'Member roles and titles.', 512, 2),
('corp', 'MemberSecurityLog', 'Member role and title change log.', 1024, 2),
('corp', 'MemberTracking', 'Extensive Member information. Time of last logoff, last known location and ship.', 33554432, 16),
('corp', 'MemberTrackingLimited', 'Limited Member information.', 2048, 16),
('corp', 'OutpostList', 'List of all outposts controlled by the corporation.', 16384, 16),
('corp', 'OutpostServiceDetail', 'List of all service settings of corporate outposts.', 32768, 16),
('corp', 'Shareholders', 'Shareholders of the corporation.', 65536, 2),
('corp', 'Standings', 'NPC Standings towards corporation.', 262144, 16),
('corp', 'StarbaseDetail', 'List of all settings of corporate starbases.', 131072, 16),
('corp', 'StarbaseList', 'List of all corporate starbases.', 524288, 16),
('corp', 'Titles', 'Titles of corporation and the roles they grant.', 4194304, 2),
('corp', 'WalletJournal', 'Wallet journal for all corporate accounts.', 1048576, 16),
('corp', 'WalletTransactions', 'Market transactions of all corporate accounts.', 2097152, 16),
('eve', 'AllianceList', 'Returns a list of alliances in eve.', 1, 16),
('eve', 'CertificateTree', 'Returns a list of certificates in eve.', 2, 1),
('eve', 'CharacterID', 'Returns the ownerID for a given character, faction, alliance or corporation name, or the typeID for other objects such as stations, solar systems, planets, etc.', 4, 1),
('eve', 'CharacterInfo', 'Character information, exposes skill points and current ship information on top of "Show Info" information.', 0, 1),
('eve', 'CharacterInfoPrivate', 'Sensitive Character Information, exposes account balance and last known location on top of the other Character Information call.', 16777216, 1),
('eve', 'CharacterInfoPublic', 'Character information, exposes skill points and current ship information on top of "Show Info" information.', 8388608, 1),
('eve', 'CharacterName', 'Returns the name associated with an ownerID or a typeID.', 8, 1),
('eve', 'ConquerableStationList', 'Conquerable Station List including Outpost.', 16, 16),
('eve', 'ErrorList', 'Returns a list of error codes that can be returned by the EVE API servers.', 32, 16),
('eve', 'FacWarStats', 'Returns global stats on the factions in factional warfare including the number of pilots in each faction, the number of systems they control, and how many kills and victory points each and all factions obtained yesterday, in the last week, and total.', 64, 16),
('eve', 'FacWarTopStats', 'Returns Factional Warfare Top 100 Stats.', 128, 16),
('eve', 'RefTypes', 'Returns a list of transaction types used in the Journal Entries.', 256, 16),
('eve', 'SkillTree', 'XML of currently in-game skills (including unpublished skills).', 512, 1),
('map', 'FacWarSystems', 'Returns a list of contestable solarsystems  and the NPC faction currently occupying them. It should be noted that this file only returns a non-zero ID if the occupying faction is not the sovereign faction.', 1, 16),
('map', 'Jumps', 'Returns a list of systems where any jumps have happened.', 2, 16),
('map', 'Kills', 'Returns the number of kills in solarsystems within the last hour. Only solar system where kills have been made are listed, so assume zero in case the system is not listed.', 4, 16),
('map', 'Sovereignty', 'Returns a list of solarsystems and what faction or alliance controls them. ', 8, 16),
('map', 'SovereigntyStatus', 'Returns a list of all sovereignty structures in EVE. This API has been disabled and is not expected to return but was included for completeness.', 16, 1),
    ('server', 'ServerStatus', 'Returns current Eve server status and number of players online.', 1, 16);
CREATE TABLE IF NOT EXISTS `{table_prefix}utilCachedInterval` (
    `section`  VARCHAR(8)       NOT NULL,
    `api`      VARCHAR(32)      NOT NULL,
    `interval` INT(10) UNSIGNED NOT NULL,
    PRIMARY KEY (`section`, `api`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =ascii;
TRUNCATE TABLE `{table_prefix}utilCachedInterval`;
INSERT INTO `{table_prefix}utilCachedInterval` (`section`, `api`, `interval`)
VALUES
    ('account', 'AccountStatus', 3600),
('account', 'APIKeyInfo', 300),
('char', 'AccountBalance', 900),
('char', 'AssetList', 21600),
('char', 'CalendarEventAttendees', 3600),
('char', 'CharacterSheet', 3600),
('char', 'ContactList', 900),
('char', 'ContactNotifications', 21600),
('char', 'Contracts', 900),
('char', 'FacWarStats', 3600),
('char', 'IndustryJobs', 900),
('char', 'KillMails', 1800),
('char', 'Locations', 3600),
('char', 'MailBodies', 1800),
('char', 'MailingLists', 21600),
('char', 'MailMessages', 1800),
('char', 'MarketOrders', 3600),
('char', 'Medals', 3600),
('char', 'Notifications', 1800),
('char', 'NotificationTexts', 1800),
('char', 'Research', 900),
('char', 'SkillInTraining', 300),
('char', 'SkillQueue', 900),
('char', 'Standings', 3600),
('char', 'UpcomingCalendarEvents', 900),
('char', 'WalletJournal', 1620),
('char', 'WalletTransactions', 3600),
('corp', 'AccountBalance', 900),
('corp', 'AssetList', 21600),
('corp', 'ContactList', 900),
('corp', 'ContainerLog', 3600),
('corp', 'Contracts', 900),
('corp', 'CorporationSheet', 21600),
('corp', 'FacWarStats', 3600),
('corp', 'IndustryJobs', 900),
('corp', 'KillMails', 1800),
('corp', 'Locations', 3600),
('corp', 'MarketOrders', 3600),
('corp', 'Medals', 3600),
('corp', 'MemberMedals', 3600),
('corp', 'MemberSecurity', 3600),
('corp', 'MemberSecurityLog', 3600),
('corp', 'MemberTracking', 21600),
('corp', 'OutpostList', 3600),
('corp', 'OutpostServiceDetail', 3600),
('corp', 'Shareholders', 3600),
('corp', 'Standings', 3600),
('corp', 'StarbaseDetail', 3600),
('corp', 'StarbaseList', 3600),
('corp', 'Titles', 3600),
('corp', 'WalletJournal', 1620),
('corp', 'WalletTransactions', 3600),
('eve', 'AllianceList', 3600),
('eve', 'CertificateTree', 86400),
('eve', 'CharacterInfo', 3600),
('eve', 'ConquerableStationList', 3600),
('eve', 'ErrorList', 86400),
('eve', 'FacWarStats', 3600),
('eve', 'FacWarTopStats', 3600),
('eve', 'RefTypes', 86400),
('eve', 'SkillTree', 86400),
    ('map', 'FacWarSystems', 3600),
    ('map', 'Jumps', 3600),
    ('map', 'Kills', 3600),
    ('map', 'Sovereignty', 3600),
    ('server', 'ServerStatus', 180);
CREATE TABLE IF NOT EXISTS `{table_prefix}utilCachedUntil` (
    `ownerID`     BIGINT(20) UNSIGNED NOT NULL,
    `api`         VARCHAR(32)         NOT NULL,
    `cachedUntil` DATETIME            NOT NULL,
    `section`     VARCHAR(8)          NOT NULL,
    PRIMARY KEY (`ownerID`, `api`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =ascii;
CREATE TABLE IF NOT EXISTS `{table_prefix}utilGraphic` (
    `graphic`     MEDIUMBLOB,
    `graphicType` VARCHAR(4) DEFAULT NULL,
    `ownerID`     BIGINT(20) UNSIGNED NOT NULL,
    `ownerType`   VARCHAR(4) DEFAULT NULL,
    PRIMARY KEY (`ownerID`),
    KEY `utilGraphic1` (`ownerType`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =ascii;
CREATE TABLE IF NOT EXISTS `{table_prefix}utilRegisteredCharacter` (
    `activeAPIMask` BIGINT(20) UNSIGNED DEFAULT NULL,
    `characterID`   BIGINT(20) UNSIGNED NOT NULL,
    `characterName` VARCHAR(100) DEFAULT NULL,
    `isActive`      TINYINT(1) DEFAULT NULL,
    `proxy`         VARCHAR(255)
        DEFAULT NULL,
    PRIMARY KEY (`characterID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}utilRegisteredCorporation` (
    `activeAPIMask`   BIGINT(20) UNSIGNED DEFAULT NULL,
    `corporationID`   BIGINT(20) UNSIGNED NOT NULL,
    `corporationName` VARCHAR(150) DEFAULT NULL,
    `isActive`        TINYINT(1) DEFAULT NULL,
    `proxy`           VARCHAR(255)
        DEFAULT NULL,
    PRIMARY KEY (`corporationID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `{table_prefix}utilRegisteredKey` (
    `activeAPIMask` BIGINT(20) UNSIGNED DEFAULT NULL,
    `isActive`      TINYINT(1) DEFAULT NULL,
    `keyID`         BIGINT(20) UNSIGNED NOT NULL,
    `proxy`         VARCHAR(255) DEFAULT NULL,
    `vCode`         VARCHAR(64)         NOT NULL,
    PRIMARY KEY (`keyID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =ascii;
TRUNCATE TABLE `{table_prefix}utilRegisteredKey`;
INSERT INTO `{table_prefix}utilRegisteredKey` (`activeAPIMask`, `isActive`, `keyID`, `proxy`, `vCode`)
VALUES
    (8388608, 1, 1156, NULL, 'abc123');

CREATE TABLE IF NOT EXISTS `{table_prefix}utilRegisteredUploader` (
    `isActive`            TINYINT(1) DEFAULT NULL,
    `key`                 VARCHAR(255) DEFAULT NULL,
    `ownerID`             BIGINT(20) UNSIGNED NOT NULL,
    `uploadDestinationID` BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`ownerID`, `uploadDestinationID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8;
CREATE TABLE IF NOT EXISTS `{table_prefix}utilSections` (
    `activeAPIMask` BIGINT(20) UNSIGNED NOT NULL,
    `isActive`      TINYINT(1)          NOT NULL,
    `proxy`         VARCHAR(255) DEFAULT NULL,
    `sectionID`     BIGINT(20) UNSIGNED NOT NULL,
    `section`       VARCHAR(8) DEFAULT NULL,
    PRIMARY KEY (`sectionID`),
    KEY `utilSection1` (`section`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =ascii;
TRUNCATE TABLE `{table_prefix}utilSections`;
INSERT INTO `{table_prefix}utilSections` (`activeAPIMask`, `isActive`, `proxy`, `sectionID`, `section`)
VALUES
    (33554433, 1, NULL, 1, 'account'),
    (74440635, 1, NULL, 2, 'char'),
    (46068159, 1, NULL, 3, 'corp'),
    (497, 1, NULL, 4, 'eve'),
    (15, 1, NULL, 5, 'map'),
    (1, 1, NULL, 6, 'server');
CREATE TABLE IF NOT EXISTS `{table_prefix}utilUploadDestination` (
    `isActive`            TINYINT(1) DEFAULT NULL,
    `name`                VARCHAR(25) DEFAULT NULL,
    `uploadDestinationID` BIGINT(20) UNSIGNED NOT NULL,
    `url`                 VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (`uploadDestinationID`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8;
CREATE TABLE IF NOT EXISTS `{table_prefix}utilXmlCache` (
    `hash`     CHAR(40)
               CHARACTER SET ascii NOT NULL,
    `api`      CHAR(32)
               CHARACTER SET ascii NOT NULL,
    `modified` TIMESTAMP           NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `section`  VARCHAR(8)
                                   NOT NULL,
    `xml`      LONGTEXT
               COLLATE utf8_unicode_ci,
    PRIMARY KEY (`hash`),
    KEY `utilXmlCache1` (`section`),
    KEY `utilXmlCache2` (`api`)
)
    ENGINE =InnoDB
    DEFAULT CHARSET =utf8
    COLLATE =utf8_unicode_ci;
