QueryBuilder
============
A lightweight, straight-forward and easy-to-use SQL query builder for DML and DQL queries.

<p align="center">
    <a href="https://packagist.org/packages/jayrods/query-builder">
        <img src="./resources/img/logo.png" alt="Package logo"></img>
    </a>
</p>
<p align="center">
    <a href="LICENSE">
        <img src="https://img.shields.io/github/license/Jadersonrilidio/querybuilder?style=flat-square" alt="Software License"></img>
    </a>
    <a href="https://packagist.org/packages/jayrods/query-builder">
        <img src="https://img.shields.io/github/downloads/Jadersonrilidio/querybuilder/total?style=flat-square" alt="Downloads"></img>
    </a>
    <a href="https://github.com/Jadersonrilidio/querybuilder/releases">
        <img src="https://img.shields.io/github/v/release/Jadersonrilidio/querybuilder?style=flat-square" alt="Latest Version"></img>
    </a>
    <a href="https://packagist.org/packages/jayrods/query-builder">
        <img src="https://img.shields.io/github/languages/code-size/Jadersonrilidio/querybuilder?style=flat-square" alt="Code Size"></img>
    </a>
</p>


## About

**Writing SQL queries by hand is subject of great concern amongst developers!**
It not just let your code 'dirty' (as some PHP purists might say) but also affects
testability, simplicity and impose more work and time over development. With this in
mind, this package comes in handy with a simple approach of wrapping SQL queries into
PHP classes and methods, providing an abstraction with easy-to-use syntax and extra
features to assert the queries are being written accordingly.


## Installation

