<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1423194178.
 * Generated on 2015-02-06 09:27:58 by dil
 */
class PropelMigration_1423194178
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

CREATE TABLE `fos_user`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(255),
    `username_canonical` VARCHAR(255),
    `email` VARCHAR(255),
    `email_canonical` VARCHAR(255),
    `enabled` TINYINT(1) DEFAULT 0,
    `salt` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `last_login` DATETIME,
    `locked` TINYINT(1) DEFAULT 0,
    `expired` TINYINT(1) DEFAULT 0,
    `expires_at` DATETIME,
    `confirmation_token` VARCHAR(255),
    `password_requested_at` DATETIME,
    `credentials_expired` TINYINT(1) DEFAULT 0,
    `credentials_expire_at` DATETIME,
    `roles` TEXT,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `fos_user_U_1` (`username_canonical`),
    UNIQUE INDEX `fos_user_U_2` (`email_canonical`)
) ENGINE=InnoDB;

CREATE TABLE `fos_group`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `roles` TEXT,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `fos_user_group`
(
    `fos_user_id` INTEGER NOT NULL,
    `fos_group_id` INTEGER NOT NULL,
    PRIMARY KEY (`fos_user_id`,`fos_group_id`),
    INDEX `fos_user_group_FI_2` (`fos_group_id`),
    CONSTRAINT `fos_user_group_FK_1`
        FOREIGN KEY (`fos_user_id`)
        REFERENCES `fos_user` (`id`),
    CONSTRAINT `fos_user_group_FK_2`
        FOREIGN KEY (`fos_group_id`)
        REFERENCES `fos_group` (`id`)
) ENGINE=InnoDB;

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
    UNIQUE INDEX `version` (`version`),
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

DROP TABLE IF EXISTS `fos_user`;

DROP TABLE IF EXISTS `fos_group`;

DROP TABLE IF EXISTS `fos_user_group`;

DROP TABLE IF EXISTS `document`;

DROP TABLE IF EXISTS `section`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}