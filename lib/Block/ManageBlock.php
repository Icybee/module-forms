<?php

/*
 * This file is part of the Icybee package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Icybee\Modules\Forms\Block;

use Icybee\Modules\Forms\Module;

class ManageBlock extends \Icybee\Modules\Nodes\Block\ManageBlock
{
	public function __construct(Module $module, array $attributes=[])
	{
		parent::__construct($module, $attributes + [

				self::T_COLUMNS_ORDER => [ 'title', 'is_online', 'modelid', 'uid', 'updated_at' ]

		]);
	}

	/**
	 * Adds the following columns:
	 *
	 * - `modelid`
	 */
	protected function get_available_columns()
	{
		return array_merge(parent::get_available_columns(), [

			'modelid' => __CLASS__ . '\ModelIdColumn'

		]);
	}
}

/*
 * Columns
 */

namespace Icybee\Modules\Forms\Block\ManageBlock;

use Icybee\Block\ManageBlock\Column;
use Icybee\Block\ManageBlock\FilterDecorator;
use Brickrouge\Alert;

/**
 * Representation of the `modelid` column
 */
class ModelIdColumn extends Column
{
	static protected $modelid_models;

	public function render_cell($record)
	{
		if (empty(self::$modelid_models))
		{
			self::$modelid_models = \ICanBoogie\app()->configs->synthesize('formmodels', 'merge');
		}

		$property = $this->id;
		$modelid = $record->$property;

		if (isset(self::$modelid_models[$modelid]))
		{
			$label = $this->t(self::$modelid_models[$modelid]['title']);
		}
		else
		{
			return new Alert("Undefined model: $modelid", [

				Alert::CONTEXT => Alert::CONTEXT_ERROR,
				Alert::UNDISMISSABLE => true

			]);
		}

		return new FilterDecorator($record, $property, $this->is_filtering, $label);
	}
}
