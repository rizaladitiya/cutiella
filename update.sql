ALTER TABLE `karyawan` ADD `password` TEXT NOT NULL ;
ALTER TABLE `karyawan` ADD `email` TINYTEXT NOT NULL AFTER `pangkat` ;
UPDATE karyawan SET PASSWORD = md5( nip ) ;
TRUNCATE karyawan;
update karyawan set password=md5(email);