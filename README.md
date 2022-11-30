# curriculumVitae
PHP based CV Generator from MySQL database (MariaDB) 

#Installation:

Create the following database:
```SQL
CREATE DATABASE curriculumVitae;
```

Then create the following tables in the database:
```SQL
create table competens
(
    innerText text null
);

create table education
(
    date      text null,
    title     text null,
    innerText text null
);

create table jobexperience
(
    date         text null,
    title        text null,
    company      text null,
    location     text null,
    innerText    text null,
    achievements text null
);

create table languages
(
    languages text null
);

create table profile
(
    innerText text null
);

create table projects
(
    title     text null,
    innerText text null
);

create table projreferences
(
    company text null,
    name    text null,
    tel     text null,
    mail    text null
);

create table userinfo
(
    name       text null,
    currTitle  text null,
    address    text null,
    city       text null,
    postalCode text null,
    phone      text null,
    mail       text null
);
```
