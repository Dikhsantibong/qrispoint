<?php

namespace App\Enums;

enum UserRole: string
{
    case Agent = 'agent';
    case Coordinator = 'coordinator';
    case DataCoordinator = 'data_coordinator';
    case Viewer = 'viewer';
}
