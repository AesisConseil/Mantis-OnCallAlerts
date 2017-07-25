# MantisBT OnCallAlerts Plugin

* [Français](#french)
* [English](#english)

##  Français  
<a name="french"></a>

___Description___
Module de gestion d'astreinte et envoi d'alertes SMS.

__Fonctionnalités__

* Gestion d'astreintes et assignation de techniciens.
* Surveillance des bogues et envoi de SMS selon les astreintes du jour.
* Gestion d'un planning de surveillance.
* Rappel par SMS avant chaque astreinte (nécessite une tâche [cron](https://fr.wikipedia.org/wiki/Cron)).

__Prérequis__

* [MantisCore => 1.2.0](https://sourceforge.net/projects/mantisbt/files/mantis-stable/1.2.0/)
* [Query => 1.6](https://github.com/mantisbt-plugins/jquery)
* [jQueryUI  => 1.11.4](https://github.com/mantisbt-plugins/jQuery-UI)

Note : un serveur SMS est également nécessaire pour la gestion des alertes par SMS.
Aesis Conseil peut vous fournir un serveur SMS si vous n'en avez pas.
Merci de nous contacter : https://www.aesis-conseil.com/contact-aesis/

__Installation__

1. Téléchargez et décompressez le fichier du plugin sur votre ordinateur
2. Téléversez le répertoire du plugin et les fichiers qu'il contient sous : *votreRepertoireMantis/plugins*
3. Dans MantisBT, accédez à la page *Gérer > Gérer les plugins*. Vous verrez une liste des plugins installés et non installés.
4. Cliquez sur le lien *Installer* pour installer un plugin.

[Plus d'informations sur les plugins dans Mantis](https://www.mantisbt.org/wiki/doku.php/mantisbt:mantis_plugins)

__Utilisation__

1. Dans MantisBT, accédez à la page *Gérer > Gérer les plugins*.
2.  Cliquez sur le nom du plugin *On Call Alerts*
3. Remplissez le formulaire de configuration technique (messages des SMS, configuration du serveur SMS etc.)
4.  Cliquez sur *Configuration On Call Alerts* et configurez vos techniciens, astreintes et planning.

__Contribuer__

1. Créez un fork du projet
2. Crééz votre branche (`git checkout -b my-new-feature`)
3. Commit vos changements (`git commit -am 'Add some feature'`)
4. Push dans la branche (`git push origin my-new-feature`)
5. Créez une nouvelle Pull Request

## English
<a name="english"></a>

__Overview__
On-call management plugin and SMS alerts sending.

__Features__

* On-call management and technician assignments.
* Issues monitoring and SMS sending to the technicians.
* Manage a monitoring plan.
* SMS alert sending before each assignment (need a [cron](https://en.wikipedia.org/wiki/Cron) task ).

__Requirements__

* [MantisCore => 1.2.0](https://sourceforge.net/projects/mantisbt/files/mantis-stable/1.2.0/)
* [Query => 1.6](https://github.com/mantisbt-plugins/jquery)
* [jQueryUI  => 1.11.4](https://github.com/mantisbt-plugins/jQuery-UI)

In order to send SMS alerts, you will need a SMS Server.

__Installation__

1. Download and unzip the plugin files to your computer.
2. Upload the plugin directory and the files it contains under: *yourMantisRoot/plugins*.
3. In MantisBT, go to *Manage > Manage Plugins*. You will see a list of installed and not installed plugins.
4. Click the *Install* link to install a plugin.

[More information](https://www.mantisbt.org/wiki/doku.php/mantisbt:mantis_plugins)

__How to use__

1. In MantisBT, go to *Manage > Manage Plugins*.
2. Click on the plugin named *On Call Alerts*.
3. Fill in the technical configuration form (SMS messages, SMS server configuration, etc.).
4. Click on *Configuration On Call Alerts* to configure and use your plugin.

__Contributing__

1. Fork the project
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Commit your changes (`git commit -am 'Add some feature'`)
4. Push to the branch (`git push origin my-new-feature`)
5. Create a new Pull Request