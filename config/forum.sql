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
SELECT 
count(email) AS count_users
FROM users;

    
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

SELECT 
count(id) AS count_topics
FROM topics;

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
WHERE topic_id = 6;

INSERT INTO replies (user_id, topic_id, reply) 
VALUES 
( 4, 1, 'This is my first reply.'),
( 4, 1, 'Another response to the topic.'),
( 3, 1, 'Third reply to the second topic.');    



    
create table categories (
	id int primary key auto_increment,
    name varchar(200),
    created_at timestamp default current_timestamp
);
    
INSERT INTO categories (name) VALUES ("Design");
INSERT INTO categories (name) VALUES ("Development");
INSERT INTO categories (name) VALUES ("Business & Marketing");
INSERT INTO categories (name) VALUES ("Search Engines");
INSERT INTO categories (name) VALUES ("Cloud & Hosting");

select *  from categories;

SELECT 
				topics.id AS id,
				topics.title AS title,
				topics.category_id AS category_id,
                categories.name AS category,
				users.username AS username,
				users.avatar AS user_avatar,
				topics.create_at AS created_at,
				COUNT(replies.id) AS count_replies
			FROM topics
			INNER JOIN users ON topics.user_id = users.id
            INNER JOIN categories ON topics.category_id = categories.id
			LEFT JOIN replies ON replies.topic_id = topics.id
			GROUP BY topics.id, topics.title, topics.category_id, users.username, users.avatar, topics.create_at
			ORDER BY topics.create_at DESC;