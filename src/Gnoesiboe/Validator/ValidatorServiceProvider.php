<?php namespace Gnoesiboe\Validator;

use Gnoesiboe\Validator\Support\KeyValueBag\MessagesKeyValueBag;
use Gnoesiboe\Validator\Support\KeyValueBag\ValidatorConstructorKeyValueBag;
use Gnoesiboe\Validator\Validator\IntegerValidator;
use Gnoesiboe\Validator\Validator\MinimumIntegerValueValidator;
use Gnoesiboe\Validator\Validator\MinimumStringLengthValidator;
use Gnoesiboe\Validator\Validator\NotEmptyStringValidator;
use Gnoesiboe\Validator\Validator\StringValidator;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

/**
 * Class ValidatorServiceProvider
 */
final class ValidatorServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerManager();
        $this->registerMessageManager();
    }

    private function registerManager()
    {
        $this->app['validation_manager'] = $this->app->share(function (Application $app) {
            $validatorManager = $app->make(ValidationManager::getClass());

            $this->registerStandardValidators($validatorManager);

            return $validatorManager;
        });
    }

    private function registerMessageManager()
    {
        $this->app['gnoesiboe.validator.validation_message_manager'] = $this->app->share(function () {
            $messageManager = new ValidationMessageManager();

            $this->registerDefaultMessages($messageManager);

            return $messageManager;
        });

        $this->app->bind(
            'Gnoesiboe\Validator\ValidationMessageManagerInterface',
            'gnoesiboe.validator.validation_message_manager'
        );
    }

    /**
     * @param ValidationMessageManager $messageManager
     */
    private function registerDefaultMessages(ValidationMessageManager $messageManager)
    {
        $messageManager
            ->setMessages(new MessagesKeyValueBag(array(
                'not_a_string' => 'De waarde voor het veld \':field\' is geen string'
            )));
    }

    /**
     * @param ValidationManager $validationManager
     */
    private function registerStandardValidators(ValidationManager $validationManager)
    {
        $validationManager->register('integer', function () {
            return new IntegerValidator();
        });

        $validationManager->register('string', function ($app) {
            return $this->app->make(StringValidator::getClass());
        });

        $validationManager->register('minimum_integer', function () {
            return new MinimumIntegerValueValidator();
        });

        $validationManager->register('minimum_string_length', function () {
            return new MinimumStringLengthValidator();
        });

        $validationManager->register('not_empty_string', function () {
            return new NotEmptyStringValidator();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array(
            'validation_manager'
        );
    }
}
