<?php

namespace App\Filament\Resources\Products\Schemas;

use Dom\Text;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\Action;


class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make("Product Info")
                        ->icon(Heroicon::InformationCircle)
                        ->description('Enter the product information here.')
                        ->schema([
                            Group::make()->schema([
                                TextInput::make("name")
                                    ->required(),
                                TextInput::make("sku")
                            ])->columns(2),

                            MarkdownEditor::make("description"),
                        ]),
                    Step::make("Pricing")
                        ->description('Set the pricing and stock details.')
                        ->schema([
                            Group::make()->schema([
                                TextInput::make("price"),
                                TextInput::make("stock")
                            ])->columns(2)
                        ]),
                    Step::make("Media & Status")
                        ->description('Upload product images and set status.')
                        ->schema([
                            FileUpload::make("image")
                                ->disk('public')
                                ->directory('products/images'),
                            Checkbox::make("is_active"),
                            Checkbox::make("is_featured")
                        ])
                ])
                    ->columnSpanFull()
                    ->skippable()
                    ->submitAction(
                        Action::make("save")
                            ->label("Save Product")
                            ->icon(Heroicon::CheckCircle)
                            ->button()
                            ->submit("save")
                    )
            ]);
    }
}
