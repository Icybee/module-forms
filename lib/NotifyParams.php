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

class NotifyParams
{
	/**
	 * Reference to the result of the operation.
	 *
	 * @var mixed
	 */
	public $rc;

	/**
	 * Reference to the `this` value used to render the template.
	 *
	 * @var mixed
	 */
	public $bind;

	/**
	 * Reference to the template used to render the message.
	 *
	 * @var string
	 */
	public $template;

	/**
	 * Reference to the mailer instance.
	 *
	 * Use this property to provide your own mailer.
	 *
	 * @var mixed
	 */
	public $mailer;

	/**
	 * Reference to the tags used to create the mailer object.
	 *
	 * @var array
	 */
	public $mailer_tags;

	/**
	 * The {@link Form} instance.
	 *
	 * @var Form
	 */
	public $record;

	/**
	 * The event that triggered the notification.
	 *
	 * @var \ICanBoogie\Operation\ProcessEvent
	 */
	public $event;

	/**
	 * The operation that triggered the event.
	 *
	 * @param \ICanBoogie\Operation
	 */
	public $operation;

	public function __construct(array $params)
	{
		foreach ($params as $k => &$v)
		{
			$this->$k = &$v;
		}
	}
}
