create table users(
user_id int (3) auto_increment,
user_name varchar (255),
user_pass varchar (255),
user_lvl int(2),
cust_id int(4),
isApproved int(1),
primary key(user_id)
);

create table customers(
cust_id int (3) auto_increment,
cust_lname varchar (255) ,
cust_fname varchar (255),
cust_bday date,
cust_gender varchar (10),
cust_address varchar (255),
cust_phone varchar(30),
cust_email varchar (39),
cust_dateRegistered datetime,
cust_dateApproved datetime,
primary key(cust_id)
)