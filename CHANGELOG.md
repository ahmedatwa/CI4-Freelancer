# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [2.1.1] - 2021-02-14
### Added
- Correct App version in Admin Constants.php File.
- App is ready for server deployment.

## [2.1-alpha] - 2021-02-13
### Added
- install wizard has been added to simplify the App installation process.

### Deprecated
- dropped formError function and ajax validation used instead in common.php.

### Security
- Codeigniter 4.1.1 upgrade.
- fixed some bugs and security issues.
- strict login in admin section with access token to be generated on every submission.
- Throttler has been implemented along with normal login attempts to admin and catalog.
- dependancies have been updated.


