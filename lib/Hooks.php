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

use function ICanBoogie\app;
use ICanBoogie\Operation;

use Patron\Engine as Patron;

class Hooks
{
	static public function markup_form(array $args, Patron $patron, $template)
	{
		/* @var $model FormModel */
		/* @var $form Form */

		$id = $args['select'];
		$model = app()->models['forms'];

		if (is_numeric($id))
		{
			$form = $model[$id];
		}
		else
		{
			$form = $model->own->visible->filter_by_slug($id)->one;
		}

		if (!$form)
		{
			throw new \Exception(\ICanBoogie\format('Unable to retrieve form using supplied conditions: %conditions', [ '%conditions' => json_encode($args['select']) ]));
		}

		new \BlueTihi\Context\LoadedNodesEvent($patron->context, [ $form ]);

		if (!$form->is_online)
		{
			throw new \Exception(\ICanBoogie\format('The form %title is offline', [ '%title' => $form->title ]));
		}

		return $form->render();
	}

	/**
	 * Tries to load the form associated with the operation.
	 *
	 * This function is a callback for the `ICanBoogie\Operation::get_form` event.
	 *
	 * The {@link OPERATION_POST_ID} parameter provides the key of the form active record to load.
	 *
	 * If the form is successfully retrieved an event hook is attached to the operation, it is used
	 * to send a notify message.
	 *
	 * At the very end of the process, the `Icybee\Modules\Forms\Form::sent` event is fired.
	 *
	 * @param Operation\GetFormEvent $event
	 * @param Operation $operation
	 */
	static public function on_operation_get_form(Operation\GetFormEvent $event, Operation $operation)
	{
		$request = $event->request;
		$post_id = (int) $request[Module::OPERATION_POST_ID];

		if (!$post_id)
		{
			return;
		}

		/* @var $record Form */

		$app = app();
		$record = $app->models['forms'][$post_id];
		$event->form = $form = $record->form;
		$event->stop();

		$mailer = function(array $message) use ($app) {

			return $app->mail($message);

		};

		$session_provider = function() use ($app) {

			return $app->session;

		};

		$app->events->attach_to($operation, new FormNotifier($record, $form, $mailer, $session_provider));
	}
}
