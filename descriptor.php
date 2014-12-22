<?php

namespace Icybee\Modules\Forms;

use ICanBoogie\ActiveRecord\Model;
use ICanBoogie\Module\Descriptor;

return [

	Descriptor::ID => 'forms',
	Descriptor::CATEGORY => 'feedback',
	Descriptor::DESCRIPTION => 'Create forms based on models',
	Descriptor::INHERITS => 'nodes',
	Descriptor::MODELS => [

		'primary' => [

			Model::T_EXTENDS => 'nodes',
			Model::T_SCHEMA => [

				'fields' => [

					'modelid' => [ 'varchar', 64 ],

					'before' => 'text',
					'after' => 'text',
					'complete' => 'text',

					'is_notify' => 'boolean',
					'notify_destination' => 'varchar',
					'notify_from' => 'varchar',
					'notify_bcc' => 'varchar',
					'notify_subject' => 'varchar',
					'notify_template' => 'text',

					'pageid' => 'foreign'

				]
			]
		]
	],

	Descriptor::NS => __NAMESPACE__,
	Descriptor::PERMISSIONS => [

		'post form'

	],

	Descriptor::REQUIRES => [

		'editor' => '1.0'

	],

	Descriptor::TITLE => 'Forms',
	Descriptor::VERSION => '1.0'
];
