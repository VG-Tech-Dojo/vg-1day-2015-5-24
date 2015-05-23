# vg-1day-2015

VOYAGE GROUP 1Dayインターン用リポジトリ

## 利用方法
Fork後、各自のリポジトリをcloneし開発していきます

## 構成
```
vg-1day-2015-5-19/
└── original
    ├── iOS-client
    │   ├── Makefile
    │   ├── My1DayApp
    │   │   ├── APIRequest.swift
    │   │   ├── AppDelegate.swift
    │   │   ├── Base.lproj
    │   │   │   ├── LaunchScreen.xib
    │   │   │   └── Main.storyboard
    │   │   ├── ImageHelper.swift
    │   │   ├── Images.xcassets
    │   │   │   └── AppIcon.appiconset
    │   │   │       └── Contents.json
    │   │   ├── Info.plist
    │   │   ├── Message.swift
    │   │   ├── MessageTableViewCell.swift
    │   │   ├── MessageTableViewController.swift
    │   │   ├── PostViewController.swift
    │   │   └── logo.png
    │   ├── My1DayApp.xcodeproj
    │   │   └── project.pbxproj
    │   ├── My1DayAppTests
    │   │   ├── APIRequestTests.swift
    │   │   ├── ImageHelperTests.swift
    │   │   ├── Info.plist
    │   │   ├── MessageTableViewControllerTests.swift
    │   │   └── MessageTests.swift
    │   └── README.md
    ├── web-client
    │   ├── css
    │   │   └── web-client.css
    │   ├── index.html
    │   └── js
    │       └── web-client.js
    └── web-server
        ├── Gemfile
        ├── Gemfile.lock
        ├── Makefile
        ├── Rakefile
        ├── app.php
        ├── composer.json
        ├── composer.lock
        ├── db
        │   ├── api.base.db
        │   └── sql
        │       └── 000_setup.sql
        ├── doc
        │   ├── api.md
        │   ├── meta.yaml
        │   ├── partial
        │   │   ├── error.md
        │   │   ├── head.md
        │   │   └── overview.md
        │   ├── schema.json
        │   ├── schemata
        │   │   └── message.yaml
        │   └── templates
        │       ├── link_schema_properties.md.erb
        │       ├── schemata
        │       │   └── link.md.erb
        │       └── schemata.md.erb
        ├── phpunit.xml
        ├── resource
        │   └── default.jpg
        ├── src
        │   └── My1DayServer
        │       ├── ApiSchemaValidator.php
        │       ├── Application.php
        │       ├── Exception
        │       │   ├── ApiExceptionInterface.php
        │       │   └── InvalidJsonApiException.php
        │       └── Repository
        │           └── MessageRepository.php
        ├── tests
        │   └── My1DayServer
        │       └── Test
        │           └── WebApiTest.php
        └── web
            └── index.php
```
