<template>
    <div :class="getPortletClass">
        <div v-if="reload || close || $slots['buttons'] || title !== null" class="card-header bg-dark text-white">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <strong v-if="title !== null || reload || close || $slots['buttons']"><i v-if="icon.length > 0" :class="`zmdi zmdi-${icon}`"></i> {{ title }}</strong>
                <div v-if="reload || close || $slots['buttons']" class="actions">
                    <portlet-button v-if="reload"  :btnTitle="false" @click="$emit('reload')" icon="sync-alt" title="بارگذاری مجدد"/>
                    <portlet-button v-if="close" @click.="$emit('close')" icon="close" title="بستن"/>
                    <slot name="buttons"></slot>
                </div>
            </div>
        </div>
        <div class="card-body" v-if="$slots['default']">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            title: {
                type: String,
                default: null
            },
            icon: {
                type: String,
                default: ''
            },
            reload: {
                type: Boolean,
                default: false
            },
            close: {
                type: Boolean,
                default: false
            },
            buttons: {
                type: Array,
                default: function () {
                    return [];
                }
            },
            animated: {
                type: Boolean,
                default: true
            },
            animation: {
                type: String,
                default: 'bounceInDown'
            }
        },
        computed: {
            getPortletClass() {
                let classObject = [];
                classObject.push('card card-default mb-3');
                if (this.animated) {
                    classObject.push(`animated ${this.animation}`);
                }
                return classObject;
            }
        }
    }
</script>