<?php

namespace Gnoesiboe\Validator;

use Gnoesiboe\Validator\Support\KeyValueBag;
use Gnoesiboe\Validator\Support\KeyValueBag\MessagesKeyValueBag;

/**
 * Interface ValidationMessageManagerInterface
 */
interface ValidationMessageManagerInterface
{

    /**
     * @param MessagesKeyValueBag $messages
     *
     * @return $this
     */
    public function setMessages(MessagesKeyValueBag $messages);

    /**
     * @param string $identifier
     * @param string $message
     *
     * @return $this
     */
    public function set($identifier, $message);

    /**
     * @param string              $identifier
     * @param string              $default
     * @param MessagesKeyValueBag $replacements
     *
     * @return string
     */
    public function get($identifier, $default, MessagesKeyValueBag $replacements = null);
}
