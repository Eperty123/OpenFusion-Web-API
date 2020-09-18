# OpenFusion-Web-API
A web API for Open Fusion (Fusionfall) written in PHP.

# Features
- Fully written in PHP
- Handles login and registration


# Usage
## Configure settings inside
> ### inc/config.php

It's still a work in progress so a bunch of features are missing and expect bugs and unoptimized code.

When you get inside config.php you have to change the value inside BASE_PATH which is the path you've placed the api at (the root folder). So you if have this:
> http://localhost/openffapi

then the value is "/openffapi/". Remember to add the dash at the end! You must also change the:
> RewriteBase /

inside .htaccess to the same path otherwise the api will redirect you to weird places. No quotes. I repeat absolutely no quotes! The .htaccess is also extremely important! If you don't have that please get it as the api heavily relies on it. Once you have it place it in exact same place as api.php.

The API_PATH is a virtual path in which you'd call any of the api functions. If you change it to say "bieber" then in order to call any api functions you'd have to go to http://localhost/bieber/<api function>. Default is "api".
	
As it is right now you have to manually visit either login.php or register.php as the api only handles very basic stuff. You can check out how things work in api.php.

## Add to your index.js

	// Add underneath var app = require('app');.
	var path = require('path');
	var fs = require('fs');

    //  Add inside the app.on("ready", function()) method.
    //This allows the client to save caches and cookies. You can configure the app name in the package.json file.
	var packagePath = app.getAppPath();
    var packageJsonPath = path.join(packagePath, 'package.json');
	var packageJson = JSON.parse(fs.readFileSync(packageJsonPath));
    if (packageJson.version) app.setVersion(packageJson.version);
    if (packageJson.productName) app.setName(packageJson.productName);
    else if (packageJson.name) app.setName(packageJson.name);
    app.setPath('userData', path.join(app.getPath('appData'), app.getName()));
    app.setPath('userCache', path.join(app.getPath('cache'), app.getName()));
    app.setAppPath(packagePath);
   
 
 # Note
 The database provided has all the required tables for the API to work. Other features are yet to be implemented.
 
 ## Server
 Max length of password must be set to 32 since we'll be comparing hashed passwords and not plain text.
