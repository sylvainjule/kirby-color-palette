import ColorPalette from './components/field/ColorPalette.vue'
import './assets/svg/icons.js'

panel.plugin('sylvainjule/color-palette', {
    fields: {
        'color-palette': ColorPalette,
    }
});