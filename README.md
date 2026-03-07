# WonderWords

A wonderful way to generate random words, phrases, and sentences from curated word lists.

## Installation

```bash
composer require alwayscurious/wonderwords
```

## Usage

### Basic Usage

```php
use AlwaysCurious\WonderWords\WonderWords;

$ww = new WonderWords();

// Generate a random word
$ww->word();                    // "phoenix"

// Generate a random phrase (adjective + noun)
$ww->phrase();                  // "blazing phoenix"

// Generate a random sentence
$ww->sentence();                // "The fierce dragon roars mightily."

// Generate a slug
$ww->slug();                    // "crimson-falcon"
$ww->slug('_');                 // "crimson_falcon"
```

### Multiple Results

```php
$ww->words('nouns', 3);         // ["phoenix", "glacier", "storm"]
$ww->phrases(5);                // ["bold raven", "cosmic ember", ...]
$ww->sentences(3);              // ["The swift falcon soars boldly.", ...]
```

### Custom Combinations

```php
use AlwaysCurious\WonderWords\WordList;

// Combine any categories in any order
$ww->combine([WordList::ADJECTIVES, WordList::NOUNS, WordList::VERBS]);
// "golden eagle soars"

// Use a custom separator
$ww->separator('-')->phrase();  // "blazing-phoenix"
```

### Word Categories

Built-in categories: `adjectives`, `nouns`, `verbs`, `adverbs`

```php
$ww->word(WordList::ADJECTIVES);  // "fierce"
$ww->word(WordList::NOUNS);       // "dragon"
$ww->word(WordList::VERBS);       // "roars"
$ww->word(WordList::ADVERBS);     // "mightily"
```

### Custom Word Lists

```php
$ww = new WonderWords();

// Replace a built-in category
$ww->wordList()->setCategory('colors', ['red', 'blue', 'green']);

// Add words to an existing category
$ww->wordList()->addWords(WordList::NOUNS, ['spaceship', 'robot']);

// Use your custom category
$ww->word('colors');             // "blue"
```

## Credits

This package is a PHP port inspired by the Python [WonderWords](https://wonderwords.readthedocs.io/en/latest/) library by mrmaxguns.

## License

MIT
