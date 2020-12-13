USE doingsdone;

SELECT * FROM users;
INSERT INTO users (username, email, password) VALUES
	('pasha','pasha@mail.ru','q1234eee'),
	('misha','misha@mail.ru','q1234ee'),
	('galya','galya@mail.ru','q123e'),
	('natasha','natasha@mail.ru','34eee');

SELECT * FROM projects;
INSERT INTO projects (title_project, user_id) VALUES
	('Входящие', DEFAULT),
	('Учеба', DEFAULT),
	('Работа', DEFAULT),
	('Домашние дела', DEFAULT),
	('Авто', DEFAULT);

SELECT * FROM tasks;
INSERT INTO tasks (title_task, user_id, project_id, dt_end) VALUES
	('Собеседование в IT компании', DEFAULT, DEFAULT, '01.12.2020'),
	('Выполнить тестовое задание', DEFAULT, DEFAULT, '04.12.2020'),
	('Сделать задание первого раздела', DEFAULT, DEFAULT, '01.12.2019'),
	('Встреча с другом', DEFAULT, DEFAULT, '22.12.2019'),
	('Купить корм для кота', DEFAULT, DEFAULT, DEFAULT),
	('Заказать пиццу', DEFAULT, DEFAULT, DEFAULT);
