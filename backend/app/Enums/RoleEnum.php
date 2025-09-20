<?php

namespace App\Enums;

use App\Traits\EnumHelper;

enum RoleEnum: string
{
    use EnumHelper;

    case DEVELOPER = 'Developer';
    case DESIGNER = 'Designer';
    case TEAM_LEAD = 'Team Lead';
    case PROJECT_MANAGER = 'Project Manager';
    case QA_ENGINEER = 'QA Engineer';
}
