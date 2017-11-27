CREATE TABLE `{prefix}googlebot_ips` 
( `ip` VARCHAR(46) NOT NULL , 
`fake` BOOLEAN NOT NULL DEFAULT FALSE,
    UNIQUE (`ip`)) ENGINE = InnoDB 
DEFAULT CHARSET=utf8mb4 ;
