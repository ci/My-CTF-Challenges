drop database if exists sqlsanitycheck;

create database sqlsanitycheck owner postgres;
\connect sqlsanitycheck

drop table if exists fl4g_1337;
create table fl4g_1337 (
    flag TEXT
);

insert into fl4g_1337 (flag) values ('tmctf{How_y0U_b3eN?___1mP0rt4nT_Fl4G_f0R_h34D_Mas7eR}');

drop table if exists users;
create table users (
    ua TEXT,
    email TEXT
);

insert into users (ua, email) values ('https://www.youtube.com/watch?v=dQw4w9WgXcQ :P.. P.S: Check out column flag from table fl4g_1337', 'john.smith@timisoaractf.com');
