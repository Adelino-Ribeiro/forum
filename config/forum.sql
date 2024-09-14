create database forum;

use forum;

create table users (
	id int primary key auto_increment,
    name varchar(200),
    email varchar(200),
    username varchar(200),
    password varchar(200),
    avatar text,
    about varchar(200),
    create_at timestamp default current_timestamp
);

select * from users;
    
    
    
    
    
    
    
    
    
    
    
    