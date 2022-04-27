<?php

namespace App\Services;

class ProductService
{
    private string $path = 'stores';

    public function __construct(private MediaService $mediaService)
    {
        //
    }

}
