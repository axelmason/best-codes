<template>
    <transition name="fade">
        <div class="modal-wrapper" @click="$emit('close')" v-if="show">
            <div class="modal" @click.stop="">
                <div class="flex justify-between mb-5">
                    <div class="title">Are you sure you want to delete this item?</div>
                    <button class="close text-red-600" @click="$emit('close')">X</button>
                </div>
                <div class="btns flex justify-evenly space-x-2">
                    <button class="yes" @click="submit()">Yes</button>
                    <button class="no" @click="$emit('close')">Cancel</button>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    name: "DeleteModal",
    props: {
        show: {
            type: Boolean
        }
    },
    methods: {
        submit() {
            this.$emit('onSubmit');
        }
    }
}
</script>

<style scoped lang="scss">
.btns {
    * {
        width: 100%;
        padding: .5em 2em;
    }
    .yes {
        color: white;
        background-color:crimson;
    }
    .no {
        background-color: lightgray;
    }
}
</style>
