<template>
    <el-card>
        <el-button @click="openEditModal(null)" class="mb-1" type="primary">+ Добавить</el-button>
        <el-table v-loading="loading" :data="codesData">
            <el-table-column prop="id" width="100">
                <template #header>ID</template>
            </el-table-column>
            <el-table-column prop="shop.name">
                <template #header>Магазин</template>
            </el-table-column>
            <el-table-column prop="code">
                <template #header>Код</template>
            </el-table-column>
            <el-table-column prop="title">
                <template #header>Заголовок</template>
            </el-table-column>
            <el-table-column width="110">
                <template #header><el-icon><View /></el-icon> / <el-icon><Checked /></el-icon></template>
                <template #default="scope">{{ scope.row.views_count }} / {{ scope.row.usages_count }}</template>
            </el-table-column>
            <el-table-column prop="created_at">
                <template #header>Дата создания</template>
            </el-table-column>
            <el-table-column>
                <template #header>Действия</template>
                <template #default="scope">
                    <div class="flex gap-x-1">
                        <el-button type="primary" @click="openEditModal(scope.row.id)"><el-icon><Edit /></el-icon></el-button>
                        <el-button type="danger" @click="deleteCode(scope.row.id)"><el-icon><Delete /></el-icon></el-button>
                    </div>
                </template>
            </el-table-column>
        </el-table>
        <el-pagination :page-size="15" :current-page="page" :total="total" layout="prev, pager, next" @current-change="changePage"></el-pagination>
        <code-modal @submit="getCodes()" ref="modal"></code-modal>
    </el-card>
</template>

<script>
import CodeModal from './CodeModal.vue'

export default {
    components: {CodeModal},
    data: () => ({
        filters: {},
        codesData: [],
        total: null,
        page: 1,
        loading: false,
    }),
    props: {
        codes: Object
    },
    mounted() {
        this.codesData = this.codes
        this.getCodes()
    },
    methods: {
        getCodes() {
            this.loading = true;
            window.axios.get('/codes', { params: { page: this.page }})
            .then((res) => {
                this.total = res.data.total
                this.codesData = res.data.codes.data
            }).finally(() => {
                this.loading = false;
            })
        },
        changePage(index) {
            this.page = index;
            this.getCodes()
        },
        openEditModal(id) {
            this.$refs['modal'].show(id)
        },
        deleteCode(id) {
            this.loading = true;
            window.axios.delete(`/codes/${id}`)
            .then(() => this.getCodes())
        }
    },

}
</script>

<style>

</style>
