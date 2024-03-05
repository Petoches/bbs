
# BBS




## Deployment

To deploy this project run

```bash
  composer install
```

```bash
  cp .env.example .env
```

```bash
  php artisan key:generate
```

```bash
  php artisan storage:link
```

```bash
  php artisan migrate
```

```bash
  npm install
```

```bash
  npm run build
```
## Environment Variables

To run this project, you will need to add the following environment variables to your .env file

`APP_ENV=production`

`APP_DEBUG=false`

`APP_URL`

`DB_CONNECTION`

`DB_HOST`

`DB_PORT`

`DB_DATABASE`

`DB_USERNAME`

`DB_PASSWORD`

#### Specific options :

`INSTAGRAM_USER_AGENT`

`INSTAGRAM_X_IG_APP_ID`

`INSTAGRAM_POST_COUNT`

`INSTAGRAM_PAGE`
## Factories

```bash
  php artisan db:seed
```
## Testing

```bash
  php artisan test
```
## Tech Stack

Laravel, Inertia, Vue, Tailwind, Pest

