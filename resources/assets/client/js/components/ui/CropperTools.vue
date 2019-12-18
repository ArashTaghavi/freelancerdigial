<template>
    <div class="m-t-10 text-center">
        <ui-button title="برش در قاب ۱:۱" icon="crop-square" :show-text="true" type="dark" @click="_setAspectRatioCropper(1)"/>
        <ui-button title="برش در قاب ۲:۳" icon="crop-portrait" :show-text="true" type="dark" @click="_setAspectRatioCropper(2/3)"/>
        <ui-button title="برش در قاب ۴:۳" icon="crop-5-4" :show-text="true" type="dark" @click="_setAspectRatioCropper(4/3)"/>
        <ui-button title="برش در قاب ۱۶:۹" icon="crop-16-9" :show-text="true" type="dark" @click="_setAspectRatioCropper(16/9)"/>
        <ui-button title="برش در قاب ۲۱:۱۱" icon="crop-7-5" :show-text="true" type="dark" @click="_setAspectRatioCropper(21/11)"/>
        <ui-button title="برش در قاب ۲۱:۶" icon="crop-16-9" :show-text="true" type="dark" @click="_setAspectRatioCropper(21/6)"/>
        <ui-button title="برش آزاد" icon="crop-free"  type="dark" @click="_setAspectRatioCropper(NaN)" v-if="hasImage"/>
    </div>
</template>

<script>
    export default {
        props: ['mainApp'],
        methods: {
            _setAspectRatioCropper(ratio) {
                this.mainApp.setAspectRatioCropper(ratio);
            }
        },
    }
</script>