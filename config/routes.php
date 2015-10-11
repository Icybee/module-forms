<?php

namespace Icybee\Modules\Forms\Routing;

use Icybee\Routing\RouteMaker as Make;

return Make::admin('forms', FormsAdminController::class, [

	Make::OPTION_ID_NAME => 'nid',
	Make::OPTION_EXCEPT => Make::ACTION_CONFIG

]);
