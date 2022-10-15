-- noinspection SqlNoDataSourceInspectionForFile

/*
Follows CakePHP naming conventions.
For use with SiteX.
*/

DROP TABLE IF EXISTS companies_users;
DROP TABLE IF EXISTS signatures;
DROP TABLE IF EXISTS inductions;
DROP TABLE IF EXISTS companies_projects;
DROP TABLE IF EXISTS checkins;
DROP TABLE IF EXISTS equipment;
DROP TABLE IF EXISTS documents;
DROP TABLE IF EXISTS companies;
DROP TABLE IF EXISTS projects;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    is_admin BOOL NOT NULL DEFAULT 0,
    `role` ENUM('Builder', 'Client', 'On-site Worker', 'Contractor', 'Subcontractor', 'Consultant', 'Visitor') NOT NULL,
    `status` ENUM('Pending', 'Verified', 'Deactivated') NOT NULL DEFAULT 'Pending',
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    address_no VARCHAR(10) NOT NULL,
    address_street VARCHAR(50) NOT NULL,
    address_suburb VARCHAR(50) NOT NULL,
    address_state VARCHAR(50) NOT NULL,
    address_postcode VARCHAR(20) NOT NULL,
    address_country VARCHAR(50) NOT NULL,
    email VARCHAR(320) UNIQUE NOT NULL,
    `password` VARCHAR(128) NOT NULL,
    phone_mobile VARCHAR(15),
    phone_office VARCHAR(15),
    emergency_name VARCHAR(100) NOT NULL,
    emergency_relationship VARCHAR(50) NOT NULL,
    emergency_phone VARCHAR(15) NOT NULL
);

