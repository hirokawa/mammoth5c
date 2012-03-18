CREATE TABLE entry (
  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  uid bigint(20) unsigned NOT NULL,
  ctime timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  content varchar(256) DEFAULT NULL,
  PRIMARY KEY (id));

CREATE TABLE user (
  uid bigint(20) NOT NULL AUTO_INCREMENT,
  username varchar(32) NOT NULL,
  password varchar(32) NOT NULL,
  nickname varchar(32) DEFAULT NULL,
  PRIMARY KEY (uid));
