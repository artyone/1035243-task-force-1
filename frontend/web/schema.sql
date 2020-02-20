CREATE DATABASE task_force_work
    CHARACTER SET UTF8
    COLLATE UTF8_GENERAL_CI;

USE task_force_work;

CREATE TABLE categories /*Таблица категорий*/
(
    id   INT(11)     NOT NULL AUTO_INCREMENT, /*сквозной айди*/
    name VARCHAR(50) NOT NULL, /*имя категории*/
    icon VARCHAR(50) NOT NULL, /*иконка*/
    PRIMARY KEY (id),
    UNIQUE (name)
);

CREATE TABLE cities /*Таблица городов*/
(
    id        INT(11)     NOT NULL AUTO_INCREMENT, /*сквозной айди*/
    name      VARCHAR(50) NOT NULL, /*имя города*/
    latitude  VARCHAR(50) NOT NULL,
    longitude VARCHAR(50) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE (name)

);

CREATE TABLE countries /*Таблица стран*/
(
    id   INT(11)     NOT NULL AUTO_INCREMENT, /*сквозной айди*/
    name VARCHAR(50) NOT NULL, /*имя страны*/
    PRIMARY KEY (id),
    UNIQUE (name)

);

CREATE TABLE locations /*Таблица локации*/
(
    id         INT(11) NOT NULL AUTO_INCREMENT, /*сквозной айди*/
    country_id INT(11) NOT NULL, /*айди страны*/
    city_id    INT(11) NOT NULL, /*айди города*/
    location   VARCHAR(500), /*геолокация*/
    FOREIGN KEY (country_id) REFERENCES countries (id),
    FOREIGN KEY (city_id) REFERENCES cities (id),
    PRIMARY KEY (id)
);

CREATE TABLE files /*Таблица с ссылками на файлы*/
(
    id   INT(11)     NOT NULL AUTO_INCREMENT, /*сквозной айди*/
    link VARCHAR(50) NOT NULL, /*ссылка на файл*/
    PRIMARY KEY (id)
);

CREATE TABLE users /*Таблица пользователей*/
(
    id            INT(11)      NOT NULL AUTO_INCREMENT, /*сквозной айди аккаунтов*/
    email         VARCHAR(254) NOT NULL, /*имейл аккаунта*/
    password_hash VARCHAR(32)  NOT NULL, /*хэш пароля*/
    name          VARCHAR(500), /*имя пользователя*/
    creation_time DATETIME DEFAULT CURRENT_TIMESTAMP, /*дата регистрации*/
    avatar        INT(11), /*ссылка на аватар*/
    FOREIGN KEY (avatar) REFERENCES files (id),
    PRIMARY KEY (id),
    UNIQUE (email)
);

CREATE TABLE users_data /*Таблица данных пользователей*/
(
    id               INT(11) NOT NULL AUTO_INCREMENT, /*сквозной айди*/
    user_id          INT(11) NOT NULL, /*айди пользователя*/
    location_id      INT(11), /*локация пользователя*/
    address          VARCHAR(500),
    birthday         DATETIME, /*дата рождения*/
    phone            VARCHAR(20), /*мобильный телефон*/
    skype            VARCHAR(50), /*скайп*/
    about            VARCHAR(500), /*биография*/
    last_online_time DATETIME, /*дата последнего онлайн*/
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (location_id) REFERENCES locations (id),
    PRIMARY KEY (id)
);

CREATE TABLE users_work_photos /*Таблица с ссылками на работы по заданиям*/
(
    id      INT(11) NOT NULL AUTO_INCREMENT, /*сквозной айди фотографии*/
    user_id INT(11) NOT NULL, /*айди пользователя*/
    file_id INT(11) NOT NULL, /*айди в таблице файлов*/
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (file_id) REFERENCES files (id),
    PRIMARY KEY (id),
    INDEX (user_id)
);

CREATE TABLE users_notifications /*таблица настроек уведомлений*/
(
    id           INT(11) NOT NULL AUTO_INCREMENT, /*сквозной айди*/
    user_id      INT(11) NOT NULL, /*айди пользователя*/
    new_feedback TINYINT NOT NULL DEFAULT 0, /*Новый отклик к заданию*/
    new_chat     TINYINT NOT NULL DEFAULT 0, /*Новое сообщение в чате*/
    new_refuse   TINYINT NOT NULL DEFAULT 0, /*Отказ от задания исполнителем*/
    start_task   TINYINT NOT NULL DEFAULT 0, /*Старт задания*/
    finish_task  TINYINT NOT NULL DEFAULT 0, /*Завершение задания*/
    FOREIGN KEY (user_id) REFERENCES users (id),
    PRIMARY KEY (id),
    INDEX (user_id)
);

CREATE TABLE users_visible /*таблица настроек видимости*/
(
    id            INT(11) NOT NULL AUTO_INCREMENT, /*сквозной айди аккаунтов*/
    user_id       INT(11) NOT NULL, /*айди пользователя*/
    only_customer TINYINT NOT NULL DEFAULT 0, /*показывать контакты только заказчику */
    not_visible   TINYINT NOT NULL DEFAULT 0, /*не показывать мой профиль в списке исполнителей */
    FOREIGN KEY (user_id) REFERENCES users (id),
    PRIMARY KEY (id),
    INDEX (user_id)
);