CREATE TABLE projects (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    project_type ENUM('Construction', 'Renovation', 'De-fit', 'Other') NOT NULL DEFAULT 'Construction', /*Other types?*/
    `name` VARCHAR(50) NOT NULL,
    builder_id INT UNSIGNED,
    client_name VARCHAR(50) NOT NULL,
    client_email VARCHAR(320) NOT NULL,
    client_phone VARCHAR(15) NOT NULL,
    start_date DATE,
    est_completion_date DATE,
    `status` ENUM('Pending', 'Active', 'Cancelled', 'Complete', 'Archived') NOT NULL DEFAULT 'Active',
    completion_date DATE,
    address_no VARCHAR(10) NOT NULL,
    address_street VARCHAR(50) NOT NULL,
    address_suburb VARCHAR(50) NOT NULL,
    address_state VARCHAR(50) NOT NULL,
    address_postcode VARCHAR(20) NOT NULL,
    address_country VARCHAR(50) NOT NULL,
    CONSTRAINT project_client_fk FOREIGN KEY (builder_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE companies (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    admin_id INT UNSIGNED,
    company_type ENUM('Builder', 'Contractor', 'Subcontractor', 'Supplier'),
    abn BIGINT NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    address_no VARCHAR(10) NOT NULL,
    address_street VARCHAR(50) NOT NULL,
    address_suburb VARCHAR(50) NOT NULL,
    address_state VARCHAR(50) NOT NULL,
    address_postcode VARCHAR(20) NOT NULL,
    address_country VARCHAR(50) NOT NULL,
    contact_name VARCHAR(50) NOT NULL,
    contact_email VARCHAR(320) NOT NULL,
    contact_phone VARCHAR(15) NOT NULL,
    CONSTRAINT admin_fk FOREIGN KEY (admin_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE documents (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL,
    details VARCHAR(250),
    document_no VARCHAR(50), /*License no., receipt no. etc*/
    document_type ENUM('SWMS', 'Induction', 'Site Policy', 'High Risk Work License', 'Insurance', 'Card', 'Other') NOT NULL,
    worker_accessible BOOL DEFAULT 1,
    class VARCHAR(50), /*For high risk work license and..?*/
    `issuer` VARCHAR(50),
    issue_date DATE,
    expiry_date DATE,
    declaration_text VARCHAR(500) DEFAULT 'I acknowledge and agree to all terms established in the document.',
    related_project_id INT UNSIGNED,
    related_user_id INT UNSIGNED,
    related_company_id INT UNSIGNED,
    CONSTRAINT documents_project_fk FOREIGN KEY (related_project_id) REFERENCES projects(id) ON DELETE CASCADE,
    CONSTRAINT documents_user_fk FOREIGN KEY (related_user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT documents_company_fk FOREIGN KEY (related_company_id) REFERENCES companies(id) ON DELETE CASCADE
);

CREATE TABLE equipment (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    equipment_type ENUM('Other'),
    `name` VARCHAR(100) NOT NULL,
    is_licensed BOOLEAN NOT NULL DEFAULT 0,
    builder_auth INT UNSIGNED NOT NULL,
    hired_from_date DATE,
    hired_until_date DATE,
    CONSTRAINT equipment_builder_auth_fk FOREIGN KEY (builder_auth) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE checkins (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    project_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    checkin_datetime DATETIME NOT NULL,
    checkout_datetime DATETIME,
    email_sent INT DEFAULT 0,
    CONSTRAINT checkins_projects_fk FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    CONSTRAINT checkins_users_fk FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE companies_projects (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    company_id INT UNSIGNED NOT NULL,
    project_id INT UNSIGNED NOT NULL,
    CONSTRAINT c_p_companies_fk FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE,
    CONSTRAINT c_p_projects_fk FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
);

CREATE TABLE inductions (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    project_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    company_id INT UNSIGNED NOT NULL,
    inducted_date DATE DEFAULT NULL, /* If NULL, they aren't inducted but have been sent their docs. */
    CONSTRAINT inductions_project_fk FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    CONSTRAINT inductions_user_fk FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT inductions_company_fk FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE
);

CREATE TABLE signatures (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    document_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    signed_datetime DATETIME,
    CONSTRAINT d_u_documents_fk FOREIGN KEY (document_id) REFERENCES documents(id) ON DELETE CASCADE,
    CONSTRAINT d_u_users_fk FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE companies_users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    company_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    `is_company_admin` BOOLEAN NOT NULL DEFAULT 0,
    confirmed BOOLEAN NOT NULL DEFAULT 0,
    CONSTRAINT c_u_companies_fk FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE,
    CONSTRAINT c_u_users_fk FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO users VALUES
    (1, 1, 'Builder', 'Verified', 'Damian', 'Marchese', '1', 'Placeholder Street', 'Mount Waverley',
     'Victoria', '3149', 'Australia', 'sitex@u22s1010.monash-ie.me',
     '$2y$10$fL.J4yYoVkXPxiRJYFVlhO4TIswzZvhKgpyMIWrQUOCb2f.2FBmRm',
     '0412222222', '98000000', 'Mark Smith', 'Friend', '0422222222'),
    (2, 0, 'Contractor', 'Verified', 'Joe', 'Contractson', '3', 'Placeholder Street', 'Mount Waverley',
    'Victoria', '3149', 'Australia', 'joe@mail.com',
    '$2y$10$fL.J4yYoVkXPxiRJYFVlhO4TIswzZvhKgpyMIWrQUOCb2f.2FBmRm',
    '0412222223', '98000001', 'Mark Smith', 'Friend', '0422222222'),
    (3, 0, 'On-site Worker', 'Verified', 'Walter', 'Workson', '1', 'Placeholder Street', 'Mount Waverley',
     'Victoria', '3149', 'Australia', 'walter@mail.com',
     '$2y$10$fL.J4yYoVkXPxiRJYFVlhO4TIswzZvhKgpyMIWrQUOCb2f.2FBmRm',
     '0412222224', '98000002', 'Mark Smith', 'Friend', '0422222222'),
    (4, 0, 'On-site Worker', 'Verified', 'William', 'Workson', '1', 'Placeholder Street', 'Mount Waverley',
    'Victoria', '3149', 'Australia', 'william@mail.com',
    '$2y$10$fL.J4yYoVkXPxiRJYFVlhO4TIswzZvhKgpyMIWrQUOCb2f.2FBmRm',
    '0412222224', '98000003', 'Mark Smith', 'Friend', '0422222222'),
    (5, 0, 'Builder', 'Verified', 'Daniel', 'Ward', '12', 'Placeholder Street', 'Mount Waverley',
     'Victoria', '3149', 'Australia', 'dwar@student.monash.edu',
     '$2y$10$fL.J4yYoVkXPxiRJYFVlhO4TIswzZvhKgpyMIWrQUOCb2f.2FBmRm',
     '0412222223', '98000000', 'Mark Smith', 'Friend', '0422222222'),
    (6, 0, 'On-site Worker', 'Pending', 'Joe Jr.', 'Contractson', '3', 'Placeholder Street', 'Mount Waverley',
     'Victoria', '3149', 'Australia', 'joejr@mail.com',
     '$2y$10$fL.J4yYoVkXPxiRJYFVlhO4TIswzZvhKgpyMIWrQUOCb2f.2FBmRm',
     '0412228223', '98000000', 'Mark Smith', 'Friend', '0422222222');

INSERT INTO projects (id, project_type, `name`, builder_id, client_name, client_email, client_phone,
                      start_date, est_completion_date, status, address_no, address_street,
                      address_suburb, address_state, address_postcode, address_country)
                      VALUES
    (1, 'Construction', 'Corporate Office 142', 1, 'DC Ward', 'd.c.ward@outlook.com', '0411222222',
        '2022-08-09', '2023-05-04', 'Active', '123', 'Worksite Street', 'Melbourne',
        'Victoria', '3000', 'Australia'),
    (2, 'Construction', 'Rustic Cabin', 1, 'George Foreman', 'george@mail.com', '0411222227',
     '2020-05-02', '2022-01-04', 'Complete', '123', 'Nice Avenue', 'Melbourne',
     'Victoria', '3000', 'Australia');

INSERT INTO documents (id, `name`, document_no, document_type, issue_date, expiry_date, related_project_id, related_user_id) VALUES
    (1, 'CorpOffice 142 Induction doc', 'ABC123', 'Induction', '2022-05-03', '2023-05-03', 1, NULL),
    (2, 'CorpOffice 142 2nd induction doc', 'ABC1234', 'Induction', '2022-05-04', '2023-05-04', 1, NULL),
    (3, 'Working with Children Check', 'AB4', 'Other', '2022-05-07', '2023-05-08', NULL, 1);

INSERT INTO companies VALUES
    (1, 1, 'Builder', 404, 'Cosmic Property', '19', 'Placeholder Street', 'Mount Waverley',
     'Victoria', '3149', 'Australia', 'Receptionist Joe', 'joe@fake.com', '0422999999'),
    (2, 2, 'Contractor', 40401, 'Joe Outsourcing', '2', 'Placeholder Street', 'Mount Waverley',
     'Victoria', '3149', 'Australia', 'Receptionist Jane', 'jane@fake.com', '0422999998'),
    (3, 5, 'Builder', 4013230, 'DanConstructions', '222', 'Placeholder Street', 'Mount Waverley',
     'Victoria', '3149', 'Australia', 'Receptionist Jack', 'jack@fake.com', '0422999978');

INSERT INTO companies_users VALUES
    (1, 1, 1, 1, 1),
    (2, 2, 2, 1, 1),
    (3, 1, 3, 0, 1),
    (4, 1, 4, 0, 0),
    (5, 3, 5, 1, 1),
    (6, 2, 6, 0, 1);

INSERT INTO companies_projects VALUES
    (1, 1, 1),
    (2, 1, 2);

INSERT INTO inductions VALUES
    (1, 1, 3, 1, NULL);

INSERT INTO checkins VALUES
    (1, 1, 3, '2022-07-18 14:30:17', NULL, 0),
    (2, 1, 3, '2022-07-18 12:54:02', '2022-07-18 18:42:44', 0),
    (3, 1, 3, '2022-08-11 14:54:02', NULL, 0),
    (4, 1, 3, '2022-08-14 09:54:02', NULL, 0);

INSERT INTO signatures VALUES
    (1, 1, 3, NULL),
    (2, 2, 3, NULL);
