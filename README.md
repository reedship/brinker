# Brinker Takehome

This project contains the assessment sent to me via IDR for Brinker International. There were a number of requirements listed in the SRS, which I've outlined below. There is also a `project demo.mkv` video file, showing the project running and all required functionality.

  * [x] Create a web app using Symfony
  * [x] Authenticate users using Symfony's security bundle
  * [x] CRUD operations for a single resource using `Doctorine ORM` for database interactions
  * [x] RESTful API
  * [x] Form handling and validation
  * [x] Create a relational database in `MySQL` to support the application
  * [x] Use Twig for basic frontend pages, including forms for user input && displaying data from the database
  * [x] Unit tests for Entities mapped in ORM.
  * [ ] { Optional } Third party API integration, and unit tests for critical parts of the application.


## How to run

Please ensure that you set a `DB_PASSWORD` environment variable that the project can use to access the database. With this variable set, after configuring your database path in a `.env` file to point to your preferred database location.

``` txt
DATABASE_URL="mysql://app:%env(DB_PASSWORD)%@127.0.0.1:3306/app?serverVersion=8.0.32&charset=utf8mb4"
```

Run `composer install` in order to install all dependencies for the project.

### Running tests

`php bin/phpunit`

### Running the project

`php app/console server:start`

## Project Summary

To meet the above demands I have created a simple `Goals tracking` application where users can login and view, create, edit, or delete goals. There are two main `Entity` classes that are stored in the database. You can see the schema for these classes below.

### BrinkerUser

| Property | Type        | Nullable | Constraint |
|----------|-------------|----------|------------|
| username | string(255) | false    | unique     |
| zip      | string(20)  | true     | none       |

### Goal

| Property    | Type                                | Nullable | Constraint |
|-------------|-------------------------------------|----------|------------|
| title       | string(255)                         | false    | unique     |
| description | string(255)                         | true     | none       |
| user_id     | ManyToOne Relation (BrinkerUser.id) | false    | none       |

## Successes

I feel that I encompassed the basic requirements within the time frame, even if the UI is not very stylish. This was my first time writing in PHP or using the Symfony framework, so any differences from best practices should be viewed from that perspective. I found the language and the framework very familiar to writing in Ruby on Rails, and the development experience was pleasant.

## Room for improvement

I did not have time to implement third party API integration within the 48 hour window. On any other time table this wouldn't have been an issue, but I had lots of plates spinning at work and wanted to be able to meet the basic requirements of the assessment before moving on to optional features. Unfortunately I ran out of time, but had I had time, I would have liked to create an API Service that would call out to a [Zip Code API](https://zipcodestack.com/) to get location information for the `BrinkerUser.zip` property. This would have been rendered in the `user/profile.html.twig` template, had all gone to plan.
