Docker (local dev)

Prerequisites
- Install Docker Desktop (Windows/macOS/Linux). Ensure "Docker Compose" is enabled.

Start the app
- In the project root, run: `docker compose up -d`
- Open: `http://localhost:8003/`

Live edit
- The container maps `./Haustap_Capstone-Haustap_Connecting/Haustap_Capstone-Haustap_Connecting` to `/var/www/html` in the container.
- Editing files locally updates immediately in the running container.

Stop / restart
- Stop: `docker compose down`
- Restart after changes to Dockerfile: `docker compose up --build -d`

Optional database
- MySQL is enabled and exposed on `localhost:3306`.
- Connect using: host `db` (from other containers) or `127.0.0.1` (from host), user `haustap`, password `haustap`, database `haustap`.
- Root access: user `root`, password `haustap`.
- Data persists in the `db_data` volume.

Database UI (Adminer)
- Open: `http://localhost:8080/`
- Server: `db` (from the Adminer container) or `127.0.0.1`
- Username: `haustap` (or `root`), Password: `haustap`, Database: `haustap`
- Use Adminer to inspect tables, run SQL, and import/export data.
