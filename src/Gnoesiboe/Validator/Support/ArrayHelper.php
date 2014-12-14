<?php

namespace Gnoesiboe\Validator\Support;

/**
 * Class ArrayHelper
 */
final class ArrayHelper
{

    /**
     * @param array $input
     * @param array $keys
     *
     * @return array
     */
    public function ensureKeys(array $input, array $keys)
    {
        $input = new KeyValueBag($input);

        foreach ($keys as $key) {
            if ($input->has($key) === false) {
                $input->set($key, null);
            }
        }

        return $input->getData();
    }

    /**
     * @param array $input
     * @param array $defaults
     *
     * @return array
     */
    public function normalize(array $input, array $defaults)
    {
        $input = new KeyValueBag($input);
        $defaults = new KeyValueBag($defaults);

        $out = array();

        $defaults->each(function ($key, $defaultValue) use ($input, &$out) {
            /** @var string $key */
            /** @var mixed $defaultValue */

            $out[$key] = $input->has($key) === true ? $input->get($key) : $defaultValue;
        });

        return $out;
    }
}
