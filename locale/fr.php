<?php

return [

	'section.title' => [

		'messages' => "Messages accompagnant le formulaire",
		'notify' => "Options de notification",
		'operation' => "Opération et configuration"

	],

	'forms' => [

		'count' => [

			'none' => 'Aucun formulaire',
			'one' => 'Un formulaire',
			'other' => ':count formulaires'

		],

		'name' => [

			'one' => 'Formulaire',
			'other' => 'Formulaires'

		]

	],

	'forms.edit' => [

		'element.label' => [

			'modelid' => 'Modèle du formulaire',
			'pageid' => "Page sur laquelle s'affiche le formulaire",
			'before' => "Message précédant le formulaire",
			'after' => "Message suivant le formulaire",
			'complete' => "Message de remerciement"

		],

		'element.description' => [

			'complete' => "Il s'agit du message affiché une fois le formulaire posté avec succés."

		],

		'default.complete' => 'Votre message a été envoyé',
		'Default values' => "Valeurs par défaut",
		'description_notify' => "Le sujet du message et le corps du message sont formatés
		par :link, utilisez ses fonctionnalités avancées pour les personnaliser."

	],

	'label' => [

		'is_notify' => "Activer la notification",
		'notify_destination' => "Adresse de destination",
		'notify_from' => "Adresse d'expédition",
		'notify_bcc' => "Copie cachée",
		'notify_subject' => "Sujet du message",
		'notify_template' => "Patron du message"

	],

	'description' => [

		'is_notify' => "Cette option déclenche l'envoi d'un email lorsqu'un formulaire est posté
		avec succès."

	],

	'manager.label' => [

		'modelid' => 'Modèle',
		'subject' => 'Objet'

	],

	'module_title.forms' => 'Formulaires',

	#
	# forms.contact
	#

	'Company' => 'Société',
	'Your message' => 'Votre message'

];
