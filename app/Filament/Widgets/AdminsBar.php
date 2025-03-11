<?php

namespace App\Filament\Widgets;

use App\Models\Ad;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class AdminsBar extends ChartWidget
{
    protected static ?string $heading = 'Ads';

    protected function getData(): array
    {
        $data = Trend::model(Ad::class)
            ->between(
                now()->startOfMonth(),
                now()->endOfMonth()
            )
            ->perDay()
            ->count();
    
        return [
            'datasets' => [
                [
                    'label' => 'Ads',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