Installation is super-easy via [Composer](https://getcomposer.org/):

```bash
$ composer require jayrods/query-builder
```

or add it by hand to your `composer.json` file.


## Upgrading

We follow [semantic versioning](https://semver.org/), which means breaking
changes may occur between major releases. We would introduce upgrading guides
whenever major version releases becomes available [here](UPGRADING.md).


## Getting Started

Before start using the component, it's important to know how it is structured.

The QueryBuilder component is divided into 4 different use-cases, each
representing one CRUD operation (Create, Read, Update and Delete). For
simplicity sake, the component uses a QueryBuilder factory object to
create all builder kinds with no trouble.

Follow bellow an example script using the component:

**Example 01**

```php
use Jayrods\QueryBuilder\QueryBuilder;

// QueryBuilderFactory instance.
$builderFactory = new QueryBuilder();

// Create a SELECT queryBuilder use-case.
$builder = new $builderFactory->create(QueryBuilder::SELECT);

$selectQuery = $builder->selectFrom('users')
    ->column('uuid')
    ->columnAs('name', 'username')
    ->column('email')
    ->where('uuid', '=', 'uuid')
    ->build();

echo $selectQuery;
```

Output:

```sql
"SELECT users.uuid, users.name AS username, users.email FROM users WHERE uuid = :uuid"
```

**NOTE:** The `create()` method demands an argument informing which use-case
to apply. In this case it is strongly recommended to use the available QueryBuilder
object constants, as follow bellow:

```php
QueryBuilder::DELETE = 'delete';
QueryBuilder::INSERT = 'insert';
QueryBuilder::SELECT = 'select';
QueryBuilder::UPDATE = 'update';
```

**NOTE:** By convention, the component works ONLY with parameterized values,
following by the notation `:parameter` or `?`, as could be seen in
[Parameterized options](https://github.com/Jadersonrilidio/querybuilder#parameterized-options).

**NOTE:** The `build()` method returns the built query and save it internaly,
providing a `query()` method to retrieve the query whenever you whish. It also
resets all other object's properties to default, enabling it to promptly start
building another query if necessary.

```php
echo $builder->query();
```

**ATTENTION!** Calling the `build()` method a second time will override the previously saved query.

**NOTE:** The component also enables partial construction of the query,
providing more flexibility for the user:

```php
$builder->selectFrom('users');
$builder->column('uuid');
$builder->column('email');
$builder->columnAs('name', 'username');
$builder->where('uuid', '=', 'uuid');

$query = $builder->build();

echo $query;
```

Output:

```sql
"SELECT users.uuid, users.name AS username, users.email FROM users WHERE uuid = :uuid"
```

Partial construction simplifies certain cases where a SQL query depends on
certain conditions as in the example bellow:

```php
$columns = ['uuid', 'name', 'email'];
$userUuid = 'example-user-uuid';

$builder->selectFrom('users');

foreach ($columns as $column) {
    $builder->column($column)
}

if (isset($userUuid)) {
    $builder->where('uuid', '=', 'uuid');
}

$query = $builder->build();

echo $query;
```

Output:

```sql
"SELECT users.uuid, users.name, users.email FROM users WHERE uuid = :uuid"
```

**NOTE:** It is important to say that **EACH USE-CASE INSTANCE HAS ITS OWN SET OF METHODS**,
that could differ from each other either if the methods have the same name. In the
next examples you could notice the difference of called methods for each use-case:

**Example 02**

```php
use Jayrods\QueryBuilder\QueryBuilder;

// QueryBuilderFactory instance.
$builderFactory = new QueryBuilder();

// Create a INSERT queryBuilder use-case.
$builder = new $builderFactory->create(QueryBuilder::INSERT);

$insertQuery = $builder->insertInto('users')
    ->column('name')
    ->column('email')
    ->build();

echo $insertQuery;
```

Output:

```sql
"INSERT INTO users (name, email) VALUES (:name, :email)"
```


**Example 03**

```php
use Jayrods\QueryBuilder\QueryBuilder;

// QueryBuilderFactory instance.
$builderFactory = new QueryBuilder();

// Create a DELETE queryBuilder use-case.
$builder = new $builderFactory->create(QueryBuilder::DELETE);

$deleteQuery = $builder->delete('users')
    ->where('uuid', '=')
    ->or('uuid', '=', 'param2')
    ->build();

echo $deleteQuery;
```

Output:

```sql
"DELETE FROM users WHERE uuid = :uuid OR uuid = :param2"
```


**Example 04**

```php
use Jayrods\QueryBuilder\QueryBuilder;

// QueryBuilderFactory instance.
$builderFactory = new QueryBuilder();

// Create a UPDATE queryBuilder use-case.
$builder = new $builderFactory->create(QueryBuilder::UPDATE);

$deleteQuery = $builder->update('users')
    ->column('name')
    ->column('email')
    ->where('uuid', '=')
    ->build();

echo $deleteQuery;
```

Output:

```sql
"UPDATE users SET name = :name, email = :email WHERE uuid = :uuid"
```

More detailed explanation for each use-case could be seen on the sections bellow:

* [Building DELETE Queries](https://github.com/Jadersonrilidio/querybuilder#delete-queries).
* [Building INSERT Queries](https://github.com/Jadersonrilidio/querybuilder#insert-queries).
* [Building SELECT Queries](https://github.com/Jadersonrilidio/querybuilder#select-queries).
* [Building UPDATE Queries](https://github.com/Jadersonrilidio/querybuilder#update-queries).


### DELETE Queries

#### Methods

```php
// Start building DELETE query.
DeleteQueryBuilder::delete(string $table): self

// Start WHERE clause.
DeleteQueryBuilder::where(string $column, string $operator, ?string $binder = null): self

// Start WHERE NOT clause.
DeleteQueryBuilder::whereNot(string $column, string $operator, ?string $binder = null): self

// Start WHERE IN clause.
DeleteQueryBuilder::whereIn(string $column, string $subquery): self

// Start WHERE NOT IN clause.
DeleteQueryBuilder::whereNotIn(string $column, string $subquery): self

// Start WHERE BETWEEN clause.
DeleteQueryBuilder::whereBetween(string $column, ?string $left = null, ?string $right = null): self

// Start WHERE NOT BETWEEN clause.
DeleteQueryBuilder::whereNotBetween(string $column, ?string $left = null, ?string $right = null): self

// Add AND clause to conditions.
DeleteQueryBuilder::and(string $column, string $operator, ?string $binder = null): self

// Add AND NOT clause to conditions.
DeleteQueryBuilder::andNot(string $column, string $operator, ?string $binder = null): self

// Add AND BETWEEN clause to conditions.
DeleteQueryBuilder::andBetween(string $column, ?string $left = null, ?string $right = null): self

// Add AND NOT BETWEEN clause to conditions.
DeleteQueryBuilder::andNotBetween(string $column, ?string $left = null, ?string $right = null): self

// Add OR clause to conditions.
DeleteQueryBuilder::or(string $column, string $operator, ?string $binder = null): self

// Add OR NOT clause to conditions.
DeleteQueryBuilder::orNot(string $column, string $operator, ?string $binder = null): self

// Add OR BETWEEN clause to conditions.
DeleteQueryBuilder::orBetween(string $column, ?string $left = null, ?string $right = null): self

// Add OR NOT BETWEEN clause to conditions.
DeleteQueryBuilder::orNotBetween(string $column, ?string $left = null, ?string $right = null): self

// Build the query and set it to the query attribute.
DeleteQueryBuilder::build(): string

// Return the last built query or empty string.
DeleteQueryBuilder::query(): string

// Return array with used parameterized names acresced by ':' notation.
DeleteQueryBuilder::getBindParams(): array
```

#### Examples

**Example 01**

```php
$builderFactory = new QueryBuilder();
$builder = $builderFactory->create(QueryBuilder::DELETE);

$builder->delete('users')
    ->where('birth_date', '<', 'birth_date')
    ->or('name', 'LIKE', 'username')
    ->build();

echo $builder->query();
```

Output:

```sql
"DELETE FROM users WHERE birth_date < :birth_date OR name LIKE :username"
```

**Example 02**

```php
$builderFactory = new QueryBuilder();
$builder = $builderFactory->create(QueryBuilder::DELETE);

$builder->delete('products')
    ->whereBetween('price')
    ->build();

echo $builder->query();
```

Output:

```sql
"DELETE FROM products WHERE price BETWEEN :price_left AND :price_right"
```

**Example 03**

```php
$builderFactory = new QueryBuilder();
$builder = $builderFactory->create(QueryBuilder::DELETE);

$subquery = "SELECT * FROM users WHERE id BETWEEN :id_left AND :id_right";

$builder->delete('users')
    ->whereIn('name', $subquery)
    ->build();

echo $builder->query();
```

Output:

```sql
"DELETE FROM users WHERE name IN (SELECT * FROM users WHERE id BETWEEN :id_left AND :id_right)"
```


### INSERT Queries

#### Methods

```php
// Start building INSERT INTO query.
InsertQueryBuilder::insertInto(string $table): self

// Set column and respective binder name as value.
InsertQueryBuilder::column(string $column, ?string $binder = null): self

// Build the query and set it to the query attribute.
InsertQueryBuilder::build(): string

// Return the last built query or empty string.
InsertQueryBuilder::query(): string

// Return array with used parameterized names acresced by ':' notation.
InsertQueryBuilder::getBindParams(): array
```

#### Examples

**Example 01**

```php
$builderFactory = new QueryBuilder();
$builder = $builderFactory->create(QueryBuilder::INSERT);

$builder->insertInto('users')
    ->column('name', 'username')
    ->column('email', 'useremail')
    ->build();

echo $builder->query();
```

Output:

```sql
"INSERT INTO users (name, email) VALUES (:username, :useremail)"
```


### SELECT Queries

#### Methods

```php
// Start building SELECT FROM query.
SelectQueryBuilder::selectFrom(string $table): self

// Add column to be selected.
SelectQueryBuilder::column(string $column, ?string $refTable = null): self

// Add column with AS clause to be selected.
SelectQueryBuilder::columnAs(string $column, string $as, ?string $refTable = null): self

// Start WHERE clause.
SelectQueryBuilder::where(string $column, string $operator, ?string $binder = null): self

// Start WHERE NOT clause.
SelectQueryBuilder::whereNot(string $column, string $operator, ?string $binder = null): self

// Start WHERE IN clause.
SelectQueryBuilder::whereIn(string $column, string $subquery): self

// Start WHERE NOT IN clause.
SelectQueryBuilder::whereNotIn(string $column, string $subquery): self

// Start WHERE BETWEEN clause.
SelectQueryBuilder::whereBetween(string $column, ?string $left = null, ?string $right = null): self

// Start WHERE NOT BETWEEN clause.
SelectQueryBuilder::whereNotBetween(string $column, ?string $left = null, ?string $right = null): self

// Add AND clause to conditions.
SelectQueryBuilder::and(string $column, string $operator, ?string $binder = null): self

// Add AND NOT clause to conditions.
SelectQueryBuilder::andNot(string $column, string $operator, ?string $binder = null): self

// Add AND BETWEEN clause to conditions.
SelectQueryBuilder::andBetween(string $column, ?string $left = null, ?string $right = null): self

// Add AND NOT BETWEEN clause to conditions.
SelectQueryBuilder::andNotBetween(string $column, ?string $left = null, ?string $right = null): self

// Add OR clause to conditions.
SelectQueryBuilder::or(string $column, string $operator, ?string $binder = null): self

// Add OR NOT clause to conditions.
SelectQueryBuilder::orNot(string $column, string $operator, ?string $binder = null): self

// Add OR BETWEEN clause to conditions.
SelectQueryBuilder::orBetween(string $column, ?string $left = null, ?string $right = null): self

// Add OR NOT BETWEEN clause to conditions.
SelectQueryBuilder::orNotBetween(string $column, ?string $left = null, ?string $right = null): self

// Add LIMIT clause.
SelectQueryBuilder::limit(int $limit): self

// Add ORDER BY clause.
SelectQueryBuilder::orderBy(string $column): self

// Sort the result order ascending.
SelectQueryBuilder::asc(): self

// Sort the result order descending.
SelectQueryBuilder::desc(): self

// Add INNER JOIN clause.
SelectQueryBuilder::innerJoin(string $joinTable, string $columnTable, string $operator, string $columnJoinTable): self

// Add LEFT JOIN clause.
SelectQueryBuilder::leftJoin(string $joinTable, string $columnTable, string $operator, string $columnJoinTable): self

// Add RIGHT JOIN clause.
SelectQueryBuilder::rightJoin(string $joinTable, string $columnTable, string $operator, string $columnJoinTable): self

// Build the query and set it to the query attribute.
SelectQueryBuilder::build(): string

// Return the last built query or empty string.
SelectQueryBuilder::query(): string

// Return array with used parameterized names acresced by ':' notation.
SelectQueryBuilder::getBindParams(): array
```

#### Examples

**Example 01**

```php
$builderFactory = new QueryBuilder();
$builder = $builderFactory->create(QueryBuilder::SELECT);

$builder->selectFrom('users')
    ->build();

echo $builder->query();
```

Output:

```sql
"SELECT * FROM users"
```

**NOTE:** In the SELECT use-case, whenever the user don't assign any columns, the
builder understands that all columns should be retrieved, applying the `*` syntaxs.

**Example 02**

```php
$builderFactory = new QueryBuilder();
$builder = $builderFactory->create(QueryBuilder::SELECT);

$builder->selectFrom('users')
    ->columnAs('name', 'username')
    ->columnAs('email', 'useremail')
    ->columnAs('area_code', 'phonearea', 'phones')
    ->columnAs('number', 'phonenumber', 'phones')
    ->innerJoin('phones', 'user_uuid', '=', 'uuid')
    ->where('uuid', '=', 'uuid')
    ->build();

echo $builder->query();
```

Output:

```sql
"SELECT
    users.name AS username, users.email AS useremail,
    phones.area_code AS phonearea, phones.number AS phonenumber
    FROM users
    INNER JOIN phones ON phones.user_uuid = users.uuid
    WHERE uuid = :uuid"
```

**Example 03**

```php
$builderFactory = new QueryBuilder();
$builder = $builderFactory->create(QueryBuilder::SELECT);

$builder->selectFrom('users')
    ->column('uuid')
    ->column('name')
    ->column('email')
    ->orderBy('name')
    ->asc()
    ->limit(20)
    ->build();

echo $builder->query();
```

Output:

```sql
"SELECT users.uuid, users.name, users.email FROM users ORDER BY users.name ASC LIMIT 20;
```


### UPDATE Queries

#### Methods

```php
// Start building UPDATE query.
UpdateQueryBuilder::update(string $table): self

// Add column to be updated with respective binder name.
UpdateQueryBuilder::column(string $column, ?string $binder = null): self

// Start WHERE clause.
UpdateQueryBuilder::where(string $column, string $operator, ?string $binder = null): self

// Start WHERE NOT clause.
UpdateQueryBuilder::whereNot(string $column, string $operator, ?string $binder = null): self

// Start WHERE IN clause.
UpdateQueryBuilder::whereIn(string $column, string $subquery): self

// Start WHERE NOT IN clause.
UpdateQueryBuilder::whereNotIn(string $column, string $subquery): self

// Start WHERE BETWEEN clause.
UpdateQueryBuilder::whereBetween(string $column, ?string $left = null, ?string $right = null): self

// Start WHERE NOT BETWEEN clause.
UpdateQueryBuilder::whereNotBetween(string $column, ?string $left = null, ?string $right = null): self

// Add AND clause to conditions.
UpdateQueryBuilder::and(string $column, string $operator, ?string $binder = null): self

// Add AND NOT clause to conditions.
UpdateQueryBuilder::andNot(string $column, string $operator, ?string $binder = null): self

// Add AND BETWEEN clause to conditions.
UpdateQueryBuilder::andBetween(string $column, ?string $left = null, ?string $right = null): self

// Add AND NOT BETWEEN clause to conditions.
UpdateQueryBuilder::andNotBetween(string $column, ?string $left = null, ?string $right = null): self

// Add OR clause to conditions.
UpdateQueryBuilder::or(string $column, string $operator, ?string $binder = null): self

// Add OR NOT clause to conditions.
UpdateQueryBuilder::orNot(string $column, string $operator, ?string $binder = null): self

// Add OR BETWEEN clause to conditions.
UpdateQueryBuilder::orBetween(string $column, ?string $left = null, ?string $right = null): self

// Add OR NOT BETWEEN clause to conditions.
UpdateQueryBuilder::orNotBetween(string $column, ?string $left = null, ?string $right = null): self

// Build the query and set it to the query attribute.
UpdateQueryBuilder::build(): string

// Return the last built query or empty string.
UpdateQueryBuilder::query(): string

// Return array with used parameterized names acresced by ':' notation.
UpdateQueryBuilder::getBindParams(): array
```

#### Examples

**Example 01**

```php
$builderFactory = new QueryBuilder();
$builder = $builderFactory->create(QueryBuilder::UPDATE);

$builder->update('users')
    ->column('name')
    ->column('email')
    ->where('uuid', '=')
    ->build();

echo $builder->query();
```

Output:

```sql
"UPDATE users SET name = :name, email = :email WHERE uuid = :uuid"
```


## Advanced Options

The QueryBuilder component also provides features to help assert the
correct building of a query, by throwing errors on inconsistency,
echoing console warnings on inconsistency and ignoring unexpected on
wrong build methods calling.

The principal helper feature is the Constrained QueryBuilder Mode
[See Constrained Mode](https://github.com/Jadersonrilidio/querybuilder#constrained-mode).
It's major function is to ignore missplaced build methods to avoid wrong
query writing, and also allows the component to inform the user throught
Exceptions thrown or console messages echoing during runtime.

All different modes could be enabled using Environment variables or config
file settings, as could be seen [Here - Environment Variables](https://github.com/Jadersonrilidio/querybuilder#environment-variables-options)
and [Here - Configuration File](https://github.com/Jadersonrilidio/querybuilder#config-file), respectively


### Constrained Mode

The constrained mode's major function is to ignore missplaced build methods,
avoiding wrong query writing. It also allows the component to inform the
errors occuried and the action taken throught Exceptions thrown or console
messages echoing during runtime.

The constrained mode could be enabled/disabled by two ways:

First, setting the environment variable `QB_ENABLE_CONSTRAINED_MODE` in a `.env` file;

Second, overriding the config file `ENABLE_CONSTRAINED_MODE` param.
[More about config file here](https://github.com/Jadersonrilidio/querybuilder#config-file)

**NOTE:** By default, the constrained mode is set to true.

```shell
QB_ENABLE_CONSTRAINED_MODE=true
```

With the constrained mode on (`QB_ENABLE_CONSTRAINED_MODE=true`), the user have
two more available options:

Enable\disable Constrained mode to throw an Exception on fail, throught
the env variable `QB_FAIL_ON_WRONG_METHOD_CALL`;

Enable\disable Constrained mode to echo message on fail, throught the
env variable `QB_ECHO_WARNINGS_ON_WRONG_METHOD_CALL`;

**NOTE:** By default:

```shell
QB_FAIL_ON_WRONG_METHOD_CALL=false
QB_ECHO_WARNINGS_ON_WRONG_METHOD_CALL=true
```
**IMPORTANT!** As the constrained mode is used to assert the right construction of
the query, we recommend to use it only for development, and disable the constrained
mode for production to make the component more performatic.


### Environment Variables Options


Follow bellow all the available environment variables with their default value:

```shell
QB_ENABLE_CONSTRAINED_MODE=true
QB_FAIL_ON_WRONG_METHOD_CALL=false
QB_ECHO_WARNINGS_ON_WRONG_METHOD_CALL=true
QB_PARAMETERIZED_MODE=true
QB_PARAMETERIZED_MODE_FAIL_ON_ERROR=false
QB_PARAMETERIZED_MODE_ECHO_WARNINGS_ON_ERROR=true
```


### Parameterized Options

```shell
QB_PARAMETERIZED_MODE=true
QB_PARAMETERIZED_MODE_FAIL_ON_ERROR=false
QB_PARAMETERIZED_MODE_ECHO_WARNINGS_ON_ERROR=true
```

### Config File

In addition, it is possible to set all component's options throught a
`queryBuilderConfig.php` file. By default, the component uses its config
file available in the package `./config` folder, however there is a possibility
to puslish such file in the root `./config` folder, or even in a user-defined
directory [See](https://github.com/Jadersonrilidio/querybuilder#publishing-config-file).

To use a config file in a user-defined directory, it makes necessary to inform the
user-defined path to the QueryBuilder object, like the example bellow:

```php
$configFilePath = dirname(__DIR__) . '/path/to/file/queryBuilderConfig.php';

$builderFactory = new QueryBuilder($configFilePath);
```

#### Publishing Config File

The component make available a bin script to publish correctly the `queryBuilderConfig.php`
file. The user can puslish the config file by typing the following commands at the console:

```bash
php vendor/bin/qb_publish_config <optional:path>
```

Without argument, attempt to create config file on `./config/` folder, if exists

```bash
php vendor/bin/qb_publish_config
```

With argument, attempt to create on the passed folder, if exists

```bash
php vendor/bin/qb_publish_config ./path/to/folder/
```


## Contributing

We appreciate the kindness of any developer willing to contribute to this project to make it
complete enough to real-project use, by suggesting or adding new features, covering vulnerability
and other nature issues. If you are willing to contribute to this project, please send an
email to [jayrods](jaderson.rodrigues@yahoo.com).


## Security

If you discover a security vulnerability within this package, please report the issue or send an
email to [jayrods](jaderson.rodrigues@yahoo.com). All security vulnerabilities
will be promptly addressed. We appreciate your concern.


## License

QueryBuilder is licensed under [The GPL V3.0 License](LICENSE).
