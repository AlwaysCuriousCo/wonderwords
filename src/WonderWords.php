<?php

namespace AlwaysCurious\WonderWords;

class WonderWords
{
    private WordList $wordList;
    private string $separator = ' ';

    public function __construct(?WordList $wordList = null)
    {
        $this->wordList = $wordList ?? new WordList();
    }

    /**
     * Get the underlying WordList instance.
     */
    public function wordList(): WordList
    {
        return $this->wordList;
    }

    /**
     * Set the separator used when joining words.
     */
    public function separator(string $separator): self
    {
        $clone = clone $this;
        $clone->separator = $separator;

        return $clone;
    }

    /**
     * Generate a random word from a specific category.
     */
    public function word(string $category = WordList::NOUNS): string
    {
        return $this->wordList->randomWord($category);
    }

    /**
     * Generate multiple random words from a category.
     *
     * @return string[]
     */
    public function words(string $category, int $count = 5): array
    {
        return $this->wordList->randomWords($category, $count);
    }

    /**
     * Generate a random phrase: "adjective noun" (e.g., "blazing phoenix").
     */
    public function phrase(): string
    {
        return implode($this->separator, [
            $this->wordList->randomWord(WordList::ADJECTIVES),
            $this->wordList->randomWord(WordList::NOUNS),
        ]);
    }

    /**
     * Generate a random sentence: "adjective noun verb adverb"
     * (e.g., "the fierce dragon roars mightily").
     */
    public function sentence(): string
    {
        $words = [
            'the',
            $this->wordList->randomWord(WordList::ADJECTIVES),
            $this->wordList->randomWord(WordList::NOUNS),
            $this->wordList->randomWord(WordList::VERBS),
            $this->wordList->randomWord(WordList::ADVERBS),
        ];

        $sentence = implode(' ', $words);

        return ucfirst($sentence) . '.';
    }

    /**
     * Generate a random slug-style string (e.g., "blazing-phoenix").
     */
    public function slug(string $glue = '-'): string
    {
        return implode($glue, [
            $this->wordList->randomWord(WordList::ADJECTIVES),
            $this->wordList->randomWord(WordList::NOUNS),
        ]);
    }

    /**
     * Generate a random combination from specified categories.
     *
     * @param string[] $categories Array of category names to pick from, in order.
     */
    public function combine(array $categories): string
    {
        $words = array_map(
            fn(string $cat) => $this->wordList->randomWord($cat),
            $categories
        );

        return implode($this->separator, $words);
    }

    /**
     * Generate multiple unique phrases.
     *
     * @return string[]
     */
    public function phrases(int $count = 5): array
    {
        $results = [];
        $attempts = 0;
        $maxAttempts = $count * 10;

        while (count($results) < $count && $attempts < $maxAttempts) {
            $phrase = $this->phrase();
            if (!in_array($phrase, $results, true)) {
                $results[] = $phrase;
            }
            $attempts++;
        }

        return $results;
    }

    /**
     * Generate multiple unique sentences.
     *
     * @return string[]
     */
    public function sentences(int $count = 3): array
    {
        $results = [];
        $attempts = 0;
        $maxAttempts = $count * 10;

        while (count($results) < $count && $attempts < $maxAttempts) {
            $sentence = $this->sentence();
            if (!in_array($sentence, $results, true)) {
                $results[] = $sentence;
            }
            $attempts++;
        }

        return $results;
    }
}
