// Define our project root
var path = require('path');
global.projectRoot = path.resolve(__dirname);

// Run the build script
require('./node_modules/fab-build-next/src/fab.js');
