<?php

namespace Awcodes\Mason\Actions;

use Awcodes\Mason\Mason;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Radio;
use Livewire\Component;
use Filament\Actions\Action as ButtonAction;

class InsertBrick
{
    public static function make(): ButtonAction
    {
        return ButtonAction::make('insertBrick')
            ->label(__('mason::mason.insert_brick'))
            ->modalWidth('sm')
            ->modalActionsAlignment('center')
            ->form(function (Mason $component) {
                return [
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
                        ->extraAttributes(['style' => 'margin-bottom: 1rem;']),
                ];
            })
            ->action(function (Mason $component, Component $livewire, array $data, array $arguments) {
                $livewire->dispatch('handle-brick-insert', [
                    ...$data,
                    'statePath' => $component->getStatePath(),
                    'editorSelection' => $arguments['editorSelection'] ?? null,
                ]);
            });
    }
}
