<?php

namespace App\Enums;

enum UserRole: string
{
    case Agent = 'agent';
    case Coordinator = 'coordinator';
    case Viewer = 'viewer';
}
