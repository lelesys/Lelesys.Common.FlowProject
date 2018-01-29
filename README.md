# Lelesys.Common.FlowProject
Common stuff and helpers for Flow Framework based projects
## Adding query string parameter to static resource URIs
Query string parameter "v=INTEGER" is added to the static resource URIs. By default CSS and Javascript URIs are enabled. This can be combined with setting far future cache headers from web server configuration. This is very helpful when a new version of application is deployed the cached version string is regenrated which forces reload of the static resource in clients' browsers.

To start using this feature add your package key to the settings:
```
Lelesys:
  Common:
    FlowProject:
      resourceUri:
        enabledPackages: ['Your.Package']
```
To enable other kinds of URIs modify the regular expression from settings:
```
Lelesys:
  Common:
    FlowProject:
      resourceUri:
        matchingRegex: '/\.(js|css)$/'
```
