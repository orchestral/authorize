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

		if (false === Orchestra\Installer::installed())
		{
			throw new RuntimeException("Orchestra need to be install first.");
		}
	}

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		$role    = Orchestra\Model\Role::admin();
		$acl     = Orchestra::acl();
		$actions = array(
			'Manage Roles',
			'Manage Acl',
		);

		$acl->add_actions($actions);
		$acl->allow($role->name, $actions);
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