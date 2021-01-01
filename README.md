![Interface](img/screenshot.png)


# mybrary

A library managing system for local area networks


## Motivation

The reason I started this project is because I wanted a php script that was able to classify and share my huge e-book collection with my family on my local network. I wanted all my family members to be able to access the books without the need to explicitly grant them access to my data volume on my NAS ( kids can do a pretty big damage on important data, believe me ). On the other hand I needed a way to search efficiently through my collection and have my books readily available on any device. Presently I do have a big collection of books stored on a Calibre installation but I really don't like the interface Calibre has; Also the functionality is actually slightly different to the needs I have. So I sat down and wrote this...


## Usage


### Starting to serve on a desktop computer

Once all databases have been created, use the following statement to run mybrary from inside it's directory:

```
  php -S 0.0.0.0:1234
```

This will start a PHP development server, serving on port 1234 ( this makes an unprivileged start possible ) to any IP on the local system. You may access the library from any other device on the local area network through the private ip of the computer.


### Starting to serve on a NAS

I personally run a Synology nas with the nginx webserver and php version 7.4. Just copy the whole directory as is to a directory of your choice and start adding documents.


## Installation


### Creating the database

From terminal (this will be changed in the future) execute the following statement to create a new empty database:

```
  cat mybrary_scheme.sql | sqlite3 mybrary.db
```


## Working with *mybrary*


### Covers

mbrary is not as fancy as Calibre is, obtaining the covers online. So you have two possibilities:

1- Use the cover from the isbnsearch page ( linked by clicking on the isbn number ) which mostly is pretty small in size.

2- Get a screenshot from the pdf file with imagemagick's convert utility. Given a book named `book.pdf` and given that the cover is on the first page (not allways the case) we type the following at your command line:

```
  convert book.pdf[0] book.jpg
```

This will generate a single jpeg file containing the cover with the original size.

3- Not use any cover, thus a "*NO COVER*" sign will appear next to the book.


## Limitations

This php script intentionally does **not** require/use a mariadb database server on the host. It uses sqlite3 instead. This strategy has its advantages but algo some disadvantages. As the library is multi-user but mono-library ( i.e. all registered users can *read* - and some can *edit* and *upload* books ) the use of sqlite3 can slow down the execution of the script. The intended use is for family sharing of books or small community access. It should not pose a big problem though to port the software to use mariadb or similar...but this is something that I have no need to do, so I leave this task to others.

Every book, can only exist once. It is *not* possible to have different copies of the same book in different formats. Please choose the best format for your needs and convert it to other formats if needed ( as Calibre does ).

## TODO

- [ ] Finish Upload
- [ ] Finish Tag Editor
- [ ] Include https://mozilla.github.io/pdf.js/
