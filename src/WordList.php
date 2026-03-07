<?php

namespace AlwaysCurious\WonderWords;

class WordList
{
    /** @var array<string, string[]> */
    private static array $cache = [];

    /** @var array<string, string[]> */
    private array $custom = [];

    public const ADJECTIVES = 'adjectives';
    public const NOUNS = 'nouns';
    public const VERBS = 'verbs';
    public const ADVERBS = 'adverbs';

    public const ALL_CATEGORIES = [
        self::ADJECTIVES,
        self::NOUNS,
        self::VERBS,
        self::ADVERBS,
    ];

    /**
     * Get all words for a given category.
     *
     * @return string[]
     */
    public function words(string $category): array
    {
        if (isset($this->custom[$category])) {
            return $this->custom[$category];
        }

        return $this->loadBuiltIn($category);
    }

    /**
     * Get a single random word from a category.
     */
    public function randomWord(string $category): string
    {
        $words = $this->words($category);

        return $words[array_rand($words)];
    }

    /**
     * Get multiple random words from a category.
     *
     * @return string[]
     */
    public function randomWords(string $category, int $count): array
    {
        $words = $this->words($category);
        $count = min($count, count($words));
        $keys = array_rand($words, $count);

        if ($count === 1) {
            return [$words[$keys]];
        }

        return array_map(fn(int $key) => $words[$key], $keys);
    }

    /**
     * Register a custom word list for a category, replacing the built-in list.
     *
     * @param string[] $words
     */
    public function setCategory(string $category, array $words): self
    {
        $this->custom[$category] = array_values($words);

        return $this;
    }

    /**
     * Add words to an existing category (built-in or custom).
     *
     * @param string[] $words
     */
    public function addWords(string $category, array $words): self
    {
        $existing = $this->words($category);
        $this->custom[$category] = array_values(array_unique(array_merge($existing, $words)));

        return $this;
    }

    /**
     * Get all available categories.
     *
     * @return string[]
     */
    public function categories(): array
    {
        return array_unique(array_merge(self::ALL_CATEGORIES, array_keys($this->custom)));
    }

    /**
     * @return string[]
     */
    private function loadBuiltIn(string $category): array
    {
        if (isset(self::$cache[$category])) {
            return self::$cache[$category];
        }

        $file = dirname(__DIR__) . '/data/' . $category . '.php';

        if (!file_exists($file)) {
            throw new \InvalidArgumentException("Unknown word category: {$category}");
        }

        self::$cache[$category] = require $file;

        return self::$cache[$category];
    }
}
