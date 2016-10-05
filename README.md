# hashpass
A simple PHP script to take a user supplied password and hash it.

To use it copy it somewhere onto a web server that supports PHP.  
You need to have SSL configured and working on the server as the script
will try to redirect to the HTTPS URL.

If you don't have SSL running (why don't you? https://letsencrypt.org/) then just comment out that section of the script.
