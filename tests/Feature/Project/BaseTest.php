<?php

namespace Tests\Feature\Project;

use App\Models\Product;
use App\Models\Store;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

abstract class BaseTest extends TestCase
{
    use AdditionalAssertions;

    public static function structure(): array
    {
        return [
            'id',
            'name',
            'style_id',
            'author_id',
            'published',
            'public',
            'image',
            'created_at',
            'updated_at',
            'forkedFrom',
            'tags',
            'settings',
        ];
    }

    public static function structureStyle(): array
    {
        return [
            'style' => [
                'id',
                'code',
                'name',
                'image',
            ],
        ];
    }

    public static function structureAuthor(): array
    {
        return [
            'author' => [
                'id',
                'first_name',
                'last_name',
                'email',
                'username',
                'phone',
                'birthday',
                'avatar',
                'is_active',
            ],
        ];
    }
}
