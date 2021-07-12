<?php

namespace App\View\Components;

use Closure;
use GuzzleHttp\Client;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LatestPosts extends Component
{
    public $posts;

    public function __construct()
    {
        $client = new Client();
        $result = $client->request(
            'GET',
            'https://medium.com/@info_38937/latest',
            [
                'query' => [
                    'format' => 'json',
                ],
            ],
        )->getBody()->getContents();

        $posts = explode('])}while(1);</x>', $result);
        $posts = json_decode(implode('', $posts), true);

        $this->posts = $posts['payload']['posts'];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render()
    {
        return view('components.latest-posts');
    }
}
