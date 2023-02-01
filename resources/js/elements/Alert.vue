<template>
    <div class="border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert"
         :class="childClass">
        <div class="flex">
            <div class="py-1"><slot></slot></div>
            <div>
                <p class="font-bold">{{title}}</p>
                <p class="text-sm">{{text}}</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Alert",
    props: {
        childClass: {
            type: Object
        },
        title: {
            type: String,
            default: ''
        },
        text: {
            type: String,
            default: ''
        },
    }
}
</script>

<style scoped>

</style>
