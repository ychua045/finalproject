create table movieinfo
( movie_id int unsigned not null auto_increment primary key,
  movie_name char(50) not null,
  directors char(50), 
  casts char(100), 
  genre	char(50), 
  rating float(3,1),
  runtime int unsigned,
  synopsis char(250), 
  poster char(50),
  splash_poster char(50)
);

create table moviecomment
( comment_id int unsigned not null auto_increment primary key,
  movie_id int unsigned not null,
  commentor char(20),
  comment_content char(250)
);

create table showinfo
(
  show_id int unsigned not null auto_increment primary key,
  movie_id int unsigned not null,
  cinema_id int unsigned not null,
  hall_id int unsigned not null,
  show_date char(20) not null,
  show_time char(20) not null,
  ticket_price float(4,2) not null
);

create table addonmeals
( meal_id int unsigned not null auto_increment primary key,
  meal_name char(50), 
  meal_price float(4,2),
  meal_image char(50)
);

create table orderlist 
( order_id int unsigned not null auto_increment primary key,
  order_dt char(20), 
  account_id int unsigned not null,
  show_id int unsigned not null,
  num_tickets int unsigned not null,
  ticket_price float(4,2)
);

create table tmpseats
( show_id int unsigned not null,
  seat_row int unsigned not null, 
  seat_col int unsigned not null,
  member_id int unsigned not null,
  start_dt char(20)
);

create table orderseat
( order_id int unsigned not null,
  seat_row int unsigned not null, 
  seat_col int unsigned not null
);
create table orderaddon
( order_id int unsigned not null, 
  meal_name char(50), 
  meal_price float(4,2), 
  meal_quantity int unsigned not null
);

create table memberlist
( member_id int unsigned not null auto_increment primary key,
  member_name char(25),
  member_password char(25),
  member_email char(255),
  member_hp char(20),
  member_card char(25),
  register_date char(20)
);

create table cinemainfo
( cinema_id int unsigned not null auto_increment primary key,
  cinema_name char(50) not null,
  num_halls int unsigned not null
);

create table cardlist
( card_id int unsigned not null auto_increment primary key,
  card_number char(25)
);