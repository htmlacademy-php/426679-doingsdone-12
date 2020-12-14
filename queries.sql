USE doingsdone;

SELECT * FROM users;
INSERT INTO users (user_id, username, email, password) VALUES
	(DEFAULT, 'pasha','pasha@mail.ru','q1234eee'),
	(DEFAULT, 'misha','misha@mail.ru','q1234ee'),
	(DEFAULT, 'galya','galya@mail.ru','q123e'),
	(DEFAULT, 'natasha','natasha@mail.ru','34eee');

SELECT * FROM projects;
INSERT INTO projects (project_id, title_project, user_id) VALUES
	(DEFAULT, 'Входящие', 1),
	(DEFAULT, 'Учеба', 2),
	(DEFAULT, 'Работа', 3),
	(DEFAULT, 'Домашние дела', 4),
	(DEFAULT, 'Авто', 1);

SELECT * FROM tasks;
INSERT INTO tasks (task_id, title_task, user_id, project_id, st_check, dt_end) VALUES
	(DEFAULT, 'Собеседование в IT компании', 1, 3, DEFAULT, '01.12.2020'),
	(DEFAULT, 'Выполнить тестовое задание', 2, 3, DEFAULT, '04.12.2020'),
	(DEFAULT, 'Сделать задание первого раздела', 3, 2, 1, '01.12.2019'),
	(DEFAULT, 'Встреча с другом', 2, 1, DEFAULT, '22.12.2019'),
	(DEFAULT, 'Купить корм для кота', 4, 4, DEFAULT, DEFAULT),
	(DEFAULT, 'Заказать пиццу', 4, 4, DEFAULT, DEFAULT);

/* меняем статус на выполнено */
UPDATE tasks SET st_check = 1 WHERE title_task ='Встреча с другом';

/* обновляем название задачи по индентификатору */
UPDATE tasks SET title_task = 'Заказать пиццу' WHERE task_id = 2;

/* Выводим список всех проектов для одного пользователя */
SELECT username, title_project FROM users, projects WHERE users.user_id = projects.user_id AND users.user_id = 1;

/* Выводим список всех задач для одного проекта */
SELECT title_project, title_task FROM projects, tasks WHERE projects.project_id = tasks.project_id AND projects.project_id = 3;

