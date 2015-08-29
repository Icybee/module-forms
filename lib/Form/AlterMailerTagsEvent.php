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

class AlterMailerTagsEvent extends Event
{
	public $mailer_tags;

	public function __construct(Form $target, array &$mailer_tags)
	{
		$this->mailer_tags = &$mailer_tags;

		parent::__construct($target, 'alter_mailer_tags');
	}
}
