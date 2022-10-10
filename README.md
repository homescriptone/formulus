# Formulus [![Twitter](https://img.shields.io/twitter/url?style=social&url=https%3A%2F%2Fgithub.com%2Fhomescriptone%2FFormulus)](https://twitter.com/intent/tweet?text=Wow:&url=https%3A%2F%2Fgithub.com%2Fhomescriptone%2FFormulus)

![GitHub License](https://img.shields.io/github/license/homescriptone/formulus)
[![GitHub stars](https://img.shields.io/github/stars/homescriptone/formulus?style=social)](https://github.com/homescriptone/formulus)
[![GitHub followers](https://img.shields.io/github/followers/homescriptone?label=Follow&style=social)](https://github.com/Rishit-dagli)



This repo implements [WooCommerce Form Fields](https://github.com/woocommerce/woocommerce) from 
WooCommerce. **Formulus** is a extended version of the WooCommerce library with the ability to use it into a WordPress plugin, themes or a simple PHP codebase.  
By using this library, you no longer need to write HTML code, let Formulus generate HTML fields for your application and focus more on usability.  
He is used into the WooCommerce plugin : [Ultimate SMS & WhatsApp for WooCommerce](https://wordpress.org/plugins/ultimate-sms-notifications/)
## Installation
You just need to load it into your PHP codebase.

```php
require_once __DIR__. 'formulus.php';
```

## Usage
The library is composed of 3 fundamental functions:


### 1 - formulus_input_fields( $key, $args, $value ) 
Based on the parameters passed, this function generate html code. ( Works only with WordPress, ClassicPress, BedRocks )

* **$key ( string )**   : unique identifier to target this field,
* **$args ( array )**   : list of options defining the type of fields you're creating,
* **$value ( string )** : default value for the field 

The parameter **$args** has this architecture : 
```php
$args = array(
  'type' => 'text' | 'select' | 'radio' | 'number' // specify type of the field, it support all HTML input type
  'label'             => '', // specify a field label
  'description'       => '', // specify a description for the field
  'placeholder'       => '', // specify a placeholder
  'maxlength'         => false, // specify the maxlength
  'required'          => false, // whether this field is required or not
  'autocomplete'      => false, // autocomplete or not
  'class'             => array(), // contains the class to apply to the whole field
  'label_class'       => array(), // contains the class for the label
  'input_class'       => array(), // contains the class for the input
  'return'            => false, // whether the field must be displayed directly or returned as HTML code
  'options'           => array(), // options for the type select
  'custom_attributes' => array(), // specify the data-attribute here or any custom attribute you would like to add
  'default'           => '', // specify the default value for the field
);
```


### 2 - formulus_input_table( $key, $args ) 
Based on the parameters passed, this function render fields one after another using a table structure. ( Works with WordPress, ClassicPress, BedRocks, Laravel, Symfony )

* **$key ( string )**   : unique identifier to target this table,
* **$args ( array )**   : list of options defining the type of fields you're creating,

The parameter **$args** has this architecture :
```php
$args = array(
	'product' => array( // specify the key for identifying this field
		'label'   // field label    => __( 'Title :' ),
		'label_class' => 'table-label', // class for the field label
		'description' => __( 'Title to show on top of the configurator.', ), // description for the field
		'content'     => '', // specify the HTML code to render for this field ,
		'tr_class'    => 'products-settings-description', // class to attribute the tr
	),
  ...$args, // add more fields by following the previous code architecture,
);
```
Here is a exemple of table generated with this function : 

<img width="907" alt="image" src="https://user-images.githubusercontent.com/25031292/194818077-31b6a80f-41c6-433f-b447-1c0a7b50de38.png">


### 3 - formulus_format_fields( $html_field ) 
Based on the HTML code passed, this function format and escape it.
* **$html_field ( string )**   : HTML code to be displayed.



## Want to Contribute 🙋‍♂️?

Awesome! If you want to contribute to this project, you're always welcome!. You can take a look at [open issues](https://github.com/homescriptone/formulus/issues) for getting more information about current or upcoming tasks.

## Want to discuss? 💬

Have any questions, doubts or want to present your opinions, views? You're always welcome. You can [start discussions](https://github.com/homescriptone/formulus/discussions).

## License

```
Copyright (C) 2022  HomeScript
Licensed under GPL version 3,
This program comes with ABSOLUTELY NO WARRANTY; for details type `show w'.
This is free software, and you are welcome to redistribute it
under certain conditions; type `show c' for details.
```
