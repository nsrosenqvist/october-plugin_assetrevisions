<?php namespace NSRosenqvist\AssetRevisions;

use Cms\Classes\Theme;
use File;
use Config;
use Request;
use NSRosenqvist\AssetRevisions\Components\AssetRevisions as Component;

class Plugin extends \System\Classes\PluginBase
{
    protected static $loaded = false;
    protected static $lookup = [];
    protected static $theme = null;

    public function pluginDetails()
    {
        return [
            'name' => 'Asset Revisions',
            'description' => 'Provides a filter to make the theme\'s asset revision manifest file available in a twig filter.',
            'author' => 'Niklas Rosenqvist',
            'icon' => 'icon-leaf',
            'homepage' => 'https://www.nsrosenqvist.com/'
        ];
    }

    public function registerMarkupTags()
    {
        return [
            'filters' => [
                'revision' => [$this, 'getRevision']
            ]
        ];
    }

    public function boot()
    {
        if ( ! self::$loaded)
            $this->loadLookup();
    }

    public function getRevision($text)
    {
        if (isset(self::$lookup[$text]))
        {
            return Request::root().'/'.$this->getThemeDir().'/'.self::$lookup[$text];
        }

        return Request::root().'/'.$this->getThemeDir().'/'.$text;
    }

    protected function loadLookup()
    {
        $fileName = 'rev-manifest.json';
        $manifestFile = $this->getThemeDir().'/'.$fileName;

        if (File::exists($manifestFile))
        {
            self::$lookup = $this->loadRevisionManifest($manifestFile);
        }

        self::$loaded = true;
    }

    protected function loadRevisionManifest($path)
    {
        $manifest = File::get($path);
        return json_decode($manifest, true);
    }

    protected function getThemeDir()
    {
        if (is_null(self::$theme))
            self::$theme = Theme::getActiveTheme();

        return ltrim(Config::get('cms.themesPath'),'/').'/'.self::$theme->getDirName();
    }
}
