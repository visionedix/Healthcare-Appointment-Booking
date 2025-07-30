docker compose down
sudo chown -R 1000:1000 database/
sudo chown -R 1000:1000 mysql/

docker compose up --build -d

