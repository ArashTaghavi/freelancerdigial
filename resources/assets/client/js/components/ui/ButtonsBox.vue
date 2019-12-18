<template>
    <div class="buttons-box toggle">
        <a class="btn btn-sm btn-default btn-round btn-toggle">
            <i class="icon-options"></i>
            <div class="paper-ripple"><div class="paper-ripple__background" style="opacity: 0.00096;"></div><div class="paper-ripple__waves"></div></div></a>
        <a class="btn btn-sm btn-default btn-round btn-code" rel="tooltip" title="" href="#" data-original-title="کدها">
            <i class="fa fa-code"></i>
            <div class="paper-ripple"><div class="paper-ripple__background"></div><div class="paper-ripple__waves"></div></div></a>
        <div class="code-modal hide">
            <!-- <div class="panel panel-success box shadow border"> -->
        </div>
        <a class="btn btn-sm btn-default btn-round btn-refresh" rel="tooltip" title="" href="#" data-original-title="بارگذاری مجدد">
            <i class="icon-refresh"></i>
            <div class="paper-ripple"><div class="paper-ripple__background"></div><div class="paper-ripple__waves"></div></div></a>
        <a class="btn btn-sm btn-default btn-round btn-fullscreen" rel="tooltip" title="" href="#" data-original-title="تمام صفحه">
            <i class="icon-size-fullscreen"></i>
            <div class="paper-ripple"><div class="paper-ripple__background"></div><div class="paper-ripple__waves"></div></div></a>
        <a class="btn btn-sm btn-default btn-round btn-collapse" rel="tooltip" title="" href="#" data-original-title="کوچک کردن">
            <i class="icon-arrow-up"></i>
            <div class="paper-ripple"><div class="paper-ripple__background"></div><div class="paper-ripple__waves"></div></div></a>
        <a class="btn btn-sm btn-default btn-round btn-close" rel="tooltip" title="" href="#" data-original-title="بستن">
            <i class="icon-trash"></i>
            <div class="paper-ripple"><div class="paper-ripple__background"></div><div class="paper-ripple__waves"></div></div></a>
    </div>
</template>

<script>
    export default {
        mounted(){
            let collapseButton = $(this.$el).find(".btn-toggle");
            collapseButton.on("click", function (e) {
                e.preventDefault();
                $(this).parent().toggleClass("in");
            });
        }
    }
</script>