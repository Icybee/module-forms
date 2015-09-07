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

use Brickrouge\Element;
use ICanBoogie\Debug;
use ICanBoogie\Operation;

use Brickrouge\Button;

use Icybee\Modules\Nodes\Node;

/**
 * @method string render() [prototype method] Renders the form.
 *
 * @property array $form_model
 * @property \Brickrouge\Form $form
 */
class Form extends Node
{
	const MODELID = 'modelid';
	const CONFIG = 'config';
	const BEFORE = 'before';
	const AFTER = 'after';
	const COMPLETE = 'complete';
	const PAGE_ID = 'page_id';

	const FORM_RECORD_TAG = '#form-record';

	/**
	 * Identifier of the form model.
	 *
	 * @var string
	 */
	public $modelid;

	/**
	 * The optional message that appears before the form.
	 *
	 * @var string
	 */
	public $before;

	/**
	 * The optional message that appears after the formm.
	 *
	 * @var string
	 */
	public $after;

	/**
	 * The message that appears instead of the form, when the form was successfuly submitted.
	 *
	 * @var string
	 */
	public $complete;

	/**
	 * `true` if the notify options are enabled.
	 *
	 * @var bool
	 */
	public $is_notify;
	public $notify_destination;
	public $notify_from;
	public $notify_bcc;
	public $notify_subject;
	public $notify_template;
	public $page_id;

	/**
	 * Returns the model definition for the form.
	 *
	 * @return array if the form model is not defined.
	 *
	 * @throws \Exception if the form model is not defined.
	 */
	protected function lazy_get_form_model()
	{
		$modelid = $this->modelid;
		$models = $this->app->configs->synthesize('formmodels', 'merge');

		if (empty($models[$modelid]))
		{
			throw new \Exception(\ICanBoogie\format('Unknown model id: %id', [ '%id' => $modelid ], 404));
		}

		return $models[$modelid];
	}

	protected function get_url()
	{
		if (!$this->page_id)
		{
			return '#form-url-not-defined';
		}

		try
		{
			return $this->app->models['pages'][$this->page_id]->url;
		}
		catch (\Exception $e)
		{
			return '#missing-target-page-' . $this->page_id;
		}
	}

	/**
	 * Returns the {@link \Brickrouge\Form} associated with the active record.
	 *
	 * @return \Brickrouge\Form
	 */
	protected function lazy_get_form()
	{
		$class = $this->form_model['class'];

		return new $class([

			\Brickrouge\Form::ACTIONS => new Button('Send', [

				'class' => 'btn-primary',
				'type' => 'submit'

			]),

			\Brickrouge\Form::HIDDENS => [

				Operation::DESTINATION => 'forms',
				Operation::NAME => Module::OPERATION_POST,
				Module::OPERATION_POST_ID => $this->nid

			],

			\Brickrouge\Form::VALUES => $_POST + $_GET,

			self::FORM_RECORD_TAG => $this,

			'id' => $this->slug

		]);
	}

	public function __toString()
	{
		try
		{
			return (string) $this->render();
		}
		catch (\Exception $e)
		{
			Debug::report($e);

			return Debug::format_alert($e);
		}
	}
}
