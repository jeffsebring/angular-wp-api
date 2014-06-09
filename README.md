AngularJS Module for WP-API
============================

**There is also a [Backbone.js WP-API client](https://github.com/WP-API/client-js).**

This library provides an [AngularJS](https://angularjs.org/) client-side interface for the [WP API Plugin](https://github.com/WP-API/WP-API) for [WordPress](http://wordpress.org).

* Author - [Jeff Sebring](http://jeffsebring.com)
* License - [GPLv3](http://www.gnu.org/licenses/gpl-3.0.html)


## Dependencies

Aside from AngularJS, this module relies on [ngResource](https://github.com/angular/bower-angular-resource), a separate AngularJS module, to create API resources for your apps. This is a separate script you will need to include.

You will need to [enqueue](http://codex.wordpress.org/Function_Reference/wp_enqueue_script) AngularJS in your theme or plugin, and have the WP-API plugin activated.


## Inclusion

There are 2 methods of using this script. You can use the provided plugin, or bundle it with your app.

### Set theme support

To include the script using the plugin, you'll just add a snippet to the theme or plugin containing your app.

There is one required parameter, and 2 optional configuration parameters. Here is the minimal code to enable the script:

```
add_theme_support( 'angular-wp-api' );
```

The first parameter designates what to support using a string - `angular-wp-api`.

The second parameter is the script dependency array. This is used to control where the script is enqueued, to ensure it has AngularJS and ngResource available, and that the script itself is available for your app.

The third parameter is an optional array of data to be localized with the script in the `wpAPIData` object.

```
add_theme_support( 'angular-wp-api',
	array(
		'mytheme-angular'
	),
	array(
		'data' => 'this is some data',
		'moredata' => 'more data wheee'
	)
);
```

Script dependencies and localized data can also be modified with the `angular_wp_api_script_dependencies` and `angular_wp_api_local_data` filters, respectively.

Now that you have set the dependency of the angular-wp-api script, add `wp.api` as a dependency of your app scripts to make sure it is accessable. If you get error messages in the console about missing objects, check this.

### Bundling

If you would like to include the module in your scripts for concatentation with grunt or otherwise, you'll need to localize some data from within WordPress. See the [plugin.php](plugin.php) file for an example.


## Use

### `wp.api` in your Modules

To provide access to API resources, include `wp.api` in the dependency array of your module definition.

```javascript
angular.module( 'myApp', [ 'wp.api' ] );
```

### Local Data

The resources rely on localized data injected into the footer of the page, with the name of `wpAPIData`. By default, there are three values it provides, which allow access to the rest of WP-API.

* `base`: JSON API url, provided by the `json_url()` function.
* `nonce`: JSON API nonce sent with requests, and used for authorization.
* `user_id`: Current user ID if logged in. Users not logged will have an ID of 0 for utility.

### Getting Data

The resource takes 7 parameters ( the depth of WP-API's routing ) to designate the API route:

```
/:param1/:param2/:param3/:param4/:param5/:param6/:param7/
```

Additional parameters are added to the query string by ngResource.

#### Examples

This is an example of requesting base API information:

```javascript
wpAPIResource.get();
```

A request for the current user data:

```javascript
wpAPIResource.get( {
	param1: 'users',
	param2: wpAPIData.user_id
} );
```
** If the user is not logged in, the request will recieve a `403 Forbidden` response.

A single post request:

```javascript
wpAPIResource.get( {
	param1: 'posts',
	param2: 1
} );
```

A post loop request:

```javascript
wpAPIResource.query( {
	param1: 'posts'
} );
```

Creating a new post draft:

```javascript
wpAPIResource.save( {
	param1: 'posts'
},
{
	title: 'Only a Test',
	slug: 'a-test',
	content: 'This is test content.'
} );
```

Updating a post title:

```javascript
wpAPIResource.save( {
	param1: 'posts',
	param2: 1
},
{
	title: 'Hi World!'
} );
```

A post loop request for page 3 of posts:

```javascript
wpAPIResource.query( {
	param1: 'posts',
	page: 3
} );
```

A request for registered post types:

```javascript
wpAPIResource.query( {
	param1: 'posts',
	param2: 'types'
} );
```

A request for data about the attachment post type:

```javascript
wpAPIResource.query( {
	param1: 'posts',
	param2: 'types',
	param3: 'attachment'
} );
```


The ngResource method `.get()`, should be used for requesting single objects/entities, as it expects an object to be returned. When requesting a loop/collection, use `query()`, which expects an array.


## Development

To develop, build and test this library, you must have [Node](http://nodejs.org) installed. For Windows users, simply [download](http://nodejs.org/download/) and install Node. For Mac users, we recommend installing Node using [Homebrew](http://mxcl.github.com/homebrew/). Once Homebrew is installed, run `brew install node` to install Node.js.


### Installation

Clone this repository, and then execute the following commands within the checkout directory:

```bash
$ npm install
```

This will use Node's NPM package manager to install all the dependencies for building and testing this library. [Grunt](http://gruntjs.com) is installed automatically by the `npm install` command, and is used to run the build tasks.


### Building

To update the JavaScript files in after you've made changes, run the library's `build` script with the npm command:

```bash
$ npm run build
```

This will use Grunt to check the source script for syntax errors, then minify it to create [the minified angular-wp-api.min.js file](angular-wp-api.min.js) and a corresponding source map file.


### Testing

Coming soon . .


#### A note on Grunt

The custom "build" script defined in this library's [package.json](package.json) enable access to Grunt's functionality after a simple `npm install`; however, these commands can also be run directly using Grunt itself. In order to gain access to the `grunt` console command, you must globally install the Grunt command-line interface:

```bash
$ npm install -g grunt-cli
```

Once `grunt-cli` has been installed, you can run the build and test commands with `grunt` and `grunt test`, respectively, without having to invoke the scripts via NPM.
