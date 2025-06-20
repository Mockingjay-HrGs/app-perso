# 🎟️ Projet0 — Application de Billetterie Événementielle

Bienvenue sur **Projet0**, une application web de gestion d'événements et de billetterie, développée avec **Symfony**.

---

## 🚀 **Fonctionnalités**

✅ Gestion des **catégories d'événements**  
✅ Création et affichage des **événements**  
✅ Création de **types de billets** avec **stock limité**  
✅ Achat de billets avec **QR Code généré** pour chaque ticket  
✅ Espace **profil utilisateur** pour gérer ses billets  
✅ Possibilité d'**annuler** un billet payé (remis automatiquement en stock)  
✅ Back-office **administrateur** pour gérer utilisateurs, événements, billets et catégories  
✅ Authentification **login / logout** avec redirection automatique  
✅ Interface responsive et moderne

---

## 🗂️ **Technologies**

- **Symfony 6**
- **Doctrine ORM**
- **EasyAdminBundle** pour le back-office
- **Twig** pour les vues
- **Bootstrap/Custom CSS** pour le design

---

## ⚙️ **Installation**

```bash
# Cloner le repo
git clone <URL_DU_REPO>

# Aller dans le dossier
cd Projet0

# Installer les dépendances PHP
composer install

# Copier le fichier .env et configurer la base de données
cp .env .env.local
# Modifier DATABASE_URL selon vos identifiants

# Créer la base et lancer les migrations
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

# Charger éventuellement des données de test (optionnel)
# php bin/console doctrine:fixtures:load

## 📂 Import de la base `eventconnect`

**Via phpMyAdmin :**
- Créer une base nommée `eventconnect`
- Importer `database/eventconnect.sql`

**Via terminal :**
```bash
mysql -u root -p eventconnect < database/eventconnect.sql

# Lancer le serveur Symfony
symfony server:start

