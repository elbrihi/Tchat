CREATE TABLE IF NOT EXISTS t_loginDetails (
	id INT(11) NOT NULL AUTO_INCREMENT,
	user_id INT(12) DEFAULT NULL,
	latest_activity DATE TIME DEFAULT NULL,
	created DATETIME DEFAULT NULL,
	createdBy VARCHAR(50) DEFAULT NULL,
	updated DATETIME DEFAULT NULL,
	updatedBy VARCHAR(50) DEFAULT NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;