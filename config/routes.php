<?php

namespace Icybee\Modules\Forms;

use ICanBoogie\HTTP\Request;
use Icybee\Routing\RouteMaker as Make;

return Make::admin('forms', Routing\FormsAdminController::class, [

	'id_name' => 'nid'

]);
