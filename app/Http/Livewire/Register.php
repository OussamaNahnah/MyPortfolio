<?php

namespace App\Http\Livewire;

use Filament\Forms;
use JeffGreco13\FilamentBreezy\FilamentBreezy;
use JeffGreco13\FilamentBreezy\Http\Livewire\Auth\Register as FilamentBreezyRegister;
use Illuminate\Support\Facades\Hash;

class Register extends FilamentBreezyRegister
{
    // Define the new attributes
    public $username;

    public $email;

    public $password;
    public $fullname;

    // Override the getFormSchema method and merge the default fields then add your own.
    protected function getFormSchema(): array
    {
        return array_merge([ Forms\Components\TextInput::make('fullname')
        ->label('fullname')
        ->required()
        ->string()
        ->minLength(4)
        ->maxLength(255)
       ,
            Forms\Components\TextInput::make('username')
            ->label('username')
            ->required()
            ->string()
            ->minLength(4)
            ->maxLength(255)
            ->unique(ignoreRecord: true),
            Forms\Components\TextInput::make('email')
                ->label(__('filament-breezy::default.fields.email'))
                ->required()
                ->email()
                ->unique(table: config('filament-breezy.user_model')),
            Forms\Components\TextInput::make('password')
                ->label(__('filament-breezy::default.fields.password'))
                ->required()
                ->password()
                ->string()
                ->minLength(6)
                ->maxLength(255)
                //->rules(app(FilamentBreezy::class)->getPasswordRules())
                ,
            Forms\Components\TextInput::make('password_confirm')
                ->label(__('filament-breezy::default.fields.password_confirm'))
                ->required()
                ->password()
                ->same('password'),
        ],
        );
    }

   // Use this method to modify the preparedData before the register() method is called.
    protected function prepareModelData($data): array
    {
        //$preparedData = parent::prepareModelData($data);
        $preparedData['username'] = $this->username;
        $preparedData['email'] = $this->email;
        $preparedData['password'] =Hash::make($this->password) ;
        $preparedData['fullname'] = $this->fullname;

        return $preparedData;
    }
 /*
    // Optionally, you can override the entire register() method to customize exactly what happens at registration
    public function register()
    {
        $preparedData = $this->prepareModelData($this->form->getState());
        $team = Team::create(["name" => $preparedData["team_name"]]);
        unset($preparedData["team_name"]);

    }
    */
}
