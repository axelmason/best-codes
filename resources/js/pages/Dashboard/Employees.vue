<template>
    <el-card>
        <el-row class="mb-4">
            <el-col :span="8">
                <p>Добавить модератора</p>
                <div class="flex gap-x-2">
                    <el-input v-model="newModerator" placeholder="Введите email пользователя"></el-input>
                    <el-button type="success" @click="addModerator">Добавить</el-button>
                </div>
            </el-col>
        </el-row>
        <el-table v-loading="loading" :data="data">
            <el-table-column prop="id" label="ID" />
            <el-table-column prop="email" label="Email" />
            <el-table-column label="Количество назначенных">
                <el-table-column prop="new_count" label="Новых" />
                <el-table-column prop="accepted_count" label="Одобренных" />
                <el-table-column prop="rejected_count" label="Отклонённых" />
                <el-table-column prop="in_work_count" label="В работе" />
            </el-table-column>
            <el-table-column>
                <template #default="scope">
                    <el-link type="danger" @click="unsetModerator(scope.row.id)">Забрать должность</el-link>
                </template>
            </el-table-column>
        </el-table>
    </el-card>
</template>

<script>
import { ElMessage } from 'element-plus'

export default {
    name: "Shops",
    data: () => ({
        data: [],
        loading: false,
        newModerator: ""
    }),
    mounted() {
        this.getEmployees()
    },
    methods: {
        async getEmployees() {
            this.loading = true

            await this.axios.get('/moderators/list').then(res => this.data = res.data)

            this.loading = false
        },
        unsetModerator(id) {
            this.loading = true

            this.axios.post('/moderators/unset', {id}).then(res => {
                if(!res.data.success) {
                    ElMessage({
                        message: res.data.message,
                        type: 'error'
                    })
                }

                this.getEmployees()
            })
        },
        addModerator() {
            this.loading = true

            this.axios.post('/moderators/set', { email: this.newModerator }).then(res => {
                if(!res.data.success) {
                    ElMessage({
                        message: res.data.message,
                        type: 'error'
                    })
                }

                this.getEmployees()
            })
        }
    },
}

</script>
