create table javajam1
( just_java float(6,2) not null,
  cafe_single float(6,2) not null,
  cafe_double float(6,2) not null,
  iced_single float(6,2) not null,
  iced_double float (6,2) not null
);

use javajam1;

insert into javajam1 values
  ("just_java", 2.00),
  ("cafe_single", 2.00),
  ("cafe_double", 3.00),
  ("iced_single", 4.75),
  ("iced_double", 5.75);