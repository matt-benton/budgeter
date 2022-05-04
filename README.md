# Budgeter

A small and simple Laravel application for managing budgets, tracking spending, and categorizing expenses.

## Features

-   Group expenses into categories to get monthly totals and averages for each category.
-   Setup a monthly budget for each category and see when totals go over budget.
-   Add vendors and see how much you buy from them as well as how much you spend each time.

## Setup

```sh
# install php dependencies
$ composer install

# setup .env file
$ cp .env.example .env

# update .env to your environment

# generate app key
$ php artisan key:generate

# migrate the database
$ php artisan migrate

# install frontend dependencies
$ npm install

# compile frontend assets
$ npx mix

# run server
$ php artisan serve
```
