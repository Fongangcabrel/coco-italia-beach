# 📖 GUIDE D'INSTALLATION ET DÉPLOIEMENT
## Coco Italia Beach — Site Web Officiel

---

## 📋 TABLE DES MATIÈRES

1. [Prérequis](#1-prérequis)
2. [Structure des fichiers](#2-structure-des-fichiers)
3. [Installation en local (test)](#3-installation-en-local)
4. [Configuration Stripe (paiement)](#4-configuration-stripe)
5. [Déploiement sur hébergeur](#5-déploiement-sur-hébergeur)
6. [Configuration du domaine](#6-configuration-du-domaine)
7. [Tests à effectuer](#7-tests)
8. [Dépannage](#8-dépannage)

---

## 1. PRÉREQUIS

### Sur votre hébergeur / serveur, il faut :
- **PHP 8.0** ou supérieur
- **Apache** avec `mod_rewrite` activé (ou Nginx)
- **Composer** (gestionnaire de paquets PHP)
- **SSL/HTTPS** activé (obligatoire pour Stripe)
- **PHP mail()** fonctionnel OU un SMTP configuré

### Outils à installer sur votre ordinateur :
- [Composer](https://getcomposer.org/download/) — pour installer Stripe
- Un client FTP : [FileZilla](https://filezilla-project.org/) (gratuit)
- Ou accès SSH à votre hébergeur

---

## 2. STRUCTURE DES FICHIERS

```
coco-italia-beach/
├── index.php                  ← Page d'accueil
├── config.php                 ← ⚠️ Configuration principale (clés Stripe, etc.)
├── composer.json              ← Dépendances PHP
├── .htaccess                  ← Configuration Apache
├── assets/
│   ├── css/
│   │   └── main.css           ← Styles du site
│   └── js/
│       └── main.js            ← Scripts JS
├── includes/
│   ├── header.php             ← En-tête (navbar)
│   ├── footer.php             ← Pied de page
│   └── payment_modal.php     ← Modal de paiement
├── pages/
│   ├── apropos.php            ← Page À Propos
│   ├── billetterie.php        ← Page Billetterie
│   ├── infos.php              ← Page Infos Pratiques
│   ├── contact.php            ← Page Contact
│   └── contact_send.php      ← Handler formulaire contact (AJAX)
├── payment/
│   ├── create_checkout.php   ← Création session Stripe
│   ├── success.php            ← Page après paiement réussi
│   └── webhook.php            ← Webhook Stripe (confirmations)
├── vendor/                    ← Généré par Composer (ne pas modifier)
│   └── stripe/
│       └── stripe-php/
└── logs/
    ├── ventes.log             ← Journal des ventes
    └── echecs.log             ← Journal des échecs
```

---

## 3. INSTALLATION EN LOCAL

### Étape 1 — Télécharger XAMPP (serveur local)
Allez sur https://www.apachefriends.org et téléchargez XAMPP pour Windows/Mac/Linux.

Lancez XAMPP et démarrez **Apache**.

### Étape 2 — Copier les fichiers
Copiez tout le dossier `coco-italia-beach/` dans :
- **Windows** : `C:\xampp\htdocs\coco-italia-beach\`
- **Mac/Linux** : `/opt/lampp/htdocs/coco-italia-beach/`

### Étape 3 — Installer Stripe via Composer
Ouvrez un terminal dans le dossier du projet :

```bash
cd C:\xampp\htdocs\coco-italia-beach
composer install
```

Cela crée automatiquement le dossier `vendor/` avec la bibliothèque Stripe.

### Étape 4 — Configurer `config.php`
Ouvrez `config.php` et modifiez :

```php
define('SITE_URL', 'http://localhost/coco-italia-beach');
define('STRIPE_PUBLIC_KEY', 'pk_test_VOTRE_CLE_TEST');
define('STRIPE_SECRET_KEY', 'sk_test_VOTRE_CLE_TEST');
```

### Étape 5 — Tester
Ouvrez votre navigateur et allez sur :
```
http://localhost/coco-italia-beach/
```

---

## 4. CONFIGURATION STRIPE (PAIEMENT)

### Étape A — Créer un compte Stripe
1. Allez sur https://stripe.com et créez un compte gratuit
2. Vérifiez votre email

### Étape B — Obtenir vos clés API
1. Connectez-vous sur https://dashboard.stripe.com
2. Allez dans **Développeurs** → **Clés API**
3. Copiez :
   - **Clé publiable** (commence par `pk_test_...` en test, `pk_live_...` en prod)
   - **Clé secrète** (commence par `sk_test_...` en test, `sk_live_...` en prod)

### Étape C — Mettre les clés dans config.php

```php
// EN TEST (pour vérifier que tout fonctionne) :
define('STRIPE_PUBLIC_KEY', 'pk_test_51ABC...');
define('STRIPE_SECRET_KEY', 'sk_test_51ABC...');

// EN PRODUCTION (pour de vrais paiements) :
define('STRIPE_PUBLIC_KEY', 'pk_live_51ABC...');
define('STRIPE_SECRET_KEY', 'sk_live_51ABC...');
```

### Étape D — Configurer le Webhook Stripe
Le webhook permet à Stripe de notifier votre site après chaque paiement.

1. Dans le dashboard Stripe → **Développeurs** → **Webhooks**
2. Cliquez **Ajouter un endpoint**
3. URL de l'endpoint :
   ```
   https://votre-domaine.com/payment/webhook.php
   ```
4. Événements à écouter : sélectionnez `checkout.session.completed`
5. Copiez le **secret de signature** (commence par `whsec_...`)
6. Collez-le dans `config.php` :
   ```php
   define('STRIPE_WEBHOOK_SECRET', 'whsec_...');
   ```

### Étape E — Tester le paiement
En mode test, utilisez ces cartes Stripe :
- ✅ **Paiement réussi** : `4242 4242 4242 4242`
- ❌ **Paiement refusé** : `4000 0000 0000 0002`
- Date : n'importe quelle date future · CVC : n'importe quels 3 chiffres

---

## 5. DÉPLOIEMENT SUR HÉBERGEUR

### Option A — Hébergeur mutualisé (O2Switch, OVH, Infomaniak…)
C'est la solution la plus simple et économique (~5-10€/mois).

#### Étape 1 — Acheter un hébergement
Recommandé : **O2Switch** (hébergement français, PHP 8+, illimité)
Site : https://www.o2switch.fr

#### Étape 2 — Installer Composer sur l'hébergeur
Connectez-vous en SSH à votre hébergeur :
```bash
ssh votre_user@votre-serveur.com
```
Puis dans le dossier du site :
```bash
cd public_html
composer install --no-dev --optimize-autoloader
```

Si SSH n'est pas disponible, vous pouvez aussi :
- Installer Composer en local
- Exécuter `composer install` en local → un dossier `vendor/` est créé
- Uploader le dossier `vendor/` via FTP avec les autres fichiers

#### Étape 3 — Uploader les fichiers via FTP
1. Ouvrez **FileZilla**
2. Connectez-vous avec vos identifiants FTP (fournis par votre hébergeur)
3. Naviguez vers `public_html/` (ou `www/`)
4. Glissez-déposez tous les fichiers du projet

**⚠️ Important** : N'oubliez pas d'uploader le dossier `vendor/` !

#### Étape 4 — Configurer config.php sur le serveur
Modifiez `config.php` avec les vraies valeurs :

```php
define('SITE_URL', 'https://www.votre-domaine.com');
define('STRIPE_PUBLIC_KEY', 'pk_live_...');  // Clés de PRODUCTION
define('STRIPE_SECRET_KEY', 'sk_live_...');
define('STRIPE_WEBHOOK_SECRET', 'whsec_...');
define('ADMIN_EMAIL', 'votre@email.com');
```

#### Étape 5 — Permissions des dossiers
Via FTP ou SSH, donnez les bonnes permissions :
```bash
chmod 755 logs/
chmod 644 logs/ventes.log
chmod 644 logs/echecs.log
chmod 644 config.php
```

---

### Option B — VPS (DigitalOcean, OVH VPS, Hetzner…)
Pour plus de contrôle (~5-20€/mois).

```bash
# Installer Apache + PHP sur Ubuntu/Debian
sudo apt update
sudo apt install apache2 php8.2 php8.2-curl php8.2-mbstring libapache2-mod-php

# Activer mod_rewrite
sudo a2enmod rewrite
sudo systemctl restart apache2

# Installer Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Copier les fichiers
sudo cp -r coco-italia-beach/ /var/www/html/

# Installer Stripe
cd /var/www/html/coco-italia-beach/
composer install --no-dev

# Permissions
sudo chown -R www-data:www-data /var/www/html/coco-italia-beach/
sudo chmod -R 755 /var/www/html/coco-italia-beach/logs/

# Configurer Apache (virtual host)
sudo nano /etc/apache2/sites-available/coco.conf
```

Contenu du fichier `coco.conf` :
```apache
<VirtualHost *:80>
    ServerName www.votre-domaine.com
    DocumentRoot /var/www/html/coco-italia-beach
    <Directory /var/www/html/coco-italia-beach>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

```bash
sudo a2ensite coco.conf
sudo systemctl restart apache2

# SSL gratuit avec Let's Encrypt
sudo apt install certbot python3-certbot-apache
sudo certbot --apache -d votre-domaine.com -d www.votre-domaine.com
```

---

## 6. CONFIGURATION DU DOMAINE

### Étape 1 — Acheter un domaine
Sites recommandés : OVH, Namecheap, Gandi

### Étape 2 — Pointer le domaine vers votre hébergeur
Dans les paramètres DNS de votre domaine :
```
Type A    @    → adresse IP de votre hébergeur
Type A    www  → adresse IP de votre hébergeur
```

### Étape 3 — Activer HTTPS (SSL)
- Sur hébergeur mutualisé : activez Let's Encrypt depuis le panneau de contrôle (cPanel / DirectAdmin)
- Sur VPS : utilisez Certbot (voir commandes ci-dessus)

### Étape 4 — Mettre à jour config.php
```php
define('SITE_URL', 'https://www.votre-domaine.com');
```

Et décommenter dans `.htaccess` la redirection HTTPS :
```apache
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

---

## 7. TESTS À EFFECTUER

Après déploiement, vérifiez chaque point :

### Navigation
- [ ] Page d'accueil s'affiche correctement
- [ ] Page À Propos fonctionne
- [ ] Page Billetterie fonctionne
- [ ] Page Infos Pratiques fonctionne
- [ ] Page Contact fonctionne
- [ ] Menu hamburger mobile fonctionne
- [ ] Site est responsive sur mobile

### Formulaire Contact
- [ ] Formulaire s'envoie sans erreur
- [ ] Message reçu sur l'email admin

### Paiement Stripe
- [ ] Cliquer "Acheter" ouvre la modal
- [ ] Remplir le formulaire → redirige vers Stripe
- [ ] Payer avec carte test `4242 4242 4242 4242`
- [ ] Redirection vers page de succès
- [ ] Email de confirmation reçu
- [ ] Vente enregistrée dans `logs/ventes.log`
- [ ] Webhook reçu dans le dashboard Stripe

---

## 8. DÉPANNAGE

### ❌ "Stripe non configuré"
→ Exécutez `composer install` dans le dossier du projet

### ❌ Page blanche
→ Vérifiez les erreurs PHP : ajoutez en haut de `config.php` :
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

### ❌ Paiement ne redirige pas vers Stripe
→ Vérifiez que `STRIPE_SECRET_KEY` est correct dans `config.php`
→ Vérifiez les logs PHP de votre hébergeur

### ❌ Email de confirmation non reçu
→ La fonction `mail()` PHP doit être activée sur votre hébergeur
→ Vérifiez les spams
→ Sur VPS, installez `sendmail` : `sudo apt install sendmail`

### ❌ Erreur 500 sur .htaccess
→ Vérifiez que `mod_rewrite` est activé sur Apache
→ Sur VPS : `sudo a2enmod rewrite && sudo systemctl restart apache2`

### ❌ CSS/JS ne se charge pas
→ Vérifiez que `SITE_URL` dans `config.php` correspond exactement à votre URL
→ Pas de slash final : `https://domaine.com` ✅ et non `https://domaine.com/` ❌

---

## 📞 RÉCAPITULATIF RAPIDE

```
1. composer install          → installe Stripe
2. Modifier config.php       → mettre vos clés Stripe + URL
3. Uploader via FTP          → tous les fichiers vers public_html/
4. Configurer webhook Stripe → URL: https://domaine.com/payment/webhook.php
5. Activer HTTPS             → via panneau hébergeur ou Certbot
6. Tester avec carte test    → 4242 4242 4242 4242
7. Passer en mode production → remplacer pk_test/sk_test par pk_live/sk_live
```

---

*Guide rédigé pour Coco Italia Beach · Parma 2026*
