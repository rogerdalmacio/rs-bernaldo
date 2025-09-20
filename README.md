# RS-Bernaldo Exam - Docker Setup

## Prerequisites

* Docker & Docker Compose installed
* Ports 8000 (Laravel) and 3000 (Nuxt) free

---

## Project Structure

```
rs-bernaldo-exam/
├─ backend/           # Laravel app
├─ frontend/          # Nuxt app
├─ docker/            # Docker files
└─ docker-compose.yml
```

---

## Setup & Run

1. **Copy `.env.example`** if needed:

```bash
cp backend/.env.example backend/.env
cp frontend/.env.example frontend/.env
```

2. **Start Docker containers**:

```bash
docker-compose up --build
```

* This will:

    * Build Laravel and Nuxt images
    * Start PostgreSQL container
    * Run Laravel migrations and seeders automatically
    * Start Laravel (`http://localhost:8000`) and Nuxt (`http://localhost:3000`)

3. **Access the app**:

* Laravel API: `http://localhost:8000`
* Nuxt frontend: `http://localhost:3000`

---

## Useful Commands

* Stop containers:

```bash
docker-compose down
```

* Run migrations manually:

```bash
docker-compose exec app php artisan migrate --force
```

* Run seeders manually:

```bash
docker-compose exec app php artisan db:seed --force
```

* View logs:

```bash
docker-compose logs -f
```

---

## Notes

* Laravel uses PostgreSQL (`database` service) — do **not** set `DB_HOST=127.0.0.1`. Use `.env` as provided.
* Nuxt frontend and Laravel backend share the Docker network for internal communication.
