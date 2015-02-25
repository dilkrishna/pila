<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1424846359.
 * Generated on 2015-02-25 12:24:19 by ramesh
 */
class PropelMigration_1424846359
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

DROP INDEX `FI_uam_version_document` ON `uam_document_version`;

DROP INDEX `version` ON `uam_document_version`;

CREATE UNIQUE INDEX `version` ON `uam_document_version` (`document_id`,`version`);

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

DROP INDEX `version` ON `uam_document_version`;

CREATE UNIQUE INDEX `version` ON `uam_document_version` (`version`);

CREATE INDEX `FI_uam_version_document` ON `uam_document_version` (`document_id`);

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}