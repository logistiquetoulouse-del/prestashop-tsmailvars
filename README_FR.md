# tsmailvars

Module PrestaShop permettant d’ajouter **la référence produit / référence de déclinaison** dans les e-mails d’alerte de stock générés par le module natif `ps_emailalerts`.

Compatible avec **PrestaShop 1.7.x** et **PrestaShop 8.x**

Développé par **Studio 109**

---

# Présentation

Le module natif PrestaShop **ps_emailalerts** envoie des e-mails lorsque le stock d’un produit devient faible ou atteint zéro.

Cependant, ces e-mails **n’incluent pas la référence produit**, ce qui rend l’identification du produit plus difficile dans certains catalogues.

Ce module ajoute une nouvelle variable :

`{product_reference}`

permettant d’obtenir par exemple :

`T-SHIRT BLEU (Référence : TS-BL-68) est presque en rupture de stock.`

au lieu de :

`T-SHIRT BLEU est presque en rupture de stock.`

---

# Fonctionnalités

- ajout de la variable `{product_reference}` dans les e-mails d’alerte stock
- prise en charge des **déclinaisons produit**
- aucune modification du **core PrestaShop**
- aucun **override**
- aucune modification du module natif **ps_emailalerts**
- compatible **PrestaShop 1.7 et PrestaShop 8**
- installation et désinstallation sécurisées

---

# Fonctionnement

Le module utilise deux hooks PrestaShop.

## actionUpdateQuantity

Ce hook est déclenché lorsque la quantité d’un produit est mise à jour.

Le module mémorise temporairement :

- l’ID du produit
- l’ID de la déclinaison

---

## sendMailAlterTemplateVars

Ce hook est déclenché juste avant l’envoi d’un e-mail.

Le module :

1. vérifie si le template est `productoutofstock`
2. récupère la référence produit ou déclinaison
3. injecte `{product_reference}` dans les variables du template

---

# Installation

## Méthode 1 — Back Office

Uploader le module via :

Modules → Gestionnaire de modules → Installer un module

---

## Méthode 2 — Installation manuelle

Uploader le dossier :

`/modules/tsmailvars/`

Puis installer le module dans le back-office.

---

# Ordre du hook (important)

Dans le back-office :

Apparence → Positions

Chercher le hook :

`actionUpdateQuantity`

Le module **tsmailvars** doit être positionné **avant** :

`ps_emailalerts`

---

# Modification du template email

Ajouter la référence dans le template d’email :

`{product} (Référence : {product_reference}) est presque en rupture de stock.`

Exemples de fichiers :

themes/votre-theme/mails/fr/modules/ps_emailalerts/mails/fr/productoutofstock.html  
themes/votre-theme/mails/fr/modules/ps_emailalerts/mails/fr/productoutofstock.txt

---

# Exemple

Avant :

`T-SHIRT BLEU est presque en rupture de stock.`

Après :

`T-SHIRT BLEU (Référence : TS-BL-68) est presque en rupture de stock.`

---

# Compatibilité

Testé avec :

- PrestaShop 1.7.8
- PrestaShop 8.x

---

# Auteur

Studio 109

https://www.studio109prod.com  
https://www.trophee-sportif.com

---

# Licence

MIT
