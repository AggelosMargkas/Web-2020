![](img/logo.png)
# JSON Machine

Very easy to use and memory efficient drop-in replacement for inefficient iteration of big JSON files or streams
for PHP 5.6+. See [TL;DR](#tl-dr). No dependencies in production except optional `ext-json`.

[![Build Status](https://travis-ci.com/halaxa/json-machine.svg?branch=master)](https://travis-ci.com/halaxa/json-machine)
[![Latest Stable Version](https://img.shields.io/badge/stable-0.5.0-blueviolet)](https://packagist.org/packages/halaxa/json-machine)
[![Monthly Downloads](https://poser.pugx.org/halaxa/json-machine/d/monthly)](https://packagist.org/packages/halaxa/json-machine)

---

* [TL;DR](#tl-dr)
* [Introduction](#introduction)
* [Parsing JSON documents](#parsing-json-documents)
  + [Simple document](#simple-document)
* [Parsing streaming responses from a JSON API](#parsing-json-stream-api-responses)
  + [GuzzleHttp](#guzzlehttp)
  + [Symfony HttpClient](#symfony-httpclient)
* [Tracking the progress](#tracking-parsing-progress)
* [Parsing a subtree](#parsing-a-subtree)
  + [What is Json Pointer?](#json-pointer)
* [Decoders](#decoders)
  + [Available decoders](#available-decoders)
* [Error handling](#error-handling)
  + [Catching malformed items](#malformed-items)
* [Parser efficiency](#on-parser-efficiency)
  + [Streams / files](#streams-files)
  + [In-memory JSON strings](#in-memory-json-strings)
* [Troubleshooting](#troubleshooting)
  + ["I'm still getting Allowed memory size ... exhausted"](#step1)
  + ["That didn't help"](#step2)
  + ["I am still out of luck"](#step3)
* [Running tests](#running-tests)
  + [Running tests on all supported PHP platforms](#running-tests-on-all-supported-php-platforms)
* [Installation](#installation)
* [Support](#support)
* [License](#license)

---

<a name="tl-dr"></a>
## TL;DR
```diff
<?php

use \JsonMachine\JsonMachine;

// this often causes Allowed Memory Size Exhausted
- $users = json_decode(file_get_contents('500MB-users.json'));

// this usually takes few kB of memory no matter the file size
+ $users = JsonMachine::fromFile('500MB-users.json');

foreach ($users as $id => $user) {
    // just process $user as usual
}
```

Random access like `$users[42]` or counting results like `count($users)` **is not possible** by design.
Use above-mentioned `foreach` and find the item or count the collection there.

Requires `ext-json` if used out of the box. See [Decoders](#decoders).


<a name="introduction"></a>
## Introduction
JSON Machine is an efficient, easy-to-use and fast JSON stream/pull/incremental/lazy (whatever you name it) parser
based on generators developed for unpredictably long JSON streams or documents. Main features are:

- Constant memory footprint for unpredictably large JSON documents.
- Ease of use. Just iterate JSON of any size with `foreach`. No events and callbacks.
- Efficient iteration on any subtree of the document, specified by [Json Pointer](#json-pointer)
- Speed. Performance critical code contains no unnecessary function calls, no regular expressions
and uses native `json_decode` to decode JSON document chunks by default. See [Decoders](#decoders).
- Parses not only streams but any iterable that produces JSON chunks.
- Thoroughly tested. More than 100 tests and 700 assertions.

<a name="parsing-json-documents"></a>
## Parsing JSON documents

<a name="simple-document"></a>
### A simple document
Let's say that `fruits.json` contains this really big JSON document:
```json
// fruits.json
{
    "apple": {
        "color": "red"
    },
    "pear": {
        "color": "yellow"
    }
}
``` 
It can be parsed this way:
```php
<?php

use \JsonMachine\JsonMachine;

$fruits = JsonMachine::fromFile('fruits.json');

foreach ($fruits as $name => $data) {
    // 1st iteration: $name === "apple" and $data === ["color" => "red"]
    // 2nd iteration: $name === "pear" and $data === ["color" => "yellow"]
}
```

Parsing a json array instead of a json object follows the same logic.
The key in a foreach will be a numeric index of an item.

If you prefer JSON Machine to return objects instead of arrays, use `new ExtJsonDecoder()` as decoder
which by default decodes objects - same as `json_decode`
```php
<?php

use JsonMachine\JsonDecoder\ExtJsonDecoder;
use JsonMachine\JsonMachine;

$objects = JsonMachine::fromFile('path/to.json', '', new ExtJsonDecoder);
```


<a name="parsing-json-stream-api-responses"></a>
## Parsing streaming responses from a JSON API
A stream API response or any other JSON stream is parsed exactly the same way as file is. The only difference
is, you use `JsonMachine::fromStream($streamResource)` for it, where `$streamResource` is the stream
resource with the JSON document. The rest is the same as with parsing files. Here are some examples of
popular http clients which support streaming responses:

<a name="guzzlehttp"></a>
### GuzzleHttp
Guzzle uses its own streams, but they can be converted back to PHP streams by calling
`\GuzzleHttp\Psr7\StreamWrapper::getResource()`. Pass the result of this function to
`JsonMachine::fromStream` function, and you're set up. See working
[GuzzleHttp example](src/examples/guzzleHttp.php).

<a name="symfony-httpclient"></a>
### Symfony HttpClient
A stream response of Symfony HttpClient works as iterator. And because JSON Machine is
based on iterators, the integration with Symfony HttpClient is very simple. See
[HttpClient example](src/examples/symfonyHttpClient.php).


<a name="tracking-parsing-progress"></a>
## Tracking the progress
Big documents may take a while to parse. Call `JsonMachine::getPosition()` in your `foreach` to get current
count of the processed bytes from the beginning. Percentage is then easy to calculate as `position / total * 100`.
To find out the total size of your document in bytes you may want to check:
- `strlen($document)` if you're parsing string
- `filesize($file)` if you're parsing a file
- `Content-Length` http header if you're parsing http stream response
- ... you get the point

```php
<?php

use JsonMachine\JsonMachine;

$fileSize = filesize('fruits.json');
$fruits = JsonMachine::fromFile('fruits.json');
foreach ($fruits as $name => $data) {
    echo 'Progress: ' . intval($fruits->getPosition() / $fileSize * 100) . ' %'; 
}
```

<a name="parsing-a-subtree"></a>
## Parsing a subtree
If you want to iterate only `results` subtree in this `fruits.json`:
```json
// fruits.json
{
    "results": {
        "apple": {
            "color": "red"
        },
        "pear": {
            "color": "yellow"
        }
    }
}
```
use Json Pointer `"/results"` as the second argument:
```php
<?php

use \JsonMachine\JsonMachine;

$fruits = JsonMachine::fromFile("fruits.json", "/results");
foreach ($fruits as $name => $data) {
    // The same as above, which means:
    // 1st iteration: $name === "apple" and $data === ["color" => "red"]
    // 2nd iteration: $name === "pear" and $data === ["color" => "yellow"]
}
```

> Note:
>
> Value of `results` is not loaded into memory at once, but only one item in
> `results` at a time. It is always one item in memory at a time at the level/subtree
> you are currently iterating. Thus, the memory consumption is constant.

<a name="json-pointer"></a>
### What is Json Pointer?
It's a way of addressing one item in JSON document. See the [Json Pointer RFC 6901](https://tools.ietf.org/html/rfc6901).
It's very handy, because sometimes the JSON structure goes deeper, and you want to iterate a subtree,
not the main level. So you just specify the pointer to the JSON array or object you want to iterate and off you go.
When the parser hits the collection you specified, iteration begins. It is always a second parameter in all
`JsonMachine::from*` functions. If you specify a pointer to a scalar value (which logically cannot be iterated)
or a non-existent position in the document, an exception is thrown.

Some examples:

| Json Pointer value | Will iterate through                                                                              |
|--------------------|---------------------------------------------------------------------------------------------------|
| `""` (empty string - default)     | `["this", "array"]` or `{"a": "this", "b": "object"}` will be iterated (main level) |
| `"/result/items"`    | `{"result":{"items":["this","array","will","be","iterated"]}}`                                    |
| `"/0/items"`         | `[{"items":["this","array","will","be","iterated"]}]` (supports array indexes)                    |
| `"/"` (gotcha! - a slash followed by an empty string, see the [spec](https://tools.ietf.org/html/rfc6901#section-5))      | `{"":["this","array","will","be","iterated"]}`              |


<a name="decoders"></a>
## Decoders
As a third parameter of all the `JsonMachine::from*` functions is an optional instance of
`JsonMachine\JsonDecoder\Decoder`. If none specified, `ExtJsonDecoder` is used by
default. It requires `ext-json` PHP extension to be present, because it uses
`json_decode`. When `json_decode` doesn't do what you want, implement `JsonMachine\JsonDecoder\Decoder`
and make your own.

<a name="available-decoders"></a>
### Available decoders
- **`ExtJsonDecoder`** - **Default.** Uses `json_decode` to decode keys and values.
Constructor takes the same params as `json_decode`.

- **`PassThruDecoder`** - uses `json_decode` to decode keys but returns values as pure JSON strings.
Useful when you want to parse a JSON chunk with something else directly in the foreach
and don't want to implement `JsonMachine\JsonDecoder\Decoder`.
Constructor takes the same params as `json_decode`.
Example:
```php
<?php

use JsonMachine\JsonDecoder\PassThruDecoder;
use JsonMachine\JsonMachine;

$items = JsonMachine::fromFile('path/to.json', '', new PassThruDecoder);
```

- **`ErrorWrappingDecoder`** - A decorator which wraps decoding errors inside `DecodingError` object
thus enabling you to skip malformed chunks instead of dying on `SyntaxError` exception.
Example:
```php
<?php

use JsonMachine\JsonMachine;
use JsonMachine\JsonDecoder\DecodingError;
use JsonMachine\JsonDecoder\ErrorWrappingDecoder;
use JsonMachine\JsonDecoder\ExtJsonDecoder;

$items = JsonMachine::fromFile('path/to.json', '', new ErrorWrappingDecoder(new ExtJsonDecoder()));
foreach ($items as $key => $item) {
    if ($key instanceof DecodingError || $item instanceof DecodingError) {
        // handle error of this malformed json item
        continue;
    }
    var_dump($key, $item);
}
```


<a name="error-handling"></a>
## Error handling
Since 0.4.0 every exception extends `JsonMachineException`, so you can catch that to filter any error from JSON Machine library.

<a name="malformed-items"></a>
### Skipping malformed items
If there's an error anywhere in a json stream, `SyntaxError` exception is thrown. That's very inconvenient,
because if there is an error inside one json item you are unable to parse the rest of the document
because of one malformed item. `ErrorWrappingDecoder` is a decoder decorator which can help you with that.
Wrap a decoder with it, and all malformed items you are iterating will be given to you in the foreach via
`DecodingError`. This way you can skip them and continue further with the document. See example in
[Available decoders](#available-decoders). Syntax errors in the structure of a json stream between the iterated
items will still throw `SyntaxError` exception though.


<a name="on-parser-efficiency"></a>
## Parser efficiency

<a name="streams-files"></a>
### Streams / files
JSON Machine reads a stream (or a file) 1 JSON item at a time and generates corresponding 1 PHP array at a time.
This is the most efficient way, because if you had say 10,000 users in JSON file and wanted to parse it using
`json_decode(file_get_contents('big.json'))`, you'd have the whole string in memory as well as all the 10,000
PHP structures. Following table shows the difference:

|                        | String items in memory at a time | Decoded PHP items in memory at a time | Total |
|------------------------|---------------------------------:|--------------------------------------:|------:|
| `json_decode()`        |                            10000 |                                 10000 | 20000 |
| `JsonMachine::from*()` |                                1 |                                     1 |     2 |

This means, that `JsonMachine` is constantly efficient for any size of processed JSON. 100 GB no problem.

<a name="in-memory-json-strings"></a>
### In-memory JSON strings
There is also a method `JsonMachine::fromString()`. If you are
forced to parse a big string, and the stream is not available, JSON Machine may be better than `json_decode`.
The reason is that unlike `json_decode`, JSON Machine still traverses the JSON string one item at a time and doesn't
load all resulting PHP structures into memory at once.

Let's continue with the example with 10,000 users. This time they are all in string in memory.
When decoding that string with `json_decode`, 10,000 arrays (objects) is created in memory and then the result
is returned. JSON Machine on the other hand creates single structure for each found item in the string and yields it back
to you. When you process this item and iterate to the next one, another single structure is created. This is the same
behaviour as with streams/files. Following table puts the concept into perspective:

|                             | String items in memory at a time | Decoded PHP items in memory at a time | Total |
|-----------------------------|---------------------------------:|--------------------------------------:|------:|
| `json_decode()`             |                            10000 |                                 10000 | 20000 |
| `JsonMachine::fromString()` |                            10000 |                                     1 | 10001 |

The reality is even better. `JsonMachine::fromString` consumes about **5x less memory** than `json_decode`. The reason is
that a PHP structure takes much more memory than its corresponding JSON representation.


<a name="troubleshooting"></a>
## Troubleshooting

<a name="step1"></a>
### "I'm still getting Allowed memory size ... exhausted"
One of the reasons may be that the items you want to iterate over are in some sub-key such as `"results"`
but you forgot to specify a json pointer. See [Parsing a subtree](#parsing-a-subtree).

<a name="step2"></a>
### "That didn't help"
The other reason may be, that one of the items you iterate is itself so huge it cannot be decoded at once.
For example, you iterate over users and one of them has thousands of "friend" objects in it.
Use `PassThruDecoder` which does not decode an item, get the json string of the user
and parse it iteratively yourself using `JsonMachine::fromString()`.

```php
<?php

use JsonMachine\JsonMachine;
use JsonMachine\JsonDecoder\PassThruDecoder;

$users = JsonMachine::fromFile('users.json', '', new PassThruDecoder);
foreach ($users as $user) {
    foreach (JsonMachine::fromString($user, "/friends") as $friend) {
        // process friends one by one
    }
}
```

<a name="step3"></a>
### "I am still out of luck"
It probably means that the JSON string `$user` itself or one of the friends are too big and do not fit in memory.
However, you can try this approach recursively. Parse `"/friends"` with `PassThruDecoder` getting one `$friend`
json string at a time and then parse that using `JsonMachine::fromString()`... If even that does not help,
there's probably no solution yet via JSON Machine. A feature is planned which will enable you to iterate
any structure fully recursively and strings will be served as streams.


<a name="running-tests"></a>
## Running tests
```bash
tests/run.sh
```
This uses php and composer installation already present in your OS installation.

<a name="running-tests-on-all-supported-php-platforms"></a>
### Running tests on all supported PHP platforms
[Install docker](https://docs.docker.com/install/) to your machine and run
```bash
tests/docker-run-all-platforms.sh
```
This needs no php nor composer installation on your machine. Only Docker.


<a name="installation"></a>
## Installation
```bash
composer require halaxa/json-machine
```
or clone or download this repository (not recommended).


<a name="support"></a>
## Support
Do you like this library? Star it, share it, show it  :)
Issues and pull requests are very welcome.

<a name="license"></a>
## License
Apache 2.0

Cogwheel element: Icons made by [TutsPlus](https://www.flaticon.com/authors/tutsplus)
from [www.flaticon.com](https://www.flaticon.com/)
is licensed by [CC 3.0 BY](http://creativecommons.org/licenses/by/3.0/)

<i><a href='http://ecotrust-canada.github.io/markdown-toc/'>Table of contents generated with markdown-toc</a></i>

