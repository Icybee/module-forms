<?php

return [

	'patron.markups' => [

		/**
		 * @deprecated
		 */
		'feedback:form' => [

			'Icybee\Modules\Forms\Hooks::markup_form', [

				'select' => [ 'required' => true ]

			]
		],

		'form' => [

			'Icybee\Modules\Forms\Hooks::markup_form', [

				'select' => [ 'required' => true ]

			]
		]
	]
];
