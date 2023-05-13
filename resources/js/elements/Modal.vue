<template>
    <transition name="fade">
        <div class="modal-wrapper z-50" @click="$emit('close')" v-if="show">
            <div class="modal" @click.stop>
                <div class="flex max-lg:flex-col max-lg:w-[320px]">
                    <div class="lg:rounded-l max-lg:rounded-t promotion bg-gradient-to-br from-primary to-[#FF5F6D] flex flex-1 flex-col py-5 px-10"
                        v-if="promotion">
                        <h3 class="text-4xl font-bold text-white text-center mb-4">Добро пожаловать на PromoZone</h3>
                        <p class="text-lg text-white text-center max-lg:hidden">Узнавайте обо всех скидках на нашем сайте!</p>
                        <div class="flex flex-col justify-center items-center bg-white py-4 px-6 rounded-lg shadow-md mt-4 max-lg:hidden">
                            <span class="text-gray-500 text-md font-medium mb-2">Следите за нами в соцсетях:</span>
                            <div class="flex justify-center items-center">
                                <a href="#" target="_blank" rel="noopener" class="mr-4">
                                    <img src="@/assets/img/telegram.webp" alt="Telegram" width="32" height="32">
                                </a>
                                <a href="#" target="_blank" rel="noopener" class="mr-4">
                                    <img src="@/assets/img/vk.png" alt="VK" width="32" height="32">
                                </a>
                                <a href="#" target="_blank" rel="noopener">
                                    <img src="@/assets/img/youtube.webp" alt="YouTube" width="32" height="32">
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="w-full flex-1 py-5 px-10">
                        <div class="flex justify-between mb-5">
                            <div class="title">{{ title }}</div>
                            <button class="close text-red-600 text-3xl" @click="$emit('close')">&times;</button>
                        </div>

                        <form action="#" @submit.prevent="submit" v-if="fields">
                            <div class="input-group flex flex-col" v-for="(field, name) in fields">
                                <label :for="name">{{ field.name }} <span class="text-red-600"
                                        v-if="!!field.required">*</span></label>
                                <input :name="name" :type="field.type">
                                <p class="error" v-if="errors[name]" v-for="error in errors[name]">{{ error }}</p>
                            </div>

                            <div class="error-message">
                                {{ errors.message }}
                            </div>
                            <button type="submit" class="w-full bg-gradient-to-br from-primary to-[#FF5F6D] rounded-full text-white font-bold text-lg py-2 px-4 shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition duration-300 ease-in-out hover:opacity-90">
                                {{ buttonText }}
                            </button>
                        </form>

                        <div v-if="text">
                            <p>{{ text }}</p>
                        </div>
                        <div class="slots">
                            <slot name="extra"></slot>
                        </div>
                    </div>
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
        },
        promotion: {
            type: Boolean
        },
        buttonText: {
            type: String,
            default: "Отправить"
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
