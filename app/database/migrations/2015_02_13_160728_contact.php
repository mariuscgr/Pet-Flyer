<?php

use Illuminate\Database\Migrations\Migration;

class Contact extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("CREATE TABLE `contact1` (
							`Id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
							`Name` VARCHAR(100) NULL DEFAULT '',
							`Email` VARCHAR(100) NULL DEFAULT '',
							`Data` TEXT NULL,
							PRIMARY KEY (`Id`)
						)
						COLLATE='latin1_swedish_ci'
						ENGINE=InnoDB
						AUTO_INCREMENT=41
						;");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("DROP TABLE contact1");
	}

}