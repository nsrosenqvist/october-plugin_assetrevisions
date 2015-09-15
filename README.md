This is a simple plugin that adds a twig filter for theme developers.

By enabling this plugin a filter called `revision` becomes available and it reads
the `rev-manifest.json` in the theme root. Then in the theme when you link to
assets, instead of using the `theme` filter you can use the `revision` filter.

If the filter doesn't find a corresponding entry in the manifest it simply
returns what `theme` would have returned.

Currently the manifest path isn't configurable. If you know of a way to enable
configuration, without forcing the user to include a component, please send a
pull request with the necessary changes.
