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
use Brickrouge\Group;
use Brickrouge\Text;

class PressContactForm extends \Brickrouge\Form
{
	public function __construct($tags, $dummy=null)
	{
		parent::__construct(\ICanBoogie\array_merge_recursive($tags, [

			Element::CHILDREN => [

				'gender' => new Element(Element::TYPE_RADIO_GROUP, [

					self::LABEL => 'Gender',
					Element::OPTIONS => [ 'salutation.misses', 'salutation.miss', 'salutation.mister' ],
					Element::REQUIRED => true

				]),

				'lastname' => new Text([

					self::LABEL => 'Lastname',
					Element::REQUIRED => true

				]),

				'firstname' => new Text([

					self::LABEL => 'Firstname',
					Element::REQUIRED => true

				]),

				'media' => new Text([

					self::LABEL => 'Média'

				]),

				'email' => new Text([

					Group::LABEL => 'E-Mail',
					Element::REQUIRED => true,
					Element::VALIDATION => 'email'

				]),

				'subject' => new Text([

					Group::LABEL => 'Subject',
					Element::REQUIRED => true

				]),

				'message' => new Element('textarea', [

					Group::LABEL => 'Your message'

				])
			]
		]));
	}

	static public function get_defaults()
	{
		$app = \ICanBoogie\app();

		return [

			'notify_destination' => $app->user->email,
			'notify_bcc' => $app->user->email,
			'notify_from' => $app->site->email,
			'notify_subject' => 'Formulaire de contact presse',
			'notify_template' => <<<EOT
Un message a été posté depuis le formulaire de contact presse :

Nom : #{@gender.index('Mme', 'Mlle', 'M')} #{@lastname} #{@firstname}
Média : #{@media.or('N/C')}
E-Mail : #{@email}

Message :

#{@message}
EOT
		];
	}
}
