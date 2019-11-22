CREATE DATABASE task_force_work
    CHARACTER SET UTF8
    COLLATE UTF8_GENERAL_CI;

USE task_force_work;

CREATE TABLE categories                                             /*Таблица категорий*/
(
    id                  INT(11)         NOT NULL AUTO_INCREMENT,    /*сквозной айди*/
    name                VARCHAR(50)     NOT NULL,                   /*имя категории*/
    PRIMARY KEY (id)
);

CREATE TABLE cities                                                 /*Таблица городов*/
(
    id                  INT(11)         NOT NULL AUTO_INCREMENT,    /*сквозной айди*/
    name                VARCHAR(50)     NOT NULL,                   /*имя города*/
    PRIMARY KEY (id)
);

CREATE TABLE accounts                                               /*Таблица аккаунтов*/
(
    id                  INT(11)         NOT NULL AUTO_INCREMENT,    /*сквозной айди аккаунтов*/
    email               VARCHAR(254)    NOT NULL,                   /*имейл аккаунта*/
    password_hash       VARCHAR(32)     NOT NULL,                   /*хэш пароля*/
    role                VARCHAR(20)     DEFAULT 'consumer',         /*роль пользователя (consumer or executor)*/
    notify              VARCHAR(20)     DEFAULT 'true',             /*уведомления*/
    visible             VARCHAR(20)     DEFAULT 'true',             /*видимость профиля*/
    PRIMARY KEY (id),
    UNIQUE (email) 
);

CREATE TABLE users                                                  /*Таблица пользователей*/
(
    id                  INT(11)         NOT NULL AUTO_INCREMENT,    /*сквозной айди пользователя*/
    id_account          INT(11)         NOT NULL,                   /*айди аккаунта*/
    date_register       DATETIME        DEFAULT CURRENT_TIMESTAMP,  /*дата регистрации */
    email               VARCHAR(254)    NOT NULL,                   /*имейл*/
    name                VARCHAR(500),                               /*имя пользователя*/
    country             VARCHAR(500),                               /*страна пользователя*/
    id_city             INT(11),                                    /*айди города*/
    date_birthday       DATETIME,                                   /*дата рождения*/
    mobile_phone        VARCHAR (20),                               /*мобильный телефон*/
    skype               VARCHAR(50),                                /*скайп*/
    biography           VARCHAR (500),                              /*биография*/
    raiting             TINYINT(4),                                 /*рейтинг*/
    count_task          INT(11),                                    /*количество выполненных заданий*/
    date_online         DATETIME,                                   /*дата последнего онлайн*/
    avatar_link         VARCHAR(50),                                /*ссылка на аватар*/
    FOREIGN KEY (id_account) REFERENCES accounts(id),
    FOREIGN KEY (id_city) REFERENCES cities(id),
    PRIMARY KEY (id)
);

CREATE TABLE users_photos                                           /*Таблица с ссылками на работы по заданиям*/
(
    id                  INT(11)         NOT NULL AUTO_INCREMENT,    /*сквозной айди фотографии*/
    id_user             INT(11)         NOT NULL,                   /*айди пользователя*/
    photo_link          VARCHAR(50)     NOT NULL,                   /*ссылка на фото*/
    FOREIGN KEY (id_user) REFERENCES users(id),
    PRIMARY KEY (id),
    INDEX (id_user)
);

CREATE TABLE users_category                                         /*Таблица отмеченных категорий пользователя*/
(
    id                  INT(11)         NOT NULL AUTO_INCREMENT,    /*сквозной айди*/
    id_user             INT(11)         NOT NULL,                   /*айди пользователя*/
    id_category         INT(11)         NOT NULL,                   /*айди категории*/
    FOREIGN KEY (id_user) REFERENCES users(id),
    FOREIGN KEY (id_category) REFERENCES categories(id),
    PRIMARY KEY (id),
    INDEX (id_user)
);

CREATE TABLE users_favorites                                        /*Таблица избранного пользователя*/
(
    id                  INT(11)         NOT NULL AUTO_INCREMENT,    /*сквозной айди*/
    id_user             INT(11)         NOT NULL,                   /*айди пользователя*/
    id_favorites        INT(11)         NOT NULL,                   /*айди избранного */
    FOREIGN KEY (id_user) REFERENCES users(id),
    FOREIGN KEY (id_favorites) REFERENCES users(id),
    PRIMARY KEY (id),
    INDEX (id_user)
);

