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

/**
 * Post a form.
 *
 * Note: The form is retrieved by a hook attached to the
 * {@link \ICanBoogie\Operation\GetFormEvent} event, just like any other operation.
 *
 * @property \ICanBoogie\Form $form
 * @property Form $record
 */
class PostOperation extends \ICanBoogie\Operation
{
	/**
	 * Controls for the operation: form.
	 */
	protected function get_controls()
	{
		return array
		(
			self::CONTROL_FORM => true
		)

		+ parent::get_controls();
	}

	/**
	 * Returns the form record associated with the operation.
	 *
	 * @return Form
	 */
	protected function get_record()
	{
		$nid = $this->request[Module::OPERATION_POST_ID];

		if (!$nid)
		{
			return;
		}

		return $this->module->model[$nid];
	}

	protected function validate(\ICanboogie\Errors $errors)
	{
		return !count($errors);
	}

	/**
	 * Processes the form submission.
	 *
	 * The `finalize` method of the form is used to finalize the operation and obtain a result.
	 * The method is optional, and if the form doesn't define it the value `true` is returned
	 * instead.
	 *
	 * @return mixed The result of the operation.
	 */
	protected function process()
	{
		$form = $this->form;

		$rc = method_exists($form, 'finalize') ? $form->finalize($this) : true;

		if ($rc && $this->request->is_xhr)
		{
			$this->response->message = $this->record->complete;
		}

		return $rc;
	}
}