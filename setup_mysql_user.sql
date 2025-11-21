CREATE USER IF NOT EXISTS 'sarpas_user'@'localhost' IDENTIFIED BY 'Sarpas2024!';
GRANT ALL PRIVILEGES ON `pengaduan-sarpas`.* TO 'sarpas_user'@'localhost';
FLUSH PRIVILEGES;
SELECT User, Host FROM mysql.user WHERE User='sarpas_user';
