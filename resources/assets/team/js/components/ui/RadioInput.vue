<template>
    <label>
        <input type="radio"
               :value="value"
               :name="name"
               :checked="picked === value"
               @change="e => picked = e.target.value">
        {{ label }}
    </label>
</template>

<script>
    export default {
        mounted() {
            alert(this.value);
        },
        props: {
            label: String,
            name: String,
            picked: String,
            value: String
        },
        methods: {}
    }
</script>