<template>
    <transition name="fade">
        <div class="modal-wrapper" @click="$emit('close')" v-if="show">
            <div class="modal" @click.stop="">
                <div class="flex justify-between mb-5">
                    <div class="title">{{ title }}</div>
                    <button class="close text-red-600" @click="$emit('close')">X</button>
                </div>

                <form action="#" @submit.prevent="submit" v-if="fields">
                    <div class="input-group flex flex-col" v-for="(field, name) in fields">
                        <label :for="name">{{ field.name }}</label>
                        <input :name="name" type="text" v-if="name !== 'password'">
                        <input :name="name" type="password" v-else>
                        <p class="error" v-if="errors[name]" v-for="error in errors[name]">{{ error }}</p>
                    </div>

                    <div class="error-message">
                        {{errors.message}}
                    </div>
                    <input type="submit" value="Отправить">
                </form>

                <div v-if="text">
                    <p>{{ text }}</p>
                </div>
                <div class="slots">
                    <slot></slot>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    name: "Modal",
    props: {
        title: {
            type: String,
            default: "Modal"
        },
        show: {
            type: Boolean
        },
        fields: {
            type: Object
        },
        text: {
            type: String
        },
        errors: {
            type: Object,
            default: {}
        }
    },
    data() {
        return {

        }
    },
    methods: {
        submit(submitEvent) {
            let values = {};
            for (let v in this.fields) {
                values[v] = submitEvent.target.elements[v].value
            }
            this.$emit('onSubmit', values);
        }
    }
}
</script>
