USE yeticave;

CREATE TABLE users (id int AUTO_INCREMENT PRIMARY KEY,
                   name varchar(128) UNIQUE,
                    userPassword char(255),
                    email varchar(128) NOT NULL UNIQUE,
					dateRegistration timestamp DEFAULT CURRENT_TIMESTAMP,
                    contacts text
                   );
				   
CREATE TABLE categories (id int AUTO_INCREMENT PRIMARY KEY,
                   name varchar(128),
                    keyword varchar(128) UNIQUE
                   );
				   
CREATE TABLE lots (id int AUTO_INCREMENT PRIMARY KEY,
                   title varchar(128) UNIQUE,
                   description text,
				   img varchar(255),
                   categoryId int,
                   createrId int,
                   dateCreating timestamp DEFAULT CURRENT_TIMESTAMP,
                   dateClosing date,
                   ownerId int,
                   initialPrice int,
                   step int,
                   FOREIGN KEY (categoryId) REFERENCES categories (id),
                   FOREIGN KEY (createrId) REFERENCES users (id),
                   FOREIGN KEY (ownerId) REFERENCES users (id)
                   );
				   
CREATE TABLE rates (id int AUTO_INCREMENT PRIMARY KEY,
                    userId int,
                    dateCreating timestamp DEFAULT CURRENT_TIMESTAMP,
                    valueRate int,
                    lotId int,
                    FOREIGN KEY (userId) REFERENCES users (id),
                    FOREIGN KEY (lotId) REFERENCES lots (id)
                   );
				   
CREATE INDEX indexOnName ON lots(title);