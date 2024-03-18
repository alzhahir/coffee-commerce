# Coffee Electronic Commerce System

Coffee-themed web-based electronic commerce system for my bachelor's degree final year project

## About

This project is created to fulfill the requirements for me to complete my bachelor's degree.

## Installation

Currently, this is not a supported feature. Proceed at your own risk.

### Database

Full database SQL is available at `db.sql`. This file might not be up-to-date, so if there are any errors, please contact me or open an issue.

### Requirements

- PHP 8.2 (8.3+ is not supported)

### Dependencies

Dependencies used in this project are:

- Stripe-PHP
- PHPMailer
- Firebase-PHP

#### Install Via Composer

Use the commands below to install the required dependencies using Composer.

```bash
composer install
```

#### Install Manually

*As of 30 July 2023, this method of dependency installation is no longer supported or maintained. **Proceed at your own risk.***

~~Please install these dependenices **manually** by putting it into the `internal` folder and renaming it to `stripe-php` instead.\
[*stripe-php (>=10.14.0)*](https://github.com/stripe/stripe-php/releases/tag/v10.14.0)~~

## Configuration

To configure the system, create a .ini file at the project root.

### Prerequisites

You must obtain the following information to proceed.

#### Stripe

[Webhook endpoint](https://stripe.com/docs/webhooks/go-live)\
[Secret API key](https://stripe.com/docs/keys)\
[Endpoint signature](https://stripe.com/docs/webhooks/signatures)

#### Firebase

Firebase JSON credentials
Firebase project file

#### Email

You would need an SMTP server. Easiest is to use the Google's Gmail SMTP servers.

### Example Configuration

An ini.example is provided in the repo.

```ini
[process]
timezone="your-timezone" ; Example: America/Chicago, Asia/Kuala_Lumpur
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

[smtp]
smtp_addr = "smtp.example.com"
smtp_port = 587
smtp_user = "smtp-user@example.com"
smtp_pass = "smtp-pass"
smtp_encr = "1"

; Encryption Methods (smtp_encr)
; 0 - None
; 1 - STARTTLS / TLS
; 2 - SSL

[email]
email_sender = "sender@example.com"
email_sender_name = "Example Email Sender Name"
email_reply = "replyto@example.com"
email_cc = ""
email_bcc = ""
```

## Contribution

This project is not accepting any contributions, but any improvements will be considered via the issues page.

## License

This project is licensed under the GNU Affero General Public License, version 3.0. Copyright © 2023 Megat Al Zhahir Daniel.
