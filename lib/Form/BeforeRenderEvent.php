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
 * Event class for the `Icybee\Modules\Forms\Form::render:before` event.
 */
class BeforeRenderEvent extends Event
{
	/**
	 * The form element.
	 *
	 * @var \Brickrouge\Form
	 */
	public $form;

	/**
	 * Reference to the element before the form.
	 *
	 * @var string
	 */
	public $before;

	/**
	 * Reference to the element after the form.
	 *
	 * @var string
	 */
	public $after;

	/**
	 * The event is created with the type `render:before`.
	 *
	 * @param Form $target
	 * @param \Brickrouge\Form $form
	 * @param \Brickrouge\Element $before
	 * @param \Brickrouge\Element $after
	 */
	public function __construct(Form $target, $form, &$before, &$after)
	{
		$this->form = $form;
		$this->before = &$before;
		$this->after = &$after;

		parent::__construct($target, 'render:before');
	}
}
