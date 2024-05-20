<?php

namespace App\Repositories;

use App\Models\Attachment;
use App\Repositories\BaseRepository;

class AttachmentRepository extends BaseRepository
{
    public function model(): string
    {
        return Attachment::class;
    }
}