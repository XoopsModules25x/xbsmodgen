CREATE TABLE xbsmodgen_module (
    id              INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    modname         VARCHAR(40)      NOT NULL,
    modtag          VARCHAR(10)      NOT NULL,
    hasadmin        TINYINT UNSIGNED NULL DEFAULT '1',
    hasuserside     TINYINT UNSIGNED NULL DEFAULT '1',
    hassearch       TINYINT UNSIGNED NULL DEFAULT '0',
    hasnotification TINYINT UNSIGNED NULL DEFAULT '0',
    hascomments     TINYINT UNSIGNED NULL DEFAULT '0',
    moddir          VARCHAR(10)      NOT NULL,
    moddesc         TEXT             NULL,
    modcredits      TEXT             NULL,
    modtargetdir    VARCHAR(255)     NOT NULL,
    lastgen         DATETIME              DEFAULT NULL,
    PRIMARY KEY (id),
    KEY indx_modname (modname)
)    ENGINE = InnoDB;

CREATE TABLE xbsmodgen_object (
    modid      INTEGER UNSIGNED                                                                                                     NOT NULL,
    id         INTEGER UNSIGNED                                                                                                     NOT NULL AUTO_INCREMENT,
    objtype    ENUM ('uscript','ascript','bscript','utpl','atpl','btpl','dochelp','docinstall','docsystem','table','umenu','amenu') NULL,
    objname    VARCHAR(30)                                                                                                          NULL,
    objdesc    TEXT                                                                                                                 NULL,
    objloc     VARCHAR(20)                                                                                                          NULL,
    objoptions TEXT                                                                                                                 NULL,
    PRIMARY KEY (id),
    INDEX xbsmodgen_object_FKIndex1 (modid)
#     FOREIGN KEY (modid)
#         REFERENCES xbsmodgen_module (id)
#         ON DELETE NO ACTION
#         ON UPDATE NO ACTION
)   ENGINE = InnoDB;

CREATE TABLE xbsmodgen_config (
    modid          INTEGER UNSIGNED NOT NULL,
    id             INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    configname     VARCHAR(30)      NOT NULL,
    configdesc     VARCHAR(255)     NOT NULL,
    configformtype CHAR(6)          NULL,
    configvaltype  CHAR(6)          NULL,
    configlen      INTEGER UNSIGNED NULL,
    configdefault  VARCHAR(60)      NULL,
    configoptions  TEXT             NULL,
    PRIMARY KEY (id),
    INDEX xbsmodgen_config_FKIndex1 (modid)
#     FOREIGN KEY (modid)
#         REFERENCES xbsmodgen_module (id)
#         ON DELETE NO ACTION
#         ON UPDATE NO ACTION
)    ENGINE = InnoDB;

INSERT INTO xbscdm_meta ( cd_set,cd_type,cd_len,val_type,val_len,cd_desc)
VALUES ('XOBJDTYPE', 'VARCHAR', '7', 'VARCHAR', '20', 'Xoops Object Data Types'
);
INSERT INTO xbscdm_code (cd_set,cd,cd_value) VALUES
('XOBJDTYPE', 'TXTBOX', 'Text Box'), 
('XOBJDTYPE', 'TXTAREA', 'Text Area'),
('XOBJDTYPE', 'INT', 'Integer'),
('XOBJDTYPE', 'URL', 'URL'),
('XOBJDTYPE', 'EMAIL', 'Email Address'),
('XOBJDTYPE', 'ARRAY', 'Array'),
('XOBJDTYPE', 'OTHER', 'Undefined type'),
('XOBJDTYPE', 'SOURCE', 'Source Code'),
('XOBJDTYPE', 'STIME', 'Short Time'),
('XOBJDTYPE', 'MTIME', 'Medium Time'),
('XOBJDTYPE', 'LTIME', 'Long Time');

INSERT INTO xbscdm_meta ( cd_set,cd_type,cd_len,val_type,val_len,cd_desc)
VALUES ('XOBJVTYPE', 'VARCHAR', '8', 'VARCHAR', '20', 'Xoops Object Value Types'
);
INSERT INTO xbscdm_code (cd_set,cd,cd_value,cd_desc) VALUES
('XOBJVTYPE', 'int', 'Integer', 'Integer'), 
('XOBJVTYPE', 'array', 'Array', 'Array'),
('XOBJVTYPE', 'float', 'Float', 'Floating Point'),
('XOBJVTYPE', 'textarea', 'Text Area', 'Text Area'),
('XOBJVTYPE', 'text', 'Text Box', 'Text Box');

INSERT INTO xbscdm_meta ( cd_set,cd_type,cd_len,val_type,val_len,cd_desc)
VALUES ('XOBJOTYPE', 'VARCHAR', '10', 'VARCHAR', '30', 'XBS Modgen object types'
);
INSERT INTO xbscdm_code (cd_set,cd,cd_value,cd_desc) VALUES
('XOBJOTYPE', 'uscript', 'Userside Script', 'Script that is presented to an end user'), 
('XOBJOTYPE', 'ascript', 'Admin Script', 'Script that is presented to an admin user'), 
('XOBJOTYPE', 'bscript', 'Block Script', 'Script that presents a block'), 
('XOBJOTYPE', 'utpl', 'Userside Template', 'Smarty template for displaying userside script'), 
('XOBJOTYPE', 'atpl', 'Admin Template', 'Smarty template for displaying admin script'), 
('XOBJOTYPE', 'btpl', 'Block Template', 'Smarty template for displaying a block'), 
('XOBJOTYPE', 'dochelp', 'Help Document', 'User side help document'), 
('XOBJOTYPE', 'docinstall', 'Install Instructions', 'Module installation isntructions'), 
('XOBJOTYPE', 'docsystem', 'System Documentation', 'System documentation (seen from admin side)'), 
('XOBJOTYPE', 'table', 'MySQL Table', 'Table creation script'); 
