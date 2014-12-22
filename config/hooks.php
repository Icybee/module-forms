<?php

return [

	'events' => [

		'ICanBoogie\Operation::get_form' => 'Icybee\Modules\Forms\Hooks::on_operation_get_form'

	],

	'patron.markups' => [

		'feedback:form' => [

			'Icybee\Modules\Forms\Hooks::markup_form', [

				'select' => [ 'required' => true ]

			]
		]
	]
];
