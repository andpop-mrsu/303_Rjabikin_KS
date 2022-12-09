
DROP TABLE IF EXISTS specializations;
DROP TABLE IF EXISTS doctors;
DROP TABLE IF EXISTS efficiency;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS procedures;
DROP TABLE IF EXISTS report;
DROP TABLE IF EXISTS register;


CREATE TABLE specializations (
    id INTEGER PRIMARY KEY,
    specialization_name VARCHAR(255) NOT NULL UNIQUE
);


CREATE TABLE doctors (
    id INTEGER PRIMARY KEY,
    FIO VARCHAR(255) NOT NULL,
    status VARCHAR(255) NOT NULL CHECK (status = "worker" OR status = "fired"),
    specialization_id INTEGER NOT NULL,
    begin_work_date TEXT NOT NULL,
    FOREIGN KEY (specialization_id) REFERENCES specializations(id)
);


CREATE TABLE efficiency (
    id INTEGER PRIMARY KEY,
    doctor_id INTEGER NOT NULL,
    persent REAL NOT NULL CHECK (persent > 0 AND persent <= 100),
    FOREIGN KEY (doctor_id) REFERENCES doctors(id)
);


CREATE TABLE categories (
    id INTEGER PRIMARY KEY,
    category_name VARCHAR(255) NOT NULL UNIQUE
);


CREATE TABLE procedures (
    id INTEGER PRIMARY KEY,
    procedure_name VARCHAR(255) NOT NULL,
    duration TEXT NOT NULL,
    price REAL NOT NULL,
    category_id INTEGER NOT NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);


CREATE TABLE report (
    id INTEGER PRIMARY KEY,
    doctor_id INTEGER NOT NULL,
    procedure_id INTEGER NOT NULL,
    FOREIGN KEY (doctor_id) REFERENCES doctors(id),
    FOREIGN KEY (procedure_id) REFERENCES procedures(id)
);


CREATE TABLE register (
    id INTEGER PRIMARY KEY,
    doctor_id INTEGER NOT NULL,
    procedure_id INTEGER NOT NULL,
    date_begin TEXT NOT NULL,
    time_begin TEXT NOT NULL,
    FOREIGN KEY (doctor_id) REFERENCES doctors(id),
    FOREIGN KEY (procedure_id) REFERENCES procedures(id)
);


    INSERT INTO specializations (specialization_name) VALUES
("Терапевт"),
("Гигиенист"),
("Хирург"),
("Ортопед"),
("Пародонтолог"),
("Имплантолог"),
("Ортодонт"),
("Стоматолог"),
("Челюстно-лицевой хирург"),
("Гнатолог");


    INSERT INTO doctors (FIO, status, specialization_id, begin_work_date) VALUES
("Акимов Константин Викторович", "worker", 1, "01.01.2022"),
("Амирова Алина Сергеевна", "worker", 2, "02.02.2022"),
("Конкордин Виталий Васильевич", "worker", 3, "05.01.2022"),
("Буров Корней Робертович", "worker", 4, "04.04.2002"),
("Дуб Александр Порфирьевич", "fired", 5, "01.01.2022"),
("Евсеев Леонид Макарович", "worker", 5, "13.05.2022"),
("Бугреева Валерия Антоновна", "worker", 6, "27.06.2022"),
("Всеволодова Анна Мирославовна", "fired", 7, "01.01.2022"),
("Агафонова Марта Федосеевна","worker",7,"13.05.2022"),
("Кочетков Павел Петрович", "worker", 8, "12.03.2022"),
("Орехова Иоланта Михайловна","worker",9,"05.01.2022");


    INSERT INTO categories (category_name) VALUES
("Имплантация"),
("Терапевтическая стоматология"),
("Хирургическая стоматология");


    INSERT INTO efficiency (doctor_id, persent) VALUES
(1,5),
(2,15),
(3,7.5),
(4,12),
(5,3),
(6,4.5),
(7,20),
(8,13.2),
(9,10),
(10,3),
(11,7);


    INSERT INTO procedures (procedure_name, duration, price, category_id) VALUES
("Установка импланта", "03:15:00", 25000, 1),
("Протезирование", "01:00:00", 5000, 1),
("Установка виниров", "04:00:00", 15000, 1),
("Лечение кариеса", "00:20:00", 3200, 2),
("Профессиональная гигиена", "00:30:00", 1800, 2),
("Профилактический осмотр", "00:20:00", 1200, 2),
("Удаление зуба мудрости", "01:20:00", 7500, 3),
("Удаление молочного зуба", "00:10:00", 700, 3),
("Удаление зуба", "01:00:00", 2200, 3),
("Пластика уздечки", "00:25:00", 2500, 3);


    INSERT INTO register (doctor_id, procedure_id, date_begin, time_begin) VALUES
(1, 2, "12.12.2022", "10:00"),
(1, 2, "12.12.2022", "15:00"),
(2, 2, "16.12.2022", "08:00"),
(2, 2, "23.12.2022", "09:00"),
(3, 2, "10.12.2022", "13:15"),
(3, 2, "28.12.2022", "17:35"),
(4, 2, "11.01.2023", "08:30"),
(6, 2, "09.01.2023", "09:45"),
(7, 2, "16.01.2023", "14:15"),
(9, 2, "19.01.2023", "16:35"),
(10, 2, "21.01.2023", "07:00"),
(11, 2, "24.01.2023", "09:20"),
(7, 2, "27.01.2023", "17:15"),
(4, 2, "30.01.2023", "18:35");


    INSERT INTO report (doctor_id, procedure_id) VALUES
(1, 6),
(2, 4),
(3, 1),
(4, 5),
(5, 5),
(2, 7),
(4,3),
(5,1),
(6,2),
(7,7),
(8,8),
(9,9),
(10,5),
(11,3);

