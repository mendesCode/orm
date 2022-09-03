<?php

namespace App\Helpers;

require_once __DIR__ . '/../../vendor/autoload.php';

use Doctrine\Inflector\Inflector;
use Doctrine\Inflector\InflectorFactory;
use Doctrine\Inflector\Language;

class Str
{
    /** @var Inflector The inflector instance */
    private static Inflector $inflector;

    /**
     * Get or set the inflector property
     *
     * @param string|null $language The language to be used by inflector
     * @return Inflector
     */
    public static function inflector(string $language = null): Inflector
    {
        if (isset(static::$inflector) && !$language) {
            return static::$inflector;
        }

        if (!$language) {
            $language = Language::ENGLISH;
        }

        static::$inflector = InflectorFactory::createForLanguage($language)->build();

        return static::$inflector;
    }

    /**
     * Converts $word to the format used by database tables
     *
     * @param string $word The model name to be tableized
     * @return string
     */
    public static function tableize(string $word): string
    {
        $plural = static::inflector()->pluralize($word);
        $table = preg_replace('/(?<=\\w)([A-Z])/u', '_$1', $plural);

        return mb_strtolower($table);
    }

    // TODO: must implement this method
    public static function classify(string $word): string
    {
        return '';
    }

    /**
     * Pluralizes $word
     *
     * @param string $word
     * @return string
     */
    public static function pluralize(string $word): string
    {
        return static::inflector()->pluralize($word);
    }

    /**
     * Singularizes $word
     *
     * @param string $word
     * @return string
     */
    public static function singularize(string $word): string
    {
        return static::inflector()->singularize($word);
    }
}
