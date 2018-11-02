# Kirby Color-Palette

A color palette displayed in the panel, helping you pick predefined colors / palettes.

![screenshot-palette-cursor](https://user-images.githubusercontent.com/14079751/47902848-12a9cc80-de83-11e8-92ea-cabf5031b355.jpg)

<br/>

## Overview

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
  label: Pick a color
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
  label: Pick a color
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

#### 3.2. `display`

![screenshot-display](https://user-images.githubusercontent.com/14079751/47905300-117a9e80-de87-11e8-8853-5b328b993439.jpg)

The display style of the color blocks, to pick from `single` or `duo` . Default is `single`.

If the selected style is `duo` and the options are structured color themes, the field will use the first color of the object as the left color, and the second as the right color.

#### 3.3. `size`

![screenshot-size](https://user-images.githubusercontent.com/14079751/47905301-12133500-de87-11e8-85f2-6ab680cab91d.jpg)

The size of the color blocks, to pick from `small`, `medium` or `large`. Default is `medium`.

#### 3.4. `unset`

If set to `true`, selected colors can be un-selected an rest the field to an empty value. Default is `false`.

```yaml
palette:
  type: color-palette
  unset: false
```

#### 3.5. `default`

The default value to be used if the field has no set value. Will be ignored if it doesn't match an option. Default is `false`.

```yaml
#simple colors
palette:
  type: color-palette
  default: '#00FF00'
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

You can extract a color palette from an image file by activating the `extractor` option. It will override the manual options, if specified. Default is `false`.

```yaml
palette:
  type: color-palette
  extractor: true
  # no need for options anymore
```

The maximum number of extracted colors can be set with the `limit` option. Default is `10`.

```yaml
palette:
  type: color-palette
  extractor: true
  limit: 10
```

<br/>

## 5. Template usage

#### 5.1. If `options` is an array of simple colors

The field will only stored the selected color.

```php
$selected = $page->palette(); #(string)
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

## 8. To-do

- [ ] Replace `$thumb->url()` with `$thumb->root()`(or `$thumb->mediaRoot()`) once [the thumb issue](https://github.com/k-next/kirby/issues/1015) is fixed 
- [ ] Look for images in both `index()` and `drafts()`, once [the collection issue](https://github.com/k-next/kirby/issues/1097) is fixed 
