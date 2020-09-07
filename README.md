# OpenFusion-Web-API
A web API for Open Fusion (Fusionfall) written in PHP.

# Features
- Fully written in PHP
- Handles login and registration


# Usage
## Configure settings inside
> ### inc/config.php

It's still a work in progress so a bunch of features are missing and expect bugs and unoptimized code.

## Add to your index.js
    // Load package.json for some info.
	var packagePath = app.getAppPath();
    var packageJsonPath = path.join(packagePath, 'package.json');
	var packageJson = JSON.parse(fs.readFileSync(packageJsonPath));
    if (packageJson.version) app.setVersion(packageJson.version);
    if (packageJson.productName) app.setName(packageJson.productName);
    else if (packageJson.name) app.setName(packageJson.name);
    app.setPath('userData', path.join(app.getPath('appData'), app.getName()));
    app.setPath('userCache', path.join(app.getPath('cache'), app.getName()));
    app.setAppPath(packagePath);
    
 Add the above code inside the app.on("ready", function()) method. This allows the client to save caches and cookies. You can configure the app name in the package.json file.
 
 # Note
 The database provided has all the required tables for the API to work.
