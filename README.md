![Interface](img/screenshot.png)

# mybrary

A library managing system for local area networks

## Motivation

Th reason I started this script is because I wanted a php script to be able to classify and share my huge e-book collection on the local network. I wanted all my family members to be able to access the books without the need to explicitly to grant access to my data volume on my NAS ( kids can do a pretty big damage on important data, believe me ). Presently I do have a big collection of books stored on a Calibre installation but I really don't like the interface Calibre has; Also the functionallity is actually slightly different to the needs I have. So I sat down and wrote this script...

## Usage

### Starting to serve on a desktop computer

Once all databases have been created, use the following statement to run mybrary:

```
  php -S 0.0.0.0:1234
```

This will start a PHP development server, serving on port 1234 ( this makes an unprivileged start possible ) to any IP on the local system. You may access the library from any other device on the local area network.


### Starting to serve on a NAS

I personally run a Synology nas with the nginx webserver and php version 7.4. Just copy the whole directory as is to a directory of your choice and start adding documents.

## Installation

### Creating the database

From terminal (this will be changed in the future) execute the following statement to create a new empty database:

```
  cat mybrary_scheme.sql | sqlite3 mybrary.db
```

## Limitations

This php script intentionally does **not** require/use a mariadb database server on the host. It uses sqlite3 instead. This strategy has its advantages but algo some disadvantages. As the library is multi-user but mono-library ( i.e. all registered users can *read* - and some can *edit* and *upload* books ) the use of sqlite3 can slow down the execution of the script. The intended use is for family sharing of books or small community access. It should not pose a big problem though to port the software to use mariadb or similar...but this is something that I have no need to do, so I leave this task to others.

Every book, can only exist once. It is *not* possible to have different copies of the same book in different formats. Please choose the best format for your needs and convert it to other formats if needed ( as Calibre does ) .
