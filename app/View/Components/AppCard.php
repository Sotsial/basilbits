<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AppCard extends Component
{
    public $title;
    public $platform;
    public $images;
    public $description;
    public $monetization;
    public $type;
    public $lastMonthProfit;
    public $lastYearProfit;
    public $age;
    public $installs;
    public $price;

    public function __construct(
        string $title,
        array $platform,
        array $images,
        string $description,
        string $monetization,
        string $type,
        string $lastMonthProfit,
        string $lastYearProfit,
        string $age,
        string $installs,
        float $price
    ) {
        $this->title = $title;
        $this->platform = $platform;
        $this->images = $images;
        $this->description = $description;
        $this->monetization = $monetization;
        $this->type = $type;
        $this->lastMonthProfit = $lastMonthProfit;
        $this->lastYearProfit = $lastYearProfit;
        $this->age = $age;
        $this->installs = $installs;
        $this->price = $price;
    }

    public function render()
    {
        return view('components.app-card');
    }
}
