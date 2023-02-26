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

**Writing hard coded SQL queries is a subject of great concern amongst developers!**
It not just let your code 'dirty' (as some PHP purists might say) but also affects
testability, simplicity and impose more work and timeover development. With those in mind
this package comes in handy with a simple approach of wrapping SQL queries into PHP
classes and methods, providing an abstraction with easy-to-use syntax and extra
features to assert the queries are being written accordingly.

**NOTE:** Bear in mind this package was developed for educational purposes goal.


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

Follow bellow example scripts using the component:

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

**NOTE:** The `create()` method demands an string argument to choose the use-case
to be applied. In this case it is strongly recommended to use the available `QueryBuilder`
object constants, as follow bellow:

```php
QueryBuilder::DELETE = 'delete';
QueryBuilder::INSERT = 'insert';
QueryBuilder::SELECT = 'select';
QueryBuilder::UPDATE = 'update';
```

**NOTE:** By convention, the component works ONLY with parameterized values,
following by the notation ':parameter' or '?', as could be seen in
[Parameterized options](https://github.com/Jadersonrilidio/querybuilder#parameterized-options).

**NOTE:** The `build()` method returns the built query and save it internaly,
providing a `query()` method to retrieve the query whenever you whish. It also
resets all other object's properties to default.

```php
echo $builder->query();
```

**ATTENTION!** Calling the 'build()' method a second time will override the previously saved query


**NOTE:** The `$builder` object also enables partial construction of the query,
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

* [Constructing DELETE Queries](https://github.com/Jadersonrilidio/querybuilder#delete-queries).
* [Constructing INSERT Queries](https://github.com/Jadersonrilidio/querybuilder#insert-queries).
* [Constructing SELECT Queries](https://github.com/Jadersonrilidio/querybuilder#select-queries).
* [Constructing UPDATE Queries](https://github.com/Jadersonrilidio/querybuilder#update-queries).


### DELETE Queries

```php
use Jayrods\QueryBuilder\QueryBuilder;

$builderFactory = new QueryBuilder();

$builder = $builderFactory->create(QueryBuilder::DELETE);

$query = $builder->delete('users')
    ->where('birth_date', '<', 'birth_date')
    ->or('name', 'LIKE', 'Noah')
    ->build();

```

### INSERT Queries


### SELECT Queries


### UPDATE Queries

### Environment variables options


### Customization options


### Advanced options


## Limitations


### Tips


### Comments


### Use Notes

When a new developer clones your codebase, they will have an additional
one-time step to manually copy the `.env.example` file to `.env` and fill-in
their own values (or get any sensitive values from a project co-worker).


## Security

If you discover a security vulnerability within this package, please report the issue or send an
email to [jayrods](jaderson.rodrigues@yahoo.com). All security vulnerabilities
will be promptly addressed. We appreciate your concern.


## License

QueryBuilder is licensed under [The GPL V3.0 License](LICENSE).
