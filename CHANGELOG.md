# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

The change log itself is written the way that [keepachangelog.com](http://keepachangelog.com/) describes.

## [Unreleased]

## [6.0.0] - 2019-11-24
## Changed
- Update drafter dependency to v4.0.2 [BC]
- Removed `type` option

## [5.0.1] - 2018-07-20
## Fixed
- Allow spaces in filenames

## [5.0.0] - 2018-03-05
## Changed
- Allow v4 of Symfony component
- Update Robo task runner

## [4.0.1] - 2016-09-20
## Changed
- Removed the cumbersome way to install drafter and added a reference to hmaus/drafter-installer
- Renamed phpunit.xml to phpunit.xml.dist and ignored phpunit.xml so you can customize your settings
- Slimmed down phpunit output

## [4.0.0] - 2016-08-05
## Changed
- Update drafter dependency to v3.0.0 [BC]

## [3.0.0] - 2016-03-31
## Changed
- Updated drafter dependency to v2.2.0 in composer.json and readme [BC]
- Implemented new behavior of the sourcemap argument [BC]
- Begin namespace with vendor name `Hmaus` [BC]

## [2.0.0] - 2015-11-07
## Changed
- Increased min required PHP version to >=5.6 [BC]
- Bumped PHPUnit to v5.x
- Composer install example always uses the latest master of drafter
- Allow v3 of Symfony component

## Removed
- Tests do not care about the exact drafter output
- Exact match fixtures used by the removed test assertions

## [1.0.0] - 2015-10-04
## Changed
- Install example to drafter v1.0.0

## Added
- Support for drafters new `type` option which defaults to `refract`

### Removed
- `symfony/console`
- `symfony/var-dumper` (--dev)

## [0.1.0] - 2015-09-03
### Added
- Initial version
