<?php

/*
 * This file is part of the Icybee package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Icybee\Modules\Forms\Form;

use ICanBoogie\Event;
use ICanBoogie\Operation;

use Icybee\Modules\Forms\Form;
use Icybee\Modules\Forms\NotifyParams;

/**
 * Event class for the `Icybee\Modules\Forms\Form::alter_notify` event.
 */
class AlterNotifyEvent extends Event
{
	/**
	 * Notify parameters.
	 *
	 * @var NotifyParams
	 */
	public $params;

	/**
	 * The event that triggered the notification.
	 *
	 * @var Operation\ProcessEvent
	 */
	public $event;

	/**
	 * The operation that triggered the {@link ProcessEvent} event.
	 *
	 * @var Operation
	 */
	public $operation;

	/**
	 * The event is constructed with the type `alter_notify`.
	 *
	 * @param Form $target
	 * @param array $payload
	 */
	public function __construct(Form $target, array $payload)
	{
		parent::__construct($target, 'alter_notify', $payload);
	}
}
