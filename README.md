Assets loaded from a web server are usually cached. This can cause an issue when
a file is updated, but the browser cache prevents the user from seeing the changes.
The way to solve this but still enable caching, which greatly increases site performance,
is to append a hash to the end of an asset's file name. So that `app.css` becomes
`app-jid09j1230123.css`, and that hash updates every time the file does.

There are tools like [gulp-rev](https://www.npmjs.com/package/gulp-rev) that does
this automatically when building the project and outputs a manifest file to track
the changes. This plugin reads that manifest file and returns the correct file
revision. So that assets can still be worked with easily:

```
{{ "assets/css/app.css"|revision }} ... returns "assets/css/app-jid09j1230123.css"
```

For now the name of the manifest file can't be configured so adjust your build system
to save the manifest file as "rev-manifest.json" in your theme root.

If the filter doesn't find a corresponding entry in the manifest it simply
returns what the standard ["theme" filter](http://octobercms.com/docs/markup/filter-theme)
would have returned.
