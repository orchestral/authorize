<?php

class Authorize_Seed_Acl {

	/**
	 * Make sure Orchestra is started.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		Bundle::start('orchestra');
	}

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		$acl     = Orchestra::acl();
		$actions = array(
			'Manage Roles',
			'Manage Acl',
		);

		$acl->add_actions($actions);
		$acl->allow('Administrator', $actions);
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		// nothing to do here.
	}

}