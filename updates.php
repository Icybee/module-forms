<?php

namespace Icybee\Modules\Forms;

use ICanBoogie\Updater\AssertionFailed;
use ICanBoogie\Updater\Update;

/**
 * - Rename table `feedback_forms` as `forms`.
 *
 * @module forms
 */
class Update20120101 extends Update
{
	public function update_table_forms()
	{
		$db = $this->app->db;

		if (!$db->table_exists('feedback_forms'))
		{
			throw new AssertionFailed('assert_table_exists', 'feedback_forms');
		}

		$db("RENAME TABLE `feedback_forms` TO `forms`");
	}

	public function update_constructor_type()
	{
		$db = $this->app->db;
		$db("UPDATE nodes SET constructor = 'forms' WHERE constructor = 'feedback.forms'");
	}
}
