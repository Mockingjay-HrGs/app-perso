# 🛠️ Documentation Technique - Projet0

Ce document décrit l’architecture technique et l’implémentation du projet **Projet0**, une plateforme de billetterie événementielle développée en **Symfony 6**.

---

## 📂 **1) Arborescence du projet**

├── assets/ # Fichiers front (CSS, JS si besoin)
<br>├── config/ # Fichiers de configuration Symfony (routes, services, sécurité)
<br>├── migrations/ # Fichiers de migration Doctrine
<br>├── public/ # Entrée publique du site (index.php, uploads, assets) src/ # Code source (Contrôleurs, Entités, Repositories)
<br>│ ├── Controller/
<br>│ ├── Entity/
<br>│ ├── Repository/
<br>├── templates/ # Templates Twig pour les vues


---

## 🧩 **2) Description des principales entités**

| Entité       | Description |
|--------------|--------------|
| **User**     | Représente un utilisateur connecté. Peut être admin ou simple client. |
| **Category** | Classement des événements (Concert, Théâtre, Conférence, etc). |
| **Event**    | Un événement unique avec titre, description, lieu, date, image. |
| **TicketType** | Un type de billet associé à un événement, avec nom, prix et **stock maximum**. |
| **Ticket**   | Une instance de billet générée à l'achat. Contient un **code unique**, un statut (`disponible` ou `payé`), un lien vers le `User` et le `TicketType`. |

---

## 🔑 **3) Comportement du système**

### ✅ **Création d’un événement et de ses billets**

- L’administrateur utilise **EasyAdmin** pour :
    - Créer un **Event**
    - Créer un ou plusieurs **TicketType** pour cet événement
- Lors de la création d’un **TicketType**, le système génère automatiquement le nombre de **Tickets** en fonction du stock défini.

---

### ✅ **Achat d’un billet**

- L’utilisateur :
    - Visualise les types de billets disponibles pour un événement
    - Clique sur **Acheter**
    - Le système :
        - Cherche un **Ticket disponible** pour le `TicketType` choisi
        - Marque le Ticket comme `payé`
        - L’associe à l’utilisateur
        - Génère un **code unique** pour ce Ticket

---

### ✅ **Annulation d’un billet**

- Depuis son **Profil**, l’utilisateur peut :
    - Annuler un billet payé
    - Le système :
        - Change le statut du Ticket en `disponible`
        - Dissocie le Ticket de l’utilisateur
        - Remet le billet en stock pour d’autres acheteurs

---

## 🔐 **4) Gestion de la sécurité**

- **Authentification** : via le composant `security.yaml` de Symfony.
- **Rôles** :
    - `ROLE_USER` pour les clients
    - `ROLE_ADMIN` pour l’administration via EasyAdmin.
- **Accès protégés** :
    - Les pages d’achat et de profil nécessitent d’être connecté.
    - Le back-office `/admin` est protégé par `ROLE_ADMIN`.
- **Déconnexion** :
    - Route automatique `_security_logout` gérée par Symfony.
    - Redirection vers `/login` après logout.

---

## 🗺️ **5) Routes principales**

| URL | Fonction |
|-----|----------|
| `/categories` | Liste toutes les catégories d’événements |
| `/evenement/{slug}` | Détail d’un événement + liste des billets disponibles |
| `/profil` | Espace personnel de l’utilisateur (billets achetés + QR Code) |
| `/profil/ticket/{id}/delete` | Annuler un billet depuis le profil |
| `/paiement/{id}` | Route pour acheter un billet |
| `/admin` | Back-office pour gérer utilisateurs, catégories, événements, billets |
| `/logout` | Route de déconnexion |

---

## 📷 **6) QR Code**

- Généré côté **client** grâce à **Qrious.js** (CDN)
- Contenu : `code` unique du billet
- Affiché dans le **Profil utilisateur**, ouverture dans une modale pour chaque billet

---

## ⚙️ **7) Technologies principales**

| Technologie | Usage |
|-------------|-------|
| **Symfony 6** | Framework principal |
| **Doctrine ORM** | Gestion des entités et base de données |
| **Twig** | Moteur de template pour le rendu HTML |
| **EasyAdminBundle** | Back-office complet |
| **MySQL** | Base de données |

---

## 📦 **8) Déploiement et base de données**

- Base de données : fournie via `database/projet0.sql`
- Import possible via **phpMyAdmin** ou terminal :
  ```bash
  mysql -u root -p projet0 < database/projet0.sql
