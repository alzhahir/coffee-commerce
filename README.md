# Coffee Electronic Commerce System

Coffee-themed web-based electronic commerce system for my bachelor's degree final year project

## About

This project is created to fulfill the requirements for me to complete my bachelor's degree.

## Installation

Currently, this is not a supported feature. Proceed at your own risk.

### Database

Full database SQL is available at db.sql. This file might not be up-to-date, so if there are any errors, please contact me.

### Dependencies

Please install these dependenices **manually** by putting it into the `internal` folder and renaming it to `stripe-php` instead.\
[*stripe-php (>=10.14.0)*](https://github.com/stripe/stripe-php/releases/tag/v10.14.0)

## Configuration

To configure the system, create a .ini file at the project root.

### Prerequisites

You must obtain the following information to proceed.

#### Stripe

[Webhook endpoint](https://stripe.com/docs/webhooks/go-live)\
[Secret API key](https://stripe.com/docs/keys)\
[Endpoint signature](https://stripe.com/docs/webhooks/signatures)\

### Example Configuration

An ini.example is provided in the repo.

```ini
[process]
timezone="your-timezone" ;Example: America/Chicago, Asia/Kuala_Lumpur
protocol='http/https'
host='your-host'

[database]
server='your-server-address'
username='your-database-username'
password='your-database-password'
database='your-database-name'

[stripe]
secret_key='your-stripe-secret-key'
endpoint_secret='your-endpoint-signature'
```
