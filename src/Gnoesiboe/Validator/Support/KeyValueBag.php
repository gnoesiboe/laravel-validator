<?php

namespace Gnoesiboe\Validator\Support;

/**
 * Class KeyValueBag
 */
class KeyValueBag implements \Countable, \IteratorAggregate
{

    /**
     * @var array
     */
    private $data = array();

    /**
     * @param array $data
     */
    public function __construct(array $data = array())
    {
        $this->setData($data);
    }

    /**
     * @param array $values
     *
     * @return $this
     */
    public function setData(array $values)
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value);
        }

        return $this;
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    public function set($key, $value)
    {
        $this->validateKey($key);
        $this->validateValue($value, $key);

        $this->data[$key] = $value;

        return $this;
    }

    /**
     * @param string $value
     * @param string $key
     *
     * @throws \UnexpectedValueException
     */
    protected function validateValue($value, $key)
    {
        // override to add implementation
    }

    /**
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return $this->has($key) === true ? $this->data[$key] : $default;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        $this->validateKey($key);

        return array_key_exists($key, $this->data);
    }

    /**
     * @return array
     */
    public function getKeys()
    {
        return array_keys($this->data);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return array_values($this->data);
    }

    /**
     * @param callable $callback
     *
     * @return $this
     */
    public function each(\Closure $callback)
    {
        foreach ($this->data as $key => $value) {
            $callback($key, $value);
        }

        return $this;
    }

    /**
     * @param string $key
     *
     * @throws \UnexpectedValueException
     */
    private function validateKey($key)
    {
        if (is_string($key) === false) {
            throw new \UnexpectedValueException('Key should be of type string');
        }
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->data);
    }
}
