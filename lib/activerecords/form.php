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

use ICanBoogie\Debug;
use ICanBoogie\Operation;

use Brickrouge\Button;
use Brickrouge\Element;

class Form extends \Icybee\Modules\Nodes\Node
{
	const MODELID = 'modelid';
	const CONFIG = 'config';
	const BEFORE = 'before';
	const AFTER = 'after';
	const COMPLETE = 'complete';
	const PAGEID = 'pageid';

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
	public $pageid;

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
		if (!$this->pageid)
		{
			return '#form-url-not-defined';
		}

		try
		{
			return $this->app->models['pages'][$this->pageid]->url;
		}
		catch (\Exception $e)
		{
			return '#missing-target-page-' . $this->pageid;
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

	/**
	 * Renders the record into an HTML form.
	 *
	 * @return string
	 */
	public function render()
	{
		#
		# if the form was sent successfully, we return the `complete` message instead of the form.
		#

		$app = $this->app;
		$session = $app->session;

		if (!empty($session->modules['forms']['rc'][$this->nid]))
		{
			unset($session->modules['forms']['rc'][$this->nid]);

			new Form\RenderCompleteEvent
			(
				$this, [
				
				    'complete' => &$this->complete,
				]
			);
            
			return '<div id="' . $this->slug . '">' . $this->complete . '</div>';
		}

		$form = $this->form;

		if (isset($form->hiddens[Operation::DESTINATION]) && isset($form->hiddens[Operation::NAME]))
		{
			$destination = $form->hiddens[Operation::DESTINATION];
			$name = $access = $form->hiddens[Operation::NAME];

			if ($name == 'save')
			{
				$access = Module::PERMISSION_CREATE;
			}
			else if ($name == 'post' && $destination == 'forms')
			{
				$access = 'post form';
			}

			if (!$app->user->has_permission($access, $destination))
			{
				return (string) new \Brickrouge\Alert
				(
					<<<EOT
<p>You don't have permission to execute the <q>$name</q> operation on the <q>$destination</q> module,
<a href="{$app->site->path}/admin/users.roles">the <q>{$app->user->role->name}</q> role should be modified</a>.</p>
EOT
					, array(), 'error'
				);
			}
		}

		$app->document->css->add(DIR . 'public/page.css');

		$before = $this->before;
		$after = $this->after;
		$form = $this->form;

		new Form\BeforeRenderEvent($this, [

			'before' => &$before,
			'after' => &$after,
			'form' => $form,

		]);

		$normalized = \ICanBoogie\normalize($this->slug);

		if ($before)
		{
			$before = '<div class="form-before form-before--' . $normalized . '">' . $before . '</div>';
		}

		if ($after)
		{
			$after = '<div class="form-after form-after--' . $normalized . '">' . $after . '</div>';
		}

		$html = $before . $form . $after;

		new Form\RenderEvent($this, [

			'html' => &$html,
			'before' => $before,
			'after' => $after,
			'form' => $form,

		]);

		return $html;
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

namespace Icybee\Modules\Forms\Form;

/**
 * Event class for the `Icybee\Modules\Forms\Form::render:before` event.
 */
class BeforeRenderEvent extends \ICanBoogie\Event
{
	/**
	 * The form to render.
	 *
	 * @var \Icybee\Modules\Forms\Form
	 */
	public $form;

	/**
	 * The HTML content before the form.
	 *
	 * @var string
	 */
	public $before;

	/**
	 * The HTML content after the form.
	 *
	 * @var string
	 */
	public $after;

	/**
	 * The event is created with the type `render:before`.
	 *
	 * @param \Icybee\Modules\Forms\Form $target
	 * @param array $payload
	 */
	public function __construct(\Icybee\Modules\Forms\Form $target, array $payload)
	{
		parent::__construct($target, 'render:before', $payload);
	}
}

/**
 * Event class for the `Icybee\Modules\Forms\Form::render` event.
 */
class RenderEvent extends \ICanBoogie\Event
{
	/**
	 * Reference to the HTML resulting of the rendering.
	 *
	 * @var string
	 */
	public $html;

	/**
	 * The form to render.
	 *
	 * @var \Icybee\Modules\Forms\Form
	 */
	public $form;

	/**
	 * The HTML content before the form.
	 *
	 * @var string
	 */
	public $before;

	/**
	 * The HTML content after the form.
	 *
	 * @var string
	 */
	public $after;

	/**
	 * The event is created with the type `render`.
	 *
	 * @param \Icybee\Modules\Forms\Form $target
	 * @param array $payload
	 */
	public function __construct(\Icybee\Modules\Forms\Form $target, array $payload)
	{
		parent::__construct($target, 'render', $payload);
	}
}

/**
 * Event class for the `Icybee\Modules\Forms\Form::render:complete` event.
 */
class RenderCompleteEvent extends \ICanBoogie\Event
{
	/**
	 * The form to render.
	 *
	 * @var \Icybee\Modules\Forms\Form
	 */
	public $form;

	/**
	 * The HTML content after form is submitted.
	 *
	 * @var string
	 */
	public $complete;


	/**
	 * The event is created with the type `render:complete`.
	 *
	 * @param \Icybee\Modules\Forms\Form $target
	 * @param array $payload
	 */
	public function __construct(\Icybee\Modules\Forms\Form $target, $payload)
	{
		parent::__construct($target, 'render:complete', $payload);	
	}
}
