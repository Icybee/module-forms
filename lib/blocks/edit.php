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

use ICanBoogie\I18n;

use Brickrouge\Element;
use Brickrouge\Form;

/**
 * A block to edit forms.
 */
class EditBlock extends \Icybee\Modules\Nodes\EditBlock
{
	static protected function add_assets(\Brickrouge\Document $document)
	{
		parent::add_assets($document);

		$document->css->add(DIR . 'public/admin.css');
		$document->js->add(DIR . 'public/admin.js');
	}

	protected function lazy_get_attributes()
	{
		return \ICanBoogie\array_merge_recursive(parent::lazy_get_attributes(), [

			Element::GROUPS => [

				'messages' => [

					'title' => 'messages'

				],

				'options' => [

					'title' => 'options'

				],

				'operation' => [

					'title' => 'operation'

				]
			]
		]);
	}

	protected function lazy_get_children()
	{
		$app = $this->app;
		$editors = $app->editors;
		$models = $app->configs->synthesize('formmodels', 'merge');
		$models_options = [];

		if ($models)
		{
			foreach ($models as $modelid => $model)
			{
				$models_options[$modelid] = $model['title'];
			}

			asort($models_options);
		}

		return array_merge(parent::lazy_get_children(), [

			'modelid' => new Element('select', [

				Form::LABEL => 'modelid',
				Element::REQUIRED => true,
				Element::OPTIONS => [ null => '' ] + $models_options,
				Element::LABEL_POSITION => 'before'

			]),

			'before' => $editors['rte']->from([

				Form::LABEL => 'before',
				Element::GROUP => 'messages',

				'rows' => 5
			]),

			'after' => $editors['rte']->from([

				Form::LABEL => 'after',
				Element::GROUP => 'messages',

				'rows' => 5

			]),

			'complete' => $editors['rte']->from([

				Form::LABEL => 'complete',
				Element::GROUP => 'messages',
				Element::REQUIRED => true,
				Element::DESCRIPTION => 'complete',
				Element::DEFAULT_VALUE => '<p>' . I18n\t('default.complete') . '</p>',

				'rows' => 5

			]),

			'is_notify' => new Element(Element::TYPE_CHECKBOX, [

				Element::LABEL => 'is_notify',
				Element::GROUP => 'options',
				Element::DESCRIPTION => 'is_notify'

			]),

			'notify_' => new EmailComposer([

				Element::GROUP => 'options',
				Element::DEFAULT_VALUE => [

					'from' => $app->site->email,
					'destination' => $app->site->email

				],

				'class' => 'form-horizontal'

			])
		]);
	}
}
