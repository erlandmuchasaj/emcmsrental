<?php

App::uses('AppHelper', 'View/Helper');

/**
 * Compressor
 * Will compress HTML
 * Will combine and compress JS and CSS files
 *
 * @author Borg
 * @version 0.7
 */
class CompressorHelper extends AppHelper {
    // load html helper
    public $helpers = ['Html'];

    // default conf
    public $settings = [
        'html' => [
            'compression' => true
        ], 'css' => [
            'path' => '/css/cache-css', // without trailing slash
            'compression' => true
        ], 'js' => [
            'path' => '/js/cache-js', // without trailing slash
            'compression' => true,
            'async' => true
    ]];

    // the view object
    public $view;

    // container for css and js files
    private $css = ['intern' => [], 'extern' => []];
    private $js = ['intern' => [], 'extern' => []];

    // simulate live
    private $live = false;

    /**
     * Constructor
     * @param View $View
     * @param unknown $settings
     */
    public function __construct(View $View, $settings = []) {
        // set the view object and call parent constructor
        $this->view = $View;
        parent::__construct($View, $settings);

        // calculate file system route
        $this->settings['css']['route'] = rtrim(WWW_ROOT, DS) . str_replace('/', DS, $this->settings['css']['path']);
        $this->settings['js']['route'] = rtrim(WWW_ROOT, DS) . str_replace('/', DS, $this->settings['js']['path']);
    }

    /**
     * HTML compressor
     * @see Helper::afterLayout()
     */
    public function afterLayout($layoutFile) {
        $this->view->output = $this->_html($this->view->output);
    }

    /**
     * Add css files to list
     * @param array $files
     */
    public function style($files = null) {
        // nothing?
        if(is_null($files))
            return;

        // string? convert to array
        if(is_string($files))
            $files = [$files];

        // not array?
        if(!is_array($files))
            return;

        // add each file to group with www_root
        $group = [];
        foreach($files as $url)
            $group[] = $this->path($url, ['pathPrefix' => Configure::read('App.cssBaseUrl'), 'ext' => '.css']);

        // array merge
        $this->css['intern'] = am($group, $this->css['intern']);
        $this->css['extern'] = am($files, $this->css['extern']);
    }

    /**
     * Add js files to list
     * @param array $files
     */
    public function script($files = null) {
        // nothing?
        if(is_null($files))
            return;

        // string? convert to array
        if(is_string($files))
            $files = [$files];

        // not array?
        if(!is_array($files))
            return;

        // add each file to group with www_root
        $group = [];
        foreach($files as $url)
            $group[] = $this->path($url, ['pathPrefix' => Configure::read('App.jsBaseUrl'), 'ext' => '.js']);

        // array merge
        $this->js['intern'] = am($group, $this->js['intern']);
        $this->js['extern'] = am($files, $this->js['extern']);
    }

    /**
     * Fetch either combined css or js
     * @param string $what style | script
     * @throws CakeException
     */
    public function fetch($what = null, $live = false) {
        // not supported?
        if(!in_array($what, ['style', 'script']))
            throw new CakeException("{$what} not supported");

        // simulate live?
        $this->live = $live;

        // call private function
        $function = '_' . $what;
        $this->$function();
    }

    /**
     * Get full webroot path for an asset
     * @param string $path
     * @param array $options
     * @return string
     */
    private function path($path, array $options = []) {
        // get base and full paths
        $base = $this->assetUrl($path, $options);
        $base = $this->webroot($base);

        // do webroot path
        $filepath = preg_replace('/^' . preg_quote($this->request->webroot, '/') . '/', '', urldecode($base));
        $webrootPath = WWW_ROOT . str_replace('/', DS, $filepath);
        if(file_exists($webrootPath))
            return $webrootPath;

        // must be theme or plugin then?
        $segments = explode('/', ltrim($filepath, '/'));

        // do theme path
        if ($segments[0] === 'theme') {
            $theme = $segments[1];
            unset($segments[0], $segments[1]);
            $themePath = str_replace('/', DS, App::themePath($theme)) . 'webroot' . DS . implode(DS, $segments);

            return $themePath;

        // do plugin path
        } else {
            $plugin = Inflector::camelize($segments[0]);
            if (CakePlugin::loaded($plugin)) {
                unset($segments[0]);
                $pluginPath = str_replace('/', DS, CakePlugin::path($plugin)) . 'webroot' . DS . implode(DS, $segments);

                return $pluginPath;
            }
        }
    }

