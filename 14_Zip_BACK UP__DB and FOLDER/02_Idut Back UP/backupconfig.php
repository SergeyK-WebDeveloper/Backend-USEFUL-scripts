<?php
                                                /* Idut Backup v1.0
                                                 * (c) 2006-2008 Idut - www.idut.co.uk
                                                 * backupconfig.php
                                                 */
                                                 
                                                //Name of this backup service - used for emailing you if you use this for more than one website
                                                $conf['backupname'] = "Idut Backup";
                                                
                                                //Username
                                                $conf['login'] = "admin";
                                                
                                                //Password
                                                $conf['password'] = "admin";
                                                
                                                //Directory of backup files REMEMBER TRAILING SLASH (e.g. "backups/")
                                                $conf['backupdir'] = "backups/";
                                                
                                                //Backup type
                                                        // 1 = Single file backup
                                                        // 2 = Archive backup files in directory
                                                $conf['backuptype'] = 2;
                                                
                                                //BACKUP TYPE 1 CONFIG...
                                                        //Backup file location
                                                        $conf['backupfile'] = "backup.tar.gz";
                                                        
                                                        //What to do after the backup is complete
                                                                // 0 = Do Nothing
                                                                // 1 = Clear backup file
                                                        $conf['afterbackup'] = 0;
                                                        
                                                //BACKUP TYPE 2 CONFIG...
                                                        //Archive Backup file (by date)
                                                        $conf['backupfilepre'] = "backup-";
                                                        $conf['backupfileext'] = ".tar.gz";
                                                
                                                //Default files or directories to backup
                                                $conf['files'] = array(        'data/',
                                                                               'data.txt'         );
                                                
                                                //Email address if you use the email option
                                                $conf['email'] = "backup@veadas.net";
                                                
                                                //SQL options
                                                $conf['doDatabaseBackup'] = 0; //Backup a MySQL database?
                                                $conf['dbUser'] = "";
                                                $conf['dbPassword'] = "";
                                                $conf['dbHost'] = "localhost";
                                                $conf['dbDatabase'] = "";
                                                $conf['dbTables'] = array('table1','table2');
                                                ?>
