CREATE TABLE tu_gps_syn_usr
(
    usr_id    serial primary key,
    first_name        VARCHAR(200) not null,
		last_name        VARCHAR(200) not null,
		email        VARCHAR(200) not null,
		password      VARCHAR(200) not null,
		usr_activation_link      VARCHAR(200),
		status      VARCHAR(11),
    created_on        DATE
);

---------------------------------*--------------------------------------
CREATE TABLE td_gps_syn_options (
	opt_id serial PRIMARY KEY,
	usr_id int4,
	prvin_id int4,
	zoom int4,
	opt_latitude FLOAT,
	opt_longitude FLOAT
);