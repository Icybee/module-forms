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

			Model::EXTENDING => 'nodes',
			Model::SCHEMA => [

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
	],

	Descriptor::NS => __NAMESPACE__,
	Descriptor::PERMISSIONS => [

		'post form'

	],

	Descriptor::REQUIRES => [ 'editor' ],
	Descriptor::TITLE => "Forms"

];
