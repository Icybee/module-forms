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

class ContactForm extends Form
{
	public function __construct(array $attributes=[])
	{
		parent::__construct(\ICanBoogie\array_merge_recursive($attributes, [

			self::RENDERER => Form\GroupRenderer::class,

			Element::CHILDREN => [

				'gender' => new Element(Element::TYPE_RADIO_GROUP, [

					Group::LABEL => 'Salutation',
					Element::OPTIONS => [ 'salutation.Misses', 'salutation.Mister' ],
					Element::REQUIRED => true,

					'class' => 'inline-inputs'

				]),

				'firstname' => new Text([

					Group::LABEL => 'Firstname',
					Element::REQUIRED => true

				]),

				'lastname' => new Text([

					Group::LABEL => 'Lastname',
					Element::REQUIRED => true

				]),

				'company' => new Text([

					Group::LABEL => 'Company'

				]),

				'email' => new Text([

					Group::LABEL => 'E-mail',
					Element::REQUIRED => true,
					Element::VALIDATION => 'email'

				]),

				'message' => new Element('textarea', [

					Group::LABEL => 'Your message',
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
