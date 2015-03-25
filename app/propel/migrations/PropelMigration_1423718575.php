<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1423718575.
 * Generated on 2015-02-12 11:07:55 by dil
 */
class PropelMigration_1423718575
{

    public function preUp($manager)
    {
        // add the pre-migration code here
    }

    public function postUp($manager)
    {
        // add the post-migration code here
    }

    public function preDown($manager)
    {
        // add the pre-migration code here
    }

    public function postDown($manager)
    {
        // add the post-migration code here
    }

    /**
     * Get the SQL statements for the Up migration
     *
     * @return array list of the SQL strings to execute for the Up migration
     *               the keys being the datasources
     */
    public function getUpSQL()
    {
        return array (
  'default' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `document`;

DROP TABLE IF EXISTS `section`;

CREATE TABLE `uam_document_version`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `document_id` INTEGER,
    `version` VARCHAR(100) NOT NULL,
    `description` TEXT,
    `finalized_at` DATETIME,
    `cloned_from_id` INTEGER,
    `cloned_at` DATETIME,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `version` (`version`),
    INDEX `FI_uam_document_clone` (`cloned_from_id`),
    INDEX `FI_uam_version_document` (`document_id`),
    CONSTRAINT `FK_uam_document_clone`
        FOREIGN KEY (`cloned_from_id`)
        REFERENCES `uam_document_version` (`id`)
        ON DELETE SET NULL,
    CONSTRAINT `FK_uam_version_document`
        FOREIGN KEY (`document_id`)
        REFERENCES `uam_document` (`id`)
        ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE `uam_document_section`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `version_id` INTEGER NOT NULL,
    `title` VARCHAR(125),
    `content` TEXT,
    `tree_lft` INTEGER,
    `tree_rgt` INTEGER,
    `level` INTEGER,
    `section_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `FI_uam_version_section` (`version_id`),
    CONSTRAINT `FK_uam_version_section`
        FOREIGN KEY (`version_id`)
        REFERENCES `uam_document_version` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `uam_document`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `user_id` INTEGER,
    `name` VARCHAR(255) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `FI_uam_user_document` (`user_id`),
    CONSTRAINT `FK_uam_user_document`
        FOREIGN KEY (`user_id`)
        REFERENCES `fos_user` (`id`)
        ON DELETE SET NULL
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

    /**
     * Get the SQL statements for the Down migration
     *
     * @return array list of the SQL strings to execute for the Down migration
     *               the keys being the datasources
     */
    public function getDownSQL()
    {
        return array (
  'default' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `uam_document_version`;

DROP TABLE IF EXISTS `uam_document_section`;

DROP TABLE IF EXISTS `uam_document`;

CREATE TABLE `document`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `version` VARCHAR(100) NOT NULL,
    `description` TEXT,
    `finalized_at` DATETIME,
    `cloned_from_id` INTEGER,
    `cloned_at` DATETIME,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `version` (`version`(100)),
    INDEX `FI_ument_document` (`cloned_from_id`),
    CONSTRAINT `document_document`
        FOREIGN KEY (`cloned_from_id`)
        REFERENCES `document` (`id`)
        ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE `section`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `section_id` INTEGER NOT NULL,
    `title` VARCHAR(125),
    `content` TEXT,
    `tree_lft` INTEGER,
    `tree_rgt` INTEGER,
    `level` INTEGER,
    `document_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `FI_tion_document` (`section_id`),
    CONSTRAINT `section_document`
        FOREIGN KEY (`section_id`)
        REFERENCES `document` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}