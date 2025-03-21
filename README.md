# Gestion des Tickets - Documentation du Projet

## 📌 Introduction
Ce projet est une **application de gestion des tickets** développée avec **Laravel** et utilisant **Sanctum** pour l'authentification. Il permet aux utilisateurs de créer, suivre et fermer des tickets.

## 🏗️ Architecture du Projet
L'architecture suit les **principes MVC** et intègre des **services** pour séparer la logique métier des controllers.

### 📂 Structure des Dossiers Clés
```
app/
│── Http/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── TicketsController.php
│   │   ├── ResponseController.php
│   ├── Requests/
│   │   ├── TicketRequest.php
│── Models/
│   ├── Tickets.php
│   ├── User.php
│   ├── Responses.php
│── Services/
│   ├── TicketService.php
│   ├── ResponseService.php
│   ├── UserService.php
│── Providers/
│── Middleware/
│── Policies/
│── Exceptions/
│── Resources/
│── Rules/
│── Console/
│── Events/
│── Listeners/
```

## 📌 Fonctionnalités Principales
✅ **Authentification via Laravel Sanctum**  
✅ **CRUD des Tickets** (Création, lecture, mise à jour, suppression)  
✅ **Séparation de la logique métier dans `TicketService`**  
✅ **Validation centralisée via `StoreTicketRequest` et `UpdateTicketRequest`**  
✅ **Gestion des rôles (`client`, `agent`, `admin`)**  
✅ **Suppression en cascade des tickets lors de la suppression d'un utilisateur**  

## 🔧 Technologies Utilisées
- **Laravel** (PHP Framework)
- **Laravel Sanctum** (Authentification API)
- **PostgreSQL** (Base de données)

## 🚀 Installation et Configuration
### 1️⃣ Cloner le projet
```sh
git clone https://github.com/Youcode-Classe-E-2024-2025/Abdelali_Latifi_CustomerCareAPI.git
cd votre-repo
```
### 2️⃣ Installer les dépendances
```sh
composer install
npm install
```
### 3️⃣ Configurer l'environnement
Copiez `.env.example` et renommez-le en `.env`, puis modifiez les informations de la base de données.
```sh
cp .env.example .env
```
Générez la clé d'application :
```sh
php artisan key:generate
```
### 4️⃣ Exécuter les migrations
```sh
php artisan migrate --seed
```
### 5️⃣ Démarrer le serveur
```sh
php artisan serve
```

## 🛠️ API Endpoints
### 🔐 **Authentification**
| Méthode | Endpoint           | Description         |
|---------|------------------|--------------------|
| POST    | /api/register    | Inscription        |
| POST    | /api/login       | Connexion         |
| POST    | /api/logout      | Déconnexion       |

### 🎟️ **Tickets**
| Méthode | Endpoint          | Description              |
|---------|-----------------|-------------------------|
| GET     | /api/tickets    | Récupérer tous les tickets (admin) |
| GET     | /api/my-tickets | Mes tickets (utilisateur connecté) |
| POST    | /api/tickets    | Créer un ticket         |
| PUT     | /api/tickets/{id} | Modifier un ticket      |
| DELETE  | /api/tickets/{id} | Supprimer un ticket     |

## 📝 Contribution
1. **Fork** le projet 📌
2. Crée une nouvelle branche : `git checkout -b feature-nouvelle-fonctionnalite`
3. Effectue les modifications et commit : `git commit -m "Ajout d'une nouvelle fonctionnalité"`
4. Push la branche : `git push origin feature-nouvelle-fonctionnalite`
5. Crée une **Pull Request** 🚀

## 📜 Licence
Ce projet est sous licence **MIT**.

