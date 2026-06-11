<?php

namespace NoviasNet\Yousign\Enums;

enum EmailSenderType: string
{
    case Organization = 'organization';
    case Workspace = 'workspace';
    case User = 'user';
    case Custom = 'custom';
}
