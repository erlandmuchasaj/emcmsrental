#CakePHP Rest Plugin

Painless REST server Plugin for CakePHP

## Background

The [CakePHP REST Plugin](http://kvz.io/blog/2010/01/13/cakephp-rest-plugin-presentation/)
takes whatever your existing controller actions
gather in viewvars, reformats it in json, csv or xml, and outputs it to the
client. Because you hook it into existing actions, you only have to write your
features once, and this plugin will just unlock them as API. The plugin knows
it’s being called by looking at the extension in the url: `.json`, `.csv` or
`.xml` and optionally at the `Authorization:` header.

So, if you’ve already coded `/servers/reboot/2`, you can have:

- `/servers/reboot/2.json`
- `/servers/reboot/2.xml`

..up & running in no time.

CakePHP REST Plugin can even change the structure of your existing viewvars
using bi-directional xpaths. This way you can extract info using an xpath, and
output it to your API clients using another xpath. If this doesn’t make any
sense, please have a look at the examples.

You can attach the `RestComponent` to a controller, but you can limit
REST activity to a single action.

For best results, 2 changes to your application have to be made:

- A check if REST is active inside your error handler & `redirect()`
- Resource mapping in your router (see docs below)

## Warning - Cake 1.3 Users

Please use the [cake-1.3
branch](https://github.com/kvz/cakephp-rest-plugin/tree/cake-1.3).
As of November 5th 2012, \`master\` now points to Cake 2.0+ code.

## Warning - Backwards compatibility breakage

Action variables are now all contained in 1 big ‘actions’ setting, instead
of directly under settings, as to avoid setting vs action collision.
Behavior changed since [pull 15](https://github.com/kvz/cakephp-rest-
plugin/pull/15)
If you don’t change your controllers to reflect that, your API will break.

[This](https://github.com/kvz/cakephp-rest-plugin/commit/e70728fe98ac442d546e08836a5b388aff0ef1ec)
is your last *good* version. These settings have moved likewise:

 - `->{$action}['extract']` `->actions[$action]['extract']`
 - `->{$action}['id']` `->actions[$action]['id']`
 - `->{$action}['scopeVar']` `->actions[$action]['scopeVar']`
 - `->{$action}['method']` `->actions[$action]['method']`
 - Ratelimiter is now toggled with `->ratelimit['enable']` instead of `->ratelimiter`

## Requirements

- PHP 5.2.6+ or the PECL json package
- CakePHP 2.0+

## Installation

- Download this:
[http://github.com/kvz/cakephp-rest-plugin/zipball/master](http://github.com/kvz/cakephp-rest-plugin/zipball/master)
- Unzip that download.
- Copy the resulting folder to app/plugins
- Rename the folder you just copied to `rest`

### GIT Submodule

In your app directory type:

```bash
git submodule add git://github.com/kvz/cakephp-rest-plugin.git Plugins/Rest
git submodule init
git submodule update
```

### GIT Clone

In your plugin directory type

```bash
git clone git://github.com/kvz/cakephp-rest-plugin.git Rest
```

### Apache

Do you run Apache? Make your `app/webroot/.htaccess` look like so:

```bash
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]

    # Adds AUTH support to Rest Plugin:
    RewriteRule .* - [env=HTTP_AUTHORIZATION:%{HTTP:Authorization},last]
</IfModule>
```

In my experience Nginx & FastCGI already make the HTTP\_AUTHORIZATION
available which is used to parse credentials for authentication.

Usage
-----

### Controller

Beware that you can no longer use `$this->render()` yourself

```php
<?php
class ServersController extends AppController {
    public $components = array(
        'RequestHandler',
        'Rest.Rest' => array(
            'catchredir' => true, // Recommended unless you implement something yourself
            'debug' => 0,
            'actions' => array(
                'view' => array(
                    'extract' => array('server.Server' => 'servers.0'),
                ),
                'index' => array(
                    'extract' => array('rows.{n}.Server' => 'servers'),
                ),
            ),
        ),
    );

    /**
     * Shortcut so you can check in your Controllers wether
     * REST Component is currently active.
     *
     * Use it in your ->flash() methods
     * to forward errors to REST with e.g. $this->Rest->error()
     *
     * @return boolean
     */
    protected function _isRest() {
        return !empty($this->Rest) && is_object($this->Rest) && $this->Rest->isActive();
    }
}
?>
```

`extract` extracts variables you have in: `$this->viewVars` and makes them
available in the resulting XML or JSON under the name you specify in the value
part.

Here’s a more simple example of how you would use the viewVar `tweets`
**as-is**:

```php
<?php
class TweetsController extends AppController {
    public $components = array (
        'Rest.Rest' => array(
            'catchredir' => true,
            'actions' => array(
                'extract' => array(
                    'index' => array('tweets'),
                ),
            ),
        ),
    );

    public function index() {
        $tweets = $this->_getTweets();
        $this->set(compact('tweets'));
    }
}
?>
```

And when asked for the xml version, Rest Plugin would return this to
your clients:

```xml
<?xml version="1.0" encoding="utf-8"?>
<tweets_response>
    <meta>
    <status>ok</status>
    <feedback>
        <item>
        <message>ok</message>
        <level>info</level>
        </item>
    </feedback>
    <request>
        <request_method>GET</request_method>
        <request_uri>/tweets/index.xml</request_uri>
        <server_protocol>HTTP/1.1</server_protocol>
        <remote_addr>123.123.123.123</remote_addr>
        <server_addr>123.123.123.123</server_addr>
        <http_host>www.example.com</http_host>
        <http_user_agent>My API Client 1.0</http_user_agent>
        <request_time/>
    </request>
    <credentials>
        <class/>
        <apikey/>
        <username/>
    </credentials>
    </meta>
    <data>
    <tweets>
        <item>
        <tweet_id>123</tweet_id>
        <message>looking forward to the finals!</message>
        </item>
        <item>
        <tweet_id>123</tweet_id>
        <message>i need a drink</message>
        </item>
    </tweets>
    </data>
</tweets_response>
```

As you can see, the controller name + response is always the root element (for
json there is no root element). Then the content is divived in `meta` &
`data`, and the latter is where your actual viewvars are stored. Meta is there
to show any information regarding the validity of the request & response.

### Authorization

Check the HTTP header as shown [here](http://docs.amazonwebservices.com/Amazon
S3/latest/dev/index.html?RESTAuthentication.html). You can control the
`authKeyword` setting to control what keyword belongs to your REST API. By
default it uses: TRUEREST. Have your users supply a header like:
`Authorization: TRUEREST
username=john&password=xxx&apikey=247b5a2f72df375279573f2746686daa`

Now, inside your controller these variables will be available by calling
`$this->Rest->credentials()`. This plugin only handles the parsing of the
header, and passes the info on to your app. So login anyone with e.g.
`$this->Auth->login()` and the information you retrieved from
`$this->Rest->credentials()`;

Example:

```php
<?php
class TweetsController extends AppController {
    public $components = array ('Rest.Rest');

    public function beforeFilter () {
        if (!$this->Auth->user()) {
            // Try to login user via REST
            if ($this->Rest->isActive()) {
                $this->Auth->autoRedirect = false;
                $data = array(
                    $this->Auth->userModel => array(
                        'username' => $credentials['username'],
                        'password' => $credentials['password'],
                    ),
                );
                $data = $this->Auth->hashPasswords($data);
                if (!$this->Auth->login($data)) {
                    $msg = sprintf('Unable to log you in with the supplied credentials. ');
                    return $this->Rest->abort(array('status' => '403', 'error' => $msg));
                }
            }
        }
        parent::beforeFilter();
    }
}
?>
```

### Schema

If you’re going to make use of this plugin’s Logging & Ratelimitting (default)
and you should run the database schema found in:
`config/schema/rest_logs.sql`.

### Router

```php
<?php
// Add an element for each controller that you want to open up
// in the REST API
Router::mapResources(array('servers'));

// Add XML + JSON to your parseExtensions
Router::parseExtensions('rss', 'json', 'xml', 'json', 'pdf');
?>
```

### Callbacks

If you’re using the built-in ratelimiter, you may still want a little control
yourself. I provide that in the form of 4 callbacks:

```php
<?php
class TweetsController extends AppController {
    public $components = array ('Rest.Rest');

    public function restlogBeforeSave ($Rest) {}
    public function restlogAfterSave ($Rest) {}
    public function restlogBeforeFind ($Rest) {}
    public function restlogAfterFind ($Rest) {}
}
?>
```

That will be called in you AppController if they exists.

You may want to give a specific user a specific ratelimit. In that case you
can use the following callback in your User Model:

```php
<?php
class TweetsController extends AppController {
    public $components = array ('Rest.Rest');

    public function restRatelimitMax ($Rest, $credentials = array()) { }
}
?>
```

And for that user the return value of the callback will be used instead of the
general class limit you could have specified in the settings.

### Customizing callback

You can map callbacks to different places using the `callbacks` setting
like so:

```php
<?php
class TwitterController extends AppController {
    public $components = array(
        'Rest.Rest' => array(
            'catchredir' => true,
            'callbacks' => array(
                'cbRestlogBeforeSave' => 'restlogBeforeSave',
                'cbRestlogAfterSave' => 'restlogAfterSave',
                'cbRestlogBeforeFind' => 'restlogBeforeFind',
                'cbRestlogAfterFind' => array('Common', 'setCache'),
                'cbRestlogFilter' => 'restlogFilter',
                'cbRestRatelimitMax' => 'restRatelimitMax',
            ),
        ),
    );
}
?>
```

If the resolved callback is a string we assume it’s a method in the
calling controller.

Here’s an example of the logFilter callback

```php
<?php
/**
 * Only log when special conditions have been met
 *
 * @param <type> $Rest
 * @param <type> $log
 *
 * @return <type>
 */
public function restlogFilter ($Rest, $log) {
    if (Configure::read('App.short') === 'truecare') {
        // You could also do last minute changes to the data being logged
        return $log;
    }
    // Or return false to prevent logging alltogether
    return false;
}
?>
```

### Logs

We can use this in simple way

```php
public $components = array(
    'Rest.Rest' => array(
        'catchredir' => true,
        'log' => array(
            'model' => 'Rest.RestLog',
            'pretty' => true,
        ),
        'actions' => array(
            'index' => array(
                'extract' => array( 'orders' ),
            ),
            'view' => array(
                'extract' => array( 'orderDetail' ),
            ),
            'add' => array(
                'extract' => array( 'message' ),
            ),
        ),
    ),
);
```

And in AppController

```php
public function restlogFilter ($Rest, $log) {
    return $log;
}
```

Optionally in (your own, maybe extended) Model you could define extra db config

```php
App::import('Rest.RestLog', 'model');
class ApiLog extends RestLog {
    public $useDbConfig = 'mongo';
```

### Configuration

You can chose to override Rest’s default configuration using a global:

```php
<?php
Configure::write('Rest.settings', array(
    'version' => '0.3',
    'log' => array(
        'vars' => array(
            '{environment}' => Configure::read('App.short') . '-' . Configure::read('App.environment'),
        ),
        'pretty' => false,
        // Optionally, choose to store some log fields on disk, instead of in the database
        'fields' => array(
            'data_in' => '/var/log/rest/{environment}/{controller}/{date_Y}_{date_m}/{username}_{id}.log',
            'meta' => '/var/log/rest/{environment}/{controller}/{date_Y}_{date_m}/{username}_{id}.log',
            'data_out' => '/var/log/rest/{environment}/{controller}/{date_Y}_{date_m}/{username}_{id}.log',
        ),
    ),
));
?>
```

And you can override that on a per-controller basis like so:

```php
<?php
class TwitterController extends AppController {
    public $components = array(
        'Rest.Rest' => array(
            'log' => array(
                'pretty' => true,
            ),
        ),
    );
}
?>
```

So:

Rest default \< Global Rest.settings config \< Controller Rest.Rest
component settings

### JSONP support

[Thanks to](https://github.com/kvz/cakephp-rest-plugin/pull/3#issuecomment-883201)
[Chris Toppon](http://www.supermethod.com/), there now also is
[JSONP](http://en.wikipedia.org/wiki/JSON#JSONP) support out of the box.

No extra PHP code or configuration is required on the server side with this
patch, just supply either the parameter `callback` or `jsoncallback` to the
JSON url provided by your plugin and the output will be wrapped in mycallback
as a function.

For example:

```html
<script type="text/javascript">
    var showPrice = function (data) {
         alert('Product: ' + data.product.name + ', Price: ' + data.product.price);
    }
</script>
<script type="text/javascript" src="http://server2.example.com/getjson?callback=showPrice"></script>
```

With jQuery, something similar could have been achieved like so:

```javascript
jQuery.getJSON('http://www.yourdomain.com/products/product.json', function (data) {
    alert('Product: ' + data.product.name + ', Price: ' + data.product.price);
});
```

But for cross-domain requests, use JSONP. jQuery will substitute `?`
with the callback.

```javascript
jQuery.getJSON('http://www.yourdomain.com/products/product.json?callback=?', function (data) {
    alert('Product: ' + data.product.name + ', Price: ' + data.product.price);
});
```

Good explanations of typical JSONP usage here:

- [What is JSONP?](http://remysharp.com/2007/10/08/what-is-jsonp/)
- [Cross-domain communications with JSONP, Part 1: Combine JSONP and jQuery to quickly build powerful mashups](http://www.ibm.com/developerworks/library/wa-aj-jsonp1/)

## Todo

- More testing
- ~~Cake 2.0 support~~
- ~~Cake 1.3 support~~
- ~~The RestLog model that tracks usage should focus more on IP for
    rate-limiting than account info. This is mostly to defend against
    denial of server & brute force attempts~~
- ~~Maybe some Refactoring. This is pretty much the first attempt at a
    working plugin~~
- ~~XML (now only JSON is supported)~~

## Resources

This plugin was based on:

- [Priminister’s API presentation during CakeFest 03 Berlin](http://www.cake-toppings.com/2009/07/15/cakefest-berlin/)
- [The help of Jonathan Dalrymple](http://github.com/veritech)
- [REST documentation](http://book.cakephp.org/view/476/REST)
- [CakeDC article](http://cakedc.com/eng/developer/mark_story/2008/12/02/nate-abele-restful-cakephp)

I held a presentation on this plugin during the first Dutch CakePHP
meetup:

- [REST presentation at slideshare](http://www.slideshare.net/kevinvz/rest-presentation-2901872)

I’m writing a client side API that talks to this plugin for the company
I work for.
If you’re looking to provide your customers with something similar,
it may be helpful to [have a look at it](http://github.com/true/true-api).

## Other

### Leave comments

[On my blog](http://kvz.io/blog/2010/01/13/cakephp-rest-plugin-presentation/)

### Leave money ;)

Like this plugin? Consider [a small donation](https://flattr.com/thing/68756/cakephp-rest-plugin)

Love this plugin? Consider [a big donation](http://pledgie.com/campaigns/12581) :)

## License

Licensed under MIT

Copyright © 2009-2011, Kevin van Zonneveld
All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are
met:
\* Redistributions of source code must retain the above copyright
notice, this list of conditions and the following disclaimer.
\* Redistributions in binary form must reproduce the above copyright
notice, this list of conditions and the following disclaimer in the
documentation and/or other materials provided with the distribution.
\* Neither the name of the this plugin nor the names of its
contributors may be used to endorse or promote products derived from
this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS “AS IS”
AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED. IN NO EVENT SHALL <COPYRIGHT HOLDER> BE LIABLE FOR ANY DIRECT,
INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY
OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,
EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
