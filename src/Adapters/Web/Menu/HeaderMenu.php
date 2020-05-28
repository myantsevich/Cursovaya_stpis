<?php

namespace BelkinDom\Adapters\Web\Menu;

class HeaderMenu
{
    const
        ABOUT = 'about',
        STORE = 'store',
        BLOG = 'blog',
        FAQ = 'faq',
        CONTACT = 'contact',
        REVIEWS = 'reviews',
        PARTNERS = 'partners',
        CART = 'cart'
    ;

    /**
     * @var array
     */
    private $items;

    /**
     * @var string
     */
    private $currentItem;

    public function __construct()
    {
        $this->currentItem = self::ABOUT;
        $this->items = [
            self::ABOUT => [
                'id' => self::ABOUT,
                'title' => 'menu.items.about_us',
                'path' => 'front_index',
            ],
            self::STORE => [
                'id' => self::STORE,
                'title' => 'menu.items.store',
                'path' => 'front_store',
            ],
            self::BLOG => [
                'id' => self::BLOG,
                'title' => 'menu.items.blog',
                'path' => 'front_blog',
            ],
            self::FAQ => [
                'id' => self::FAQ,
                'title' => 'menu.items.faq',
                'path' => 'front_faq',
            ],
            self::CONTACT => [
                'id' => self::CONTACT,
                'title' => 'menu.items.contacts',
                'path' => 'front_contact',
            ],
            self::REVIEWS => [
                'id' => self::REVIEWS,
                'title' => 'menu.items.feedback',
                'path' => 'front_reviews',
            ],
            self::PARTNERS => [
                'id' => self::PARTNERS,
                'title' => 'menu.items.partners',
                'path' => 'front_partners',
            ],
        ];
    }

    /**
     * @param string $key
     */
    public function updateCurrentItem(string $key)
    {
        $this->currentItem = $key;
    }

    /**
     * @return array
     */
    public function items(): array
    {
        return $this->items;
    }

    /**
     * @return string
     */
    public function currentItem(): string
    {
        return $this->currentItem;
    }
}
