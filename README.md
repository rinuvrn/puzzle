# Puzzle

**Puzzle** is a backend application built with **Symfony 6.4**, designed to manage student submissions for word puzzles.

---

## 📋 Description

Puzzle provides a robust RESTful API to manage student word puzzle submissions. It allows for:

- Submitting and evaluating words
- Grading performance
- Displaying a leaderboard upon puzzle completion

---

## 🛠 Technologies Used

- Symfony 6.4  
- PHP 8.2.12  
- Doctrine ORM/DBAL  
- Various Symfony Bundles  

---

## 📦 Dependencies

Key dependencies managed via Composer include:

- **Symfony Components**:  
  `symfony/framework-bundle`, `symfony/console`, `symfony/doctrine-messenger`, `symfony/http-client`, and more.  
  *(See `composer.json` for the full list)*

- **Doctrine Packages**:  
  `doctrine/orm`, `doctrine/doctrine-bundle`, `doctrine/doctrine-migrations-bundle`, etc.

---

## 🚀 Installation

1. **Create Project Directory**  
   *(Example: `xampp/htdocs/puzzle` if using XAMPP)*

2. **Clone the Repository**

   ```bash
   git clone <repository-url>
   ```

3. **Start XAMPP Services**  
   Start **Apache** and **MySQL** from the XAMPP control panel.

4. **Configure Environment Variables**  
   Edit `.env` or `env.php` to set up the database connection and other variables.

5. **Install Dependencies**

   ```bash
   composer install
   ```

6. **Run Migrations**

   ```bash
   php bin/console doctrine:migrations:migrate
   ```

7. **Start Development Server**

   ```bash
   php -S 127.0.0.1:8000 -t public
   ```

   Access the application at [http://127.0.0.1:8000](http://127.0.0.1:8000)

8. **Run Messenger Consumer** *(for asynchronous tasks)*

   ```bash
   php bin/console messenger:consume async --time-limit=60
   ```

   *(Adjust `--time-limit` as needed)*

---

## 📡 API Endpoints

| Endpoint | Description |
|----------|-------------|
| `POST /api/puzzle/start` | Start a new puzzle game |
| `GET /api/puzzle/leaderboard` | View the top 10 high-scoring words |
| `POST /api/puzzle/{puzzleId}/submit` | Submit a word for a given puzzle |
| `POST /api/puzzle/{puzzleId}/stop` | Stop the puzzle game |

---