    /**
     * Attempt to create the filename for the selected resources
     * @param string $what js | css
     * @throws CakeException
     * @return string
     */
    private function filename($what = null) {
        // not supported?
        if(!in_array($what, ['css', 'js']))
            throw new CakeException("{$what} not supported");

        $last = 0;
        $loop = $this->$what;
        foreach($loop['intern'] as $res)
            if(file_exists($res))
                $last = max($last, filemtime($res));

        return "cache-{$last}-" . md5(serialize($loop['intern'])) . ".{$what}";
    }

    /**
     * Chunk content of files into array
     * @param array $files
     * @return array
     */
    private function chunks($files = []) {
        $index = 0;
        $output[$index] = null;

        // go through each file
        foreach($files as $idx => $file) {
            $content = "\n" . file_get_contents($file) . "\n";
            if(strlen($output[$index] . $content) > 100000) {
                $index++;
                $output[$index] = null;
            }

            // concat
            $output[$index] .= $content;
        }

        // return array
        return $output;
    }

    /**
     * HTML compressor
     * @param string $content
     * @return string
     */
    private function _html($content) {
        // compress?
        if(Configure::read('debug') == 0 && $this->settings['html']['compression'])
            $content = trim(\Minify_HTML::minify($content));

        // return
        return $content;
    }

    /**
     * Create the cache file if it doesnt exist
     * Return the combined css either compressed or not (depending on the setting)
     */
    private function _style() {
        // only compress if we're in production
        if(Configure::read('debug') == 0 || $this->live == true) {
            // no cache file? write it
            $cache = $this->filename('css');
            if (!file_exists($this->settings['css']['route']) || !is_dir($this->settings['css']['route']))  { 
                if (!mkdir($this->settings['css']['route'], 0777, true)) {
                    die(__('There was an error creating the image directory. '));
                } 
            }

            if(!file_exists($this->settings['css']['route'] . DS . $cache)) {
                // get chunks
                $output = null;
                $chunks = $this->chunks($this->css['intern']);

                // replace relative paths to absolute paths
                foreach($chunks as $idx => $content)
                    $chunks[$idx] = preg_replace('/(\.\.\/)+/i', Router::url('/', true), $content);

                // compress?
                if($this->settings['css']['compression'])
                    foreach($chunks as $content)
                        $output .= trim(\Minify_CSS::minify($content, ['preserveComments' => false]));

                // not compressed
                else $output = implode("\n", $chunks);

                // write to file
               file_put_contents($this->settings['css']['route'].DS.$cache, $output);
            }

            // output with the HTML helper
            echo $this->Html->css($this->settings['css']['path'] . '/' . $cache);

        // development mode, output separately with the HTML helper
        } else echo $this->Html->css($this->css['extern']);
    }

    /**
     * Create the cache file if it doesnt exist
     * Return the combined js either compressed or not (depending on the setting)
     */
    private function _script() {
        // only compress if we're in production
        if(Configure::read('debug') == 0 || $this->live == true) {
            // no cache file? write it
            $cache = $this->filename('js');
            if(!file_exists($this->settings['js']['route'] . DS . $cache)) {
                // get chunks
                $output = null;
                $chunks = $this->chunks($this->js['intern']);

                // compress?
                if($this->settings['js']['compression'])
                    foreach($chunks as $content)
                        $output .= trim(\Minify_JS_ClosureCompiler::minify($content));

                // not compressed
                else $output = implode("\n", $chunks);

                // write to file
                file_put_contents($this->settings['js']['route'] . DS . $cache, $output);
            }

            // output with the HTML helper
            echo $this->Html->script($this->settings['js']['path'] . '/' . $cache, $this->settings['js']['async'] == true ? ['async' => 'async'] : []);

        // development mode, output separately with the HTML helper
        } else echo $this->Html->script($this->js['extern']);
    }
}