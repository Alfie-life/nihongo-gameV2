# 🗾 日本語ロード — Japanese Grammar Road

A fun Japanese grammar learning game where you walk a character down a forking road, choosing the correct grammar form. Get it right and earn delicious Japanese food for your collection! Get it wrong and... 🚗💀

## 🎮 Game Modes

### Mode 1: ある / いる (Aru / Iru)
- **ある** = existence of things (objects, abstract concepts, events)
- **いる** = existence of living beings (people, animals)
- Left path = ある, Right path = いる

### Mode 2: だし / し (Dashi / Shi)
- **だし** = after na-adjectives and nouns (きれい**だし**, 元気**だし**)
- **し** = after i-adjectives (おいしい**し**, 高い**し**)
- Left path = だし, Right path = し

## 📚 Levels (JLPT-based)
| Level | JLPT | Description |
|-------|------|-------------|
| 1-2   | N5   | Basic vocabulary and grammar |
| 3-4   | N4   | Elementary grammar patterns |
| 5-6   | N3   | Intermediate usage |
| 7-8   | N2   | Advanced/formal contexts |
| 9-10  | N1   | Literary/academic Japanese |

Each level has 5 questions. Correct answers earn food items for your 図鑑 (collection book).

## 🛠 Tech Stack

| Layer     | Technology |
|-----------|-----------|
| Frontend  | Vue.js 3 + Vuetify 3 + Pinia |
| Backend   | PHP 8.2 + Laravel 11 |
| Database  | MySQL 8.0 (local) / PostgreSQL (Render) |
| Auth      | Laravel Sanctum (token-based) |
| Container | Docker + Docker Compose |
| Deploy    | Render (free tier) |

## 🚀 Local Development (Docker)

### Prerequisites
- Docker & Docker Compose installed
- Git

### Quick Start

```bash
# 1. Clone the repo
git clone <your-repo-url>
cd nihongo-game

# 2. Copy env file
cp backend/.env.example backend/.env

# 3. Build and start containers
docker-compose build
docker-compose up -d

# 4. Install backend dependencies
docker-compose exec app composer install

# 5. Generate app key
docker-compose exec app php artisan key:generate

# 6. Wait for MySQL to be ready (~10 seconds), then migrate & seed
docker-compose exec app php artisan migrate --seed

# 7. Install & build frontend
docker-compose exec frontend sh -c "cd /app && npm install && npm run build"
```

Open **http://localhost:8080** in your browser!

### Development with hot reload

For frontend development with hot reload:
```bash
cd frontend
npm install
npm run dev
```
Then access via **http://localhost:5173** (API proxied to Docker backend)

### Useful Commands

```bash
# View logs
docker-compose logs -f

# Reset database
docker-compose exec app php artisan migrate:fresh --seed

# Stop everything
docker-compose down

# Stop and remove volumes (full reset)
docker-compose down -v
```

## 🌐 Deploy to Render (Free Tier)

### Option A: Render Blueprint (Recommended)

1. Push your code to a GitHub repo
2. Go to [Render Dashboard](https://dashboard.render.com)
3. Click **New** → **Blueprint**
4. Connect your GitHub repo
5. Render will read `render.yaml` and set up everything

> ⚠️ **Database Note:** Render's free tier offers PostgreSQL, not MySQL. The app supports both. Set `DB_CONNECTION=pgsql` in Render environment variables.

### Option B: Manual Setup

1. **Create a PostgreSQL database** on Render (free tier)
2. **Create a Web Service:**
   - Runtime: Docker
   - Dockerfile path: `./Dockerfile.render`
   - Add environment variables:
     ```
     APP_ENV=production
     APP_DEBUG=false
     APP_KEY=<generate with: php artisan key:generate --show>
     APP_URL=https://your-app.onrender.com
     DB_CONNECTION=pgsql
     DB_HOST=<from Render DB>
     DB_PORT=5432
     DB_DATABASE=<from Render DB>
     DB_USERNAME=<from Render DB>
     DB_PASSWORD=<from Render DB>
     SANCTUM_STATEFUL_DOMAINS=your-app.onrender.com
     SESSION_DRIVER=file
     ```
3. Deploy!

### Using MySQL on Render
If you prefer MySQL, use an external provider:
- **PlanetScale** (free tier available)
- **Aiven** (free tier available)
- **Railway** (usage-based)

Set `DB_CONNECTION=mysql` and the corresponding host/credentials.

## 📁 Project Structure

```
nihongo-game/
├── docker-compose.yml          # Local development
├── Dockerfile.render           # Production (Render)
├── render.yaml                 # Render Blueprint
├── backend/                    # Laravel API
│   ├── app/
│   │   ├── Http/Controllers/
│   │   │   ├── AuthController.php    # Login/Register/Logout
│   │   │   └── GameController.php    # Game logic & collection
│   │   └── Models/
│   │       ├── User.php
│   │       ├── Question.php
│   │       ├── FoodItem.php
│   │       ├── UserProgress.php
│   │       └── FoodCollection.php
│   ├── database/
│   │   ├── migrations/
│   │   └── seeders/
│   │       └── DatabaseSeeder.php    # All 100 questions + 100 food items
│   └── routes/
│       └── api.php                   # API routes
├── frontend/                   # Vue.js SPA
│   ├── src/
│   │   ├── views/
│   │   │   ├── LoginView.vue         # Login screen
│   │   │   ├── RegisterView.vue      # Registration
│   │   │   ├── HomeView.vue          # Mode selection
│   │   │   ├── LevelSelectView.vue   # Level picker
│   │   │   ├── GamePlayView.vue      # Main game (walking + choices)
│   │   │   └── CollectionView.vue    # 図鑑 (food collection book)
│   │   ├── store/
│   │   │   ├── auth.js               # Auth state (Pinia)
│   │   │   └── game.js               # Game state (Pinia)
│   │   ├── router/index.js
│   │   └── plugins/vuetify.js
│   └── package.json
└── docker/
    ├── nginx/
    ├── php/
    ├── frontend/
    └── supervisor/
```

## 🔌 API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/register` | Create account |
| POST | `/api/login` | Login (returns token) |
| POST | `/api/logout` | Logout (auth required) |
| GET | `/api/me` | Get current user |
| GET | `/api/game/{mode}/levels` | Get levels with progress |
| GET | `/api/game/{mode}/{level}/question` | Get next question |
| POST | `/api/game/{mode}/{level}/answer` | Submit answer |
| POST | `/api/game/{mode}/{level}/reset` | Reset level progress |
| GET | `/api/collection` | Get food collection |

## 📝 License

MIT
# nihongo-game
