window.addEvent('domready', function() {

	var toggle = document.id(document.body).getElement('[name="is_notify"]')
	, toggleContainer = null

	function checkToggle()
	{
		toggleContainer[toggle.checked ? 'addClass' : 'removeClass']('enabled')
	}

	if (toggle)
	{
		toggleContainer = toggle.getParent('.form-group')
		toggleContainer.addClass('group-description')

		toggle.addEvent('change', checkToggle)

		checkToggle()
	}

	var block = document.getElement('.block-edit--forms')

	if (!block) return

	var form = block.getElement('form')
	, modelidControl = document.id(form.modelid)

	function getDefaults(id)
	{
		new Request.API({

			url: 'forms/' + id + '/defaults',

			onSuccess: function(response)
			{
				Object.each(response.rc, function(value, name) {

//					console.log('name: ', name, value)

					if (!form[name]) return

					form[name].set('data-default-value', value)
				})
			}

		}).get()
	}

	modelidControl.addEvent('change', function(ev) {

		getDefaults(modelidControl.value)

	})

	if (modelidControl.value)
	{
		getDefaults(modelidControl.value)
	}

})
