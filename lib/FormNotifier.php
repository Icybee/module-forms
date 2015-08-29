<?php

namespace Icybee\Modules\Forms;

use ICanBoogie\Core;
use ICanBoogie\Operation;

use Brickrouge\Form as FormElement;

/**
 * Handles the notify process of forms.
 */
class FormNotifier
{
	/**
	 * @var Form
	 */
	protected $record;

	/**
	 * @var FormElement
	 */
	protected $form;

	/**
	 * @var callable
	 */
	protected $mailer;

	/**
	 * A session provider that should return a {@link \ICanBoogie\Session} instance.
	 *
	 * @var callable
	 */
	protected $session_provider;

	/**
	 * @param Form $record
	 * @param FormElement $form
	 * @param callable $mailer
	 * @param callable $session_provider
	 */
	public function __construct(Form $record, FormElement $form, callable $mailer, callable $session_provider)
	{
		$this->record = $record;
		$this->form = $form;
		$this->mailer = $mailer;
		$this->session_provider = $session_provider;
	}

	/**
	 * Notifies.
	 *
	 * If defined, the `alter_notify` method of the form is invoked to alter the notify options.
	 * The method is wrapped with the `Icybee\Modules\Forms\Form::alter_notify:before` and
	 * `Icybee\Modules\Forms\Form::alter_notify` events.
	 *
	 * If the `is_notify` property of the record is true a notify message is sent with the notify
	 * options.
	 *
	 * The result of the operation using the form is stored in the session under
	 * `[modules][forms][rc][<record_nid>]`. This stored value is used when the form is
	 * rendered to choose what to render. For example, if the value is empty, the form is rendered
	 * with the `before` and `after` messages, otherwise only the `complete` message is rendered.
	 *
	 * @param Operation\ProcessEvent $event
	 * @param Operation $operation
	 */
	public function __invoke(Operation\ProcessEvent $event, Operation $operation)
	{
		$rc = $event->rc;
		$bind = $event->request->params;
		$record = $this->record;
		$template = $record->notify_template;
		$mailer_tags = [

			'bcc' => $record->notify_bcc,
			'to' => $record->notify_destination,
			'from' => $record->notify_from,
			'subject' => $record->notify_subject,
			'body' => null

		];

		$mailer = $this->mailer;
		$notify_params = $this->alter_notify_params(new NotifyParams([

			'record' => $record,
			'event' => $event,
			'operation' => $operation,

			'rc' => &$rc,
			'bind' => &$bind,
			'template' => &$template,
			'mailer' => &$mailer,
			'mailer_tags' => &$mailer_tags

		]));

		#
		# The result of the operation is stored in the session and is used in the next
		# session to present the `success` message instead of the form.
		#
		# Note: The result is not stored for XHR.
		#

		if (!$event->request->is_xhr)
		{
			$session_provider = $this->session_provider;
			$session_provider()['modules']['forms']['rc'][$record->nid] = $rc;
		}

		$message = null;

		if ($record->is_notify)
		{
			$patron = \Patron\get_patron();

			if (!$mailer_tags['body'])
			{
				$mailer_tags['body'] = $template;
			}

			foreach ($mailer_tags as &$value)
			{
				$value = $patron($value, $bind);
			}

			$message = $mailer_tags['body'];

			new Form\AlterMailerTagsEvent($record, $mailer_tags);

			if ($mailer)
			{
				$mailer($mailer_tags);
			}
		}

		new Form\NotifyEvent($record, [

			'params' => $notify_params,
			'message' => $message,
			'event' => $event,
			'operation' => $operation

		]);
	}

	/**
	 * Alters notify params.
	 *
	 * @param NotifyParams $params
	 *
	 * @return NotifyParams
	 */
	protected function alter_notify_params(NotifyParams $params)
	{
		$record = $params->record;
		$event = $params->event;
		$operation = $params->operation;

		new Form\BeforeAlterNotifyEvent($record, [

			'params' => $params,
			'event' => $event,
			'operation' => $operation

		]);

		$form = $this->form;

		if ($form instanceof AlterFormNotifyParams)
		{
			$form->alter_form_notify_params($params);
		}

		new Form\AlterNotifyEvent($record, [

			'params' => $params,
			'event' => $event,
			'operation' => $operation

		]);

		return $params;
	}
}
