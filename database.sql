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
    Created_at timestamp default current_timestamp
);

insert into users (Username, Password) values
('SKA','$2y$10$LnQRlvQDLnB5jltZn0QNyOVRLsdDkL.cyV6j6K.vcFnV2WYXgCbBK');

insert into posts (Title, Content) values
('The 2-Minute Rule','If a task takes less than two minutes, do it immediately to stop procrastination.'),
('Morning Momentum','Starting your day with one small victory makes the rest of the day easier to conquer.'),
('Declutter Your Mind','Writing down your worries for five minutes can significantly reduce daily anxiety.'),
('The Productivity Trap','Being busy is not the same as being productive, so focus on high-impact work instead.'),
('Inbox Zero Simplified','Delete, delegate, or do; never look at an email twice without taking action.'),
('Remote Work Reality','Turning off notifications after 5 PM is essential for mental separation from work.'),
('Simple Morning Hydration','Drinking a glass of water before coffee rehydrates your body and boosts energy.');