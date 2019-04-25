import Vue from "vue";
import store from "./shared/store";
import { router } from "./shared/router";
//import Axios from "axios";
import Buefy from "buefy";
// @ts-ignore
import Sortable from "sortablejs";
import App from "./App.vue";

var EventBus = new Vue();
Vue.prototype.$bus = EventBus;

const moment = require('moment');
require('moment/locale/de');
Vue.use(require('vue-moment'), {  moment });

import "./scss/bulma_custom.scss";
import "./scss/global.scss";
//import "@/shared/helpers/buefy/components"
//Vue.prototype.$http = Axios;
Vue.config.productionTip = false;

Vue.use(Buefy);


new Vue({
  router,
  store,
  render: h => h(App)
}).$mount("#app");
