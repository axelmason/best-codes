<template>
    <div class="mt-20">
        <div class="grid max-lg:grid-cols-1 grid-cols-3 gap-4">
            <div v-if="!!topCodes" class="col-span-2 grid max-xl:grid-cols-2 max-md:grid-cols-1 grid-cols-4 row-span-2 gap-4">
                <div
                    class="relative top-item py-1 max-md:mx-4 px-4 text-sm flex flex-col items-center bg-white rounded-xl border-[#E2E2E2]"
                    v-for="code in topCodes">
                    <div class="img-wrapper">
                        <img :src="getImage(code.images[0]?.['path'])" @error="brokenImage" />
                    </div>
                    <p style="color: #505050" class="font-normal py-3 max-xl:mb-12">
                        {{ code.title }}
                    </p>
                    <a :href="'/code/'+code.id" class="bg-primary px-5 py-2 text-white rounded-2xl absolute bottom-3">Открыть<span
                            class="max-xl:hidden"> промокод</span></a>
                </div>
            </div>
            <div v-else class="col-span-2 max-md:grid-cols-1">
                <div v-if="shops.length !== 0" class="grid lg:grid-cols-2 gap-5">
                    <div class="text-3xl" v-if="!!getSearchQuery">Результаты по запросу "{{ getSearchQuery }}"</div>
                    <br v-if="!!getSearchQuery" />
                    <shop-card v-for="shop in shops" horizont :shop="shop" />
                </div>
                <div class="text-3xl mb-52" v-else>Нет результатов по запросу "{{ getSearchQuery }}"</div>
            </div>
            <div class="flex flex-col gap-y-3">
                <div id="how-it-works" class="bg-white rounded-xl px-12 py-10 relative" style="z-index: -20">
                    <div class="how-img-wrapper absolute right-0 top-0" style="z-index: -10">
                        <img src="@/assets/img/help_outline_black.svg" alt="" />
                    </div>
                    <div class="how-it-works-text z-20 text-[#505050]">
                        <h3 class="text-2xl font-medium mb-7">Как это работает?</h3>
                        <div class="flex flex-col gap-y-7">
                            <div class="item flex flex-col gap-y-1">
                                <div class="item-title flex gap-x-2">
                                    <span class="item-img-wrapper"><img src="@/assets/img/loupe.svg" alt="" /></span>
                                    <span>Найдите магазин</span>
                                </div>
                                <div class="item-text">
                                    Воспользуйтесь списком магазинов ниже или с
                                    помощью поисковой строки
                                </div>
                            </div>
                            <div class="item flex flex-col gap-y-1">
                                <div class="item-title flex gap-x-2">
                                    <span class="item-img-wrapper"><img src="@/assets/img/coupon.svg" alt="" /></span>
                                    <span>Заберите промокод</span>
                                </div>
                                <div class="item-text">
                                    Кликните на карточку купона и скопируйте
                                    заинтересовавший вас промокод или посмотрите
                                    доступные акции
                                </div>
                            </div>
                            <div class="item flex flex-col gap-y-1">
                                <div class="item-title flex gap-x-2">
                                    <span class="item-img-wrapper"><img src="@/assets/img/ticksquare.svg" alt="" /></span>
                                    <span>Используйте промокод</span>
                                </div>
                                <div class="item-text">
                                    Вставьте промокод в специальном поле при
                                    оформлении заказа в магазине/сервисе, чтобы
                                    получить скидку
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="subscribe">
                    <div class="h-max bg-white rounded-xl px-12 py-10 text-[#505050] font-medium flex flex-col gap-y-6">
                        <h3 class="text-2xl">Подписаться</h3>
                        <p>Получайте уникальные предложения <br> раз в неделю</p>
                        <input type="email" class="px-5 py-3 rounded-full border font-normal" placeholder="E-mail">
                        <button
                            class="bg-[#4671D5] w-max px-10 py-4 rounded-full text-white self-center hover:bg-[#2f509c] transition-colors">Подписаться</button>
                    </div>
                </div>
            </div>
            <h2 class="col-span-full mt-5 font-bold text-4xl" v-if="!!topCodes">Список магазинов</h2>
            <div v-if="!!topCodes" class="code-cards mt-3 col-start-1 col-end-3">
                <shop-card v-for="shop in shops" :shop="shop"></shop-card>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {};
    },
    props: {
        shops: {
            type: Object,
            default: () => ({}),
        },
        topCodes: {
            type: Object,
        },
    },
    computed: {
        getSearchQuery() {
            return new URLSearchParams(window.location.search).get('query')
        }
    },
    methods: {
        getImage(img) {
            return img
                ? "/storage/" + img
                : "/storage/images/default.png";
        },
        brokenImage(e) {
            return (e.target.src = "/storage/images/default.png");
        },
    },
};
</script>

<style scoped lang="scss">
* {
    @apply font-roboto;
}

.code-cards {
    @apply grid xl:grid-cols-4 lg:grid-cols-4 gap-5 justify-center items-center;
}

.img-wrapper {
    max-height: 150px;
    width: 200px;
    display: flex;
    justify-content: center;
    object-fit: contain;
    img {
        height: 100%;
    }
}

.item-title {
    font-weight: 600;
}
</style>
