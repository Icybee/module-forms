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

		$db("RENAME TABLE `{prefix}feedback_forms` TO `{prefix}forms`");
	}

	public function update_constructor_type()
	{
		$db = $this->app->db;
		$db("UPDATE `{prefix}nodes` SET constructor = 'forms' WHERE constructor = 'feedback.forms'");
	}
}

/**
 * @module forms
 */
class Update2015090821 extends Update
{
	/**
	 * Renames column `pageid` as `page_id`.
	 */
	public function update_column_page_id()
	{
		$this->module->model
			->assert_has_column('pageid')
			->rename_column('pageid', 'page_id');
	}
}
