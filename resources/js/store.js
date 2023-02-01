import Vuex, {createStore} from "vuex";

const store = createStore({
    state() {
        return {
            renderComponent: true
        }
    },
    mutations: {
        forceRender(state) {
            state.renderComponent = false;
            setTimeout(() => {
                state.renderComponent = true;
            }, 0)
        }
    },
    actions: {
        sendNotification({commits}, data) {
            window.axios.post('/notifications', {
                user_id: data.user_id,
                text: data.text,
                code: data.code,
                reason: data.reason
            })
        }
    }
})
export default store;
