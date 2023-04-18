<template>
    <el-dialog :model-value="visible" :title="code.title" @close="closeDialog">
        <el-form require-asterisk-position="right" class="h-max overflow-y-scroll" v-loading="loading" label-position="top" :model="code">
            <el-tabs type="border-card">
                <el-tab-pane label="Код" lazy>
                    <el-row :gutter="25">
                        <el-col>От пользователя: {{ code.user?.name }}</el-col>
                        <el-col :md="12">
                            <el-form-item label="Заголовок" required>
                                <el-input v-model="code.title"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :md="12">
                            <el-form-item label="Код" required>
                                <el-input v-model="code.code"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row>
                        <el-col>
                            <div>Просмотров: {{ code.views_count }}</div>
                            <div>Использований: {{ code.usages_count }}</div>
                            <div>Время добавления:
                                <span v-if="!!code.created_at">{{ code.created_at }}</span>
                                <span v-else class="text-gray-400">неизвестно</span>
                            </div>
                        </el-col>
                    </el-row>
                </el-tab-pane>
                <el-tab-pane label="Описание кода">
                    <el-row>
                        <el-col>
                            <el-form-item label="Описание">
                                <div class="flex flex-col w-full quill-scroll max-h-[300px] h-[300px]">
                                    <QuillEditor :options="{'scrollingContainer': '.quill-scroll'}" toolbar="full" theme="snow" v-model:content="code.description" :content-type="'html'" />
                                </div>
                            </el-form-item>
                        </el-col>
                    </el-row>
                </el-tab-pane>
                <el-tab-pane label="Магазин" lazy>
                    <el-row>
                        <el-col>
                            <el-form-item label="Магазин" required>
                                <el-select @change="changeShop = true" v-model="code.shop.id" filterable clearable>
                                    <el-option v-for="(item, index) in shops" :key="index" :value="item.id" :label="item.name"></el-option>
                                </el-select>
                            </el-form-item>
                            <el-row class="items-center place-">
                                <el-col :md="11">
                                    <table class="border border-collapse table-fixed w-full">
                                        <thead>
                                            <tr>
                                                <th class="border px-3 py-2">Название</th>
                                                <th class="border px-3 py-2">Сайт</th>
                                                <th class="border px-3 py-2">Тип</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="border px-3 py-2">{{ code.shop.name }}</td>
                                                <td class="border px-3 py-2"><a :href="code.shop.url" target="_blank">Ссылка</a></td>
                                                <td class="border px-3 py-2">{{ code.shop.type.title }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </el-col>
                                <el-col v-if="changeShop && !!newCode" :md="2" class="text-center text-3xl"><el-icon><Right /></el-icon></el-col>
                                <el-col v-if="changeShop && !!newCode" :md="11">
                                    <table class="border border-collapse table-fixed w-full">
                                        <thead>
                                            <tr>
                                                <th class="border px-3 py-2">Название</th>
                                                <th class="border px-3 py-2">Сайт</th>
                                                <th class="border px-3 py-2">Тип</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="border px-3 py-2">{{ newCode.name }}</td>
                                                <td class="border px-3 py-2"><a :href="newCode.url" target="_blank">Ссылка</a></td>
                                                <td class="border px-3 py-2">{{ newCode.type.title }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </el-col>
                            </el-row>
                        </el-col>
                    </el-row>
                </el-tab-pane>
            </el-tabs>
            <div class="flex mt-3">
                <el-button type="primary" @click="submit">Сохранить</el-button>
                <el-button type="danger">Удалить</el-button>
            </div>
        </el-form>
    </el-dialog>
</template>

<script>
import { QuillEditor } from '@vueup/vue-quill'
import {ElMessage} from 'element-plus'
import '@vueup/vue-quill/dist/vue-quill.snow.css';

export default {
    components: { QuillEditor },
    data: () => ({
        codeId: null,
        code: {},
        visible: false,
        loading: false,
        shops: [],
        changeShop: false,
        errors: {
            "shop.id": [null],
            "title": [null],
            "code": [null]
        }
    }),
    mounted() {},
    computed: {
        newCode() {
            return this.shops.find(el => el.id === this.code.shop.id)
        }
    },
    methods: {
        getCode() {
            this.loading = true;
            this.$http
                .get('/codes/'+this.codeId, {params: { withShops: true }})
                .then((res) => {
                    this.code = res.data.code;
                    this.shops = res.data.shops;
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        show(id) {
            this.codeId = id;
            this.visible = true;
            this.getCode();
        },
        closeDialog() {
            this.codeId = null;
            this.visible = false;
        },
        submit() {
            this.loading = true;

            this.$http.put('/codes/'+this.code.id, {...this.code})
            .then((res) => {
                ElMessage({
                    message: "Изменения успешно сохранены",
                    type: "success"
                });
                this.closeDialog();
                this.$emit('submit');
            }).catch((err) => {
                this.errors = err.response.data.errors
                ElMessage({
                    message: "Заполните обязательные поля",
                    type: "error",
                    duration: 5000,
                    showClose: true
                });
            }).finally(() => {
                this.loading = false;
            })
        }
    },
};
</script>

<style></style>
