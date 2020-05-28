<?php

namespace BelkinDom\UseCase\Web;

use BelkinDom\Adapters\Instagram\Client as Instagram;

class GetInstagramRecentPostsUseCase
{
    /**
     * @var Instagram
     */
    private $instagram;

    public function __construct(Instagram $instagram)
    {
        $this->instagram = $instagram;
    }

    /**
     * @param int $limit
     *
     * @return array
     */
    public function execute(int $limit = 4)
    {
        try {
            $response = $this->instagram->getRecentMedia($limit);
            $result = [];

            if (property_exists($response, 'data') && is_array($response->data)) {
                foreach ($response->data as $post) {
                    $result[] = $post->images->low_resolution->url;
                }
            }

            return $result;
        } catch (\Exception $x) {
            return [];
        }
    }
}
