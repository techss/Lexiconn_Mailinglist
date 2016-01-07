# lexiconn_mailinglist
Magento Mailinglist Module

This module provides integration between Magento and the LexiConn mailinglist system.

The module will be installed in the user's home directory under:

/home/DOM/Lexiconn/modules/

and symlinks will be added to link the code to the correct places in the Magento application.  

This REQUIRES Allow Symlinks to be enabled in Magenot under System -> Configuration -> Developer -> Template Settings.

This will allow for easy updates/patched without copying/overwriting code in each nested Magento directory.  Any custom modification to code will be implemented (and maintained) as a separate branch.
 
INSTALLATION PROCEDURE (Could be added to add.lex)
==================================================
mkdir /home/DOM/Lexiconn
cd /home/DOM/Lexiconn
mkdir modules
cd modules

git clone git@github.com:techss/Lexiconn_Mailinglist.git

ln -s /home/DOM/Lexiconn/modules/lexiconn_mailinglist/app/code/local/Lexiconn /home/DOM/www/app/code/local/Lexiconn
ln -s /home/DOM/Lexiconn/modules/lexiconn_mailinglist/app/design/adminhtml/default/default/layout/mailinglist.xml /home/DOM/www/app/design/adminhtml/default/default/layout/mailinglist.xml
ln -s /home/DOM/Lexiconn/modules/lexiconn_mailinglist/app/design/adminhtml/default/default/template/mailinglist /home/DOM/www/app/design/adminhtml/default/default/template/mailinglist
ln -s /home/DOM/Lexiconn/modules/lexiconn_mailinglist/app/design/frontend/base/default/layout/mailinglist.xml /home/DOM/www/app/design/frontend/base/default/layout/mailinglist.xml
ln -s /home/DOM/Lexiconn/modules/lexiconn_mailinglist/app/design/frontend/base/default/template/mailinglist /home/DOM/www/app/design/frontend/base/default/template/mailinglist

ln -s /home/DOM/Lexiconn/modules/lexiconn_mailinglist/app/etc/modules/Lexiconn_Mailinglist.xml /home/DOM/www/app/etc/modules/Lexiconn_Mailinglist.xml
