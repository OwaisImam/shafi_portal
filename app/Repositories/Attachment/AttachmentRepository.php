<?php

namespace App\Repositories\Attachment;

use App\Models\Attachment;
use App\Repositories\BaseRepository;

class AttachmentRepository extends BaseRepository
{
    public function model(): string
    {
        return Attachment::class;
    }
}
