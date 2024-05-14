<?php

namespace App\Enums\Social;

enum EventStatusEnum: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case PROGRESS = 'progress';

    case SUBMITTING = 'submitting';

    case EVALUATION = 'evaluation';

    case CLOSED = 'closed';
}
