<?php

namespace App\Repositories;

use App\Models\Attachment;

class AttachmentRepository extends BaseRepository
{
    public function model(): string
    {
        return Attachment::class;
    }
}
