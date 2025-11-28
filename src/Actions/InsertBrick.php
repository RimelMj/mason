<?php

namespace Awcodes\Mason\Actions;

use Awcodes\Mason\Mason;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Radio;
use Livewire\Component;
use Filament\Forms\Components\Actions\ButtonAction;

class InsertBrick
{
    public static function make(Mason $component, Component $livewire): ButtonAction
    {
        return ButtonAction::make('insertBrick')
            ->label(__('mason::mason.insert_brick'))
            ->modalWidth('sm')
            ->modalActionsAlignment('center')
            ->form([
                Select::make('name')
                    ->label('Brick')
                    ->placeholder('Select a brick')
                    ->options(fn() => collect($component->getBricks())
                        ->mapWithKeys(fn($brick) => [$brick->getName() => $brick->getLabel()])
                    )
                    ->searchable()
                    ->required(),
                Radio::make('position')
                    ->label('Position')
                    ->options([
                        'before' => 'Before',
                        'after' => 'After',
                    ])
                    ->inline()
                    ->default('after')
                    ->required()
            ])
            ->action(function (array $data) use ($component, $livewire) {
                $livewire->dispatch('handle-brick-insert', [
                    ...$data,
                    'statePath' => $component->getStatePath(),
                ]);
            });
    }
}
