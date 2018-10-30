create table migrations
(
  id        int unsigned auto_increment
    primary key,
  migration varchar(255) not null,
  batch     int          not null
)
  collate = utf8mb4_unicode_ci;

create table password_resets
(
  email      varchar(255) not null,
  token      varchar(255) not null,
  created_at timestamp    null
)
  collate = utf8mb4_unicode_ci;

create index password_resets_email_index
  on password_resets (email);

create table roles
(
  id   int          not null
    primary key,
  name varchar(255) not null
);

create table users
(
  id                int unsigned auto_increment
    primary key,
  role_id           int          null,
  name              varchar(255) not null,
  email             varchar(255) not null,
  email_verified_at timestamp    null,
  password          varchar(255) not null,
  phone             varchar(32)  null,
  address           varchar(255) null,
  gender            char         null,
  created_at        timestamp    null,
  updated_at        timestamp    null,
  remember_token    varchar(100) null,
  constraint users_email_unique
  unique (email),
  constraint fk_role_users
  foreign key (role_id) references roles (id)
)
  collate = utf8mb4_unicode_ci;

create table stores
(
  id          int auto_increment
    primary key,
  name        varchar(255)  not null,
  description varchar(1000) not null,
  address     varchar(255)  not null,
  user_id     int unsigned  not null,
  constraint fk_user_stores
  foreign key (user_id) references users (id)
);

create table products
(
  id               int auto_increment
    primary key,
  name             varchar(255) not null,
  description      longtext     not null,
  original_price   double       not null,
  discounted_price double       null,
  stock            int          not null,
  category         varchar(255) not null,
  store_id         int          not null,
  constraint fk_store_products
  foreign key (store_id) references stores (id)
);

create table images
(
  id         int auto_increment
    primary key,
  link       varchar(255) not null,
  product_id int          not null,
  constraint fk_product_images
  foreign key (product_id) references products (id)
);


