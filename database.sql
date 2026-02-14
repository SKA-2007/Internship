create database if not exists blog;

use blog;

create table if not exists users (
    ID int auto_increment primary key,
    Username varchar(50) unique not null,
    Password varchar(255) not null,
    Role enum('admin','editor','user') not null,
    Created_at timestamp default current_timestamp
);

create table if not exists posts (
    ID int auto_increment primary key,
    User_ID int not null,
    Title varchar(255) not null,
    Content text not null,
    Created_at timestamp default current_timestamp
);

insert into users (ID,Username, Password, Role) values
(1,'Editor1','$2y$10$mf79I5nrBZf1dE5NV49Y6O62WSPK.QPXX5Azozpf3ersUQHTwK/fK','editor'),
(2,'Editor2','$2y$10$1CqPrGSAhjt2eSd.uMSrVOYOk/6scu6eSOUO20WJN5MYGdEVPhRxq','editor'),
(3,'User1','$2y$10$QxRlQz4q8E5u2x1ECNzU3.I7PzGZulL6enw/KF1SZlDxvcMlkrYL6','user'),
(4,'User2','$2y$10$P4Jn5Da2lY9rkOO82sMcNutar7BQNfPiw5I/lfgSAz2zjic3dGZF2','user');

insert into posts (User_ID, Title, Content) values
(1,'The 2-Minute Rule','If a task takes less than two minutes, do it immediately to stop procrastination.'),
(2,'Morning Momentum','Starting your day with one small victory makes the rest of the day easier to conquer.'),
(3,'Declutter Your Mind','Writing down your worries for five minutes can significantly reduce daily anxiety.'),
(4,'The Productivity Trap','Being busy is not the same as being productive, so focus on high-impact work instead.'),
(3,'Inbox Zero Simplified','Delete, delegate, or do; never look at an email twice without taking action.'),
(3,'Remote Work Reality','Turning off notifications after 5 PM is essential for mental separation from work.'),
(4,'Simple Morning Hydration','Drinking a glass of water before coffee rehydrates your body and boosts energy.');