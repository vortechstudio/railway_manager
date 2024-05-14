<?php

namespace App\Enums\Social\Post;

enum PostTypeEnum: string
{
    case TEXT = 'text';

    case IMAGE = 'image';

    case VIDEO = 'video';
}
