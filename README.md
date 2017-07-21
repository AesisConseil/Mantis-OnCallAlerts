# MantisBT OnCallAlerts Plugin

* [French](#french)
* [English](#english)

##  French  
<a name="french"></a>

___Description___
Module de gestion d'astreinte et envoie d'alertes sms.

__Fonction__

* Gestion de tour d'astreintes et assignations de technicien.
* Surveillance de tickets et envoie de sms selon les astreintes du jour.
* gestion d'un planning de surveillance.
* Rappel par sms avant chaque astreinte (besoin d'une tâche [cron](https://fr.wikipedia.org/wiki/Cron)).
Pour l'envoie de sms, vous aurez besoin d'un serveur SMS. Nous pouvons vous aider: www.aesis-conseil.com, alors contacté nous.

__Prérequis__

* [MantisCore => 1.2.0](https://sourceforge.net/projects/mantisbt/files/mantis-stable/1.2.0/)
* [Query => 1.6](https://github.com/mantisbt-plugins/jquery)
* [jQueryUI  => 1.11.4](https://github.com/mantisbt-plugins/jQuery-UI)

Pour l'envoie de sms, vous aurez besoin d'un serveur SMS. [Nous](www.aesis-conseil.com) pouvons vous aider, alors [contacté nous](mailto:contact@aesis-conseil.com).

__Installation__

Un plugin est simplement un répertoire contenant des fichiers. Pour l'installer :

1. Téléchargez et décompressez les fichiers de plugins sur votre ordinateur
2. Téléchargez le répertoire du plugin et les fichiers qu'il contient sous : votreRepertoireMantis/plugins
3. Dans MantisBT, accédez à la page Gérer> Gérer les plugins . Vous verrez une liste de plugins installés et actuellement non installés
4. Cliquez sur le lien Installer pour installer un plugin.


[plus d'information](https://www.mantisbt.org/wiki/doku.php/mantisbt:mantis_plugins)

__Usage__

La configuration du plugin ce fait facilement par formulaire.

1. Dans MantisBT, accédez à la page Gérer> Gérer les plugins.
2.  Cliquez sur le nom du plugin ** On Call Alerts **
3. Remplissez le formulaire de configuration technique ( messages des SMS , configuration serveur SMS etc...)
4.  cliquez sur  **Configuration On Call Alerts** et configurez vos techniciens , astreintes, planning.


__Contribuer__

1. Fork le projet
2. Créé votre branche (`git checkout -b my-new-feature`)
3. Commit vos changements (`git commit -am 'Add some feature'`)
4. Push dans la branche (`git push origin my-new-feature`)
5. Créé une  new Pull Request

## English
<a name="english"></a>

__Overview__
On-call management plugin and sending text alerts.

__Features__

* On-call management and technician assignments.
* Ticket monitoring and sending text for the technician.
* Management  a monitoring plan.
* Recall by text before each assignment (need a [cron](https://en.wikipedia.org/wiki/Cron) task ).

__Requirements__

* [MantisCore => 1.2.0](https://sourceforge.net/projects/mantisbt/files/mantis-stable/1.2.0/)
* [Query => 1.6](https://github.com/mantisbt-plugins/jquery)
* [jQueryUI  => 1.11.4](https://github.com/mantisbt-plugins/jQuery-UI)


For sending text, you will need an Text Server. [We](www.aesis-conseil.com) can help you, then [contacted us](mailto:contact@aesis-conseil.com).

__Installation__

A plugin is simply a directory with files in it. To install one:

1. Download and unzip the plugin files to your computer
2. Upload the plugin directory and the files it contains files under : yourMantisRoot/plugins
3. In MantisBT go to page Manage > Manage Plugins. You will see a list of installed and currently not installed plugins
4. Click the Install link to install a plugin.

[more information](https://www.mantisbt.org/wiki/doku.php/mantisbt:mantis_plugins)

__Usage__

The plugin configuration is verry easy

1. In MantisBT, go to Manage > Manage Plugins.
2. Click on the plugin name ** On Call Alerts **
3. Fill in the technical configuration form (SMS messages, SMS server configuration, etc.)
4. Click on  ** Configuration On Call Alerts ** and configure and use your plugin.

__Contributing__

1. Fork it
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Commit your changes (`git commit -am 'Add some feature'`)
4. Push to the branch (`git push origin my-new-feature`)
5. Create new Pull Request