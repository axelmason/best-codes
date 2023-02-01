<template>
    <loader v-if="loading"/>
    <div class="overflow-x-auto" v-else>
        <table class="table-auto default">
            <thead>
            <tr>
                <th class="narrow">#</th>
                <th>Code</th>
                <th>Title</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(code, i) in codes" :key="i"
                :class="{
                    'bg-fuchsia-100': code.moderate_status === 'new',
                    'bg-orange-100': code.moderate_status === 'in_work',
                    'bg-green-100': code.moderate_status === 'accepted',
                    'bg-red-100': code.moderate_status === 'rejected',
                }">
                <td class="narrow">{{ (i + 1) }}</td>
                <td>{{ code.code }}</td>
                <td>{{ code.title }}</td>
                <td class="capitalize">
                    {{ moderateStatus(code.moderate_status) }}
                </td>
                <td>
                    <span class="flex justify-evenly text-blue-500">
                        <a :href="`moderate/open/${code.id}`"><i class="las la-pen-square"></i>Moderate</a>
                    </span>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            codes: {},
            modalShow: null,
            editModalShow: null,
            deleteModalShow: null,
            fields: {},
            loading: true,
            editErrors: []
        }
    },
    props: {},
    methods: {
        moderateStatus(status) {
            if (status.indexOf('_') !== -1) {
                return status.replace(/_/g, " ");
            }
            return status;
        }
    },
    mounted() {
        window.axios.get('/codes')
            .then((response) => {
                this.codes = response.data
                this.loading = false;
            })
    }
}
</script>

<style scoped>

</style>
