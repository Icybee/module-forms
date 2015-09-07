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
use Icybee\Binding\PrototypedBindings;

class PopForm extends Element
{
	use PrototypedBindings;

	public function __toString()
	{
		$app = $this->app;

		try
		{
			$site = $app->site;
			$value = (int) $this['value'];

			$options = $app->models['forms']->select('nid, title')
			->where('nid = ? OR ((site_id = 0 OR site_id = ?) AND (language = "" OR language = ?))', $value, $site->site_id, $site->language)
			->order('title')
			->pairs;

			if (!$options)
			{
				$url = \Brickrouge\escape($app->site->path . '/admin/forms/new');

				return <<<EOT
<a href="$url" class="btn btn-info">Créer un premier formulaire...</a>
EOT;
			}

			if ($this->type == 'select')
			{
				$options = [ null => '' ] + $options;
			}

			$this[self::OPTIONS] = $options;
		}
		catch (\Exception $e)
		{
			return \Brickrouge\render_exception($e);
		}

		return parent::__toString();
	}
}
