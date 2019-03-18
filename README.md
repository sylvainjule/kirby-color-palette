# Kirby Color-Palette

A color palette displayed in the panel, helping you pick predefined colors / palettes.

![screenshot-palette-cursor](https://user-images.githubusercontent.com/14079751/47902848-12a9cc80-de83-11e8-92ea-cabf5031b355.jpg)

<br/>

## Overview

> This plugin is completely free and published under the MIT license. However, if you are using it in a commercial project and want to help me keep up with maintenance, please consider [making a donation of your choice](https://www.paypal.me/sylvainjule) or purchasing your license(s) through [my affiliate link](https://a.paddle.com/v2/click/1129/36369?link=1170).

- [1. Installation](#1-installation)
- [2. Setup](#2-setup)
- [3. Configuration](#3-configuration)
- [4. Extract palette from an image](#4-extract-palette-from-an-image)
- [5. Template usage](#5-template-usage)
- [6. License](#6-license)
- [7. Credits](#7-credits)

<br/>

## 1. Installation

Download and copy this repository to ```/site/plugins/color-palette```

Alternatively, you can install it with composer: ```composer require sylvainjule/color-palette```

<br/>

## 2. Setup

A basic setup looks like this:

```yaml
palette:
  label: Pick a color
  type: color-palette
  options:
    - '#135fdc'
    - '#f6917e'
    - '#6a96e4'
    - ...
```

Note that you can fill it with any CSS-valid color:

```yaml
- '#ffffff'
- rgba(255, 255, 255, 0.5)
- rgb(255, 255, 255)
- white
```

## 3. Configuration

#### 3.1. `options` (required)

The plugin accepts both an array or a structured object.

##### • Simple colors

```yaml
palette:
  type: color-palette
  options:
    - '#135fdc'
    - '#f6917e'
    - '#6a96e4'
    - ...
```

##### • Structured color themes

The field will use the first color of the object as the background-color. 

```yaml
palette:
  type: color-palette
  options:
    blue:
      background: '#135fdc'
      border: '#0438c7'
      text: white
    orange:
      background: '#f6917e'
      border: '#ef6a57'
      text: white
    ...
```

##### • Dynamic options

You can set dynamic options / query your options from a different field. Just make sure the `value` returns a CSS-valid color.

For example with a structure field:

```yaml
palette:
  type: color-palette
  options: query
  query:
    fetch: page.mycolors.toStructure
    value: "{{ structureItem.color }}"

...

mycolors:
  type: structure
  fields:
    color:
      type: text
```



#### 3.2. `display`

![screenshot-display](https://user-images.githubusercontent.com/14079751/47905300-117a9e80-de87-11e8-8853-5b328b993439.jpg)

The display style of the color blocks, to pick from `single` or `duo` . Default is `single`.

If the selected style is `duo` and the options are structured color themes, the field will use the first color of the object as the left color, and the second as the right color.

```yaml
palette:
  type: color-palette
  display: single
```

#### 3.3. `size`

![screenshot-size](https://user-images.githubusercontent.com/14079751/47905301-12133500-de87-11e8-85f2-6ab680cab91d.jpg)

The size of the color blocks, to pick from `small`, `medium` or `large`. Default is `medium`.

```yaml
palette:
  type: color-palette
  size: medium
```

#### 3.4. `unselect`

If set to `true`, selected colors can be unselected. Default is `false`.

```yaml
palette:
  type: color-palette
  unselect: false
```

#### 3.5. `default`

The default value to be used if the field has no set value. Will be ignored if it doesn't match an option. Default is `false`.

```yaml
#simple colors
palette:
  type: color-palette
  default: '#135fdc'
  options:
    - '#135fdc'
    - '#f6917e'

# structured colors
palette:
  type: color-palette
  default: blue
  options:
    blue:
      background: '#135fdc'
      border: '#0438c7'
    orange:
      background: '#f6917e'
      border: '#ef6a57'
```

<br/>

## 4. Extract palette from an image

#### 4.1. Select manually which image to extract colors from

You can extract a color palette from a page's image file by activating the `extractor` option. It will override the manual options, if specified. Default is `false`.

```yaml
palette:
  type: color-palette
  extractor: true
  # no need for options anymore
```

You can restrict the choices to a specific file template with the `template` option:

```yaml
palette:
  type: color-palette
  extractor: true
  template: cover
```

#### 4.2. Automatically extract colors when an image matches a template

Alternatively, you can make use of the `autotemplate` option (do not add the above `extractor` option in this case).

If the page has at least 1 image matching the given template (if 2+ are found, the field will use the first one), options will automatically be extracted from it on load.

Note that **there is no realtime-sync**, the page needs to be reloaded in order for the plugin to detect a newly added image. The best way of achieving this without having to manually refresh the page is to place this field and the files section under two different tabs.

```yaml
palette:
  type: color-palette
  autotemplate: cover
  # no need for options anymore
```

#### 4.3. Limit

In both cases, the maximum number of extracted colors can be set with the `limit` option. Default is `10`.

```yaml
palette:
  type: color-palette
  extractor: true
  limit: 10
```

<br/>

## 5. Template usage

#### 5.1. If `options` is an array of simple colors

The field will only store the selected color.

```php
$selected = $page->palette();   #(Field object)
$selected = $selected->value(); #(string)
```

#### 5.2. If `options` is a structured color object

The field will need to be decoded with the `yaml` method. For example, if your options look like this:

```yaml
options:
  blue:
    background: '#135fdc'
    border: '#0438c7'
```

Here's how to get the selected color:

```php
$palette    = $page->palette()->yaml();
$background = $palette['background']; #(string)
$border     = $palette['border']; #(string)
```

Note that in this case, the plugin automatically adds the key of the selected color, in case you'd want it to deal with custom classes, etc.

```php
$border     = $palette['key']; #(string)
```

#### 5.3. If the palette has been extracted from an image

Both the selected color and the extracted palette are stored. The value of the field is an array you'll need to decode with the `yaml` method:

```php
$palette  = $page->palette()->yaml();
$selected = $palette[0]; #selected color (string)
$palette  = $palette[1]; #extracted palette (array)
```

<br/>

## 6. License

MIT

<br/>

## 7. Credits

- K2 version: [Color list](https://github.com/Thiousi/kirby-color-list) by [@Thiousi](https://github.com/Thiousi)
