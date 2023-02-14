<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Jayrods\QueryBuilder\QueryBuilderFactory;

$builderFactory = new QueryBuilderFactory;

/**
 * INSERT TEST
 * 
 * @var Jayrods\QueryBuilder\InsertQueryBuilder
 */
$insert = $builderFactory->create(QueryBuilderFactory::INSERT);

$query = $insert->insertInto('table')
    ->column('name')
    ->column('dog')
    ->column('pet')
    ->build();

var_dump($query);

/**
 * SELECT TEST
 * 
 * @var Jayrods\QueryBuilder\SelectQueryBuilder
 */
$select = $builderFactory->create(QueryBuilderFactory::SELECT);

$query = $select->selectFrom('tb1')
    ->column('first')
    ->column('second')
    ->column('third')
    ->column('fourth', 'tb2')
    ->column('fifth', 'tb2')
    ->innerJoin('tb2', 'fifth', 'first', '=')
    ->where('second', '=', 'SMTHELSE')
    ->and('second', '<>', 'JUSTSMTH')
    ->orderBy('first')
    ->asc()
    ->limit(10)
    ->build();

var_dump($query);

/**
 * DELETE TEST
 * 
 * @var Jayrods\QueryBuilder\DeleteQueryBuilder
 */
$delete = $builderFactory->create(QueryBuilderFactory::DELETE);

$query = $delete->delete('table')
    ->where('id', '=', 'id')
    ->build();

var_dump($query);

/**
 * UPDATE TEST
 * 
 * @var Jayrods\QueryBuilder\UpdateQueryBuilder
 */
$update = $builderFactory->create(QueryBuilderFactory::UPDATE);

$query = $update->update('table')
    ->column('pet')
    ->column('dog', 'cachorro')
    ->where('id', '=', 'id')
    ->build();

var_dump($query);
