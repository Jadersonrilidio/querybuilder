<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Jayrods\QueryBuilder\QueryBuilder;

// $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
// $dotenv->load();

// $configPath = dirname(__DIR__) . '/config/queryBuilderConfig.php';

$builderFactory = new QueryBuilder();

/** @var Jayrods\QueryBuilder\Builders\Simple\InsertQueryBuilder */
$insert = $builderFactory->create(QueryBuilder::INSERT);

/** @var Jayrods\QueryBuilder\Builders\Simple\DeleteQueryBuilder */
$delete = $builderFactory->create(QueryBuilder::DELETE);

/** @var Jayrods\QueryBuilder\Builders\Simple\SelectQueryBuilder */
$select = $builderFactory->create(QueryBuilder::SELECT);

/** @var Jayrods\QueryBuilder\Builders\Simple\UpdateQueryBuilder */
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
    ->where('second', '=', 'primeiro')
    ->and('second', '<>', 'segundo')
    ->and('second', '<', 'terceiro')
    ->orderBy('first')
    ->asc()
    ->limit(10)
    ->build();

$deleteQuery = $delete->delete('table')
    ->where('id', '=', 'id')
    ->build();

$updateQuery = $update->update('table')
    ->column('pet')
    ->column('pet', 'first_pet')
    ->column('dog', 'cachorro')
    ->where('id', '=', 'id')
    ->build();

var_dump($builderFactory);

// var_dump($insert);
var_dump($insertQuery);
var_dump($insert->query());
var_dump($insert->getBindParams());

// var_dump($delete);
var_dump($deleteQuery);
var_dump($delete->query());
var_dump($delete->getBindParams());

// var_dump($select);
var_dump($selectQuery);
var_dump($select->query());
var_dump($select->getBindParams());

// var_dump($update);
var_dump($updateQuery);
var_dump($update->query());
var_dump($update->getBindParams());
