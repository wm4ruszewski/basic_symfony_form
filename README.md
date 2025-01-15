# Symfony Docker

A [Docker](https://www.docker.com/)-based installer and runtime for the [Symfony](https://symfony.com) web framework,
with [FrankenPHP](https://frankenphp.dev) and [Caddy](https://caddyserver.com/) inside!

![CI](https://github.com/dunglas/symfony-docker/workflows/CI/badge.svg)

## Uwagi

- Całość jest postawiona na standardowym obrazie dockera dla Symfony 7.2
- PHP 8.3 jest w kontenerze `php`.
- Podłączona jest baza Postgres. Jest dostępna w kontenerze `database`. Użytkownik to `app`, hasła nie ma.
- Uzytkownicy zostali roboczo wpisani w `UserProvider`. Nie chciałem przesyłać dodatkowo bazy danych, bo tam się powinny znaleźć ich dane.
  Korzystam z paczki security dla Symfony. Są to `admin/admin` oraz `test/test`. Hasła są zahashowane za pomocą bcrypt.
- Jest wykonanych kilka prostych testów. Można je uruchomić za pomocą komendy `docker compose exec php php bin/phpunit`
- Wprowadzone jest prowizoryczne ostylowanie, żeby można było się komfortowo poruszać po miniaplikacji.
- Aby wejść w konsoli do bazy trzeba dostać się do kontenera z bazą`docker-compose exec database bash` a następnie połączyć się `psql -Uapp`

### Kroki do postawienia projektu:
1. `docker compose build --no-cache`
2. `docker compose up --pull always -d --wait`
3. Trzeba utworzyć strukturę bazy danych za pomocą komendy `docker compose exec php bin/console do:mi:mi`
4. Tworzenie setupu dla messengera odbywa się komendą `docker compose exec php bin/console messenger:setup-transports`
6. Włączenie workerów w kolejce np. na 5 minut albo 10 wiadomości `docker compose exec php bin/console messenger:consume async --limit=10 --time-limit=300 --memory-limit=128M`
4. Projekt jest dostępny na `http://localhost`
5. Aby zatrzymać dockera należy wywołać `docker compose down --remove-orphans`

Autor: Wojciech Maruszewski

## License

Symfony Docker is available under the MIT License.
