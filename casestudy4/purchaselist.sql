create table purchaselist
( orderid int unsigned not null auto_increment primary key,
  orderdate char(20) not null,
  itemid int unsigned not null,
  itemtype int unsigned not null,
  quantity int unsigned not null,
  subtotal double
);