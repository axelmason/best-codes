<template>
    <div class="xl:mr-5 max-xl:my-3 notifications" @click.stop>
        <i class="las la-bell" @click="this.opened = !this.opened"></i>
        <Transition name="fade">
            <div class="notifications-block" v-if="this.opened">
                <loader v-if="loading"></loader>
                <div v-else>
                    <div class="flex flex-col justify-between">
                        <h1 class="title">Уведомления</h1>
                        <div class="flex space-x-1 filters">
                            <input class="flex-1 w-full search-notify" type="text" placeholder="Поиск..."
                                   @input="searchNotifications">
                            <button class="flex-1" @click="filterNotifications('new')">Новые</button>
                            <button class="flex-1" @click="filterNotifications('read')">Прочитанные</button>
                            <button class="flex-1" @click="filterNotifications()">Все</button>
                        </div>
                    </div>
                    <hr>
                    <div class="notification" v-if="notifications.length" v-for="notification in getNewNotifications"
                         :key="notification.id">
                        <div :class="{new: notification.status === 'new'}">
                            <p class="notification-title">Новое</p>
                            <p class="text" v-html="notification.text"></p>
                            <button class="text-blue-500" @click="setRead(notification.id)">Отметить как прочитанное
                            </button>
                        </div>
                    </div>
                    <div class="notification" v-if="notifications.length" v-for="notification in getReadNotifications"
                         :key="notification.id">
                        <div :class="{read: notification.status === 'read'}">
                            <p class="notification-title">Прочитано</p>
                            <p class="text" v-html="notification.text"></p>
                        </div>
                    </div>
                    <div v-else>У вас нет уведомлений...</div>
                </div>
            </div>
        </Transition>
    </div>
</template>

<script>
export default {
    name: "Notifications",
    data: () => ({
        notifications: [],
        defaultNotifications: [],
        opened: false,
        loading: false,
        timer: null,
    }),
    computed: {
        getNewNotifications() {
            return this.notifications.filter((v) => v.status === 'new');
        },
        getReadNotifications() {
            return this.notifications.filter((v) => v.status === 'read');
        }
    },
    methods: {
        setRead(id) {
            this.loading = true;
            window.axios.put(`/notifications/${id}`, {status: 'read'})
                .then((response) => this.getNotifications())
        },
        getNotifications() {
            this.loading = true;
            window.axios.get('/notifications')
                .then((response) => {
                    this.notifications = response.data
                    this.defaultNotifications = this.notifications;

                    document.querySelector('.las.la-bell')
                        .setAttribute('data-notifications-count', this.notifications.filter((v) => v.status === 'new').length || '0')
                    this.loading = false;
                });
        },
        searchNotifications(e) {
            if (this.timer) {
                clearTimeout(this.timer);
                this.timer = null;
            }
            this.timer = setTimeout(() => {
                this.notifications = this.defaultNotifications.filter((v) => {
                    let lowerText = v.text.toLowerCase()
                    return lowerText.includes(e.target.value.toLowerCase())
                })
            }, 800);
        },
        filterNotifications(status) {
            if (status) {
                this.notifications = this.defaultNotifications.filter((v) => {
                    return v.status === status;
                })
            } else {
                document.querySelector('input.search-notify').value = "";
                this.notifications = this.defaultNotifications;
            }
        }
    },
    mounted() {
        this.getNotifications();
        window.addEventListener('click', (e) => {
            this.opened = false;
        });
    }
}
</script>

<style scoped lang="scss">
.notifications {
    position: relative;

    i {
        font-size: 40px;
        padding: 10px;
        cursor: pointer;
        background-color: #fff;
        border-radius: 50%;
        transition: .3s ease;

        &:hover {
            background: #e0e0e0;
        }

        &:active {
            background: white;
        }

        &:after {
            @apply font-roboto;
            content: attr(data-notifications-count);
            position: absolute;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 10px;
            color: white;
            right: 0;
            bottom: 0;
            background: red;
            border-radius: 50%;
            width: 20px;
            height: 20px;
        }
    }

    .notifications-block {
        @apply bg-white px-3 py-2 absolute xl:right-0 top-20 border w-[400px] max-w-sm;
        @media screen and (max-width: 1280px) {
            @apply w-[300px];
            right: -120px;
        }
        overflow-y: scroll;
        height: 400px;

        .title {
            font-size: 20px;
            font-weight: bold;
        }

        .filters {
            * {
                padding: 5px 0;
            }
        }

        .notification {
            border: 1px solid black;
            padding: .5em 1em;
            margin: 5px 0;

            .notification-title {
                border-bottom: 1px solid #e3e3e3;
            }

            .new {
                .notification-title {
                    font-weight: bold;
                }
            }
        }
    }
}
</style>
