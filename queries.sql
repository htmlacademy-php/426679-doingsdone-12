USE doingsdone;

SELECT * FROM users;
INSERT INTO users (username, email, password) VALUES
	('pasha','pasha@mail.ru','q1234eee'),
	('misha','misha@mail.ru','q1234ee'),
	('galya','galya@mail.ru','q123e'),
	('natasha','natasha@mail.ru','34eee');

SELECT * FROM projects;
INSERT INTO projects (title_project, user_id) VALUES
	('Входящие', 1),
	('Учеба', 2),
	('Работа', 3),
	('Домашние дела', 4),
	('Авто', 1);

SELECT * FROM tasks;
INSERT INTO tasks (title_task, user_id, project_id, st_check, dt_end) VALUES
	('Собеседование в IT компании', 1, 3, DEFAULT, '01.12.2020'),
	('Проверка ДЗ', 1, 3, DEFAULT, '05.12.2020'),
	('Уборка квартиры', 1, 4, DEFAULT, '10.12.2020'),
	('Прогулка', 1, 4, DEFAULT, '11.12.2020'),
	('Уборка квартиры', 2, 4, DEFAULT, '09.12.2020'),
	('Выполнить тестовое задание', 2, 3, DEFAULT, '04.12.2020'),
	('Сделать задание первого раздела', 3, 2, 1, '01.12.2019'),
	('Встреча с другом', 2, 1, DEFAULT, '22.12.2019'),
	('Купить корм для кота', 4, 4, DEFAULT, DEFAULT),
	('Заказать пиццу', 4, 4, DEFAULT, DEFAULT);

/* меняем статус на выполнено */
UPDATE tasks SET st_check = 1 WHERE title_task ='Встреча с другом';

/* обновляем название задачи по индентификатору */
UPDATE tasks SET title_task = 'Заказать пиццу' WHERE id = 2;

/* Выводим список всех проектов для одного пользователя */
SELECT username, title_project FROM users, projects WHERE users.id = projects.id AND users.id = 1;

/* Выводим список всех задач для одного проекта */
SELECT title_project, title_task FROM projects, tasks WHERE projects.id = tasks.project_id AND projects.id = 3;

