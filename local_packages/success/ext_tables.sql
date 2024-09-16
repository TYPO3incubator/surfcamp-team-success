CREATE TABLE tt_content
(
	overline     varchar(255) DEFAULT '' NOT NULL,
	header_style varchar(255) DEFAULT '' NOT NULL,
	button_link  varchar(2048) DEFAULT '' NOT NULL,
	button_label varchar(255) DEFAULT '' NOT NULL,
	button_style varchar(255) DEFAULT '' NOT NULL,
	name varchar(255) DEFAULT '' NOT NULL,
	color varchar(255) DEFAULT '' NOT NULL,
	navigation varchar(255) DEFAULT '' NOT NULL
);

CREATE TABLE tx_success_card
(
	headline     varchar(255) DEFAULT '' NOT NULL,
	text         text,
	media        int(11) DEFAULT '0' NOT NULL,
	button_link  varchar(2048) DEFAULT '' NOT NULL,
	button_label varchar(255) DEFAULT '' NOT NULL,
	button_style varchar(255) DEFAULT '' NOT NULL
);

CREATE TABLE tx_success_number_item
(
	number int(11) DEFAULT '0' NOT NULL,
	suffix varchar(11)  DEFAULT '' NOT NULL,
	label  varchar(255) DEFAULT '' NOT NULL
);

CREATE TABLE tx_success_faq
(
	question varchar(255) DEFAULT '' NOT NULL,
	answer   text
);

CREATE TABLE tx_success_review
(
	name   varchar(255) DEFAULT '' NOT NULL,
	review text
);

CREATE TABLE tx_success_feature
(
	icon   int(11) DEFAULT '0' NOT NULL,
	header varchar(255) DEFAULT '' NOT NULL,
	text   text
);

CREATE TABLE tx_success_menu_item
(
	label  varchar(255) DEFAULT '' NOT NULL,
	button_link  varchar(2048)
);
