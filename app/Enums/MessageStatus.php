<?php

namespace App\Enums;

enum MessageStatus: string
{
    case SENT = 'sent';
    case DELIVERED = 'delivered';
    case READ = 'read';
    case FAILED = 'failed';
}
