<?php

namespace App\Enums;

enum TransactionSource: string
{
    case AgentManual = 'agent_manual';
    case ImportPjp = 'import_pjp';
}
