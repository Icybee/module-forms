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

use ICanBoogie;

$hooks = Hooks::class . '::';

return [

	ICanBoogie\Operation::class . '::get_form' => $hooks . 'on_operation_get_form'

];
