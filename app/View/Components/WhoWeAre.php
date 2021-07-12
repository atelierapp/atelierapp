<?php

namespace App\View\Components;

use Illuminate\View\Component;

class WhoWeAre extends Component
{
    public array $team;

    public function __construct()
    {
        $this->team = [
            [
                'name' => 'Andrea Orrego',
                'position' => 'CEO & Co-founder',
                'biography' => '3rd Generation Architect with vast experience in the field of residential design and 1-1 client-assessment',
                'image' => 'images/team/andrea.png',
            ],
            [
                'name' => 'JUNIOR QUEVEDO',
                'position' => 'CTO & Co-founder',
                'biography' => 'Software engineer specialized in mobile development and 3D technologies',
                'image' => 'images/team/junior.png',
            ],
            [
                'name' => 'Kenny Horna',
                'position' => 'COO & Co-founder',
                'biography' => 'Software engineer with a focus on planning, strategy, and brand and product alignment',
                'image' => 'images/team/kenny.png',
            ],
            [
                'name' => 'María Fernanda Pacheco',
                'position' => 'Creativity and Art Director',
                'biography' => 'Creative with a background in architecture, interior design, and  exhibition and experience design',
                'image' => 'images/team/mafer.png',
            ],
            [
                'name' => 'Yanise Orrego',
                'position' => 'UI/UX & Brand Design',
                'biography' => 'Graphic designer with experience creating mobile and web interfaces, as well as brand identities',
                'image' => 'images/team/yanise.png',
            ],
            [
                'name' => 'Ingle',
                'position' => 'Emotional Support Director',
                'biography' => 'Woof woof woof, woof woof woof. Woof!',
                'image' => 'images/team/ingle.png',
            ],
        ];
    }

    public function render()
    {
        return view('components.who-we-are');
    }
}
