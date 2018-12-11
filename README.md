## Background
This project provides some API endpoints to create a job. The actual endpoint to save the job is POST /jobs, 
while the other endpoints are providing some additional functionality that clients may need.

A job represents a task or some job a consumer needs to be done by a tradesman/craftsman.
It is something like "Paint my 60m2 flat" or "Fix the bathroom sink".
Every job is categorized in a "Service". You can think of them like categories. eg: "Boat building & boat repair" or "Cleaning of gutters".
Also every job needs some additional data like a description and when the job should be done.

## My The Task
I reviewed and refactored this project, so it matches to my criteria of good code and has a state that I'm fine with. 

## Run the project
### Setup
- `docker-compose up -d`
- `docker run --rm --interactive --tty --volume $PWD/jobs:/app --volume $COMPOSER_HOME:/tmp composer install`
- `docker-compose exec php bin/console doctrine:migrations:migrate`

## Tests
- `docker-compose exec php bin/console doctrine:database:create --env=test`
- `docker-compose exec php vendor/bin/phpunit`
