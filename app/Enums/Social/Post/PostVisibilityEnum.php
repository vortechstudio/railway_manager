<?php

namespace App\Enums\Social\Post;

enum PostVisibilityEnum: string
{
    case PUBLIC = 'public';

    case FRIENDS = 'friends';
}
