<template>
    <div class="admin-page">
        <ul class="tabs">
            <li class="tab" :class="[tab === 1 ? 'active' : '']" @click="openTab(1)">
                <button class="tab-name">Home</button>
            </li>
        </ul>

        <div class="tab-content" v-if="tab && $store.state.renderComponent">
            <button class="btn btn-primary mb-1" @click="$store.commit('forceRender')">Reload</button>
            <codes-tab v-if="tab === 1" />
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                tab: 1,
                renderComponent: true
            }
        },
        props: {

        },
        methods: {
            openTab(num) {
                if(this.tab === num) {
                    return this.tab = null;
                }

                this.tab = num;
            },
        }
    }
</script>

<style scoped lang="scss">
    .admin-page {
        margin: 1em;
        margin-top: 0;

        .tabs {

            .tab {
                width: max-content;
                padding: .5em 1em;
                border: 1px solid rgb(226, 226, 226);
                border-top: none;
                cursor: pointer;

                &:not(.active) {
                    border-bottom: 1px solid rgb(226, 226, 226);
                }

                &.active {
                    position: relative;
                    background-color:paleturquoise;

                    &::after {
                        content: "";
                        background-color: paleturquoise;
                        height: 2px;
                        width: 100%;
                        left: 0;
                        bottom: -2px;
                        position: absolute;
                    }
                }
            }
        }

        .tab-content {
        padding: 1em;
        border: 1px solid rgb(226, 226, 226);
    }
    }
</style>
