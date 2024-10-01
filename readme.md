## Keating
### Local development
```
cp .env.example .env
make init
make shell
  # inside container
  npm run dev
```
Application will be running under [localhost:53851](http://localhost:53851) and [http://keating.blumilk.localhost/](http://keating.blumilk.localhost/) in Blumilk traefik environment. If you don't have a Blumilk traefik environment set up, follow the instructions in this [repository](https://github.com/blumilksoftware/environment).


### Commands
Before run every command from below list, you must run shell:
```
make shell
```
#### Command list
Composer:
```
composer <command>
```
Run backend tests:
```
composer test
```
Lints backend files:
```
composer cs
```
Lints and fixes backend files:
```
composer csf
```
Artisan commands:
```
php artisan <command>
```
Compiles and hot-reloads frontend for development:
```
npm run dev
```
Compiles and minifies for production:
```
npm run build
```
Lints frontend files:
```
npm run lint
```
Lints and fixes frontend files:
```
npm run lintf
```

### Containers

| service  | container name               | default host port               |
|:---------|------------------------------|---------------------------------|
| app      | keating-app-dev     | [53851](http://localhost:53851) |
| database | keating-db-dev      | 53853                           |
| redis    | keating-redis-dev   | 53852                           |

### Further reading
* [Production deployment](./readme.prod.md)
