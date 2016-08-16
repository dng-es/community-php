# jcolumn
A jQuery plugin to make selected html elements the same height.
Size: 0.508 kB 

### Without jcolumn

![without jcolumn screenshot](http://oliverj.net/img/jqueryplugins/without-jcolumn.png)

### With jcolumn
![with jcolumn screenshot](http://oliverj.net/img/jqueryplugins/with-jcolumn.png)

## Install

### Bower
```html
bower install jcolumn
```

### npm
```html
npm install jcolumn
```

### The oldschool way
Reference the JavaScript file manually directly after [jQuery](http://jquery.com):

```html
<script src="jcolumn.min.js" type="text/javascript" charset="utf-8"></script>
```

## Usage

Just invoke jcolumn on a class of elements.

```javascript
$('.col').jcolumn();
```

## Options

option   | default  | type      | Description
-------- | -------- | --------  | --------
delay    | 500      | number    | The delayed time after the resize happens
maxWidth | 767      | number    | Every document width smaller than maxWidth will not use jcolumn
resize   | true     | boolean   | Disable resize event with false
callback | null     | function  | A callaback function which gets triggered after resize


```javascript
$('.col').jcolumn({
    delay: 500,
    maxWidth: 767,
    callback: function (height) {
        console.log('New max height is: ' + height);
    }
});
```

### Author

Oliver Jessner [@oliverj_net](https://twitter.com/oliverj_net), [Website](http://oliverj.net) 

Copyright © 2015
