<?php

namespace App\Services;

class ViewStateController
{
    public $navItemActive;

    private $breadcrumb = [];

    public function breadcrumbPush($label, $url)
    {
        $this->breadcrumb[] = [
            'label' => $label,
            'url' => $url,
            'isActive' => false,
        ];
    }

    public function breadcrumbPushActive($label)
    {
        $this->breadcrumb[] = [
            'label' => $label,
            'isActive' => true,
        ];
    }

    public function getBreadcrumbs()
    {
        return $this->breadcrumb;
    }

    public function activeNavItemMatch($match = '', $term = 'active')
    {
        if ($this->navItemActive == $match) {
            return $term;
        }
        return null;
    }
}
