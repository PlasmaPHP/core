# Plasma Core [![CI status](https://github.com/PlasmaPHP/core/workflows/CI/badge.svg)](https://github.com/PlasmaPHP/core/actions) parts and interfaces.

The core component alone does __nothing__, you need a Plasma driver, which does all the handling of the DBMS.

Plasma does not aim to be a full Database Abstraction Layer. Simulating missing features is not a goal and should never be.

For a list of drivers, see the [main repository](https://github.com/PlasmaPHP/plasma).

# Getting Started
As soon as you have selected a driver, you can install it using `composer`. For the core, the command is

```
composer require plasma/core
```

Each driver has their own dependencies, as such they have to implement a factory, which creates their driver instances correctly. For more information, see the driver project page.

But this is some little pseudo code:

```php
use Plasma\Client;
use Plasma\QueryResultInterface;
use React\EventLoop\Factory;
use SomeGuy\PlasmaDriver\MsSQLFactory;

$loop = Factory::create();
$factory = new MsSQLFactory($loop);

$client = Client::create($factory, 'root:1234@localhost');

$client->execute('SELECT * FROM `users`', [])
    ->then(function (QueryResultInterface $result) use ($client) {
        // Do something with the query result
        // Most likely for a SELECT query,
        // it will be a streaming query result
        
        $client->close()->done();
    }, function (Throwable $error) use ($client) {
        // Oh no, an error occurred!
        echo $error.PHP_EOL;
        
        $client->close()->done();
    });

$loop->run();
```

# Cursors
Cursors are a powerful way to get full control over fetching rows.
Cursors allow you to control when a row (or multiple) is fetched from the database and allows your application a small memory footprint while fetching millions of rows.

Cursors return a promise and resolve with the row, an array of rows or `false` (when no more rows).
Since they return a promise, you don't need to depend on events and possibly buffer rows when passing around the result.

When combining cursors with generator coroutines (such as Recoil), you get a powerful tool you already know from PDO.

```php
// Inside a coroutine
use Plasma\CursorInterface;

/** @var CursorInterface  $cursor */
$cursor = yield $client->createReadCursor('SELECT * FROM `my_table`');

while($row = yield $cursor->fetch()) {
    // Process row
}
```

Support for cursors depend on the individual drivers.

# Documentation
https://plasmaphp.github.io/core/
