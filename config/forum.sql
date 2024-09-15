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
    
create table topics (
	id int primary key auto_increment,
	user_id int,
    title varchar(200), 
    category varchar(200), 
    body text, 
	create_at timestamp default current_timestamp,
    foreign key (user_id) references users(id)    
);

select * from topics;

SELECT COUNT(*) AS count_topics
FROM topics 
INNER JOIN users
ON topics.user_id = users.id;

SELECT users.id AS user_id, users.username, users.avatar, topics.* 
FROM topics 
INNER JOIN users
ON topics.user_id = users.id
WHERE topics.id = 2 ;

create table replies (
	id int primary key auto_increment,
    user_id int(5),
    topic_id int(5),
    reply varchar(200),
    create_at timestamp default current_timestamp,
    foreign key (user_id) references users(id),
    foreign key (topic_id) references topics(id)
);
    
select * from replies;

SELECT 
    topics.id AS id,
    topics.title AS title,
    topics.category AS category,
    users.username AS username,
    users.avatar AS user_avatar,
    topics.create_at AS created_at,
    COUNT(replies.topic_id) AS count_replies
FROM topics
INNER JOIN users ON topics.user_id = users.id
INNER JOIN replies ON replies.topic_id = topics.id
GROUP BY(replies.topic_id);

SELECT 
    users.username AS username,
    users.avatar AS user_avatar,
    replies.*
FROM replies
INNER JOIN users ON replies.user_id = users.id
WHERE topic_id = 1;

INSERT INTO replies (user_id, topic_id, reply) 
VALUES 
( 4, 1, 'This is my first reply.'),
( 4, 1, 'Another response to the topic.'),
( 3, 1, 'Third reply to the second topic.');    
    
    
    
    
    
    
    
    