# hashpass

> A quick web page to generate a *nix password hash in javascript

This is a rather trivial page that takes a password as input and generates
password hashes that can be used to create a unix account via puppet, ansible,  etc.

I did it mostly as a way for me to get more familiar with:
 * vuejs.
 * Buefy
 * 'modern' javascript development

You can use the online version at https://hashpasswd.com

## Build Setup

``` bash
# install dependencies
npm install

# serve with hot reload at localhost:8080
npm run dev

# build for production with minification
npm run build
```

To deploy to production, simply rsync the contents of the /dist
directory to a webserver.