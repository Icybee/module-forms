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

/**
 * "Form" editor.
 */
class FormEditor implements \Icybee\Modules\Editor\Editor
{
	/**
	 * @inheritdoc
	 */
	public function serialize($content)
	{
		return $content;
	}

	/**
	 * @inheritdoc
	 */
	public function unserialize($serialized_content)
	{
		return $serialized_content;
	}

	/**
	 * @inheritdoc
	 *
	 * @return FormEditorElement
	 */
	public function from(array $attributes)
	{
		return new FormEditorElement($attributes);
	}

	/**
	 * @inheritdoc
	 *
	 * @return Form
	 */
	public function render($content)
	{
		return $content ? app()->models['forms'][$content] : null;
	}
}
