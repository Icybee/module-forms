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

/**
 * Interface for forms that which to alter the notify parameters.
 */
interface AlterFormNotifyParams
{
	function alter_form_notify_params(NotifyParams $notify_params);
}