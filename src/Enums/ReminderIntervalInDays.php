<?php

namespace NoviasNet\Yousign\Enums;

enum ReminderIntervalInDays: int
{
    case OneDay = 1;
    case TwoDays = 2;
    case OneWeek = 7;
    case TwoWeeks = 14;
}
