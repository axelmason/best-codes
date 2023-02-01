import './bootstrap';
import store from './store'

import {createApp} from 'vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import Home from './pages/Home.vue'
import Admin from './pages/Admin.vue'
import Moderate from './pages/Moderate.vue'
import ModerateForm from './pages/ModerateForm.vue'
import SuggestForm from './pages/SuggestForm.vue'
import CodeDetails from './pages/CodeDetails.vue'

import Login from './modals/Login.vue'
import Register from './modals/Register.vue'

import Modal from './elements/Modal.vue'
import EditModal from './elements/EditModal.vue'
import DeleteModal from './elements/DeleteModal.vue'
import Loader from './elements/Loader.vue'
import CodeCard from './elements/CodeCard.vue'
import Notifications from './elements/Notifications.vue'
import Alert from './elements/Alert.vue'

import CodesTab from './tabs/CodesTab.vue'
import ModerateTab from './tabs/ModerateTab.vue'

const app = createApp({});

app.use(store)
app.component('font-awesome-icon', FontAwesomeIcon)

app.component('home-page', Home);
app.component('admin-page', Admin);
app.component('moderate-page', Moderate);
app.component('moderate-form', ModerateForm);
app.component('suggest-form', SuggestForm);
app.component('code-details', CodeDetails);

app.component('login-modal', Login);
app.component('register-modal', Register);

app.component('show-modal', Modal);
app.component('edit-modal', EditModal);
app.component('delete-modal', DeleteModal);
app.component('loader', Loader);
app.component('code-card', CodeCard);
app.component('notifications', Notifications);
app.component('alert', Alert);

app.component('codes-tab', CodesTab);
app.component('moderate-tab', ModerateTab);

app.mount("#app");
