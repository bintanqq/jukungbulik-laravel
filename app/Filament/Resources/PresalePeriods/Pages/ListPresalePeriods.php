<?php

namespace App\Filament\Resources\PresalePeriods\Pages;

use App\Filament\Resources\PresalePeriods\PresalePeriodResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPresalePeriods extends ListRecords
{
    protected static string $resource = PresalePeriodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
