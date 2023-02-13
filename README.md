# ABOUT

This package aims to create a user-friendly interface to build simple queries for Data Querying Language (DQL) and Data Manipulation Language (DML) using advanced design patterns as builder, factory, facade, etc.

# HOW IT WORKS

all input values are expected to be inserted as prepared statement, thus the package associates the named value argument as the same given column name prepended of ':'. Example: column name is 'birth_date', thus the bind value is ':birth_date'.
