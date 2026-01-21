<?php

namespace App\Filament\Resources\Posts\Schemas;

use Date;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Post Details')
                    ->description('Enter the details of the post here.')
                    ->schema([
                        Group::make()->schema([
                            TextInput::make('title')
                                ->rules('required|min:3|max:10')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('slug')
                                ->unique()
                                ->maxLength(255)
                                ->validationMessages([
                                    'unique' => 'The slug must be unique.',
                                ]),
                            Select::make('category_id')
                                ->label('Category')
                                ->relationship('category', 'name')
                                ->required(),
                            ColorPicker::make('color'),
                        ])->columns(2),
                        MarkdownEditor::make('body')
                            ->label('Content')
                            ->required(),
                    ])->columnSpan(2)
                ,
                Group::make()->schema([
                    Section::make('Image Upload')
                        ->schema([
                            FileUpload::make('image')
                                ->label(' ')
                                ->disk('public')
                                ->directory('posts/images'),
                        ]),
                    Section::make('Meta')
                        ->schema([
                            TagsInput::make('tags')
                                ->label('Tags'),
                            Checkbox::make('is_published')
                                ->label('Published')
                                ->default(false),
                            DatePicker::make('published_at')
                                ->label('Published At')
                        ])
                ])->columnSpan(1),
            ])->columns(3);
    }
}
