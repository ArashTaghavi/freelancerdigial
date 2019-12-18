<template>
    <div :class="'float-'+ place">
        <portlet-button key="cp-btn-01" slot="buttons" title="فعال سازی برش" icon="crop" @click="enableCropper"
                        v-if="hasImage && !showCropper"/>
        <portlet-button key="cp-btn-02" slot="buttons" title="چرخش" icon="redo" @click="rotateCropper"
                        v-if="hasImage && showCropper"/>
        <portlet-button key="cp-btn-03" slot="buttons" title="حذف برش" icon="window-close" @click="clearCropper"
                        v-if="hasImage && showCropper"/>
        <portlet-button key="cp-btn-04" slot="buttons" title="حذف" icon="delete" @click="clearImage"
                        v-if="hasImage && !showCropper"/>
        <portlet-file-input key="cp-btn-05" type="warning" slot="buttons" ref="imageInput" picture-newsaccept="image/*"
                            @change="setImageData"/>
        <portlet-button key="cp-btn-06" slot="buttons" title="اعمال تغییرات" icon="check" @click="setImage"
                        v-if="hasImage && showCropper"/>

        <slot v-if="$slots['default']"></slot>
        <hr v-if="$slots['default']"/>

        <div v-if="hasImage && showCropper" class="m-t-10 text-center">
            <ui-button title="برش در قاب ۱:۱" icon="crop-square" :show-text="true" type="dark"
                       @click="setAspectRatioCropper(1)"/>
            <ui-button title="برش در قاب ۲:۳" icon="crop-portrait" :show-text="true" type="dark"
                       @click="setAspectRatioCropper(2/3)"/>
            <ui-button title="برش در قاب ۴:۳" icon="crop-5-4" :show-text="true" type="dark"
                       @click="setAspectRatioCropper(4/3)"/>
            <ui-button title="برش در قاب ۱۶:۹" icon="crop-16-9" :show-text="true" type="dark"
                       @click="setAspectRatioCropper(16/9)"/>
            <ui-button title="برش در قاب ۲۱:۱۱" icon="crop-7-5" :show-text="true" type="dark"
                       @click="setAspectRatioCropper(21/11)"/>
            <ui-button title="برش در قاب ۲۱:۶" icon="crop-16-9" :show-text="true" type="dark"
                       @click="setAspectRatioCropper(21/6)"/>
            <ui-button title="برش آزاد" icon="crop-free" type="dark" @click="setAspectRatioCropper(NaN)"/>
        </div>

        <img v-if="hasImage && !showCropper" class="m-t-20 img-responsive" style="width:100%;height: auto" :src="value"
             alt="تصویر"/>

        <vue-cropper v-if="hasImage && showCropper" class="m-t-20" ref="cropper" :view-mode="2" :src="value"
                     alt="تصویر"/>
    </div>
</template>

<script>
    export default {
        props: {
            title: {
                type: String,
                default: 'تصویر شاخص'
            },
            value: {
                type: String,
                default: ''
            },
            place: {
                type: String,
                default: 'float-right'
            }
        },
        data() {
            return {
                showCropper: false,
            }
        },
        methods: {
            enableCropper() {
                try {
                    this.showCropper = true;
                    this.$refs.cropper.replace(this.value);
                } catch (e) {
                    //
                }
            },
            resetCropper() {
                try {
                    this.$refs.cropper.reset();
                } catch (e) {
                    //
                }
            },
            clearCropper() {
                try {
                    this.$refs.cropper.clear();
                } catch (e) {
                    //
                }
                this.showCropper = false;
            },
            rotateCropper() {
                try {
                    this.$refs.cropper.rotate(90);
                } catch (e) {
                    //
                }
            },
            setAspectRatioCropper(ratio) {
                try {
                    this.$refs.cropper.setAspectRatio(ratio);
                } catch (e) {
                    //
                }
            },
            setImageData(e) {
                const file = e.target.files[0];
                if (!file.type.includes('image/')) {
                    this.notifyMessage('پرونده انتخاب شده یک تصویر معتبر نمی باشد.');
                    return;
                }
                if (typeof FileReader === 'function') {
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        this.$emit('input', event.target.result);
                        try {
                            this.$refs.cropper.replace(event.target.result);
                            this.setImage();
                        } catch (e) {
                            //console.log('cropper error');
                        }
                    };
                    reader.readAsDataURL(file);
                } else {
                    this.notifyMessage('Sorry, FileReader API not supported')
                }
            },
            clearImage() {
                this.$emit('input', null);
            },
            setImage() {
                let imageData = this.$refs.cropper.getCroppedCanvas().toDataURL();
                this.$emit('input', imageData);
                this.clearCropper();
            }
        },
        computed: {
            hasImage() {
                return this.value !== null && this.value !== '';
            },
        }
    }
</script>