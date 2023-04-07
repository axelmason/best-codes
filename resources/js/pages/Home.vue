<template>
    <div class="mt-24">
        <div class="grid grid-cols-3 gap-4">
            <div class="top-codes col-span-2 grid grid-cols-4 row-span-2 gap-4">
                <div class="top-item py-1 px-4 text-sm flex flex-col items-center bg-white rounded-xl border-[#E2E2E2]"
                    v-for="code in topCodes">
                    <div class="img-wrapper">
                        <img :src="getImage(code.image)" @error="brokenImage" />
                    </div>
                    <p style="color: #505050" class="font-normal py-3">
                        {{ code.title }}
                    </p>
                    <a href="#" class="bg-primary px-5 py-2 text-white rounded-2xl">Открыть промокод</a>
                </div>
            </div>
            <div class="d-flex flex-col">
                <div id="how-it-works" class="bg-white rounded-xl px-12 py-10 relative" style="z-index: -20">
                    <div class="how-img-wrapper absolute right-0 top-0" style="z-index: -10">
                        <img src="/help_outline_black.svg" alt="" />
                    </div>
                    <div class="how-it-works-text z-20 text-[#505050]">
                        <h3 class="text-2xl font-medium mb-7">Как это работает?</h3>
                        <div class="flex flex-col gap-y-7">
                            <div class="item flex flex-col gap-y-1">
                                <div class="item-title flex gap-x-2">
                                    <span class="item-img-wrapper"><img src="/loupe.svg" alt="" /></span>
                                    <span>Найдите магазин</span>
                                </div>
                                <div class="item-text">
                                    Воспользуйтесь списком магазинов ниже или с
                                    помощью поисковой строки
                                </div>
                            </div>
                            <div class="item flex flex-col gap-y-1">
                                <div class="item-title flex gap-x-2">
                                    <span class="item-img-wrapper"><img src="/coupon.svg" alt="" /></span>
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
                                    <span class="item-img-wrapper"><img src="/ticksquare.svg" alt="" /></span>
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
        </div>
        <div class="code-cards flex flex-col">
            <shop-card v-for="shop in shops" :shop="shop"></shop-card>
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
    methods: {
        getImage(img) {
            try {
                return img
                    ? "/storage/images/" + img
                    : "/storage/images/default.png";
            } catch (e) {
                console.log(e);
            }
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
    @apply grid xl:grid-cols-4 lg:grid-cols-2 gap-5 justify-center items-center w-full;
}

.img-wrapper {
    width: 200px;
}

.item-title {
    font-weight: 600;
}
</style>
