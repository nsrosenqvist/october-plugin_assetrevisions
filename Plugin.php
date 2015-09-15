<?php namespace NSRosenqvist\AssetRevisions;

use Cms\Classes\Theme;
use File;
use Config;
use Request;
use NSRosenqvist\AssetRevisions\Components\AssetRevisions as Component;

class Plugin extends \System\Classes\PluginBase
{
    public function pluginDetails()
    {
        return [
            'name' => 'Asset Revisions',
            'description' => 'Reads the rev-manifest.json files and provide the asset file names through a twig filter',
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

    public function getRevision($text)
    {
        $theme = Theme::getActiveTheme();
        $themeDir = ltrim(Config::get('cms.themesPath'),'/').'/'.$theme->getDirName();
        $fileName = 'rev-manifest.json';
        $manifestFile = $themeDir.'/'.$fileName;

        if (File::exists($manifestFile))
        {
            $manifest = $this->loadRevisionManifest($manifestFile);

            foreach ($manifest as $asset => $path)
            {
                if ($text == $asset)
                {
                    return Request::root().'/'.$themeDir.'/'.$path;
                }
            }
        }

        return Request::root().'/'.$themeDir.'/'.$text;
    }

    private function loadRevisionManifest($path)
    {
        $manifest = File::get($path);
        return json_decode($manifest, true);
    }
}
