<template>
    <el-card>
        <el-table v-loading="loading" :data="codesData" :row-class-name="getRowStatus">
            <el-table-column prop="id" width="100">
                <template #header>ID</template>
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
            <el-table-column width="400">
                <template #header>Действия</template>
                <template #default="scope">
                    <div class="flex gap-x-3">
                        <el-link type="success" @click="setCodeStatus(scope.row.id, 'accepted')">Принять</el-link>
                        <el-link type="danger" @click="setCodeStatus(scope.row.id, 'rejected')">Отклонить</el-link>
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
            window.axios.get('/moderate')
            .then((res) => {
                this.codesData = res.data.filter(el => el.moderate_status === 'new')
            }).finally(() => {
                this.loading = false;
            })
        },
        setCodeStatus(id, moderate_status) {
            this.axios.put(`/moderate/${id}/edit`, {
                moderate_status
            }).then(() => this.getCodes())
        },
        changePage(index) {
            this.page = index;
            this.getCodes()
        },
        openEditModal(id) {
            this.$refs['modal'].show(id)
        }
    },

}
</script>

<style>

</style>
