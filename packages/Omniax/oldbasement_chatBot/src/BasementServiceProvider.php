<?php

declare(strict_types=1);

namespace Omniax\basement_chatBot;

use App\Models\User;
use Omniax\basement_chatBot\Actions\AllContacts;
use Omniax\basement_chatBot\Actions\AllPrivateMessages;
use Omniax\basement_chatBot\Actions\MarkPrivatesMessagesAsRead;
use Omniax\basement_chatBot\Actions\SendPrivateMessage;
use Omniax\basement_chatBot\Console\InstallCommand;
use Omniax\basement_chatBot\Contracts\Basement as BasementContract;
use Omniax\basement_chatBot\Models\PrivateMessage;
use Omniax\basement_chatBot\Observers\PrivateMessageObserver;
use Omniax\basement_chatBot\View\Components\ChatBox;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Omniax\basement_chatBot\Bots\MyBot;
use Omniax\basement_chatBot\Services\BotService;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class BasementServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('basement')
            ->hasConfigFile()
            ->hasMigration('create_private_messages_table')
            ->hasRoutes(['api', 'channels'])
            ->hasViews()
            ->hasCommand(InstallCommand::class);

            $this->app->bind(BotService::class, MyBot::class);
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        parent::register();

        $this->app->singleton(abstract: BasementContract::class, concrete: static fn (): Basement => new Basement());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();

        $this->configurePublishableFiles();
        $this->configureModels();
        $this->configureActions();
        $this->configureRouteModelBindings();
        $this->configureBladeComponents();
    }

    /**
     * Configure the list of publishable files.
     */
    protected function configurePublishableFiles(): void
    {
        if ($this->app->runningInConsole() === false) {
            return;
        }

        $this->publishes(paths: [
            __DIR__ . '/../dist/basement.bundle.min.css' => public_path('vendor/basement/basement.bundle.min.css'),
            __DIR__ . '/../dist/basement.bundle.min.js' => public_path('vendor/basement/basement.bundle.min.js'),
            __DIR__ . '/../dist/basement.bundle.min.js.map' => public_path('vendor/basement/basement.bundle.min.js.map'),
        ], groups: 'basement-assets');
    }

    /**
     * Configure models used by the package.
     */
    protected function configureModels(): void
    {
        Basement::useUserModel(config(key: 'basement.user_model', default: User::class));
        Basement::usePrivateMessageModel(PrivateMessage::class);

        PrivateMessage::observe(PrivateMessageObserver::class);
    }

    /**
     * Configure how the application actions are resolved.
     */
    protected function configureActions(): void
    {
        Basement::allContactsUsing(AllContacts::class);
        Basement::allPrivateMessagesUsing(AllPrivateMessages::class);
        Basement::markPrivateMessagesAsReadUsing(MarkPrivatesMessagesAsRead::class);
        Basement::sendPrivateMessagesUsing(SendPrivateMessage::class);
    }

    /**
     * Configure how parameters in the controller application are resolved.
     */
    protected function configureRouteModelBindings(): void
    {
        Route::bind('contact', static fn (string|int $value) => Basement::newUserModel()->findOrFail($value));
    }

    /**
     * Register the package blade view components.
     */
    protected function configureBladeComponents(): void
    {
        Blade::component('basement::chat-box', ChatBox::class);
    }
}
