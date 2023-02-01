<template>
    <loader v-if="loading" />
    <div class="overflow-x-auto" v-else>
    <table class="table-auto default">
        <thead>
            <tr>
                <th class="narrow">#</th>
                <th>Code</th>
                <th>Title</th>
                <th>Description</th>
                <th>Activate URL</th>
                <th class="narrow">Views</th>
                <th class="narrow">Usages</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="code, i in codes" :key="i">
                <td class="narrow">{{(i+1)}}</td>
                <td>{{code.code}}</td>
                <td>{{code.title}}</td>
                <td><button class="text-blue-500" @click="(modalShow = code.id)">Show</button></td>
                <td><a class="text-blue-500" :href="code.activate_url">Go</a></td>
                <td class="narrow">{{code.views_count}}</td>
                <td class="narrow">{{code.usages_count}}</td>
                <td>
                    <span class="flex justify-evenly text-blue-500">
                        <button @click="buildEditModal(code.id)"><i class="las la-pen-square"></i>Edit</button>
                        <button @click="(deleteModalShow = code.id)"><i class="las la-trash"></i>Delete</button>
                    </span>
                </td>
                <show-modal
                    :title="`Description of ${code.code}`"
                    :text="code.description"
                    :show="(modalShow === code.id)"
                    @close="modalShow = null"
                />

                <edit-modal
                    :title="`Edit ${code.code}`"
                    :fields="fields"
                    :show="(editModalShow === code.id)"
                    :errors="editErrors"
                    @close="editModalShow = null"
                    @onSubmit="submitEdit"
                />

                <delete-modal
                    :show="(deleteModalShow === code.id)"
                    @close="deleteModalShow = null"
                    @onSubmit="submitDelete(code.id)"
                />
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
        props: {

        },
        methods: {
            buildEditModal(codeId) {
                let row = this.codes.filter((data) => {
                    return data.id === codeId
                })[0]

                this.fields = {
                    code: {
                        name: "Code",
                        value: row.code
                    },
                    title: {
                        name: "Title",
                        value: row.title
                    },
                    description: {
                        name: "Description",
                        value: row.description
                    },
                    activate_url: {
                        name: "Activate url",
                        value: row.activate_url
                    }
                }
                this.editModalShow = codeId;
            },
            submitEdit(data) {
                window.axios.put('/codes/'+this.editModalShow, data)
                .then(() => location.reload())
                .catch((e) => {this.editErrors = e.response.data.errors;})
            },
            submitDelete() {
                window.axios.delete('/codes/'+this.deleteModalShow)
                .then(() => location.reload())
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
