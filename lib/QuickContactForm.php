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
use Brickrouge\Form;
use Brickrouge\Group;
use Brickrouge\Text;

class QuickContactForm extends \Brickrouge\Form
{
	public function __construct(array $attributes=[])
	{
		parent::__construct(\ICanBoogie\array_merge_recursive($attributes, [

			self::RENDERER => Form\GroupRenderer::class,

			Element::CHILDREN => [

				'email' => new Text([

					Element::LABEL_MISSING => 'Votre e-mail',
					Element::REQUIRED => true,
					Element::VALIDATION => 'email',

					'placeholder' => "Votre e-mail"

				]),

				'message' => new Element('textarea', [

					Element::LABEL_MISSING => 'Message',
					Element::REQUIRED => true,

					'placeholder' => "Votre message"

				])

			]
		]));
	}

	static public function getConfig() // TODO-20120304: refactor this
	{
		$app = \ICanBoogie\app();

		$email = $app->user->email;

		return [

			Element::CHILDREN => [

				'config[destination]' => new Text([

					Group::LABEL => 'Addresse de destination',
					Element::GROUP => 'config',
					Element::DEFAULT_VALUE => $email

				]),

				'config' => new \WdEMailNotifyElement([

					Group::LABEL => 'Paramètres du message électronique',
					Element::GROUP => 'config',
					Element::DEFAULT_VALUE => [

						'from' => "Contact <{$app->site->email}>",
						'subject' => 'Formulaire de contact',
						'template' => <<<EOT
Un message a été posté depuis le formulaire de contact :

E-Mail : #{@email}

#{@message}
EOT
					]
				])
			]
		];
	}
}
