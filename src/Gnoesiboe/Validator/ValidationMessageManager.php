<?php

namespace Gnoesiboe\Validator;

use Gnoesiboe\Validator\Support\KeyValueBag\MessagesKeyValueBag;


/**
 * Class ValidationMessageManager
 */
final class ValidationMessageManager implements ValidationMessageManagerInterface
{

    /**
     * @var MessagesKeyValueBag
     */
    private $messages;

    /**
     * @inheritdoc
     */
    public function __construct()
    {
        $this->messages = new MessagesKeyValueBag();
    }

    /**
     * @param MessagesKeyValueBag $messages
     *
     * @return $this
     */
    public function setMessages(MessagesKeyValueBag $messages)
    {
        $this->messages = $messages;

        return $this;
    }

    /**
     * @param string $identifier
     * @param string $message
     *
     * @return $this
     */
    public function set($identifier, $message)
    {
        $this->messages->set($identifier, $message);

        return $this;
    }

    /**
     * @param string              $identifier
     * @param string              $default
     * @param MessagesKeyValueBag $replacements
     *
     * @return string
     */
    public function get($identifier, $default, MessagesKeyValueBag $replacements = null)
    {
        $this->validateIdentifier($identifier);

        $value = $this->messages->get($identifier, $default);

        return $replacements instanceof MessagesKeyValueBag ? $this->applyReplacements($value, $replacements) : $value;
    }

    /**
     * @param string              $value
     * @param MessagesKeyValueBag $replacements
     *
     * @return string
     */
    private function applyReplacements($value, MessagesKeyValueBag $replacements)
    {
        $keys = $replacements->getKeys();
        $values = $replacements->getValues();

        $keys = array_map(function ($key) {
            return $this->assureColonPrefix($key);
        }, $keys);

        return strtr($value, array_combine($keys, $values));
    }

    /**
     * @param string $key
     *
     * @return string
     */
    private function assureColonPrefix($key)
    {
        if (strpos($key, ')', 0) === false) {
            return ':' . $key;
        }
    }

    /**
     * @param string $identifier
     *
     * @throws \UnexpectedValueException
     */
    private function validateIdentifier($identifier)
    {
        if (is_string($identifier) === false) {
            throw new \UnexpectedValueException('Identifier should be of type string');
        }
    }
}
