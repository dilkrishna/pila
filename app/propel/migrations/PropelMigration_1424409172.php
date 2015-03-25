<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1424409172.
 * Generated on 2015-02-20 10:57:52 by ramesh
 */
class PropelMigration_1424409172
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

ALTER TABLE  `uam_document` DROP FOREIGN KEY  `FK_uam_user_document` ;

ALTER TABLE  `uam_document` ADD CONSTRAINT  `FK_uam_user_document` FOREIGN KEY (  `user_id` ) REFERENCES `editor`.`fos_user` (
`id`
) ON DELETE CASCADE;

ALTER TABLE  `uam_document_version` DROP FOREIGN KEY  `FK_uam_version_document` ;

ALTER TABLE  `uam_document_version` ADD CONSTRAINT  `FK_uam_version_document` FOREIGN KEY (  `document_id` ) REFERENCES  `editor`.`uam_document` (
`id`
) ON DELETE CASCADE;

ALTER TABLE `uam_document` CHANGE `user_id` `user_id` INTEGER NOT NULL;

ALTER TABLE `uam_document_version` CHANGE `document_id` `document_id` INTEGER NOT NULL;

CREATE TABLE `session`
(
    `session_id` VARCHAR(64) NOT NULL,
    `session_data` TEXT NOT NULL,
    `session_lifetime` INTEGER NOT NULL,
    `session_time` INTEGER,
    PRIMARY KEY (`session_id`)
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

DROP TABLE IF EXISTS `session`;

ALTER TABLE  `uam_document` DROP FOREIGN KEY  `FK_uam_user_document` ;

ALTER TABLE  `uam_document` ADD CONSTRAINT  `FK_uam_user_document` FOREIGN KEY (  `user_id` ) REFERENCES `editor`.`fos_user` (
`id`
) ON DELETE SET NULL;

ALTER TABLE  `uam_document_version` DROP FOREIGN KEY  `FK_uam_version_document` ;

ALTER TABLE  `uam_document_version` ADD CONSTRAINT  `FK_uam_version_document` FOREIGN KEY (  `document_id` ) REFERENCES  `editor`.`uam_document` (
`id`
) ON DELETE SET NULL;

ALTER TABLE `uam_document` CHANGE `user_id` `user_id` INTEGER;

ALTER TABLE `uam_document_version` CHANGE `document_id` `document_id` INTEGER;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}