CREATE TABLE tasks                                                  /*Общая таблица заданий*/
(
    id                  INT(11)         NOT NULL AUTO_INCREMENT,    /*сквозной айди задания, уникальный*/
    date_public         DATETIME        DEFAULT CURRENT_TIMESTAMP,  /*дата создания*/
    name                VARCHAR(500)    NOT NULL,                   /*имя задания*/
    id_category         INT(11)         NOT NULL,                   /*айди категории задания*/
    id_city             INT(11) ,                                   /*айди города*/
    adress              VARCHAR(500),                               /*адрес в формате координат*/
    adress_comments     VARCHAR(500),                               /*комментарий для адреса*/
    description         VARCHAR(500),                               /*описание задания*/
    price               INT             NOT NULL,                   /*цена, целое не отрицательное*/
    id_customer         INT(11)         NOT NULL,                   /*айди заказчика*/
    id_executor         INT(11) ,                                   /*айди исполнителя*/
    date_execution      DATETIME,                                   /*дата выполнения*/
    status              VARCHAR(20)     DEFAULT 'new',              /*статус */
    FOREIGN KEY (id_category) REFERENCES categories(id),
    FOREIGN KEY (id_city) REFERENCES cities(id),
    FOREIGN KEY (id_customer) REFERENCES users(id),
    FOREIGN KEY (id_executor) REFERENCES users(id),
    PRIMARY KEY (id),                                   
    INDEX (status),    
    INDEX (id_category)
);

CREATE TABLE tasks_responses                                        /*Таблица откликов на задания*/
(
    id                  INT(11)         NOT NULL AUTO_INCREMENT,    /*сквозной айди задания, уникальный*/
    date_public         DATETIME        DEFAULT CURRENT_TIMESTAMP,  /*дата создания*/
    id_task             INT(11)         NOT NULL,                   /*айди задания*/
    id_executor         INT(11)         NOT NULL,                   /*айди исполнителя*/
    comments            VARCHAR(500),                               /*комментарий к отклику*/
    price               INT             NOT NULL,                   /*цена, целое не отрицательное*/
    FOREIGN KEY (id_task) REFERENCES tasks(id),
    FOREIGN KEY (id_executor) REFERENCES users(id),
    PRIMARY KEY (id)
);

CREATE TABLE tasks_files                                            /*Таблица файлов к заданию*/
(
    id                  INT(11)         NOT NULL AUTO_INCREMENT,    /*сквозной айди, уникальный*/
    id_task             INT(11)         NOT NULL,                   /*айди задания*/
    file_link           VARCHAR(50)     NOT NULL,                   /*ссылка на файл*/
    FOREIGN KEY (id_task) REFERENCES tasks(id),
    PRIMARY KEY (id)
);

CREATE TABLE tasks_chats                                            /*Таблица чатов заданий*/
(
    id                  INT(11)         NOT NULL AUTO_INCREMENT,    /*сквозной айди чата, уникальный*/
    date_public         DATETIME        DEFAULT CURRENT_TIMESTAMP,  /*дата публикации сообщения*/
    id_task             INT(11)         NOT NULL,                   /*айди задания*/
    id_customer         INT(11)         NOT NULL,                   /*айди заказчика*/
    id_executor         INT(11)         NOT NULL,                   /*айжи исполнителя*/
    message             VARCHAR(500)    NOT NULL,                   /*сообщение*/
    FOREIGN KEY (id_customer) REFERENCES users(id),
    FOREIGN KEY (id_executor) REFERENCES users(id),
    FOREIGN KEY (id_task) REFERENCES tasks(id),
    PRIMARY KEY (id),
    INDEX (id_task)
);

CREATE TABLE tasks_completed_feedback                               /*Таблица отклика выполненного задания*/
(
    id                  INT(11)         NOT NULL AUTO_INCREMENT,    /*сквозной айди отклика, уникальный*/
    date_public         DATETIME        DEFAULT CURRENT_TIMESTAMP,  /*дата публикации отклика*/
    id_user             INT(11)         NOT NULL,                   /*айди пользователя которому оставили комментарий*/
    id_commentators     INT(11)         NOT NULL,                   /*айди пользователя, оставившего отклик*/
    id_task             INT(11)         NOT NULL,                   /*айди задания*/
    feedback            VARCHAR(500),                               /*текст отклика*/
    raiting             TINYINT(4)      NOT NULL,                   /*рейтинг*/
    FOREIGN KEY (id_user) REFERENCES users(id),
    FOREIGN KEY (id_commentators) REFERENCES users(id),
    FOREIGN KEY (id_task) REFERENCES tasks(id),
    PRIMARY KEY (id),
    INDEX (id_user)
);






