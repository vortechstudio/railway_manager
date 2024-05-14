<?php

namespace App\Enums\Social;

enum ArticleTypeEnum: string
{
    case NOTICE = 'notice';

    case EVENT = 'event';

    case NEWS = 'news';

    case SSO = 'auth';
}
