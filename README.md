# TOTP Generator and QR Code Creator

This PHP script offers a straightforward implementation for generating Time-Based One-Time Passwords (TOTP) and creating QR codes for TOTP authentication setup. Utilizing the `phpqrcode` library for QR code generation and a custom TOTP algorithm, this tool is essential for securing your applications with two-factor authentication.

## Features

- **TOTP Generation**: Create a TOTP based on a shared secret key, with customizable time frames and OTP lengths.
- **QR Code Generation**: Easily generate QR codes for TOTP setup, compatible with most TOTP applications like Google Authenticator.

## Requirements

- PHP 5.3 or later.
- The `phpqrcode` library, expected to be located in `./lib/phpqrcode-master/`.
- A `base32` decoding library, located in `./lib/`, for handling base32 encoded secret keys.

## Getting Started

Rename `submission.php` to `main.php` and ensure your project structure reflects this change.

### Command Line Interface

This script supports two main operations through the command line:

#### Generate QR Code

To generate a QR code for setting up TOTP in an authentication app, use:

```bash
php main.php --generate-qr
```

This command outputs an SVG file containing the QR code, which you can scan with your authentication app to set up TOTP.

### Generate TOTP

For generating a TOTP based on the current time, use:

```bash
php main.php --get-otp
```

### Configuration

Before running `main.php`, configure the following parameters within the script:

- **`$key`**: The secret key, already base32 encoded.
- **`$otp_length`**: The desired length of the OTP, usually 6 or 8 digits.
- **`$tframe`**: The time frame in seconds for each OTP. Commonly set to 30 or 60 seconds.
- **`$issuer`**: The issuer name to appear in the QR code, typically your application or company name.
- **`$account`**: The user's account name or email to associate with the TOTP.
