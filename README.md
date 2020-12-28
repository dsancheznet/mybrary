## Usage

### Starting to serve

Once all databases have been created, use the following statement to run mybrary:

```
  php -S 0.0.0.0:1234
```

This will start a PHP development server, serving on port 1234 ( this makes an unprivileged start possible ) to any IP on the local system. You may access the library from any other device on the local area network.


## Installation

### Creating the database

From terminal (this will be changed in the future) execute the following statement to create a new empty database:

```
  cat mybrary_scheme.sql | sqlite3 mybrary.db
```
