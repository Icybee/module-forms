<?php

/*
 * This file is part of the Icybee package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Icybee\Modules\Forms\Operation;

use ICanBoogie\Errors;
use ICanBoogie\Operation;

use Icybee\Modules\Forms\Module;

/**
 * Returns model specific default values for the form.
 */
class DefaultsOperation extends Operation
{
	/**
	 * Controls for the operation: authentication, permission(create)
	 */
	protected function get_controls()
	{
		return [

			self::CONTROL_AUTHENTICATION => true,
			self::CONTROL_PERMISSION => Module::PERMISSION_CREATE

		] + parent::get_controls();
	}

	/**
	 * Validates the operation unles the operation key is not defined.
	 *
	 * @inheritdoc
	 */
	protected function validate(Errors $errors)
	{
		if (!$this->key)
		{
			$errors->add('key', "Missing modelid");

			return false;
		}

		return true;
	}

	/**
	 * The "defaults" operation can be used to retrieve the default values for the form, usualy
	 * the values for the notify feature.
	 */
	protected function process()
	{
		$modelid = $this->key;
		$models = $this->app->configs->synthesize('formmodels', 'merge');

		if (empty($models[$modelid]))
		{
			\ICanBoogie\log_error("Unknown model.");

			return null;
		}

		$model = $models[$modelid];
		$model_class = $model['class'];

		if (!method_exists($model_class, 'get_defaults'))
		{
			\ICanBoogie\log_success("The model doesn't have defaults.");

			return false;
		}

		return call_user_func(array($model_class, 'get_defaults'));
	}
}
