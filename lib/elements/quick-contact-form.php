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
use Brickrouge\Text;

class QuickContactForm extends \Brickrouge\Form
{
	public function __construct(array $attributes=[])
	{
		parent::__construct(\ICanBoogie\array_merge_recursive($attributes, [

			self::RENDERER => 'Simple',

			Element::CHILDREN => [

				'email' => new Text([

					Element::LABEL_MISSING => 'Votre e-mail',
					Element::REQUIRED => true,
					Element::VALIDATOR => [ 'Brickrouge\Form::validate_email' ],

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
		global $core;

		$email = $core->user->email;

		return array
		(
			Element::CHILDREN => array
			(
				'config[destination]' => new Text
				(
					array
					(
						self::LABEL => 'Addresse de destination',
						Element::GROUP => 'config',
						Element::DEFAULT_VALUE => $email
					)
				),

				'config' => new \WdEMailNotifyElement
				(
					array
					(
						self::LABEL => 'Paramètres du message électronique',
						Element::GROUP => 'config',
						Element::DEFAULT_VALUE => array
						(
							'from' => "Contact <{$core->site->email}>",
							'subject' => 'Formulaire de contact',
							'template' => <<<EOT
Un message a été posté depuis le formulaire de contact :

E-Mail : #{@email}

#{@message}
EOT
						)
					)
				)
			)
		);
	}
}