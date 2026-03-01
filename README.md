# 🚀 SymfonySpace

> Projet d'apprentissage PHP/Symfony axé sur la création d'APIs REST et la manipulation de données via des opérations CRUD.

---

## 📌 Description

**SymfonySpace** est une application web développée avec le framework **Symfony** (PHP). Ce projet a été conçu dans un but pédagogique pour se familiariser avec l'écosystème Symfony, notamment la création d'APIs REST et la gestion de données via des opérations CRUD testées avec **Postman**.

---

## 🎯 Objectifs pédagogiques

- 🐘 Découvrir et maîtriser **PHP** avec le framework **Symfony**
- 🔌 Créer et structurer des **APIs REST** avec Symfony
- 🗄️ Implémenter des opérations **CRUD** (Create, Read, Update, Delete)
- 🧪 Tester les endpoints API avec **Postman**

---

## 🛠️ Technologies utilisées

| Technologie | Rôle |
|---|---|
| **PHP** | Langage principal |
| **Symfony** | Framework web back-end |
| **Twig** | Moteur de templates |
| **JavaScript / CSS** | Interface front-end |
| **Doctrine / Migrations** | Gestion de la base de données |
| **Postman** | Test des endpoints API |

---

## 🚀 Installation

### Prérequis

- PHP 8.1+
- [Composer](https://getcomposer.org/) installé
- Un serveur de base de données (MySQL, PostgreSQL, etc.)
- [Symfony CLI](https://symfony.com/download) (optionnel mais recommandé)

### Étapes

```bash
# Cloner le dépôt
git clone https://github.com/AmbiNtsoah/symfonySpace_.git

# Se déplacer dans le répertoire
cd symfonySpace_

# Installer les dépendances
composer install

# Configurer les variables d'environnement
cp .env .env.local
# Modifier .env.local avec vos informations de base de données

# Créer la base de données et exécuter les migrations
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

# Lancer le serveur de développement
symfony server:start
# ou
php -S localhost:8000 -t public/
```

---

## 🔌 Endpoints API

Une fois le serveur lancé, les endpoints REST sont testables via **Postman** à l'adresse `http://localhost:8000`.

Exemples d'opérations CRUD disponibles :

| Méthode | Endpoint | Description |
|---|---|---|
| `GET` | `/api/{ressource}` | Récupérer tous les éléments |
| `GET` | `/api/{ressource}/{id}` | Récupérer un élément par ID |
| `POST` | `/api/{ressource}` | Créer un nouvel élément |
| `PUT` | `/api/{ressource}/{id}` | Mettre à jour un élément |
| `DELETE` | `/api/{ressource}/{id}` | Supprimer un élément |

---

## 📁 Structure du projet

```
symfonySpace_/
├── assets/         # Fichiers front-end (JS, CSS)
├── bin/            # Commandes Symfony
├── config/         # Configuration de l'application
├── migrations/     # Migrations de base de données
├── public/         # Point d'entrée de l'application
├── src/            # Code source PHP (Controllers, Entities, etc.)
├── templates/      # Templates Twig
├── tests/          # Tests unitaires et fonctionnels
├── translations/   # Fichiers de traduction
├── .env            # Variables d'environnement
└── composer.json   # Dépendances PHP
```

---

## 👤 Auteur

- [@AmbiNtsoah](https://github.com/AmbiNtsoah)
