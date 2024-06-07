<?php

namespace App\Models\Config;

class Menu extends \Pharaonic\Laravel\Menus\Models\Menu
{
    protected $connection = 'mysql';

    /**
     * Creates a new menu item in the specified section
     *
     * @param  string  $section  The section of the menu item
     * @param  mixed  $title  The title of the menu item. Can be either a string or an array for localization
     * @param  string  $url  The URL of the menu item
     * @param  string|int|null  $icon  The icon of the menu item (optional)
     * @param  int|null  $parent  The ID of the parent menu item (optional)
     * @param  int|bool  $sort  The sort order of the menu item (optional)
     * @param  bool  $visible  Determines if the menu item is visible (optional)
     * @return self The created menu item instance
     */
    public static function set(string $section, mixed $title, string $url, string|int|null $icon = null, ?int $parent = null, int|bool $sort = 0, bool $visible = true)
    {
        $menu = new self;
        $data = [
            'section' => $section,
            'url' => $url,
            'parent_id' => $parent,
            'sort' => $sort,
            'visible' => $visible,
            'icon' => $icon,
        ];

        $localKey = $menu->translationsKey ?? 'locale';

        if (is_array($title)) {
            $data[$localKey] = $title;
        } else {
            $data[$localKey][app()->getLocale()]['title'] = $title;
        }

        $menu->fill($data)->save();

        return $menu;
    }
}
