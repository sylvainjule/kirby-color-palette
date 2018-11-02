<template>
    <k-field v-bind="$props" class="k-color-palette-field">
        <template slot="options">
            <div v-if="extractor" class="k-button" ref="extract" @click="openSelector">
                <figure class="k-button-figure">
                    <span class="k-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 35.99">
                            <path d="M35.41,5.25,30.74.58a2,2,0,0,0-2.83,0L21.66,6.83,17.83,3,15,5.82l2.84,2.84L0,26.49V36H9.5L27.34,18.15,30.17,21,33,18.16l-3.84-3.84,6.25-6.25A2,2,0,0,0,35.41,5.25ZM7.84,32,4,28.15,20.13,12,24,15.87Z"/>
                        </svg>
                    </span>
                </figure>
                <span class="k-button-text">{{ $t('palette.new.palette') }}</span>
            </div>
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
                <li v-for="(color, index) in colors" :class="[size, {'active': isValue(color)}, {'unset': unset}]" @click="input(color)">
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
        unset: Boolean,
        default: { type: [String, Boolean] },
        extractor: Boolean,
        limit: Number,

        // general options
        label: String,
        disabled: Boolean,
        help: String,
        parent: String,
        value: Array,
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
            this.$api.get('color-palette/extract-image-colors', {id: file[0].id, limit: this.limit})
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
                if(this.unset && this.isValue(color)) {
                    this.value = this.extractor ? ['', this.extracted] : ''
                }
                else {
                    this.value = this.extractor ? [color, this.extracted] : color
                }
            }

            this.$emit('input', this.value)
        }
    }
}
</script>

<style lang="scss">
    @import '../../assets/css/styles.scss'
</style>