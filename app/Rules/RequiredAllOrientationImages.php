<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RequiredAllOrientationImages implements Rule
{

    public function passes($attribute, $value): bool
    {
        $countOrientations = 0;
        // TODO : improvement way to validate this
        $orientations = ['front' => 'front', 'side' => 'side', 'perspective' => 'perspective', 'plan' => 'plan'];
        collect($value)
            ->pluck('orientation')
            ->each(function ($orientation) use (&$countOrientations, $orientations) {
                $countOrientations += isset($orientations[$orientation]) ? 1 : 0;
            });

        return $countOrientations == count($orientations);
    }

    public function message(): string
    {
        $messages = [
            'es' => 'No se han subido todas las orientaciones de las imagenes',
            'en' => 'Not all image orientations have been uploaded',
        ];

        return $messages[app()->getLocale()];
    }
}
