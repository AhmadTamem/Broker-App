<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class AdminsChart extends ChartWidget
{
    protected static ?string $heading = 'USERS';

    protected function getData(): array
    {
        $data = Trend::model(User::class)
            ->between(
                now()->startOfMonth(),
                now()->endOfMonth()
            )
            ->perDay()
            ->count();
    
        return [
            'datasets' => [
                [
                    'label' => 'Users',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }
    

    protected function getType(): string
    {
        return 'bar';
    }
}
