<template>
    <el-card>
        <el-button @click="openEditModal(null)" class="mb-1" type="primary">+ Добавить</el-button>
        <el-table v-loading="loading" :data="shops">
            <el-table-column prop="id" width="100">
                <template #header>ID</template>
            </el-table-column>
            <el-table-column>
                <template #header>Изображение</template>
                <template #default="scope">
                    <div class="table-img-wrapper max-w-[50px] max-h-[50px] object-contain">
                        <img class="w-full" :src="'/storage/'+scope.row.image" alt="">
                    </div>
                </template>
            </el-table-column>
            <el-table-column prop="name">
                <template #header>Название</template>
            </el-table-column>
            <el-table-column prop="type.title">
                <template #header>Тип</template>
            </el-table-column>
            <el-table-column prop="codes_count">
                <template #header>Кодов</template>
            </el-table-column>
            <el-table-column prop="created_at">
                <template #header>Дата создания</template>
                <template #default="scope">{{ parseTimestamp(scope.row.created_at) }}</template>
            </el-table-column>
            <el-table-column>
                <template #header>Действия</template>
                <template #default="scope">
                    <div class="flex gap-x-1">
                        <el-button type="primary" @click="openEditModal(scope.row.id)"><el-icon><Edit /></el-icon></el-button>
                        <el-button type="danger"><el-icon><Delete /></el-icon></el-button>
                    </div>
                </template>
            </el-table-column>
        </el-table>
        <el-pagination :page-size="15" :current-page="page" :total="total" layout="prev, pager, next" @current-change="changePage"></el-pagination>
        <ShopModal @submit="getShops()" ref="modal"></ShopModal>
    </el-card>
</template>

<script>
import ShopModal from './ShopModal.vue'
import { parseTimestamp } from '../../global/functions';

export default {
    components: {ShopModal},
    data: () => ({
        filters: {},
        shops: [],
        total: null,
        page: 1,
        loading: false,
    }),
    mounted() {
        this.getShops()
    },
    methods: {
        parseTimestamp,
        getShops() {
            this.loading = true;
            window.axios.get('/shops', { params: { page: this.page }})
            .then((res) => {
                console.log(res.data)
                this.total = res.data.total
                this.shops = res.data.shops.data
            }).finally(() => {
                this.loading = false;
            })
        },
        changePage(index) {
            this.page = index;
            this.getCodes()
        },
        openEditModal(id = null) {
            console.log(id)
            this.$refs['modal'].show(id)
        }
    },

}
</script>

<style>

</style>
