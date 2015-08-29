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

use ICanBoogie\Operation;
use ICanBoogie\Session;

use Brickrouge\Document;
use Brickrouge\Element;

class FormRenderer
{
	/**
	 * Creates a new instance.
	 *
	 * @param Form $record The form record to render.
	 *
	 * @return static
	 */
	static public function from(Form $record)
	{
		return new static($record);
	}

	/**
	 * @var Form
	 */
	protected $record;

	/**
	 * @var Document
	 */
	protected $document;

	/**
	 * @var Session
	 */
	protected $session;

	/**
	 * @param Form $record
	 * @param Document|null $document
	 * @param Session|null $session
	 */
	public function __construct(Form $record, Document $document = null, Session $session = null)
	{
		$this->record = $record;
		$this->document = $document ?: \ICanBoogie\app()->document;
		$this->session = $session ?: \ICanBoogie\app()->session;
	}

	public function __toString()
	{
		try
		{
			return (string) $this->render();
		}
		catch (\Exception $e)
		{
			return \Brickrouge\render_exception($e);
		}
	}

	/**
	 * Renders the form record.
	 *
	 * @return string
	 */
	public function render()
	{
		$this->document->css->add(DIR . 'public/page.css');

		$session = $this->session;
		$nid = $this->record->nid;

		if (!empty($session['modules']['forms']['rc'][$nid]))
		{
			unset($session['modules']['forms']['rc'][$nid]);

			return $this->render_success();
		}

		/* @TODO-20150829: implement with event hooks

		$form = $record->form;

		if (isset($form->hiddens[Operation::DESTINATION]) && isset($form->hiddens[Operation::NAME]))
		{
			$destination = $form->hiddens[Operation::DESTINATION];
			$name = $access = $form->hiddens[Operation::NAME];

			if ($name == 'save')
			{
				$access = Module::PERMISSION_CREATE;
			}
			else if ($name == 'post' && $destination == 'forms')
			{
				$access = 'post form';
			}

			if (!$app->user->has_permission($access, $destination))
			{
				return (string) new Alert
				(
					<<<EOT
<p>You don't have permission to execute the <q>$name</q> operation on the <q>$destination</q> module,
<a href="{$app->site->path}/admin/users.roles">the <q>{$app->user->role->name}</q> role should be modified</a>.</p>
EOT
					, array(), 'error'
				);
			}
		}
		*/

		return $this->render_group();
	}

	/**
	 * Renders group including _before_, _after_, and the form.
	 *
	 * @return string
	 */
	protected function render_group()
	{
		$record = $this->record;

		$before = new Element('div', [

			Element::INNER_HTML => $record->before ?: null, // So that nothing is renderer if empty

			'class' => "form-before form-before--{$record->slug}"

		]);

		$after = new Element('div', [

			Element::INNER_HTML => $record->after ?: null, // So that nothing is renderer if empty

			'class' => "form-after form-after--{$record->slug}"

		]);

		$form = $record->form;

		new Form\BeforeRenderEvent($record, $form, $before, $after);

		$html = $before . $form . $after;

		new Form\RenderEvent($record, $html, $form, $before, $after);

		return $html;
	}

	/**
	 * Renders success.
	 *
	 * @return Element
	 */
	protected function render_success()
	{
		$record = $this->record;

		$success = new Element('div', [

			Element::INNER_HTML => $record->complete,

			'id' => $record->slug,
			'class' => "form-success form-success--{$record->slug}"

		]);

		new Form\RenderSuccessEvent($record, $success);

		return $success;
	}
}
