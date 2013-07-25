<?php

/*
 * This file is part of the Icybee package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Icybee\Modules\Forms;

class ManageBlock extends \Icybee\Modules\Nodes\ManageBlock
{
	public function __construct(Module $module, array $attributes=array())
	{
		parent::__construct
		(
			$module, $attributes + array
			(
				self::T_COLUMNS_ORDER => array('title', 'is_online', 'modelid', 'uid', 'modified')
			)
		);
	}

	/**
	 * Adds the following columns:
	 *
	 * - `modelid`
	 */
	protected function get_available_columns()
	{
		return array_merge(parent::get_available_columns(), array
		(
			'modelid' => __CLASS__ . '\ModelIdColumn'
		));
	}
}

/*
 * Columns
 */

namespace Icybee\Modules\Forms\ManageBlock;

use Icybee\ManageBlock\Column;
use Icybee\ManageBlock\FilterDecorator;

/**
 * Representation of the `modelid` column
 */
class ModelIdColumn extends Column
{
	static protected $modelid_models;

	public function render_cell($record)
	{
		global $core;

		if (empty(self::$modelid_models))
		{
			self::$modelid_models = $core->configs->synthesize('formmodels', 'merge');
		}

		$property = $this->id;
		$modelid = $record->$property;
		$label = $modelid;

		if (isset(self::$modelid_models[$modelid]))
		{
			$label = $this->t(self::$modelid_models[$modelid]['title']);
		}

		return new FilterDecorator($record, $property, $this->is_filtering, $label);
	}
}