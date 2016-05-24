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

use Brickrouge\Element;

/**
 * "Form" editor element.
 */
class FormEditorElement extends PopForm implements \Icybee\Modules\Editor\EditorElement
{
	protected $selector;

	public function __construct(array $attributes=[])
	{
		parent::__construct('select', [

			Element::DESCRIPTION => 'Sélectionner le formulaire à afficher.',

			'class' => 'form-control'

		] + $attributes);
	}
}
