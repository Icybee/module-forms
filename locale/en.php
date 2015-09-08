<?php

return [

	'editor_title.form' => 'Form',

	'forms' => [

		'edit_block' => [

			'element.description.complete' => "This is the message displayed once the form is posted successfully.",

			'default.complete' => 'Your message has been sent',
			'Default values' => "Default values",
			'description_notify' => "The message subject and body of the message are formatted by :link."

		],

		'manage.column' => [

			'modelid' => 'Model type'

		],

		'permission' => [

			'post form' => 'Post form'

		]

	],

	'forms.edit_block.group.label' => [

		'modelid' => 'Form model',
		'page_id' => "Page that displays the form",
		'before' => "Message before the form",
		'after' => "Message after the form",
		'complete' => "Message of thanks"

		],

	'group.legend' => [

		'messages' => "Messages with the form",
		'notify' => "Notify options",
		'operation' => "Opération et configuration"

	],

	'description' => [

		'is_notify' => "This option triggers the sending of an email when a form is posted successfully."

	],

	'manage.title' => [

		'modelid' => 'Model',
		'subject' => 'Subject'

	],

	'module_title.forms' => 'Forms',

	#
	# EmailComposer
	#

	'label' => [

		'is_notify' => "Enable notification",
		'email_destination' => "Destination address",
		'email_from' => "Sender address",
		'email_bcc' => "Blind copy",
		'email_subject' => "Object",
		'email_template' => "Template"

	]

];
