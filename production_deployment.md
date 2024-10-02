## Keating
### Production deployment

Implementing a new Keating app into production

To add a new Keating app, several steps must be completed:

1. First you need to create a new database for the new application instance in the existing production container `keating-prod-database`;
   1. `CREATE DATABASE database_name;` 
   2. `CREATE USER user_name WITH ENCRYPTED PASSWORD 'password';`
   3. `GRANT ALL PRIVILEGES ON DATABASE database_name TO user_name;`
   4. `\c database_name`
   5. `GRANT CREATE ON SCHEMA public TO user_name;`
2. Then follow a few steps to prepare the files for application deployment
   * add a new option in your workflow to be able to trigger a workflow for a specific Keating app user deployment - (example: pnowak);
   * create a new directory in the specified path - `environment/prod/deployment/prod/apps` - the directory must be named like AppName option from workflow (example: pnowak);
   * please remember that `env.prod` and `.env.prod.secrets` must be created in the indicated folder (btw. the SOPS_AGE encryption and decryption key is located on Infisical);
   * then, to implement a new keating app, trigger the workflow by selecting the app name option that is to be implemented - (example: keating-prod-pnowak-app-container).
3. After a successful first deployment,you can execute the command in the application container:
   * ProductionSeeder to run for application installation: `php artisan db:seed --class=ProductionSeeder`
   * command `php artisan cache:flush` to flush cached page title and external schedule link
