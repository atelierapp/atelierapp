<?php

namespace App\Services;

use App\Models\Tag;

class TagService
{
    public function getTag(string $tag): Tag
    {
        return Tag::updateOrCreate(['name' => $tag]);
    }
}
