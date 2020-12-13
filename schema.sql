CREATE DATABASE doingsdone
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE doingsdone;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    username VARCHAR(128) NOT NULL UNIQUE,
    email VARCHAR(128) NOT NULL UNIQUE,
    password CHAR(64) NOT NULL UNIQUE,
    dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE projects (
	project_id INT AUTO_INCREMENT PRIMARY KEY,
	user_id INT,
	title_project VARCHAR(128) NOT NULL,
	INDEX idxProjectUser (user_id),
	CONSTRAINT project_user_td FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE tasks (
    task_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    project_id INT,
    dt_task TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    st_check INT(1) DEFAULT 0,
    title_task VARCHAR(128) NOT NULL,
    dl_file VARCHAR(4000) NULL,
    dt_end DATE NULL,
    INDEX idxTasksUser (user_id),
    INDEX idxTaskProject (project_id),
    CONSTRAINT users_task_td FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT project_task_td FOREIGN KEY (project_id) REFERENCES projects (project_id) ON DELETE CASCADE ON UPDATE CASCADE
);
