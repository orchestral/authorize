<?php namespace Authorize;

use \Config,
	Orchestra\Core as O,
	Orchestra\Model\Role;
	
class Core {
	
	/**
	 * Ensure default role has the right ACL.
	 *
	 * @static
	 * @access public
	 * @return void
	 */
	public static function sync()
	{
		$role = Role::find(Config::get('orchestra::orchestra.default_role'));
		$acl  = O::acl();
		
		$acl->allow($role->name, array(
			'Manage Users', 
			'Manage Orchestra',
			'Manage Roles',
			'Manage Acl',
		));
	}
}