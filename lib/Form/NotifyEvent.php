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
use ICanBoogie\HTTP\Request;
use ICanBoogie\Operation;

use Icybee\Modules\Forms\Form;
use Icybee\Modules\Forms\NotifyParams;

/**
 * Event class for the `Icybee\Modules\Forms\Form::notify` event.
 */
class NotifyEvent extends Event
{
	/**
	 * Notify parameters.
	 *
	 * @var NotifyParams
	 */
	public $params;

	/**
	 * Reference to the message sent.
	 *
	 * @var string
	 */
	public $message;

	/**
	 * The operation `process` event.
	 *
	 * @var Operation\ProcessEvent
	 */
	public $event;

	/**
	 * The request that triggered the operation.
	 *
	 * @var Request
	 */
	public $request;

	/**
	 * The operation that submitted the form.
	 *
	 * @var Operation
	 */
	public $operation;

	/**
	 * The event is constructed with the type `notify`.
	 *
	 * @param Form $target
	 * @param array $payload
	 */
	public function __construct(Form $target, array $payload)
	{
		parent::__construct($target, 'notify', $payload);
	}
}
