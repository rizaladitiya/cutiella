ALTER TABLE `karyawan` ADD `sisacuti1` INT NOT NULL ,
ADD `sisacuti2` INT NOT NULL ;
INSERT INTO `cuti`.`macamcuti` (
`id` ,
`nama` ,
`lama`
)
VALUES (
NULL , 'Cuti Tahunan N-1', '12'
), (
NULL , 'Cuti Tahunan N-2', '12'
);
ALTER TABLE `suratcuti` ADD `filename` VARCHAR( 60 ) NOT NULL ;