CREATE TABLE users_category /*Таблица отмеченных категорий пользователя*/
(
    id          INT(11) NOT NULL AUTO_INCREMENT, /*сквозной айди*/
    user_id     INT(11) NOT NULL, /*айди пользователя*/
    category_id INT(11) NOT NULL, /*айди категории*/
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (category_id) REFERENCES categories (id),
    PRIMARY KEY (id),
    INDEX (user_id)
);

CREATE TABLE users_favorites /*Таблица избранного пользователя*/
(
    id          INT(11) NOT NULL AUTO_INCREMENT, /*сквозной айди*/
    user_id     INT(11) NOT NULL, /*айди пользователя*/
    favorite_id INT(11) NOT NULL, /*айди избранного */
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (favorite_id) REFERENCES users (id),
    PRIMARY KEY (id),
    INDEX (user_id)
);

CREATE TABLE tasks /*Общая таблица заданий*/
(
    id               INT(11)      NOT NULL AUTO_INCREMENT, /*сквозной айди задания, уникальный*/
    creation_time    DATETIME              DEFAULT CURRENT_TIMESTAMP, /*дата создания криэйшн тайм*/
    name             VARCHAR(500) NOT NULL, /*имя задания*/
    category_id      INT(11)      NOT NULL, /*айди категории задания*/
    location_id      INT(11),
    latitude         INT,
    longitude        INT,
    address_comments VARCHAR(500), /*комментарий для адреса*/
    description      VARCHAR(500), /*описание задания*/
    price            INT                   DEFAULT NULL, /*цена, целое не отрицательное*/
    customer_id      INT(11)      NOT NULL, /*айди заказчика*/
    executor_id      INT(11), /*айди исполнителя*/
    deadline_time    DATETIME, /*дата выполнения*/
    status           TINYINT      NOT NULL DEFAULT 0, /*статус*/
    FOREIGN KEY (category_id) REFERENCES categories (id),
    FOREIGN KEY (location_id) REFERENCES cities (id),
    FOREIGN KEY (customer_id) REFERENCES users (id),
    FOREIGN KEY (executor_id) REFERENCES users (id),
    PRIMARY KEY (id),
    INDEX (status),
    INDEX (category_id)
);

CREATE TABLE tasks_responses /*Таблица откликов на задания*/
(
    id            INT(11) NOT NULL AUTO_INCREMENT, /*сквозной айди задания, уникальный*/
    creation_time DATETIME DEFAULT CURRENT_TIMESTAMP, /*дата создания*/
    task_id       INT(11) NOT NULL, /*айди задания*/
    executor_id   INT(11) NOT NULL, /*айди исполнителя*/
    description       VARCHAR(500), /*комментарий к отклику*/
    price         INT, /*цена, целое не отрицательное*/
    FOREIGN KEY (task_id) REFERENCES tasks (id),
    FOREIGN KEY (executor_id) REFERENCES users (id),
    PRIMARY KEY (id)
);

CREATE TABLE tasks_files /*Таблица файлов к заданию*/
(
    id      INT(11) NOT NULL AUTO_INCREMENT, /*сквозной айди, уникальный*/
    task_id INT(11) NOT NULL, /*айди задания*/
    file_id INT(11) NOT NULL, /*айди файла*/
    FOREIGN KEY (task_id) REFERENCES tasks (id),
    FOREIGN KEY (file_id) REFERENCES files (id),
    PRIMARY KEY (id)
);

CREATE TABLE tasks_chats /*Таблица чатов заданий*/
(
    id            INT(11)      NOT NULL AUTO_INCREMENT, /*сквозной айди чата, уникальный*/
    creation_time DATETIME   DEFAULT CURRENT_TIMESTAMP, /*дата публикации сообщения*/
    task_id       INT(11)      NOT NULL, /*айди задания*/
    sender        INT(11)      NOT NULL, /*айди заказчика*/
    recipient     INT(11)      NOT NULL, /*айжи исполнителя*/
    message       VARCHAR(500) NOT NULL, /*сообщение*/
    `read`        TINYINT(4) DEFAULT 0, /*флаг прочитано/не прочитано */
    FOREIGN KEY (sender) REFERENCES users (id),
    FOREIGN KEY (recipient) REFERENCES users (id),
    FOREIGN KEY (task_id) REFERENCES tasks (id),
    PRIMARY KEY (id),
    INDEX (task_id)
);

CREATE TABLE tasks_completed_feedback /*Таблица отклика выполненного задания*/
(
    id              INT(11)    NOT NULL AUTO_INCREMENT, /*сквозной айди отклика, уникальный*/
    creation_time   DATETIME DEFAULT CURRENT_TIMESTAMP, /*дата публикации отклика*/
    executor_id     INT(11)    NOT NULL, /*айди пользователя, которому оставили комментарий*/
    commentators_id INT(11)    NOT NULL, /*айди пользователя, оставившего отклик*/
    task_id         INT(11)    NOT NULL, /*айди задания*/
    description     VARCHAR(500), /*текст отклика*/
    rating          TINYINT(4) NOT NULL, /*рейтинг*/
    FOREIGN KEY (executor_id) REFERENCES users (id),
    FOREIGN KEY (commentators_id) REFERENCES users (id),
    FOREIGN KEY (task_id) REFERENCES tasks (id),
    PRIMARY KEY (id),
    INDEX (executor_id)
);







