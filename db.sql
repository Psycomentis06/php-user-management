create table users (id int auto_increment primary key,
      firstname varchar(30) not null,
      lastname varchar(30) not null,
      email varchar(30) not null,
      roles varchar(100) not null,
      passwd varchar(30) not null,
      createdat timestamp default current_timestamp
      );
