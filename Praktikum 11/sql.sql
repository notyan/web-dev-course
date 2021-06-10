CREATE DATABASE PPW11;
USE PPW11;
CREATE TABLE EMPLOYEE(
	Fname VARCHAR(16) NOT NULL,
	Minit CHAR(2) NOT NULL,	
	Lname VARCHAR(16) NOT NULL,
 	Ssn VARCHAR(9) NOT NULL,
  	Bdate DATE NOT NULL,
    Address TEXT NOT NULL,
    Sex ENUM ('F','M') NOT NULL, 
	Salary INT NOT NULL,
	Super_ssn VARCHAR(9),   
	Dno INT NOT NULL,    
	PRIMARY KEY (Ssn)
);

CREATE TABLE DEPARTMENT(
    Dname VARCHAR(24) NOT NULL,
    Dnumber INT,
	Mgr_ssn VARCHAR(9),
	Mgr_start_date DATE ,
	PRIMARY KEY (Dnumber)
);

ALTER TABLE EMPLOYEE
ADD FOREIGN KEY (Super_ssn) REFERENCES EMPLOYEE (Ssn),
ADD FOREIGN KEY (Dno) REFERENCES DEPARTMENT (Dnumber);

ALTER TABLE DEPARTMENT
ADD FOREIGN KEY (Mgr_ssn) REFERENCES EMPLOYEE (Ssn);



INSERT INTO EMPLOYEE (Ssn, Fname, Lname, Minit, Bdate, Address, Sex, Salary, Super_ssn, Dno) VALUES 
	(123456789, 'John', 'Smith', 'B', '1965-01-09', '791 Fondren, Houston, TX', 'M', 30000, 333445555, 5),
	(333445555, 'Franklin', 'Wong', 'T', '1955-12-08', '638 Voss, Houston, TX', 'M', 40000, 888665555, 5),
	(999887777, 'Alicia', 'Zelaya', 'J', '1968-01-19', '3321 Castle, Spring, TX', 'F', 25000, 987654321, 4),
	(987654321, 'Jennifer', 'Wallace', 'S', '1941-06-20', '291 Berry, Bellaire, TX', 'F', 43000, 888665555, 4),
	(666884444, 'Ramesh', 'Narayan', 'K', '1962-09-15', '975 Fire Oak, Humble, TX', 'M', 38000, 333445555, 5),
	(453453453, 'Joyce', 'English', 'A', '1972-07-31', '5631 Rice, Houston, TX', 'F', 25000, 333445555, 5),
	(987987987, 'Ahmad', 'Jabbar', 'V', '1969-03-29', '980 Dallas, Houston, TX', 'M', 25000, 987654321, 4),
	(888665555, 'James', 'Borg', 'E', '1937-11-10', '450 Stone, Houston, TX', 'M', 55000, NULL, 1);
        
INSERT INTO DEPARTMENT (Dnumber, Dname, Mgr_ssn, Mgr_start_date)
VALUES 
	(5, 'Research', 333445555, '1988-05-22'),
	(4, 'Administration', 987654321, '1995-01-02'),
	(1, 'Headquarters', 888665555, '1981-06-19');
	

SELECT d.dname, COUNT(*) AS number 
FROM DEPARTMENT AS d JOIN EMPLOYEE AS e
ON d.dnumber = e.dno 
GROUP BY d.dname 
Having AVG(e.salary) > 30000;

SELECT d.dname, COUNT(*) AS male
FROM DEPARTMENT AS d JOIN EMPLOYEE AS e
ON d.dnumber = e.dno
WHERE e.sex = 'M' AND d.dname IN (
	SELECT d.dname
	FROM DEPARTMENT AS d JOIN EMPLOYEE AS e
    	WHERE d.dnumber = e.dno
	GROUP BY d.dname
	HAVING AVG(Salary) > 30000)
GROUP BY d.dname;

