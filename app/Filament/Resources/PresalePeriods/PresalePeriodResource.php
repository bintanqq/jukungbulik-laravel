<?php

namespace App\Filament\Resources\PresalePeriods;

use App\Filament\Resources\PresalePeriods\Pages\CreatePresalePeriod;
use App\Filament\Resources\PresalePeriods\Pages\EditPresalePeriod;
use App\Filament\Resources\PresalePeriods\Pages\ListPresalePeriods;
use App\Filament\Resources\PresalePeriods\Schemas\PresalePeriodForm;
use App\Filament\Resources\PresalePeriods\Tables\PresalePeriodsTable;
use App\Models\PresalePeriod;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PresalePeriodResource extends Resource
{
    protected static ?string $model = PresalePeriod::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationLabel = 'Periode Presale';
    protected static ?string $modelLabel = 'Periode Presale';
    protected static ?string $pluralModelLabel = 'Periode Presale';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return PresalePeriodForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PresalePeriodsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPresalePeriods::route('/'),
        ];
    }
}
