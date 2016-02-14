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

class ContactForm extends \Brickrouge\Form
{
	public function __construct(array $attributes=[])
	{
		parent::__construct(\ICanBoogie\array_merge_recursive($attributes, [

			self::RENDERER => \Brickrouge\Form\GroupRenderer::class,

			Element::CHILDREN => [

				'gender' => new Element(Element::TYPE_RADIO_GROUP, [

					self::LABEL => 'Salutation',
					Element::OPTIONS => [ 'salutation.Misses', 'salutation.Mister' ],
					Element::REQUIRED => true,

					'class' => 'inline-inputs'

				]),

				'firstname' => new Text([

					self::LABEL => 'Firstname',
					Element::REQUIRED => true

				]),

				'lastname' => new Text([

					self::LABEL => 'Lastname',
					Element::REQUIRED => true

				]),

				'company' => new Text([

					self::LABEL => 'Company'

				]),

				'email' => new Text([

					self::LABEL => 'E-mail',
					Element::REQUIRED => true,
					Element::VALIDATOR => [ 'Brickrouge\Form::validate_email' ]

				]),

				'message' => new Element('textarea', [

					self::LABEL => 'Your message',
					Element::REQUIRED => true

				])
			]
		]));
	}

	static public function get_defaults()
	{
		$app = \ICanBoogie\app();
		$p = \Patron\Engine::PREFIX;

		return array
		(
			'notify_destination' => $app->user->email,
			'notify_from' => 'Contact <no-reply@' . preg_replace('#^www#', '', $_SERVER['SERVER_NAME']) .'>',
			'notify_subject' => 'Formulaire de contact',
			'notify_template' => <<<EOT
Un message a été posté depuis le formulaire de contact :

Nom : #{@gender.index('Mme', 'Mlle', 'M')} #{@lastname} #{@firstname}
<{$p}if test="@company">Société : #{@company}</{$p}if>
E-Mail : #{@email}

Message : #{@message}
EOT
		);
	}
}
