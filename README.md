# Formulus [![Twitter](https://img.shields.io/twitter/url?style=social&url=https%3A%2F%2Fgithub.com%2Fhomescriptone%2FFormulus)](https://twitter.com/intent/tweet?text=Wow:&url=https%3A%2F%2Fgithub.com%2Fhomescriptone%2FFormulus)

![GitHub License](https://img.shields.io/github/license/homescriptone/formulus)
[![GitHub stars](https://img.shields.io/github/stars/homescriptone/formulus?style=social)](https://github.com/homescriptone/formulus)
[![GitHub followers](https://img.shields.io/github/followers/homescriptone?label=Follow&style=social)](https://github.com/Rishit-dagli)



This repo implements [WooCommerce Form Fields](https://github.com/woocommerce/woocommerce) from 
WooCommerce. **Formulus** is a extended version of the WooCommerce library with the ability to use it into a non-WordPress project.


## Installation
You just need to load it into your PHP codebase.

## Usage
The library is composed of 3 fundamental functions:


### 1 - formulus_input_fields( $key, $args, $value ) 
Based on the parameters passed, this function generate html code. ( Works only with WordPress, ClassicPress, BedRocks )

* **$key ( string )**   : unique identifier to target this field,
* **$args ( array )**   : list of options defining the type of fields you're creating,
* **$value ( string )** : default value for the field 


### 2 - formulus_input_table( $key, $args ) 
Based on the parameters passed, this function generate and your fields one after another. ( Works with WordPress, ClassicPress, BedRocks, Laravel, Symfony )

* **$key ( string )**   : unique identifier to target this table,
* **$args ( array )**   : list of options defining the type of fields you're creating,

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
