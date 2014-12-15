# validator

Alternative Laravel setup for validation using exceptions and constraint objects. You are obligated to use 
classes to define your constraints, to force the re-use of them. It tries to fix some of Laravel's validation
weaknesses.

## Usage

Define your constraints as objects, to be able to re-use them throughout your application.

```php

use Gnoesiboe\Validator\ConstraintInterface;

/**
 * Class UsernameConstraint
 */
final class UsernameConstraint implements ConstraintInterface
{

    /**
     * @return array
     */
    public function getValidatorIdentifiers()
    {
        return array(
            'not_empty_string',
            'string',
            'minimum_string_length:4'
        );
    }
}
```

And, for validating a group of fields at the same time (like when you are validating form input), use a `ConstraintSet`:

```php
use Gnoesiboe\Validator\ConstraintSetInterface;
use Gnoesiboe\Validator\Support\KeyValueBag;
use Gnoesiboe\Validator\ConstraintInterface;

/**
 * Class AccountRegisterConstraintSet
 */
final class AccountRegisterConstraintSet implements ConstraintSetInterface
{

    /**
     * @return ConstraintInterface[]|KeyValueBag
     */
    public function getConstraints()
    {
        return new KeyValueBag(array(
            'username' => new UsernameConstraint(),
            'password' => new PasswordConstraint(),
        ));
    }
}
```

And use it in your controller like this:

```php

// in controller

try {
    \ValidationManager::validateSet(\Input::all(), new AccountRegisterConstraintSet());
} catch (ValidationSetException $e) {
    // use the exception set (that contains individual exceptions for all errors) to build your response
}
```

Or you can catch the exceptions in your `global.php` for a more generic setup:

```php
// in controller

\ValidationManager::validateSet(\Input::all(), new AccountRegisterConstraintSet());
```

```php
// in global.php

App::error(function (Gnoesiboe\Validator\Exception\ValidationSetException $exception) {
    // build your response once and re-use it throughout your application
});
```
    
