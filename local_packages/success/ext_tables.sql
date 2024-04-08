CREATE TABLE tt_content (
	overline varchar(255) DEFAULT '' NOT NULL
);

CREATE TABLE tx_success_card (
	headline    varchar(255) DEFAULT '' NOT NULL,
	text        TEXT DEFAULT '' NOT NULL,
	media       int(11) DEFAULT '0' NOT NULL,
	link    varchar(255) DEFAULT '' NOT NULL
);

CREATE TABLE tx_success_number_item (
	number       int(11) DEFAULT '0' NOT NULL,
	suffix    varchar(11) DEFAULT '' NOT NULL,
	label    varchar(255) DEFAULT '' NOT NULL
);
