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

use Icybee\Modules\Forms\Form;

/**
 * Event class for the `Icybee\Modules\Forms\Form::render_complete` event.
 */
class RenderSuccessEvent extends Event
{
	/**
	 * Reference to the _success_ element.
	 *
	 * @var string
	 */
	public $success;

	/**
	 * The event is created with the type `render_success`.
	 *
	 * @param Form $target
	 * @param \Brickrouge\Element $success
	 */
	public function __construct(Form $target, &$success)
	{
		$this->success = &$success;

		parent::__construct($target, 'render_success');
	}
}
