<template>
    <k-field v-bind="$props" class="k-color-palette-field">
        <template slot="options">
            <k-button v-if="extractor" ref="extract" :id="_uid" icon="palette-pipette" @click="openSelector">
                {{ $t('palette.new.palette') }}
            </k-button>
            <k-files-dialog ref="selector" @submit="processImage" />
        </template>

        <k-box v-if="emptyOptions" theme="info" class="color-palette_empty-options">
            {{ $t('palette.empty.options') }}
        </k-box>
        <k-empty v-else-if="emptyPalette" icon="image" :class="['color-palette_empty-palette', size]" @click="openSelector"> 
            {{ $t('palette.empty.palette') }}
        </k-empty>
        <div v-else-if="loadingPalette" class="color-palette_empty-loading">
            <div class="loader-ctn" :class="size">
                <div class="loader"></div>
            </div>
        </div>
        <div v-else class="color-palette_input">
            <ul class="color-palette_input-list">
                <li v-for="(color, index) in colors" :class="[size, {'active': isValue(color)}, {'unselect': unselect}]" @click="input(color)">
                    <div class="color-palette_input-color" :style="inlineStyle(color)"></div>
                </li>
            </ul>
        </div>
    </k-field>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            palette: [],
        }
    },
    props: {
        options: { type: [Object, Array] },
        display: String,
        size: String,
        unselect: Boolean,
        default: { type: [String, Boolean] },
        extractor: Boolean,
        limit: Number,
        uri: String,

        // general options
        label: String,
        disabled: Boolean,
        help: String,
        parent: String,
        value: [String, Array],
        name: [String, Number],
        required: Boolean,
        type: String
    },
    computed: {
        selected() {
            return Array.isArray(this.value) ? this.value[0] : this.value
        },
        extracted() {
            let val = Array.isArray(this.value) ? this.value[1] : ''
            return this.palette.length ? this.palette : val
        },
        emptyOptions() {
            let options = this.isObject(this.options) ? Object.keys(this.options).length : this.options.length
            return !options && !this.extractor
        },
        emptyPalette() {
            return this.extractor && !this.extracted.length && !this.loading
        },
        loadingPalette() {
            return this.extractor && this.loading
        },
        colors() {
            if(this.extractor) return this.extracted.length ? this.extracted : false
            else return this.options
        }
    },
    created() {
        if(!this.value && this.default) {
            if(Array.isArray(this.colors) && this.colors.find(el => el == this.default)) {
                this.value = this.default
                this.input()
            }
            else if(this.isObject(this.colors) && Object.keys(this.colors).find(el => el == this.default)) {
                this.value = this.colors[this.default]
                this.input()
            }
        }
    },
    methods: {
        isValue(color) {
            if(this.isObject(color)) return this.selected == color || this.isEquivalent(this.selected, color)
            return this.selected == color 
        },
        inlineStyle(color) {
            // display: duo
            if(this.display == 'duo' && this.isObject(color)) {
                return 'background: linear-gradient(to right, '+ this.firstColor(color) +' 50%, '+ this.secondColor(color) +' 50%);'
            }

            return 'background:'+ this.firstColor(color)
        },
        firstColor(color) {
            if(this.isString(color))      return color
            else if(this.isObject(color)) return color[Object.keys(color)[0]]
        },
        secondColor(color) {
            if(this.isObject(color)) return color[Object.keys(color)[1]]
            return false
        },
        isString(color) {
            return typeof color === 'string'
        },
        isObject(color) {
            return color !== null && typeof color === 'object'
        },
        isEquivalent(a, b) {
            let aKeys = Object.keys(a);
            let bKeys = Object.keys(b);

            // Different keys? not equivalent
            if (aKeys.length != bKeys.length) {
                return false;
            }

            for (var i = 0; i < aKeys.length; i++) {
                let key = aKeys[i];
                // Different values? not equivalent
                if (a[key] !== b[key]) {
                    return false;
                }
            }
            return true;
        },
        openSelector() {
            this.$refs.selector.open({
                multiple: false,
                parent: this.parent,
            })
        },
        processImage(file) {
            this.loading = true
            this.$api.get('color-palette/extract-image-colors', {filename: file[0].filename, uri: this.uri, limit: this.limit})
                .then(response => {
                    this.palette  = response.colors
                    this.value    = ['', this.palette]
                    this.input()
                    this.loading = false
                })
                .catch(error => {
                    this.palette = []
                    this.loading = false
                })
        },
        input(color = false) {
            if(color) {
                if(this.unselect && this.isValue(color)) color = ''
                this.value = this.extractor ? [color, this.extracted] : color
            }
            this.$emit('input', this.value)
        }
    }
}
</script>

<style lang="scss">
    @import '../../assets/css/styles.scss'
</style>