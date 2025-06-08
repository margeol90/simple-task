<h1>Simple task manager</h1>
<h4>Using Symfony 6.4 and Tailwind CSS</h4>


To run locally clone repo to your local</br>
Run `npm i` to install packages </br>
Run `php bin/console doctrine:database:create` to create SQLite database locally (git ignored) </br>
Run migration (if error due to sqlite, try to run `php bin/console doctrine:database:create`</br>
Run `php bin/console tailwind:build --watch` and in another terminal run `symfony server:start`</br>
</br>

Visit `/tasks`
