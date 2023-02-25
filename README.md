QueryBuilder
============
A straight forward and easy-to-use SQL query builder for simple DML and DQL queries.

<p align="center">
    <a href="https://packagist.org/packages/jayrods/querybuilder">
        <img src="./resources/img/logo.png" alt="Package logo"></img>
    </a>
</p>

<p align="center">
    <a href="LICENSE">
        <img src="https://img.shields.io/badge/license-BSD%203--Clause-brightgreen.svg?style=flat-square" alt="Software License"></img>
    </a>
    <a href="https://packagist.org/packages/jayrods/querybuilder">
        <img src="https://img.shields.io/packagist/dt/vlucas/phpdotenv.svg?style=flat-square" alt="Total Downloads"></img>
    </a>
    <a href="https://github.com/Jadersonrilidio/querybuilder/releases">
        <img src="https://img.shields.io/github/release/vlucas/phpdotenv.svg?style=flat-square" alt="Latest Version"></img>
    </a>
</p>


# About the Project

**Writing hard coded SQL queries is a subject of great concern amongst developers!**
It not just lets your code 'dirty' (as some PHP purists might say) but also affects
testability, simplicity and impose more work over development. With those in mind
this package comes in handy with a simple approach of wrapping SQL queries into PHP
classes and methods, providing an abstraction with easy-to-use syntax and extra
features to assert the queries are being written accordingly.

Also bear in mind this package was developed for educational purposes goal.


## Installation

Installation is super-easy via [Composer](https://getcomposer.org/):

```bash
$ composer require jayrods/querybuilder
```

or add it by hand to your `composer.json` file.


## Upgrading

We follow [semantic versioning](https://semver.org/), which means breaking
changes may occur between major releases. We would introduce upgrading guides
whenever major version releases becomes available [here](UPGRADING.md).


## Getting Started

### Building Queries
#### DELETE Queries
#### INSERT Queries
#### SELECT Queries
#### UPDATE Queries

### Environment variables options
### Customization options
### Advanced options

## Limitations

### Tips
### Comments
### Usage Notes

When a new developer clones your codebase, they will have an additional
one-time step to manually copy the `.env.example` file to `.env` and fill-in
their own values (or get any sensitive values from a project co-worker).


## Security

If you discover a security vulnerability within this package, please send an
email to [jayrods](jaderson.rodrigues@yahoo.com). All security vulnerabilities
will be promptly addressed. You may view our full security policy 
[here](https://github.com/vlucas/phpdotenv/security/policy).


## License

QueryBuilder is licensed under [The GPL V3.0 License](LICENSE).
