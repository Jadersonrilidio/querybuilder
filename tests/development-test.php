<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Jayrods\QueryBuilder\QueryBuilder;

$dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// $configPath = dirname(__DIR__) . '/config/queryBuilderConfig.php';

$builderFactory = new QueryBuilder();

/** @var Jayrods\QueryBuilder\InsertQueryBuilder */
$insert = $builderFactory->create(QueryBuilder::INSERT);

/** @var Jayrods\QueryBuilder\DeleteQueryBuilder */
$delete = $builderFactory->create(QueryBuilder::DELETE);

/** @var Jayrods\QueryBuilder\SelectQueryBuilder */
$select = $builderFactory->create(QueryBuilder::SELECT);

/** @var Jayrods\QueryBuilder\UpdateQueryBuilder */
$update = $builderFactory->create(QueryBuilder::UPDATE);

$insertQuery = $insert->insertInto('table')
    ->column('name')
    ->column('dog')
    ->column('pet')
    ->build();

$selectQuery = $select->selectFrom('table_1')
    ->column('first')
    ->column('second')
    ->column('third')
    ->column('fourth', 'table_2')
    ->column('fifth', 'table_2')
    ->innerJoin('table_2', 'first', '=', 'fifth')
    ->where('second', '=')
    ->and('second', '<>')
    ->and('second', '<')
    ->orderBy('first')
    ->asc()
    ->limit(10)
    ->build();

$deleteQuery = $delete->delete('table')
    ->where('id', '=', 'id')
    ->where('id', '<>', 'id')
    ->build();

$updateQuery = $update->update('table')
    ->column('pet')
    ->column('pet')
    ->column('dog', 'cachorro')
    ->where('id', '=', 'id')
    ->build();

var_dump($builderFactory);

// var_dump($insert);
var_dump($insertQuery);
var_dump($insert->query());

// var_dump($delete);
var_dump($deleteQuery);
var_dump($delete->query());

// var_dump($select);
var_dump($selectQuery);
var_dump($select->query());

// var_dump($update);
var_dump($updateQuery);
var_dump($update->query());
