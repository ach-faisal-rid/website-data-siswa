CREATE DATABASE db_siswa;
   USE db_siswa;
   CREATE TABLE siswa (
     id INT AUTO_INCREMENT PRIMARY KEY,
     nama VARCHAR(100),
     kelas VARCHAR(50)
   );

   CREATE TABLE guru (
     id INT AUTO_INCREMENT PRIMARY KEY,
     nama VARCHAR(100),
     mata_pelajaran VARCHAR(100)
   );