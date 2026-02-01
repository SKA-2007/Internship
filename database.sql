create database if not exists blog;

use blog;

create table if not exists users (
    ID int auto_increment primary key,
    Username varchar(15) unique not null,
    Password varchar(255) not null,
    Created_at timestamp default current_timestamp
);

create table if not exists posts (
    ID int auto_increment primary key,
    Title varchar(255) not null,
    Content text not null,
    created_at timestamp default current_timestamp
);