**ChangeLog**

** Vers 1.1 **

* Correction d'un bug sur le tri des dates. Celui-ci devrait maintenant être correct.
* Correction du bug sur l'url du site mobile lors de l'envoi d'un sms. Si une url mobile est configuré dans 
les paramêtre, l'url dans le sms devrait maintenant être la bonne.
* Correction d'un bug concernant l'ajout d'un numéro de téléphone qui permettait d'ajouter
un numéro incorrect

* Ajout de l'édition du numero de téléphone d'un technicien afin de ne pas perdre l'historique en cas 
de changement de numéro de téléphone. 
* Ajout d'une page PHP CLI qui envoie un sms de rappel au technicien en astreinte à J+1. Afin 
d'utiliser cette fonctionnalitée, faire appel au fichier : files/phpcli_sendText_recall.php toute les 24h. 