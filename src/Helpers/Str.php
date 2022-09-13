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
     * Convert $word to the format used by database tables
     *
     * @param string $word The model name to be tableized
     * @return string
     */
    public static function tableize(string $word): string
    {
        $plural = static::pluralize($word);

        return static::underscore($plural);
    }

    // TODO: must implement this method
    public static function classify(string $word): string
    {
        return '';
    }

    /**
     * Convert strings from kebab-case, PascalCase or camelCase to underscore
     *
     * @param string $word The string to be underscored
     * @return string
     */
    public static function underscore(string $word): string
    {
        if (strpos($word, '-') !== false) {
            return mb_strtolower(str_replace('-', '_', $word));
        }

        if ($word == mb_strtolower($word)) {
            return $word;
        }

        $underscored = preg_replace('/(?<=\\w)([A-Z])/u', '_$1', $word);

        return mb_strtolower($underscored);
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
