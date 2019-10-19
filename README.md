**Usage:**

```yml
# Site blueprint

fields:
  color_primary:
    type: color
  color_secondary:
    type: color
  color_success:
    type: color


# Palette blueprint

fields:
  palette:
    label: Palette
    type: color-palette
    default: 'color-primary'
    options:
      color_primary:
        background: '{{ site.color_primary }}'
        output: 'color-primary'
      color_secondary:
        background: '{{ site.color_secondary }}'
        output: 'color-secondary'
      color_success:
        background: '{{ site.color_success }}'
        output: 'color-success'
```
